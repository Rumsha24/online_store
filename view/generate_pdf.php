<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Verify CSRF token if you're using one
if (!isset($_SESSION['user_id']) || ($_SERVER['REQUEST_METHOD'] === 'POST' && (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')))) {
    die("Access denied.");
}

$orderId = $_POST['order_id'] ?? null;
if (!$orderId) {
    die("Invalid order ID.");
}

$database = new Database();
$db = $database->getConnection();

// Fetch order details
$orderStmt = $db->prepare("SELECT * FROM orders WHERE orderID = :orderID AND userID = :userID");
$orderStmt->execute([':orderID' => $orderId, ':userID' => $_SESSION['user_id']]);
$order = $orderStmt->fetch();

if (!$order) {
    die("Order not found.");
}

// Fetch order items
$itemsStmt = $db->prepare("
    SELECT oi.*, p.name, p.description, p.image 
    FROM order_items oi
    JOIN products p ON oi.productID = p.productID
    WHERE oi.orderID = :orderID
");
$itemsStmt->execute([':orderID' => $orderId]);
$orderItems = $itemsStmt->fetchAll();

// Generate PDF
require_once __DIR__ . '/../lib/tcpdf/tcpdf.php';

try {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator('Noire Essence');
    $pdf->SetAuthor('Noire Essence');
    $pdf->SetTitle('Order Receipt #' . $orderId);
    $pdf->SetSubject('Order Receipt');
    
    // Set margins
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);
    
    // Add a page
    $pdf->AddPage();
    
    // Add logo
    $logoPath = __DIR__ . '/../images/logo.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 15, 10, 30, '', 'PNG');
    }
    
    // Set font and add content
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Noire Essence', 0, 1, 'R');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 5, 'Order Receipt', 0, 1, 'R');
    $pdf->Ln(15);
    
    // Order information
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Order #' . $orderId, 0, 1);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 7, 'Date: ' . $order['orderDate'], 0, 1);
    $pdf->Ln(10);
    
    // Products table
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(80, 7, 'Product', 1, 0, 'C');
    $pdf->Cell(30, 7, 'Price', 1, 0, 'C');
    $pdf->Cell(20, 7, 'Qty', 1, 0, 'C');
    $pdf->Cell(30, 7, 'Subtotal', 1, 1, 'C');
    
    $pdf->SetFont('helvetica', '', 10);
    foreach ($orderItems as $item) {
        $pdf->Cell(80, 20, $item['description'], 1, 0, 'L');
        $pdf->Cell(30, 20, '$' . number_format($item['price'], 2), 1, 0, 'R');
        $pdf->Cell(20, 20, $item['quantity'], 1, 0, 'C');
        $pdf->Cell(30, 20, '$' . number_format($item['price'] * $item['quantity'], 2), 1, 1, 'R');
    }
    
    // Total
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(130, 10, 'Total:', 1, 0, 'R');
    $pdf->Cell(30, 10, '$' . number_format($order['totalAmount'], 2), 1, 1, 'R');
    
    // Footer
    $pdf->Ln(15);
    $pdf->SetFont('helvetica', 'I', 10);
    $pdf->Cell(0, 10, 'Thank you for shopping with Noire Essence!', 0, 1, 'C');
    
    // Output PDF
    $pdf->Output('NoireEssence_Receipt_' . $orderId . '.pdf', 'D');
    exit;

} catch (Exception $e) {
    die("Error generating PDF: " . $e->getMessage());
}