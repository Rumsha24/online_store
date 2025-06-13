<?php
session_start();

// Initialize guest cart if not exists
if (!isset($_SESSION['guest_cart'])) {
    $_SESSION['guest_cart'] = [];
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Cart.php';

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);
$cartModel = new Cart($db);

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = intval($_POST['product_id']);
    $quantity = max(1, intval($_POST['quantity']));
    
    if (isset($_SESSION['user_id'])) {
        $cartModel->addToCart($_SESSION['user_id'], $productId, $quantity);
    } else {
        if (isset($_SESSION['guest_cart'][$productId])) {
            $_SESSION['guest_cart'][$productId] += $quantity;
        } else {
            $_SESSION['guest_cart'][$productId] = $quantity;
        }
    }
    header('Location: cart.php');
    exit;
}

// Get all products
$products = $productModel->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Noire Essence | Products</title>
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
        
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--almost-white);
            color: var(--deep-red);
        }
        main {
            flex: 1 0 auto;
            padding: 20px;
            background: white;
        }
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .product-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(89, 13, 34, 0.1);
            padding: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--very-pale-pink);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(201, 24, 74, 0.15);
        }
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(201, 24, 74, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .product-card:hover::before {
            opacity: 1;
        }
        .product-image {
            width: 200px;
            height: 250px;
            object-fit: contain;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid var(--very-pale-pink);
            background: white;
            transition: transform 0.3s ease;
        }
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        .product-description {
            font-size: 1.1em;
            margin-bottom: 10px;
            color: var(--deep-red);
            transition: color 0.3s ease;
        }
        .product-card:hover .product-description {
            color: var(--primary-red);
        }
        .product-price {
            font-size: 1.2em;
            font-weight: bold;
            color: var(--primary-red);
            margin-bottom: 15px;
            position: relative;
        }
        .product-price::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--bright-pink);
            transition: width 0.3s ease;
        }
        .product-card:hover .product-price::after {
            width: 50%;
        }
        .add-to-cart-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        input[type="number"] {
            width: 60px;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid var(--very-pale-pink);
            background: white;
            color: var(--deep-red);
            transition: all 0.3s ease;
        }
        input[type="number"]:focus {
            border-color: var(--primary-red);
            outline: none;
            box-shadow: 0 0 0 2px rgba(201, 24, 74, 0.2);
        }
        button {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        button:hover {
            background: var(--vibrant-red);
            transform: translateY(-2px);
        }
        button:active {
            transform: translateY(0);
            background: var(--rich-red);
        }
        button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        button:focus:not(:active)::after {
            animation: ripple 0.6s ease-out;
        }
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        .cart-count {
            background: var(--bright-pink);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.9em;
            margin-left: 5px;
            transition: all 0.3s ease;
        }
        .cart-count:hover {
            transform: scale(1.1);
            background: var(--soft-pink);
        }
        h1 {
            color: var(--deep-red);
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }
        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--bright-pink);
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/header.php'; ?>

<main>
    <h1>Our Fragrance Collection</h1>
    
    <div class="products-grid">
        <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['description']) ?>" class="product-image" />
            <div class="product-description"><?= htmlspecialchars($product['description']) ?></div>
            <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
            <form method="post" action="products.php" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= $product['productID'] ?>" />
                <input type="number" name="quantity" value="1" min="1" />
                <button type="submit" name="add_to_cart">Add to Cart</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include __DIR__ . '/footer.php'; ?>
</body>
</html>