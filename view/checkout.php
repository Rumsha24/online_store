<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);
$cartModel = new Cart($db);

$userId = $_SESSION['user_id'];
$cartItems = $cartModel->getUserCart($userId);

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_purchase'])) {
    try {
        $db->beginTransaction();

        // Insert into orders table
        $orderStmt = $db->prepare("INSERT INTO orders (userID, totalAmount) VALUES (:userID, :totalAmount)");
        $orderStmt->execute([
            ':userID' => $userId,
            ':totalAmount' => $total
        ]);
        $orderId = $db->lastInsertId();

        // Insert into order_items
        $itemStmt = $db->prepare("INSERT INTO order_items (orderID, productID, quantity, price) VALUES (:orderID, :productID, :quantity, :price)");
        foreach ($cartItems as $item) {
            $itemStmt->execute([
                ':orderID' => $orderId,
                ':productID' => $item['productID'],
                ':quantity' => $item['quantity'],
                ':price' => $item['price']
            ]);
        }

        // Clear user's cart
        $cartModel->clearUserCart($userId);

        $db->commit();

        // Redirect to success page
        header("Location: order_success.php?order_id=" . $orderId);
        exit;

    } catch (Exception $e) {
        $db->rollBack();
        echo "Failed to complete order: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Noire Essence</title>
    <style>
        :root {
            --deep-red: #590D22;
            --rich-red: #800F2F;
            --vibrant-red: #A4133C;
            --primary-red: #C9184A;
            --bright-pink: #FF4D6D;
            --soft-pink: #FF758F;
            --light-pink: #FF8FA3;
            --pale-pink: #FFB3C1;
            --very-pale-pink: #FFCCD5;
            --almost-white: #FFF0F3;
        }
        
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&family=Playfair+Display:wght@700&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--almost-white);
            padding: 20px;
            color: var(--deep-red);
            line-height: 1.6;
        }
        
        .checkout-container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(89, 13, 34, 0.08);
            border: 1px solid var(--very-pale-pink);
        }
        
        h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-red);
            font-size: 2.2rem;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
        }
        
        h2:after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--bright-pink);
        }
        
        table {
            width: 100%;
            margin: 30px 0;
            border-collapse: collapse;
        }
        
        th {
            background: var(--pale-pink);
            color: var(--deep-red);
            font-weight: 600;
            padding: 16px;
            text-align: center;
            border-bottom: 2px solid var(--light-pink);
        }
        
        td {
            padding: 16px;
            border-bottom: 1px solid var(--very-pale-pink);
            text-align: center;
            vertical-align: middle;
        }
        
        tr:hover {
            background: rgba(255, 240, 243, 0.5);
        }
        
        img {
            border-radius: 6px;
            border: 1px solid var(--very-pale-pink);
        }
        
        .total {
            font-weight: bold;
            font-size: 1.3rem;
            text-align: right;
            color: var(--primary-red);
        }
        
        .confirm-btn {
            background: var(--primary-red);
            color: white;
            padding: 16px 32px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 40px auto 0;
            width: fit-content;
            box-shadow: 0 4px 12px rgba(201, 24, 74, 0.2);
        }
        
        .confirm-btn:hover {
            background: var(--vibrant-red);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(201, 24, 74, 0.3);
        }
        
        .confirm-btn:active {
            transform: translateY(0);
        }
        
        a {
            color: var(--primary-red);
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        a:hover {
            color: var(--vibrant-red);
            text-decoration: underline;
        }
        
        .empty-cart {
            text-align: center;
            font-size: 1.1rem;
            padding: 40px 0;
        }
        
        @media (max-width: 768px) {
            .checkout-container {
                padding: 25px;
            }
            
            h2 {
                font-size: 1.8rem;
            }
            
            th, td {
                padding: 12px 8px;
                font-size: 0.9rem;
            }
            
            .confirm-btn {
                padding: 14px 24px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<div class="checkout-container">
    <h2>Your Fragrance Order</h2>

    <?php if (count($cartItems) === 0): ?>
        <div class="empty-cart">
            <p>Your cart is empty. <a href="products.php">Discover our fragrances</a></p>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($item['image']) ?>" width="80" height="90" alt="<?= htmlspecialchars($item['description']) ?>" /></td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="total">Total:</td>
                    <td><strong>$<?= number_format($total, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <form method="post">
            <button type="submit" name="confirm_purchase" class="confirm-btn">
                Complete Your Purchase
            </button>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>