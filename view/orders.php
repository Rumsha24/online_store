<?php
header("Content-Type: application/json");
require_once 'db_connect.php';
require_once 'auth.php';

// Helper function to get order details
function getOrderDetails($orderId) {
    global $db;
    
    // Get order header
    $stmt = $db->prepare("SELECT * FROM orders WHERE orderID = ?");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        return null;
    }
    
    // Get order items
    $stmt = $db->prepare("
        SELECT oi.*, p.description, p.image 
        FROM order_items oi
        JOIN products p ON oi.productID = p.productID
        WHERE oi.orderID = ?
    ");
    $stmt->execute([$orderId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $order['items'] = $items;
    return $order;
}

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Get order(s)
        if (isset($_GET['id'])) {
            // Get specific order
            $orderId = $_GET['id'];
            $order = getOrderDetails($orderId);
            
            if ($order) {
                // Verify the requesting user owns this order
                $userId = authenticateRequest();
                if ($order['userID'] != $userId) {
                    http_response_code(403);
                    echo json_encode(["message" => "Unauthorized access to order"]);
                    exit;
                }
                
                echo json_encode($order);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Order not found"]);
            }
        } else {
            // Get all orders for user
            $userId = authenticateRequest();
            
            $stmt = $db->prepare("
                SELECT orderID, orderDate, totalAmount 
                FROM orders 
                WHERE userID = ? 
                ORDER BY orderDate DESC
            ");
            $stmt->execute([$userId]);
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode($orders);
        }
        break;
        
    case 'POST':
        // Create new order from cart
        $userId = authenticateRequest();
        
        // Begin transaction
        $db->beginTransaction();
        
        try {
            // 1. Get user's cart items
            $stmt = $db->prepare("
                SELECT c.productID, c.quantity, p.price, p.shippingCost, p.description
                FROM cart c
                JOIN products p ON c.productID = p.productID
                WHERE c.userID = ?
            ");
            $stmt->execute([$userId]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($cartItems)) {
                http_response_code(400);
                echo json_encode(["message" => "Cart is empty"]);
                exit;
            }
            
            // 2. Get user's shipping address
            $stmt = $db->prepare("SELECT shippingAddress FROM users WHERE userID = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (empty($user['shippingAddress'])) {
                http_response_code(400);
                echo json_encode(["message" => "Shipping address not set"]);
                exit;
            }
            
            // 3. Calculate total
            $totalAmount = 0;
            foreach ($cartItems as $item) {
                $totalAmount += ($item['price'] * $item['quantity']) + $item['shippingCost'];
            }
            
            // 4. Create order header
            $stmt = $db->prepare("
                INSERT INTO orders (userID, totalAmount)
                VALUES (?, ?)
            ");
            $stmt->execute([$userId, $totalAmount]);
            $orderId = $db->lastInsertId();
            
            // 5. Create order items
            foreach ($cartItems as $item) {
                $stmt = $db->prepare("
                    INSERT INTO order_items (orderID, productID, quantity, price, shippingCost)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $orderId, 
                    $item['productID'], 
                    $item['quantity'], 
                    $item['price'], 
                    $item['shippingCost']
                ]);
            }
            
            // 6. Clear cart
            $stmt = $db->prepare("DELETE FROM cart WHERE userID = ?");
            $stmt->execute([$userId]);
            
            // Commit transaction
            $db->commit();
            
            // Return order details
            $order = getOrderDetails($orderId);
            http_response_code(201);
            echo json_encode($order);
            
        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(["message" => "Order creation failed", "error" => $e->getMessage()]);
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
        break;
}
?>