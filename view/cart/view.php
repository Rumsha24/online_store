<!-- views/cart/view.php -->
<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <h1>Your Shopping Cart</h1>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="/online_store/public/index.php?url=home/index" class="btn btn-primary">Continue Shopping</a>
    <?php else: ?>
        <form action="/online_store/public/index.php?url=cart/updateCart" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Shipping</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td>
                                <img src="/online_store/public/images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['description']) ?>" width="50">
                                <?= htmlspecialchars($item['description']) ?>
                            </td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <input type="number" name="quantity[<?= $item['productID'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control" style="width: 70px;">
                            </td>
                            <td>$<?= number_format($item['shippingCost'], 2) ?></td>
                            <td>$<?= number_format(($item['price'] + $item['shippingCost']) * $item['quantity'], 2) ?></td>
                            <td>
                                <a href="/online_store/public/index.php?url=cart/removeFromCart/<?= $item['productID'] ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                        <td><strong>$<?= number_format($cartTotal, 2) ?></strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Update Cart</button>
                <a href="/online_store/public/index.php?url=cart/checkout" class="btn btn-success">Proceed to Checkout</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>