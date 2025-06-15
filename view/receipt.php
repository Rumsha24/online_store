<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$orderId = $_GET['order_id'] ?? null;
if (!$orderId) {
    echo "Invalid order ID.";
    exit;
}

$database = new Database();
$db = $database->getConnection();

$orderStmt = $db->prepare("SELECT * FROM orders WHERE orderID = :orderID AND userID = :userID");
$orderStmt->execute([':orderID' => $orderId, ':userID' => $_SESSION['user_id']]);
$order = $orderStmt->fetch();

if (!$order) {
    echo "Order not found.";
    exit;
}

$itemsStmt = $db->prepare("
    SELECT oi.*, p.name, p.description, p.image 
    FROM order_items oi
    JOIN products p ON oi.productID = p.productID
    WHERE oi.orderID = :orderID
");
$itemsStmt->execute([':orderID' => $orderId]);
$orderItems = $itemsStmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt - Noire Essence</title>
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
            padding: 30px;
            color: var(--deep-red);
            line-height: 1.6;
        }
        
        .container {
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
            position: relative;
        }
        
        h2:after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 80px;
            height: 3px;
            background: var(--bright-pink);
        }
        
        .order-info {
            margin-bottom: 30px;
        }
        
        .order-info p {
            font-size: 1.1rem;
            margin: 8px 0;
        }
        
        .order-info strong {
            color: var(--rich-red);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
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
            max-width: 80px;
            max-height: 90px;
            border-radius: 6px;
            border: 1px solid var(--very-pale-pink);
        }
        
        .total-row td {
            font-weight: bold;
            font-size: 1.2rem;
            border-top: 2px solid var(--light-pink);
            color: var(--primary-red);
        }
        
        .total-row td:first-child {
            text-align: right;
        }
        
        .btn {
            background: var(--primary-red);
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(201, 24, 74, 0.2);
            margin-top: 20px;
        }
        
        .btn:hover {
            background: var(--vibrant-red);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(201, 24, 74, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            .container {
                padding: 25px;
            }
            
            h2 {
                font-size: 1.8rem;
            }
            
            th, td {
                padding: 12px 8px;
                font-size: 0.9rem;
            }
            
            img {
                max-width: 60px;
                max-height: 70px;
            }
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<div class="container">
    <h2>Your Fragrance Receipt</h2>
    
    <div class="order-info">
        <p><strong>Order ID:</strong> <?= htmlspecialchars($order['orderID']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($order['orderDate']) ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['description']) ?>"></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="4">Total:</td>
                <td>$<?= number_format($order['totalAmount'], 2) ?></td>
            </tr>
        </tbody>
    </table>

    <a href="/online_store/view/index.php" class="btn">Continue Shopping</a>
</div>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>