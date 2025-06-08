<!DOCTYPE html>
<html>
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
        nav {
            background-color: #800f2f;
            padding: 18px 0;
            box-shadow: 0 2px 8px rgba(89,13,34,0.10);
            text-align: center;
        }
        nav a {
            color: #c9184a;
            margin: 0 18px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
            transition: background 0.2s;
            padding: 7px 14px;
            border-radius: 4px;
        }
        nav a:hover, nav a.active, nav a:focus, nav a:visited {
            color: #c9184a !important;
            background: #ffb3c1;
            text-decoration: none;
        }
    </style>
</head>
<body>

<nav>
    <a href="/online_store/view/index.php">Home</a>
    <a href="/online_store/view/products.php">Products</a>
    <a href="/online_store/view/comments.php">Comments</a>
    <a href="/online_store/view/login.php">Login</a>
    <a href="/online_store/view/signup.php">Signup</a>
    <a href="/online_store/view/cart.php">Cart</a>
</nav>
