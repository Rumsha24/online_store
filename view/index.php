<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/../models/User.php';

    $db = (new Database())->getConnection();
    $userModel = new User($db);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userModel->login($email);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        header("Location: /noire-essence/view/index.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid email or password.";
        header("Location: /noire-essence/view/login.php");
        exit;
    }
}

require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductController($db);
$featuredProducts = $controller->getAllProducts();

// Initialize guest cart if not exists
if (!isset($_SESSION['guest_cart'])) {
    $_SESSION['guest_cart'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $productId = intval($_POST['product_id']);
    $quantity = max(1, intval($_POST['quantity']));
    
    if (isset($_SESSION['user_id'])) {
        require_once __DIR__ . '/../models/Cart.php';
        $cartModel = new Cart($db);
        $cartModel->addToCart($_SESSION['user_id'], $productId, $quantity);
    } else {
        if (isset($_SESSION['guest_cart'][$productId])) {
            $_SESSION['guest_cart'][$productId] += $quantity;
        } else {
            $_SESSION['guest_cart'][$productId] = $quantity;
        }
    }
    
    $_SESSION['cart_animation'] = true;
    header('Location: index.php');
    exit;
}
?>

<?php include __DIR__ . '/header.php'; ?>

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
        --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@700;800&display=swap');
    
    body {
        background: #ffffff;
        color: #333;
        font-family: 'Montserrat', 'Helvetica Neue', Arial, sans-serif;
        margin: 0;
        padding: 0;
        line-height: 1.7;
        overflow-x: hidden;
    }
    
    h1, h2, h3, h4 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--deep-red);
    }
    
    h1 {
        font-size: 3.2rem;
        margin-bottom: 1.5rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        line-height: 1.2;
    }
    
    h2 {
        font-size: 2.5rem;
        margin: 4rem 0 2rem;
        position: relative;
        display: inline-block;
    }
    
    h2:after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 80px;
        height: 4px;
        background: var(--bright-pink);
        transform-origin: left;
        transform: scaleX(0);
        transition: transform 0.8s cubic-bezier(0.86, 0, 0.07, 1);
    }
    
    h2.in-view:after {
        transform: scaleX(1);
    }
    
    a, a:visited {
        color: var(--primary-red);
        text-decoration: none;
        transition: var(--transition);
    }
    
    a:hover {
        color: var(--vibrant-red);
    }
    
    /* Hero Section */
    .hero-section {
        position: relative;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('../images/1.jpg') center/cover no-repeat;
        padding: 160px 20px;
        text-align: center;
        color: white;
        margin-bottom: 80px;
        overflow: hidden;
    }
    
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(201,24,74,0.2) 0%, rgba(89,13,34,0.4) 100%);
        opacity: 0;
        transition: opacity 1.2s ease;
    }
    
    .hero-section.animate::before {
        opacity: 1;
    }
    
    .hero-section h1 {
        color: white;
        font-size: 4.5rem;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease 0.2s, transform 0.8s cubic-bezier(0.33, 1, 0.68, 1) 0.2s;
    }
    
    .hero-section p {
        font-size: 1.4rem;
        max-width: 700px;
        margin: 0 auto;
        color: var(--very-pale-pink);
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease 0.4s, transform 0.8s cubic-bezier(0.33, 1, 0.68, 1) 0.4s;
    }
    
    .hero-section.animate h1,
    .hero-section.animate p {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Content Section */
    .content-section {
        max-width: 1300px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .intro-text {
        font-size: 1.25rem;
        line-height: 1.9;
        max-width: 800px;
        margin: 0 auto 80px;
        text-align: center;
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease 0.6s, transform 0.8s cubic-bezier(0.33, 1, 0.68, 1) 0.6s;
    }
    
    .intro-text.in-view {
        opacity: 1;
        transform: translateY(0);
    }
    
    /* Collection Grid */
    .collection-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 40px;
        margin: 80px 0;
    }
    
    .collection-card {
        border-radius: 16px;
        padding: 40px 30px;
        background: white;
        transition: var(--transition);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border: 1px solid var(--very-pale-pink);
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.33, 1, 0.68, 1), box-shadow 0.4s ease;
        will-change: transform;
    }
    
    .collection-card:nth-child(1) { transition-delay: 0.1s; }
    .collection-card:nth-child(2) { transition-delay: 0.2s; }
    .collection-card:nth-child(3) { transition-delay: 0.3s; }
    
    .collection-card.in-view {
        opacity: 1;
        transform: translateY(0);
    }
    
    .collection-card:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 16px 40px rgba(201, 24, 74, 0.12);
    }
    
    .collection-card h3 {
        color: var(--primary-red);
        font-size: 1.8rem;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--very-pale-pink);
    }
    
    .collection-card ul {
        list-style-type: none;
        padding: 0;
    }
    
    .collection-card li {
        margin-bottom: 16px;
        position: relative;
        padding-left: 32px;
        line-height: 1.7;
        opacity: 0;
        transform: translateX(-20px);
        transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.33, 1, 0.68, 1);
    }
    
    .collection-card.in-view li {
        opacity: 1;
        transform: translateX(0);
    }
    
    .collection-card li:nth-child(1) { transition-delay: 0.2s; }
    .collection-card li:nth-child(2) { transition-delay: 0.3s; }
    .collection-card li:nth-child(3) { transition-delay: 0.4s; }
    
    .collection-card li:before {
        content: "♥";
        color: var(--bright-pink);
        position: absolute;
        left: 0;
        top: 2px;
        font-size: 1.2rem;
        transition: var(--transition);
    }
    
    .collection-card li:hover:before {
        transform: scale(1.3);
        color: var(--primary-red);
    }
    
    /* Featured Products */
    .featured-products {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 40px;
        margin: 80px 0;
    }
    
    .product-card {
        text-align: center;
        padding: 30px;
        border-radius: 12px;
        background: white;
        transition: var(--transition);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border: 1px solid var(--very-pale-pink);
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.33, 1, 0.68, 1);
        will-change: transform;
    }
    
    .product-card.in-view {
        opacity: 1;
        transform: translateY(0);
    }
    
    .product-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 16px 40px rgba(201, 24, 74, 0.15);
    }
    
    .product-card img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        margin-bottom: 24px;
        border-radius: 10px;
        transition: var(--transition);
        transform: scale(0.98);
    }
    
    .product-card:hover img {
        transform: scale(1);
    }
    
    .product-card h3 {
        color: var(--rich-red);
        font-size: 1.4rem;
        margin-bottom: 16px;
        min-height: 60px;
        transition: var(--transition);
    }
    
    .product-card:hover h3 {
        color: var(--primary-red);
    }
    
    .product-card .price {
        color: var(--primary-red);
        font-weight: 700;
        font-size: 1.3rem;
        margin-bottom: 20px;
        display: block;
    }
    
    .product-card form {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
    }
    
    .product-card form input[type="number"] {
        width: 70px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid var(--very-pale-pink);
        text-align: center;
        font-size: 1rem;
        transition: var(--transition);
    }
    
    .product-card form input[type="number"]:focus {
        border-color: var(--primary-red);
        outline: none;
        box-shadow: 0 0 0 3px rgba(201,24,74,0.1);
    }
    
    .product-card form input[type="submit"] {
        background: var(--primary-red);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        cursor: pointer;
        transition: var(--transition);
        font-weight: 600;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
    }
    
    .product-card form input[type="submit"]:hover {
        background: var(--vibrant-red);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(201,24,74,0.3);
    }
    
    .product-card form input[type="submit"]:active {
        transform: translateY(0);
    }
    
    /* Testimonial */
    .testimonial {
        font-style: italic;
        text-align: center;
        margin: 100px auto;
        max-width: 900px;
        padding: 60px;
        background: var(--almost-white);
        border-radius: 20px;
        position: relative;
        opacity: 0;
        transform: scale(0.95);
        transition: opacity 1s ease, transform 1s cubic-bezier(0.33, 1, 0.68, 1);
    }
    
    .testimonial.in-view {
        opacity: 1;
        transform: scale(1);
    }
    
    .testimonial:before, .testimonial:after {
        content: '"';
        font-size: 6rem;
        color: var(--light-pink);
        position: absolute;
        opacity: 0.2;
        transition: var(--transition);
    }
    
    .testimonial:before {
        top: 20px;
        left: 30px;
        transform: translateY(-30px);
    }
    
    .testimonial:after {
        bottom: 20px;
        right: 30px;
        transform: translateY(30px);
    }
    
    .testimonial.in-view:before,
    .testimonial.in-view:after {
        transform: translateY(0);
        opacity: 0.3;
    }
    
    .testimonial p {
        font-size: 1.6rem;
        line-height: 1.8;
        margin-bottom: 24px;
        color: var(--deep-red);
        position: relative;
        z-index: 1;
    }
    
    .testimonial p:last-child {
        font-size: 1.2rem;
        color: var(--primary-red);
        font-weight: 600;
        font-style: normal;
    }
    
    /* Benefits Grid */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 50px;
        margin: 80px 0;
    }
    
    .benefit-card {
        text-align: center;
        padding: 40px 30px;
        background: white;
        border-radius: 16px;
        transition: var(--transition);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border: 1px solid var(--very-pale-pink);
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.33, 1, 0.68, 1);
    }
    
    .benefit-card.in-view {
        opacity: 1;
        transform: translateY(0);
    }
    
    .benefit-card:hover {
        transform: translateY(-8px) scale(1.03);
        box-shadow: 0 16px 40px rgba(201, 24, 74, 0.12);
    }
    
    .benefit-icon {
        font-size: 3.5rem;
        margin-bottom: 24px;
        color: var(--primary-red);
        transition: var(--transition);
        display: inline-block;
    }
    
    .benefit-card:hover .benefit-icon {
        transform: scale(1.2) translateY(-5px);
        color: var(--bright-pink);
    }
    
    .benefit-card h3 {
        font-size: 1.5rem;
        margin-bottom: 16px;
        color: var(--rich-red);
        transition: var(--transition);
    }
    
    .benefit-card:hover h3 {
        color: var(--primary-red);
    }
    
    .benefit-card p {
        color: #666;
        line-height: 1.8;
        font-size: 1.05rem;
    }
    
    /* Cart Animation */
    .cart-animation {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: var(--primary-red);
        color: white;
        padding: 18px 30px;
        border-radius: 50px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        z-index: 1000;
        display: flex;
        align-items: center;
        transform: translateY(120px);
        opacity: 0;
        animation: cartNotification 3.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .cart-animation i {
        margin-right: 12px;
        font-size: 1.4rem;
    }
    
    @keyframes cartNotification {
        0% { transform: translateY(120px); opacity: 0; }
        15% { transform: translateY(0); opacity: 1; }
        85% { transform: translateY(0); opacity: 1; }
        100% { transform: translateY(120px); opacity: 0; }
    }
    
    /* Ripple Effect */
    @keyframes ripple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        80% {
            opacity: 0.5;
        }
        100% {
            transform: scale(15);
            opacity: 0;
        }
    }
    
    /* Scroll Progress Indicator */
    .scroll-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 5px;
        background: linear-gradient(90deg, var(--primary-red), var(--bright-pink));
        z-index: 1000;
        transition: width 0.1s ease;
    }
    
    /* Floating CTA Button */
    .floating-cta {
        position: fixed;
        bottom: 30px;
        left: 30px;
        width: 60px;
        height: 60px;
        background: var(--primary-red);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 6px 20px rgba(201,24,74,0.3);
        z-index: 999;
        cursor: pointer;
        transition: var(--transition);
        transform: translateY(20px);
        opacity: 0;
    }
    
    .floating-cta.in-view {
        transform: translateY(0);
        opacity: 1;
    }
    
    .floating-cta:hover {
        background: var(--vibrant-red);
        transform: translateY(-5px) scale(1.1);
    }
    
    /* Responsive Styles */
    @media (max-width: 1024px) {
        .hero-section {
            padding: 120px 20px;
        }
        
        .hero-section h1 {
            font-size: 3.5rem;
        }
        
        h2 {
            font-size: 2.2rem;
        }
    }
    
    @media (max-width: 768px) {
        .hero-section {
            padding: 100px 20px;
            margin-bottom: 60px;
        }
        
        .hero-section h1 {
            font-size: 2.8rem;
        }
        
        .hero-section p {
            font-size: 1.2rem;
        }
        
        h2 {
            font-size: 2rem;
            margin: 3rem 0 1.5rem;
        }
        
        .collection-grid, .featured-products, .benefits-grid {
            grid-template-columns: 1fr;
            gap: 30px;
            margin: 60px 0;
        }
        
        .testimonial {
            padding: 40px 30px;
            margin: 60px auto;
        }
        
        .testimonial p {
            font-size: 1.4rem;
        }
    }
    
    @media (max-width: 480px) {
        .hero-section h1 {
            font-size: 2.2rem;
        }
        
        .hero-section p {
            font-size: 1.1rem;
        }
        
        .intro-text {
            font-size: 1.1rem;
        }
        
        .product-card form {
            flex-direction: column;
        }
        
        .floating-cta {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
            bottom: 20px;
            left: 20px;
        }
    }
</style>

<!-- Scroll progress indicator -->
<div class="scroll-progress"></div>

<!-- Floating CTA Button -->
<div class="floating-cta" id="floatingCta">
    <i class="fas fa-phone-alt"></i>
</div>

<!-- Cart notification -->
<?php if (isset($_SESSION['cart_animation'])): ?>
<div class="cart-animation" id="cartNotification">
    <i class="fas fa-check-circle"></i>
    <span>Item added to cart!</span>
</div>
<?php 
    unset($_SESSION['cart_animation']);
endif; ?>

<!-- Main Content -->
<div class="hero-section" id="hero">
    <h1>Noire Essence</h1>
    <p>Premium Fragrance Boutique</p>
</div>

<div style="display:flex; justify-content:center; gap:30px; margin-bottom:30px;">
    <span style="background:#ffb3c1; color:#590d22; padding:10px 24px; border-radius:20px; font-weight:bold;">✨ Luxury Scents</span>
    <span style="background:#ffccd5; color:#590d22; padding:10px 24px; border-radius:20px; font-weight:bold;">🌿 Natural Ingredients</span>
    <span style="background:#fff0f3; color:#a4133c; padding:10px 24px; border-radius:20px; font-weight:bold; border:1.5px solid #ffb3c1;">🌎 Sustainably Made</span>
</div>

<div class="content-section">
    <div class="intro-text" id="introText">
        <p>Discover the art of fragrance at Noire Essence, where each scent tells a story of elegance, identity, and timeless allure. Our carefully curated collection features the world's most exquisite perfumes and colognes, from iconic designer brands to exclusive niche creations.</p>
    </div>

    <h2 id="collectionsTitle">Featured Collections</h2>
    <div class="collection-grid">
        <div class="collection-card" id="collection1">
            <h3>Luxury Scents</h3>
            <ul>
                <li><strong>Signature Collections</strong>: Our most beloved fragrances</li>
                <li><strong>Designer Exclusives</strong>: Authentic perfumes from top fashion houses</li>
                <li><strong>Niche Creations</strong>: Rare, artisanal scents</li>
            </ul>
        </div>
        
        <div class="collection-card" id="collection2">
            <h3>New Arrivals</h3>
            <ul>
                <li><strong>Seasonal Limited Editions</strong>: Capture the essence of each season</li>
                <li><strong>Emerging Brands</strong>: Discover tomorrow's iconic fragrances</li>
                <li><strong>Reformulated Classics</strong>: Beloved scents with modern twists</li>
            </ul>
        </div>
        
        <div class="collection-card" id="collection3">
            <h3>Vintage Collection</h3>
            <ul>
                <li><strong>Discontinued Treasures</strong>: Rare finds from fragrance history</li>
                <li><strong>Retro Classics</strong>: The scents that defined generations</li>
                <li><strong>Collector's Items</strong>: Highly sought-after vintage formulations</li>
            </ul>
        </div>
    </div>

    <h2 id="benefitsTitle">Why Choose Noire Essence?</h2>
    <div class="benefits-grid">
        <div class="benefit-card" id="benefit1">
            <div class="benefit-icon">✓</div>
            <h3>Authenticity Guarantee</h3>
            <p>Every product is 100% genuine with verifiable provenance and direct from manufacturers.</p>
        </div>
        <div class="benefit-card" id="benefit2">
            <div class="benefit-icon">✧</div>
            <h3>Expert Curation</h3>
            <p>Our fragrance specialists with decades of experience select only the finest quality scents.</p>
        </div>
        <div class="benefit-card" id="benefit3">
            <div class="benefit-icon">♥</div>
            <h3>Personalized Service</h3>
            <p>Get tailored recommendations based on your preferences with our fragrance matching quiz.</p>
        </div>
        <div class="benefit-card" id="benefit4">
            <div class="benefit-icon">♻</div>
            <h3>Sustainable Packaging</h3>
            <p>Beautiful presentation that respects the environment with recyclable and biodegradable materials.</p>
        </div>
    </div>

    <!-- Top Perfume & Cologne Brands -->
<h1 class="featured-perfumes-title" style="text-align:center; color:#c9184a;">Top Perfume & Cologne Brands</h1>
<div class="perfumes-row" style="margin-bottom:40px;">
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../../images/7.png" alt="Jean Paul Gaultier" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">Jean Paul Gaultier</div>
    </div>
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../../images/9.jpg" alt="Versace" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">Versace</div>
    </div>
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../../images/14.jpeg" alt="Giorgio Armani" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">Giorgio Armani</div>
    </div>
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../../images/18.avif" alt="D&G" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">D&G</div>
    </div>
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../../images/21.png" alt="Calvin Klein" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">Calvin Klein</div>
    </div>
</div>
<div style="text-align:center; margin-bottom:32px;">
    <button style="background:#c9184a; color:#fff0f3; border:none; padding:10px 32px; border-radius:6px; font-weight:bold; letter-spacing:1px; cursor:pointer; box-shadow:0 2px 8px #ffb3c1;">VIEW ALL BRANDS</button>
</div>

    <h2 id="productsTitle">Customer Favorites</h2>
    <div class="featured-products">
        <?php foreach ($featuredProducts as $product): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['description']) ?>">
            <h3><?= htmlspecialchars($product['description']) ?></h3>
            <span class="price">$<?= number_format($product['price'], 2) ?></span>
            <form method="post" action="index.php" class="add-to-cart-form">
                <input type="hidden" name="product_id" value="<?= $product['productID'] ?>">
                <input type="number" name="quantity" value="1" min="1">
                <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="testimonial" id="testimonial">
        <p>A fragrance is more than a scent - it's an invisible accessory that completes your style, a signature that lingers even after you've left the room.</p>
        <p>- Sophia Laurent, Founder of Noire Essence</p>
    </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initial animations
        setTimeout(() => {
            document.getElementById('hero').classList.add('animate');
        }, 100);
        
        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    
                    // Add ripple effect to benefit icons when they come into view
                    if (entry.target.classList.contains('benefit-card')) {
                        const icon = entry.target.querySelector('.benefit-icon');
                        icon.style.animation = 'none';
                        void icon.offsetWidth; // Trigger reflow
                        icon.style.animation = 'pulse 0.6s ease';
                    }
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        });
        
        // Observe all animated elements
        const animatedElements = [
            document.getElementById('introText'),
            document.getElementById('collectionsTitle'),
            document.getElementById('collection1'),
            document.getElementById('collection2'),
            document.getElementById('collection3'),
            document.getElementById('benefitsTitle'),
            document.getElementById('benefit1'),
            document.getElementById('benefit2'),
            document.getElementById('benefit3'),
            document.getElementById('benefit4'),
            document.getElementById('productsTitle'),
            document.getElementById('testimonial'),
            document.getElementById('floatingCta'),
            ...document.querySelectorAll('.product-card')
        ];
        
        animatedElements.forEach(el => el && observer.observe(el));
        
        // Scroll progress indicator
        window.addEventListener('scroll', function() {
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollProgress = (scrollTop / scrollHeight) * 100;
            document.querySelector('.scroll-progress').style.width = scrollProgress + '%';
        });
        
        // Cart notification animation
        const cartNotification = document.getElementById('cartNotification');
        if (cartNotification) {
            setTimeout(() => {
                cartNotification.style.display = 'none';
            }, 3500);
        }
        
        // Add to cart button animations
        const addToCartForms = document.querySelectorAll('.add-to-cart-form');
        addToCartForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('input[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.value = 'Adding...';
                
                // Create ripple effect
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.pointerEvents = 'none';
                
                // Position ripple
                const rect = submitBtn.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = (rect.width/2 - size/2) + 'px';
                ripple.style.top = (rect.height/2 - size/2) + 'px';
                
                submitBtn.style.position = 'relative';
                submitBtn.style.overflow = 'hidden';
                submitBtn.appendChild(ripple);
                
                // Remove ripple after animation
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
        
        // Floating CTA click handler
        const floatingCta = document.getElementById('floatingCta');
        if (floatingCta) {
            floatingCta.addEventListener('click', function() {
                // Replace with your contact action
                alert('Contact our fragrance specialists at +1 (555) 123-4567');
            });
        }
        
        // Add pulse animation for benefit icons
        const style = document.createElement('style');
        style.textContent = `
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.3); }
                100% { transform: scale(1); }
            }
        `;
        document.head.appendChild(style);
    });
</script>

<?php include __DIR__ . '/footer.php'; ?>