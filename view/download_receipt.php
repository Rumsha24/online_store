<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Include autoload for DOMPDF
require_once __DIR__ . '/../libs/dompdf/autoload.inc.php'; 

use Dompdf\Dompdf;

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

// Build HTML content for PDF (similar to your receipt page)
$html = '
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { color: #6B46C1; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f0e9ff; color: #6B46C1; }
        .total-row td { font-weight: bold; font-size: 1.1em; }
        img { max-width: 60px; max-height: 70px; }
    </style>
</head>
<body>
    <h2>Order Receipt</h2>
    <p><strong>Order ID:</strong> ' . htmlspecialchars($order['orderID']) . '</p>
    <p><strong>Date:</strong> ' . htmlspecialchars($order['orderDate']) . '</p>
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
        <tbody>';

foreach ($orderItems as $item) {
    $html .= '<tr>
                <td><img src="' . htmlspecialchars($item['image']) . '" alt="Product Image"></td>
                <td>' . htmlspecialchars($item['description']) . '</td>
                <td>$' . number_format($item['price'], 2) . '</td>
                <td>' . $item['quantity'] . '</td>
                <td>$' . number_format($item['price'] * $item['quantity'], 2) . '</td>
              </tr>';
}

$html .= '<tr class="total-row">
            <td colspan="4" style="text-align: right;">Total:</td>
            <td>$' . number_format($order['totalAmount'], 2) . '</td>
          </tr>
        </tbody>
    </table>
</body>
</html>';

// Initialize DOMPDF and load HTML
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// Setup paper size and orientation
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Send PDF to browser and force download with filename
$dompdf->stream("order_receipt_{$orderId}.pdf", ["Attachment" => true]);

exit;
