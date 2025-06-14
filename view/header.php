
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Perfume Store</title>
    <style>
        body {
            background: #fff0f3;
            color: #590d22;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .topbar {
            background: #590d22;
            border-bottom: 2px solid #c9184a;
            padding: 0 0;
        }
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 70px;
        }
        .brand {
            font-size: 2em;
            font-weight: bold;
            color: #ffb3c1;
            letter-spacing: 2px;
            text-decoration: none;
            transition: color 0.2s;
            text-shadow: 0 2px 12px #000, 0 1px 0 #fff0f3;
            /* Stronger shadow for better visibility */
        }
        .brand:hover {
            color: #fff0f3;
            text-shadow: 0 2px 12px #c9184a, 0 1px 0 #ff4d6d;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }
        .nav-links a {
            color: #fff0f3;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: 500;
            padding: 8px 0;
            position: relative;
            transition: color 0.2s;
        }
        .nav-links a:visited {
            color: #ff758f; /* Softer pink from your palette for visited links */
        }
        .nav-links a::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: #ff4d6d;
            transition: width 0.3s;
            position: absolute;
            left: 0;
            bottom: -2px;
        }
        .nav-links a:hover,
        .nav-links a.active {
            color: #ffb3c1;
        }
        .nav-links a:hover::after,
        .nav-links a.active::after {
            width: 100%;
        }
        .nav-icons {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .nav-icons a {
            color: #fff0f3;
            font-size: 1.3em;
            text-decoration: none;
            transition: color 0.2s, transform 0.2s;
        }
        .nav-icons a:hover {
            color: #ff4d6d;
            transform: scale(1.15) rotate(-8deg);
        }
        @media (max-width: 900px) {
            .navbar-container {
                flex-direction: column;
                height: auto;
                padding: 0 10px;
            }
            .nav-links {
                gap: 18px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<div class="topbar">
    <div class="navbar-container">
<a href="/online_store/view/index.php" class="brand">NOIRE ESSENCE</a>
<div class="nav-links">
    <a href="/online_store/view/products.php">Vintage Collections</a>
    <a href="/online_store/view/order.php">Orders</a>
    <a href="/online_store/view/comments.php">Comments</a>
    <a href="/online_store/view/story.php">Our Story</a>
</div>
<div class="nav-icons">
    <a href="/online_store/view/login.php" title="Account"><i class="fa-regular fa-user"></i></a>
    <a href="/online_store/view/cart.php" title="Cart"><i class="fa-solid fa-cart-shopping"></i></a>
</div>
    </div>
</div>
