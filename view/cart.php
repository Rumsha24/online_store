<?php
// This view is typically included by CartController::view()
// It expects $products (an array of cart items) and $total (total amount) to be set.
// If CartController::view() handles non-logged-in state, $products might be empty.

// Include header file (assuming it's in the web root or adjust path)
include __DIR__ . '/header.php'; // Adjust path if necessary. For example, if cart.php is in 'views', and header is in root, it would be '../../header.php'

// Check if $products and $total are defined. They should be if CartController::view() is used.
$products = $products ?? []; // Default to empty array if not set
$total = $total ?? 0;       // Default to 0 if not set
$message = $message ?? ''; // Message from controller (e.g., "Please log in...")

?>

<h1>Your Shopping Cart</h1>

<?php if (!empty($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php elseif (empty($products)) : ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; max-width: 900px; margin: auto;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price (Each)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= (int)$p['quantity'] ?></td>
                    <td>$<?= number_format($p['price'], 2) ?></td>
                    <td>$<?= number_format($p['price'] * $p['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" style="text-align:right;"><strong>Total:</strong></td>
                <td><strong>$<?= number_format($total, 2) ?></strong></td>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<?php include __DIR__ . '/footer.php'; // Adjust path if necessary ?>
