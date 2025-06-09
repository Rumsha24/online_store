<?php

require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/core/Database.php';

$database = new Database();
$db = $database->getConnection();
$controller = new ProductController($db);
$product = $controller->getSingleProduct();
?>

<?php include __DIR__ . '/header.php'; ?>

<style>
    body {
        background: #fff0f3;
        color: #590d22;
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    h1, h2 {
        color: #c9184a;
    }
    a, a:visited {
        color: #800f2f;
    }
    .hero-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 24px;
        padding: 16px 0;
        background: #ffb3c1;
    }
    .hero-section img {
        max-width: 320px;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(89,13,34,0.10);
    }
    .why-shop {
        background: #ffccd5;
        border-radius: 10px;
        margin: 0 auto 40px auto;
        padding: 30px 20px;
        color: #590d22;
        max-width: 800px;
        box-shadow: 0 2px 8px rgba(89,13,34,0.10);
    }
    .why-shop h2 {
        color: #c9184a;
    }
    .why-shop ul li {
        margin-bottom: 10px;
    }
    .featured-books-title {
        color: #c9184a;
        margin-bottom: 30px;
        text-align: center;
    }
    .perfumes-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        max-width: 1000px;
        margin: 0 auto 40px auto;
    }
    .perfume-card {
        flex: 0 0 30%;
        box-sizing: border-box;
        border: 1.5px solid #c9184a;
        padding: 18px 12px 20px 12px;
        text-align: center;
        margin-bottom: 20px;
        background: #ffb3c1;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(200,24,74,0.10);
        color: #590d22;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .perfume-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 6px 24px rgba(255, 77, 109, 0.15);
    }
    .perfume-card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 2px solid #ff4d6d;
        background: #ffccd5;
    }
    .book-card {
        flex: 0 0 30%;
        box-sizing: border-box;
        border: 1.5px solid #c9184a;
        padding: 18px 12px 20px 12px;
        text-align: center;
        margin-bottom: 20px;
        background: #ffb3c1;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(200,24,74,0.10);
        color: #590d22;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .book-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 6px 24px rgba(255, 77, 109, 0.15);
    }
    .book-card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 2px solid #ff4d6d;
        background: #ffccd5;
    }
    .book-card h2 {
        color: #c9184a;
        font-size: 1.2em;
        margin: 10px 0 8px 0;
    }
    .book-card p {
        margin: 6px 0;
        color: #800f2f;
    }
    .book-card form input[type="number"] {
        width: 50px;
        padding: 4px;
        border-radius: 4px;
        border: 1px solid #ff4d6d;
        background: #fff0f3;
        color: #590d22;
        margin-right: 8px;
    }
    .book-card form input[type="submit"] {
        background: #ff4d6d;
        color: #fff0f3;
        border: none;
        border-radius: 4px;
        padding: 6px 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.2s;
    }
    .book-card form input[type="submit"]:hover {
        background: #c9184a;
        color: #fff0f3;
    }
</style>

<!-- Welcome Section -->
<h1 style="text-align:center; color:#c9184a;">Welcome to Noire Essence!</h1>
<h2 style="text-align:center; color:#a4133c; font-weight:400;">Discover the Art of Fragrance</h2>
<p style="text-align:center; max-width:700px; margin: 0 auto 30px auto; color:#ff4d6d;">
    Indulge your senses with our carefully curated collection of perfumes crafted to leave a lasting impression. At <strong>[Your Brand Name]</strong>, each bottle is a story – a unique blend of elegance, identity, and allure.
</p>
<div style="display:flex; justify-content:center; gap:30px; margin-bottom:30px;">
    <span style="background:#ffb3c1; color:#590d22; padding:10px 24px; border-radius:20px; font-weight:bold;">✨ Luxury Scents</span>
    <span style="background:#ffccd5; color:#590d22; padding:10px 24px; border-radius:20px; font-weight:bold;">🌿 Natural Ingredients</span>
    <span style="background:#fff0f3; color:#a4133c; padding:10px 24px; border-radius:20px; font-weight:bold; border:1.5px solid #ffb3c1;">🌎 Sustainably Made</span>
</div>

<!-- Hero Image Centered -->
<div class="hero-section" style="display:flex; justify-content:center; align-items:center; margin-bottom:40px;">
    <img src="../images/1.jpg" alt="Elegant perfume bottles on display" style="max-width:100%; height:auto;" />
</div>

<!-- Four sections in a row: About Us, Our Collection, Why Choose Us, Customer Testimonials -->
<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 32px; margin-bottom: 40px;">
    <div class="why-shop" style="flex:1 1 220px; min-width:200px; max-width:300px; text-align:center;">
        <h2>About Us</h2>
        <p style="color:#800f2f;">
            <strong>Passion Meets Perfume</strong><br>
            Founded on a love for timeless elegance and aromatic beauty, <strong>[Your Brand Name]</strong> brings you artisanal fragrances inspired by nature, culture, and emotion. We believe a great scent doesn't just smell good – it tells your story.
        </p>
    </div>
    <div class="why-shop" style="flex:1 1 220px; min-width:200px; max-width:300px; text-align:center;">
        <h2>Our Collection</h2>
        <p style="color:#800f2f;">
            <strong>For Him, For Her, For All</strong><br>
            Explore our signature collections designed for every mood, moment, and memory.
        </p>
        <ul style="list-style:none; padding:0; color:#590d22;">
            <li style="margin-bottom:10px;"><strong>Eternal Bloom</strong> – A floral symphony that captures spring in a bottle</li>
            <li style="margin-bottom:10px;"><strong>Midnight Oud</strong> – A deep, woody blend for a bold statement</li>
            <li style="margin-bottom:10px;"><strong>Citrus Muse</strong> – Fresh, zesty, and endlessly energizing</li>
        </ul>
    </div>
    <div class="why-shop" style="flex:1 1 220px; min-width:200px; max-width:300px; text-align:center;">
        <h2>Why Choose Us?</h2>
        <ul style="list-style:none; padding:0;">
            <li style="margin-bottom:10px;">💎 <strong>Premium Ingredients</strong> sourced from around the world</li>
            <li style="margin-bottom:10px;">👃 <strong>Crafted by Master Perfumers</strong></li>
            <li style="margin-bottom:10px;">🌱 <strong>Cruelty-Free and Eco-Conscious</strong></li>
        </ul>
    </div>
    <div class="why-shop" style="flex:1 1 220px; min-width:200px; max-width:300px; text-align:center;">
        <h2>Customer Testimonials</h2>
        <p style="font-style:italic; color:#a4133c;">"The scent stays all day and makes me feel confident every time I wear it."<br><span style="color:#590d22;">– Julia M.</span></p>
        <p style="font-style:italic; color:#a4133c;">"A perfect gift for my partner – elegant and unforgettable."<br><span style="color:#590d22;">– Marc T.</span></p>
    </div>
</div>

<!-- Featured Perfumes -->
<h1 class="featured-perfumes-title" style="text-align:center; color:#c9184a;">Featured Perfumes</h1>
<div class="perfumes-row">
    <div class="perfume-card">
        <img src="../images/5.jpg" alt="Eternal Bloom Perfume Bottle" />
    </div>
    <div class="perfume-card">
        <img src="../images/2.jpg" alt="Midnight Oud Perfume Bottle" />
    </div>
    <div class="perfume-card">
        <img src="../images/3.jpg" alt="Citrus Muse Perfume Bottle" />
    </div>
</div>

<!-- Top Perfume & Cologne Brands -->
<h1 class="featured-perfumes-title" style="text-align:center; color:#c9184a;">Top Perfume & Cologne Brands</h1>
<div class="perfumes-row" style="margin-bottom:40px;">
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../images/7.png" alt="Jean Paul Gaultier" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">Jean Paul Gaultier</div>
    </div>
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../images/9.jpg" alt="Versace" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">Versace</div>
    </div>
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../images/14.jpeg" alt="Giorgio Armani" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">Giorgio Armani</div>
    </div>
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../images/18.avif" alt="D&G" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">D&G</div>
    </div>
    <div class="perfume-card" style="background:#fff0f3; border:1.5px solid #c9184a;">
        <img src="../images/21.png" alt="Calvin Klein" style="height:110px; background:#fff0f3; border-radius:10px; padding:8px; border:none;">
        <div style="font-weight:bold; color:#c9184a; margin-top:10px;">Calvin Klein</div>
    </div>
</div>
<div style="text-align:center; margin-bottom:32px;">
    <button style="background:#c9184a; color:#fff0f3; border:none; padding:10px 32px; border-radius:6px; font-weight:bold; letter-spacing:1px; cursor:pointer; box-shadow:0 2px 8px #ffb3c1;">VIEW ALL BRANDS</button>
</div>

<!-- New Arrivals -->
<div style="padding:32px 0 0 0;">
    <h2 style="text-align:center; color:#c9184a; letter-spacing:1px; font-size:1.2em; margin-bottom:18px; border-bottom:2px solid #ffb3c1; display:inline-block; width:100%;">NEW ARRIVALS</h2>
    <div style="display:flex; justify-content:center; align-items:flex-end; gap:24px; flex-wrap:wrap;">
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/23.webp" alt="New Arrival 1" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">ARMAF</div>
            <div style="color:#c9184a;">Now $59.99 CAD</div>
            <div style="text-decoration:line-through; color:#aaa;">$89.99 CAD</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/24.webp" alt="New Arrival 2" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">LATTAFA</div>
            <div style="color:#c9184a;">Best Price</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/25.jpg" alt="New Arrival 3" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">AZZARO</div>
            <div style="color:#c9184a;">$47.95 CAD</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/26.webp" alt="New Arrival 4" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">DOLCE & GABBANA</div>
            <div style="color:#c9184a;">$134.95 CAD</div>
        </div>
    </div>
    <div style="text-align:center; margin-top:18px;">
        <button style="background:#c9184a; color:#fff0f3; border:none; padding:8px 28px; border-radius:6px; font-weight:bold; letter-spacing:1px; cursor:pointer; box-shadow:0 2px 8px #ffb3c1;">VIEW ALL NEW ARRIVALS</button>
    </div>
</div>

<!-- Vintage Collection -->
<div style="padding:32px 0 0 0;">
    <h2 style="text-align:center; color:#c9184a; letter-spacing:1px; font-size:1.2em; margin-bottom:18px; border-bottom:2px solid #ffb3c1; display:inline-block; width:100%;">VINTAGE COLLECTION</h2>
    <div style="display:flex; justify-content:center; align-items:flex-end; gap:24px; flex-wrap:wrap;">
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/27.webp" alt="Burberry brit edp" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">Burberry brit edp</div>
            <div style="color:#c9184a;">$199.95 CAD</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/28.webp" alt="Armani acqua di gio profondo" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">Armani acqua di gio profondo</div>
            <div style="color:#c9184a;">$149.95 CAD</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/29.webp" alt="Lolita lempicka" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">Lolita lempicka</div>
            <div style="color:#c9184a;">$129.95 CAD</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/30.webp" alt="Burberry weekend" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">Burberry weekend</div>
            <div style="color:#c9184a;">$159.95 CAD</div>
        </div>
    </div>
    <div style="text-align:center; margin-top:18px;">
        <button style="background:#c9184a; color:#fff0f3; border:none; padding:8px 28px; border-radius:6px; font-weight:bold; letter-spacing:1px; cursor:pointer; box-shadow:0 2px 8px #ffb3c1;">VIEW ALL VINTAGE</button>
    </div>
</div>

<!-- Clearance Sales -->
<div style="padding:32px 0 40px 0;">
    <h2 style="text-align:center; color:#c9184a; letter-spacing:1px; font-size:1.2em; margin-bottom:18px; border-bottom:2px solid #ffb3c1; display:inline-block; width:100%;">CLEARANCE SALES!</h2>
    <div style="display:flex; justify-content:center; align-items:flex-end; gap:24px; flex-wrap:wrap;">
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/clear1.jpg" alt="Clearance 1" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">MALTESE</div>
            <div style="color:#c9184a;">$49.75 CAD</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/clear2.jpg" alt="Clearance 2" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">ALFRED SUNG</div>
            <div style="color:#c9184a;">$32.95 CAD</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/clear3.jpg" alt="Clearance 3" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">ESTEE LAUDER</div>
            <div style="color:#c9184a;">$99.95 CAD</div>
        </div>
        <div style="text-align:center; background:#fff0f3; border-radius:12px; padding:18px 12px; box-shadow:0 2px 8px #ffb3c1;">
            <img src="../images/clear4.jpg" alt="Clearance 4" style="height:140px; border-radius:8px; border:2px solid #ffb3c1;">
            <div style="font-weight:bold; color:#c9184a;">JOOP!</div>
            <div style="color:#c9184a;">$39.95 CAD</div>
        </div>
    </div>
    <div style="text-align:center; margin-top:18px;">
        <button style="background:#c9184a; color:#fff0f3; border:none; padding:8px 28px; border-radius:6px; font-weight:bold; letter-spacing:1px; cursor:pointer; box-shadow:0 2px 8px #ffb3c1;">VIEW ALL CLEARANCE SALES</button>
    </div>
</div>

<!-- Footer include remains -->
<?php include __DIR__ . '/footer.php'; ?>