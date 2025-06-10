<!-- views/cart/checkout.php -->
<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <h1>Checkout</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h3>Order Summary</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Shipping</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['description']) ?></td>
                                    <td>$<?= number_format($item['price'], 2) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td>$<?= number_format($item['shippingCost'], 2) ?></td>
                                    <td>$<?= number_format(($item['price'] + $item['shippingCost']) * $item['quantity'], 2) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Payment</h3>
                </div>
                <div class="card-body">
                    <form action="/online_store/public/index.php?url=cart/processCheckout" method="post">
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
                        </div>
                        <div class="form-group">
                            <label>Expiration Date</label>
                            <input type="text" class="form-control" placeholder="MM/YY" required>
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="text" class="form-control" placeholder="123" required>
                        </div>
                        <div class="form-group">
                            <label>Name on Card</label>
                            <input type="text" class="form-control" placeholder="John Doe" required>
                        </div>
                        
                        <div class="text-center mt-4">
                            <h4>Total: $<?= number_format($this->cartModel->getCartTotal($_SESSION['user_id']), 2) ?></h4>
                            <button type="submit" class="btn btn-success btn-lg btn-block">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>