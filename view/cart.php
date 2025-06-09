<?php
session_start();

require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/models/Cart.php';
require_once __DIR__ . '/../app/controllers/CartController.php';

use App\Core\Database;
use App\Controllers\CartController;

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: /online_store/view/login.php');

    exit;
}

$userId = $_SESSION['user_id'];
$db = Database::connect();
$controller = new CartController($db);
$cartItems = $controller->getCart($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Shopping Cart</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f0f0f0; }
        .cart-item { background: #fff; border-radius: 8px; padding: 15px; margin-bottom: 10px; display: flex; gap: 20px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        .cart-item img { width: 100px; height: 100px; object-fit: cover; border-radius: 5px; }
        .cart-details { flex: 1; }
        .cart-details h4 { margin: 0; font-size: 18px; }
    </style>
</head>
<body>

    <h1>Your Cart</h1>

    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <?php foreach ($cartItems as $item): ?>
            <div class="cart-item">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="Product">
                <div class="cart-details">
                    <h4><?= htmlspecialchars($item['description']) ?></h4>
                    <p>Price: $<?= number_format($item['price'], 2) ?></p>
                    <p>Quantity: <?= $item['quantity'] ?></p>
                    <p>Total: $<?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>
