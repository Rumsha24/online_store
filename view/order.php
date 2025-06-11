<?php

require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/models/Order.php';

// Initialize database connection
$database = new Database();
$db = $database->getConnection();

// Initialize Order model
$orderModel = new Order($db);

// Check if user is logged in (example)
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Handle different actions
$action = $_GET['action'] ?? 'list';

try {
    switch ($action) {
        case 'view':
            // View single order
            $orderId = $_GET['id'] ?? 0;
            $order = $orderModel->getOrderById($orderId);
            
            if (!$order || $order['userID'] != $userId) {
                throw new Exception('Order not found or access denied');
            }
            break;
            
        case 'cancel':
            // Cancel an order
            $orderId = $_GET['id'] ?? 0;
            $order = $orderModel->getOrderById($orderId);
            
            if (!$order || $order['userID'] != $userId) {
                throw new Exception('Order not found or access denied');
            }
            
            if ($orderModel->updateOrderStatus($orderId, 'cancelled')) {
                $success = "Order #$orderId has been cancelled";
                $order = $orderModel->getOrderById($orderId); // Refresh order data
            }
            break;
            
        default:
            // List all orders
            $page = $_GET['page'] ?? 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;
            
            $orders = $orderModel->getUserOrders($userId, $limit, $offset);
            $totalOrders = $orderModel->getUserOrdersCount($userId);
            $totalPages = ceil($totalOrders / $limit);
            break;
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card {
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        .order-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .status-pending {
            color: #ffc107;
        }
        .status-completed {
            color: #28a745;
        }
        .status-cancelled {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">My Orders</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <?php if ($action === 'view' && isset($order)): ?>
            <!-- Single Order View -->
            <div class="card order-card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Order #<?= htmlspecialchars($order['id']) ?></h3>
                    <span class="status-<?= htmlspecialchars($order['status']) ?>">
                        <?= strtoupper(htmlspecialchars($order['status'])) ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>Order Details</h5>
                            <p><strong>Date:</strong> <?= date('F j, Y', strtotime($order['createdAt'])) ?></p>
                            <p><strong>Total:</strong> $<?= number_format($order['totalAmount'], 2) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Shipping Information</h5>
                            <!-- Add shipping info here if available -->
                        </div>
                    </div>
                    
                    <h5 class="mt-4">Items</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- You would loop through order items here -->
                            <tr>
                                <td>Sample Product</td>
                                <td>$19.99</td>
                                <td>1</td>
                                <td>$19.99</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <?php if ($order['status'] === 'pending'): ?>
                        <div class="text-end mt-3">
                            <a href="order.php?action=cancel&id=<?= $order['id'] ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to cancel this order?')">
                                Cancel Order
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <a href="order.php" class="btn btn-secondary mt-3">Back to Orders</a>
            
        <?php else: ?>
            <!-- Orders List View -->
            <?php if (empty($orders)): ?>
                <div class="alert alert-info">You haven't placed any orders yet.</div>
                <a href="shopall.php" class="btn btn-primary">Browse Products</a>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="card order-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>Order #<?= htmlspecialchars($order['id']) ?></h5>
                                    <p class="mb-1">
                                        <strong>Date:</strong> <?= date('F j, Y', strtotime($order['createdAt'])) ?>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Total:</strong> $<?= number_format($order['totalAmount'], 2) ?>
                                    </p>
                                </div>
                                <div class="text-end">
                                    <span class="status-<?= htmlspecialchars($order['status']) ?>">
                                        <?= strtoupper(htmlspecialchars($order['status'])) ?>
                                    </span>
                                    <div class="mt-2">
                                        <a href="order.php?action=view&id=<?= $order['id'] ?>" 
                                           class="btn btn-sm btn-primary">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="order.php?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>