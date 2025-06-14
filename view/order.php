<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();

// Get orders for logged-in user
$stmt = $db->prepare("SELECT * FROM orders WHERE userID = :userID ORDER BY orderDate DESC");
$stmt->execute([':userID' => $_SESSION['user_id']]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Orders</title>
    <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #fff0f3;
        padding: 20px;
    }
    .container {
        max-width: 900px;
        margin: auto;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(89, 13, 34, 0.1);
        border: 1px solid #ffccd5;
    }
    h2 {
        color: #800f2f;
        margin-bottom: 24px;
        font-size: 1.8em;
        position: relative;
        padding-bottom: 10px;
    }
    h2:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #ff4d6d, #c9184a);
        border-radius: 2px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    th, td {
        padding: 14px 12px;
        text-align: center;
        border-bottom: 1px solid #ffb3c1;
    }
    th {
        background-color: #ffccd5;
        color: #800f2f;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    tr:hover {
        background-color: #fff0f3;
    }
    a.btn {
        background: #c9184a;
        color: #fff;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(201, 24, 74, 0.2);
    }
    a.btn:hover {
        background: #a4133c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(201, 24, 74, 0.3);
    }
</style>
</head>
<body>

<?php include __DIR__ . '/header.php'; ?>

<div class="container">
    <h2>Your Orders</h2>

    <?php if (count($orders) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['orderID']) ?></td>
                        <td><?= htmlspecialchars($order['orderDate']) ?></td>
                        <td>$<?= number_format($order['totalAmount'], 2) ?></td>
                        <td><a href="receipt.php?order_id=<?= $order['orderID'] ?>" class="btn">View Receipt</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no orders yet.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
