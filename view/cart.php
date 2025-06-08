-- Description: This file displays the user's shopping cart with items, prices, and quantities.
// It checks if the user is logged in, retrieves cart items from the database, and displays them in a styled format.

<?php
session_start();

// Include database and model/controller files
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/models/Cart.php';
require_once __DIR__ . '/../app/controllers/CartController.php';

// Use namespaces for classes
use App\Controllers\CartController;
use App\Core\Database;


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get current user's ID
$userId = $_SESSION['user_id'];

// Initialize CartController and fetch cart items for the user
$controller = new \App\Controllers\CartController($db);
$cartItems = $controller->getCart($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <style>
        /* Basic styling for cart page */
        body { font-family: Arial; padding: 20px; background: #f7f7f7; }
        .cart-item { background: #fff; padding: 15px; margin-bottom: 10px; border-radius: 8px; box-shadow: 0 0 5px #ccc; display: flex; gap: 15px; }
        .cart-item img { width: 100px; height: 100px; object-fit: cover; border-radius: 5px; }
        .cart-details { flex: 1; }
        .cart-details h4 { margin: 0 0 5px; }
    </style>
</head>
<body>

    <h1>Your Cart</h1>

    <?php if (empty($cartItems)): ?>
        <!-- Show message if cart is empty -->
        <p>Your cart is empty.</p>
    <?php else: ?>
        <!-- Loop through and display each cart item -->
        <?php foreach ($cartItems as $item): ?>
            <div class="cart-item">
                <!-- Product image -->
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="Product Image">
                <div class="cart-details">
                    <!-- Product description -->
                    <h4><?= htmlspecialchars($item['description']) ?></h4>
                    <!-- Product price -->
                    <p>Price: $<?= number_format($item['price'], 2) ?></p>
                    <!-- Quantity in cart -->
                    <p>Quantity: <?= $item['quantity'] ?></p>
                    <!-- Total price for this item -->
                    <p>Total: $<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>
