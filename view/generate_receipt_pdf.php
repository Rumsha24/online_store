<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../tcpdf/tcpdf.php';  // Adjust path to tcpdf.php

if (!isset($_GET['order_id'])) {
    die('Order ID missing');
}

$orderId = $_GET['order_id'];

$database = new Database();
$db = $database->getConnection();

// Get order info
$orderStmt = $db->prepare("SELECT * FROM orders WHERE id = :orderId");
$orderStmt->execute([':orderId' => $orderId]);
$order = $orderStmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die('Order not found.');
}

// Get order items with product details
$itemsStmt = $db->prepare("
    SELECT oi.*, p.description, p.image 
    FROM order_items oi 
    JOIN products p ON oi.productID = p.id 
    WHERE oi.orderID = :orderId
");
$itemsStmt->execute([':orderId' => $orderId]);
$items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

// Create new PDF document
$pdf = new TCPDF();
$pdf->SetCreator('Your Shop');
$pdf->SetAuthor('Your Shop');
$pdf->SetTitle("Receipt for Order #$orderId");
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = "<h2>Receipt for Order #$orderId</h2>";
$html .= "<p><strong>Order Date:</strong> " . htmlspecialchars($order['created_at'] ?? date('Y-m-d')) . "</p>";
$html .= "<table border=\"1\" cellpadding=\"5\" cellspacing=\"0\">
<thead>
<tr>
<th>Product</th><th>Description</th><th>Price</th><th>Quantity</th><th>Subtotal</th>
</tr>
</thead><tbody>";

$total = 0;
foreach ($items as $item) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
    $html .= "<tr>
        <td><img src='" . htmlspecialchars($item['image']) . "' width='40' height='50'></td>
        <td>" . htmlspecialchars($item['description']) . "</td>
        <td>$" . number_format($item['price'], 2) . "</td>
        <td>" . $item['quantity'] . "</td>
        <td>$" . number_format($subtotal, 2) . "</td>
    </tr>";
}
$html .= "<tr>
    <td colspan='4' align='right'><strong>Total Paid:</strong></td>
    <td>$" . number_format($total, 2) . "</td>
</tr>";
$html .= "</tbody></table>";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("receipt_order_$orderId.pdf", 'I');  // Output inline in browser
