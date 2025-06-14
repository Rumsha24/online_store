<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "Order ID missing.";
    exit;
}

$orderId = intval($_GET['order_id']);
$userId = $_SESSION['user_id'];

$database = new Database();
$db = $database->getConnection();

// Verify order belongs to the logged-in user
$orderStmt = $db->prepare("SELECT * FROM orders WHERE orderID = :orderID AND userID = :userID");
$orderStmt->execute([
    ':orderID' => $orderId,
    ':userID' => $userId
]);
$order = $orderStmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    echo "Order not found or you do not have permission to view it.";
    exit;
}

// Get total number of products (sum of quantities) and total bill
$itemStmt = $db->prepare("SELECT SUM(quantity) as total_products, SUM(quantity * price) as total_bill FROM order_items WHERE orderID = :orderID");
$itemStmt->execute([':orderID' => $orderId]);
$itemData = $itemStmt->fetch(PDO::FETCH_ASSOC);

$totalProducts = $itemData['total_products'] ?? 0;
$totalBill = $itemData['total_bill'] ?? 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Summary</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
        .summary-container { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px #ccc;}
        h2 { color: #6B46C1; }
        p { font-size: 1.1em; }
    </style>
</head>
<body>

<div class="summary-container">
    <h2>Order Summary</h2>
    <p><strong>Order ID:</strong> <?= htmlspecialchars($orderId) ?></p>
    <p><strong>Products Confirmed:</strong> <?= htmlspecialchars($totalProducts) ?></p>
    <p><strong>Total Bill:</strong> $<?= number_format($totalBill, 2) ?></p>
    <p><strong>Order Date:</strong> <?= htmlspecialchars($order['orderDate']) ?></p>

    <a href="products.php">Continue Shopping</a>
</div>

</body>
</html>
