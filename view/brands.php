<?php
include __DIR__ . '/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Brands - Perfume Store</title>
    <style>
        .brands-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .brands-title {
            text-align: center;
            color: #800f2f;
            font-size: 2.5em;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .brands-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #ff4d6d, #c9184a);
            border-radius: 2px;
        }
        
        .brands-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }
        
        .brand-card {
            background: #fff0f3;
            border: 1.5px solid #c9184a;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .brand-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(201, 24, 74, 0.1);
        }
        
        .brand-logo {
            height: 120px;
            width: 100%;
            object-fit: contain;
            background: white;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .brand-name {
            font-weight: bold;
            color: #590d22;
            font-size: 1.1em;
            margin-bottom: 10px;
        }
        
        .view-products-btn {
            background: #c9184a;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            font-size: 0.9em;
        }
        
        .view-products-btn:hover {
            background: #a4133c;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .brands-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 20px;
            }
            
            .brand-logo {
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="brands-container">
        <h1 class="brands-title">Our Luxury Brands</h1>
        
        <div class="brands-grid">
            <!-- Brand 1 -->
            <div class="brand-card">
                <a href="https://www.jeanpaulgaultier.com">
                    <img src="../images/7.png" alt="Jean Paul Gaultier" class="brand-logo">
                </a>
                <div class="brand-name">Jean Paul Gaultier</div>
                <a href="/online_store/view/products.php?brand=jean-paul-gaultier" class="view-products-btn">View Products</a>
            </div>
            
            <!-- Brand 2 -->
            <div class="brand-card">
                <a href="https://www.versace.com">
                    <img src="../images/9.jpg" alt="Versace" class="brand-logo">
                </a>
                <div class="brand-name">Versace</div>
                <a href="/online_store/view/products.php?brand=versace" class="view-products-btn">View Products</a>
            </div>
            
            <!-- Brand 3 -->
            <div class="brand-card">
                <a href="https://www.armani.com">
                    <img src="../images/14.jpeg" alt="Giorgio Armani" class="brand-logo">
                </a>
                <div class="brand-name">Giorgio Armani</div>
                <a href="/online_store/view/products.php?brand=giorgio-armani" class="view-products-btn">View Products</a>
            </div>
            
            <!-- Brand 4 -->
            <div class="brand-card">
                <a href="https://www.dolcegabbana.com">
                    <img src="../images/18.avif" alt="Dolce & Gabbana" class="brand-logo">
                </a>
                <div class="brand-name">Dolce & Gabbana</div>
                <a href="/online_store/view/products.php?brand=dolce-gabbana" class="view-products-btn">View Products</a>
            </div>
            
            <!-- Brand 5 -->
            <div class="brand-card">
                <a href="https://www.calvinklein.ca">
                    <img src="../images/21.png" alt="Calvin Klein" class="brand-logo">
                </a>
                <div class="brand-name">Calvin Klein</div>
                <a href="/online_store/view/products.php?brand=calvin-klein" class="view-products-btn">View Products</a>
            </div>
            
            <!-- Brand 6 (example additional brand) -->
            <div class="brand-card">
                <a href="https://www.chanel.com">
                    <img src="../images/5.jpg" alt="Chanel" class="brand-logo">
                </a>
                <div class="brand-name">Chanel</div>
                <a href="/online_store/view/products.php?brand=chanel" class="view-products-btn">View Products</a>
            </div>
            
            <!-- Brand 7 (example additional brand) -->
            <div class="brand-card">
                <a href="https://www.dior.com">
                    <img src="../images/25.jpg" alt="Dior" class="brand-logo">
                </a>
                <div class="brand-name">Dior</div>
                <a href="/online_store/view/products.php?brand=dior" class="view-products-btn">View Products</a>
            </div>
            
            <!-- Brand 8 (example additional brand) -->
            <div class="brand-card">
                <a href="https://www.gucci.com">
                    <img src="../images/22.png" alt="Gucci" class="brand-logo">
                </a>
                <div class="brand-name">Gucci</div>
                <a href="/online_store/view/products.php?brand=gucci" class="view-products-btn">View Products</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
include __DIR__ . '/footer.php';
?>