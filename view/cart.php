<?php include __DIR__ . '/header.php'; ?>

<h1>Your Shopping Cart</h1>

<?php if (empty($products)) : ?>
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

<?php include __DIR__ . '/footer.php'; ?>
