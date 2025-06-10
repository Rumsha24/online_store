<?php include __DIR__ . '/header.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Perfumes Collection</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
        }
        
        body {
            background-color: #fff0f3;
        }
        
        .page-title {
            text-align: center;
            margin: 30px 0;
            color: #590d22;
            font-size: 2.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(89, 13, 34, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(89, 13, 34, 0.2);
        }
        
        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 2px solid #ffccd5;
        }
        
        .product-info {
            padding: 20px;
            position: relative;
        }
        
        .brand-tag {
            position: absolute;
            top: -20px;
            right: 20px;
            background-color: #a4133c;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        
        .product-title {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #590d22;
            font-weight: 600;
        }
        
        .product-description {
            color: #800f2f;
            margin-bottom: 15px;
            font-size: 0.9rem;
            line-height: 1.5;
            min-height: 60px;
        }
        
        .product-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #c9184a;
            margin-bottom: 15px;
        }
        
        .product-rating {
            color: #ff8fa3;
            margin-bottom: 15px;
            font-size: 1rem;
        }
        
        .product-size {
            color: #590d22;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
        
        .add-to-cart {
            display: inline-block;
            background-color: #c9184a;
            color: white;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        
        .add-to-cart:hover {
            background-color: #a4133c;
            transform: scale(1.02);
        }
        
        .discount-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background-color: #ff4d6d;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 0.9rem;
            z-index: 2;
        }
        
        @media (max-width: 768px) {
            .products-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .page-title {
                font-size: 2rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <h1 class="page-title">Luxury Perfume Collection</h1>
    
    <div class="products-container">
        <!-- Product Card 1 -->
        <div class="product-card">
            <div class="discount-badge">-15%</div>
            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Versace Bright Crystal" class="product-image">
            <div class="brand-tag">VERSACE</div>
            <div class="product-info">
                <h3 class="product-title">Bright Crystal</h3>
                <p class="product-description">A luminous floral fragrance sparkling with fresh and juicy pomegranate and chilled yuzu.</p>
                <div class="product-size">100ml Eau de Toilette</div>
                <div class="product-price">$89.99 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$105.99</span></div>
                <div class="product-rating">★★★★★ (4.9)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 2 -->
        <div class="product-card">
            <img src="/online_store/images/no .5 e.jpeg" alt="Chanel No. 5" class="product-image">
            <div class="brand-tag">CHANEL</div>
            <div class="product-info">
                <h3 class="product-title">No. 5 Eau de Parfum</h3>
                <p class="product-description">The ultimate feminine fragrance. A timeless floral-aldehydic composition.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$132.00</div>
                <div class="product-rating">★★★★★ (4.8)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 3 -->
        <div class="product-card">
            <div class="discount-badge">-20%</div>
            <img src="/online_store/images/london dream.jpeg" alt="Burberry Her" class="product-image">
            <div class="brand-tag">BURBERRY</div>
            <div class="product-info">
                <h3 class="product-title">Her London Dream</h3>
                <p class="product-description">A vibrant fruity floral fragrance with notes of pear, blackcurrant, and jasmine.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$95.20 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$119.00</span></div>
                <div class="product-rating">★★★★☆ (4.6)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 4 -->
        <div class="product-card">
            <img src="/online_store/images/jadore.jpeg" alt="Dior J'adore" class="product-image">
            <div class="brand-tag">DIOR</div>
            <div class="product-info">
                <h3 class="product-title">J'adore Infinissime</h3>
                <p class="product-description">An intense floral bouquet with notes of jasmine, ylang-ylang, and Damascus rose.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$145.00</div>
                <div class="product-rating">★★★★★ (4.9)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 5 -->
        <div class="product-card">
            <img src="/online_store/images/bloom aqua.jpeg" alt="Gucci Bloom" class="product-image">
            <div class="brand-tag">GUCCI</div>
            <div class="product-info">
                <h3 class="product-title">Bloom Acqua di Fiori</h3>
                <p class="product-description">A green and floral fragrance with notes of honeysuckle, jasmine, and tuberose.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$98.00</div>
                <div class="product-rating">★★★★☆ (4.5)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 6 -->
        <div class="product-card">
            <div class="discount-badge">-10%</div>
            <img src="/online_store/images/black opium.jpeg" alt="YSL Black Opium" class="product-image">
            <div class="brand-tag">YVES SAINT LAURENT</div>
            <div class="product-info">
                <h3 class="product-title">Black Opium</h3>
                <p class="product-description">An addictive gourmand floral with notes of coffee, vanilla, and white flowers.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$107.10 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$119.00</span></div>
                <div class="product-rating">★★★★★ (4.7)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 7 -->
        <div class="product-card">
            <img src="/online_store/images/Daisy Love.jpeg" alt="Marc Jacobs Daisy" class="product-image">
            <div class="brand-tag">MARC JACOBS</div>
            <div class="product-info">
                <h3 class="product-title">Daisy Love</h3>
                <p class="product-description">A playful floral fragrance with notes of cloudberry, daisy petals, and cashmere musk.</p>
                <div class="product-size">75ml Eau de Toilette</div>
                <div class="product-price">$86.00</div>
                <div class="product-rating">★★★★☆ (4.4)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 8 -->
        <div class="product-card">
            <div class="discount-badge">-25%</div>
            <img src="/online_store/images/Candy Gloss.png" alt="Prada Candy" class="product-image">
            <div class="brand-tag">PRADA</div>
            <div class="product-info">
                <h3 class="product-title">Candy Gloss</h3>
                <p class="product-description">A sweet and sparkling fragrance with notes of citruses, musks, and benzoin.</p>
                <div class="product-size">80ml Eau de Parfum</div>
                <div class="product-price">$78.75 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$105.00</span></div>
                <div class="product-rating">★★★★☆ (4.3)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 9 -->
        <div class="product-card">
            <img src="/online_store/images/Black orchid.jpeg" alt="Tom Ford Black Orchid" class="product-image">
            <div class="brand-tag">TOM FORD</div>
            <div class="product-info">
                <h3 class="product-title">Black Orchid</h3>
                <p class="product-description">A luxurious oriental floral with notes of black truffle, ylang-ylang, and patchouli.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$142.00</div>
                <div class="product-rating">★★★★★ (4.8)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 10 -->
        <div class="product-card">
            <img src="/online_store/images/Wood Sage & Sea Salt.jpeg" alt="Jo Malone Wood Sage" class="product-image">
            <div class="brand-tag">JO MALONE</div>
            <div class="product-info">
                <h3 class="product-title">Wood Sage & Sea Salt</h3>
                <p class="product-description">A fresh, woody fragrance with notes of ambrette seeds, sea salt, and sage.</p>
                <div class="product-size">100ml Cologne</div>
                <div class="product-price">$138.00</div>
                <div class="product-rating">★★★★★ (4.9)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 11 -->
        <div class="product-card">
            <div class="discount-badge">-15%</div>
            <img src="/online_store/images/Si Passione.jpeg" alt="Armani Si" class="product-image">
            <div class="brand-tag">GIORGIO ARMANI</div>
            <div class="product-info">
                <h3 class="product-title">Si Passione</h3>
                <p class="product-description">A passionate fruity floral with notes of pear, rose, and vanilla.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$110.50 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$130.00</span></div>
                <div class="product-rating">★★★★☆ (4.6)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 12 -->
        <div class="product-card">
            <img src="/online_store/images/Twilly d'Hermès.jpeg" alt="Hermès Twilly" class="product-image">
            <div class="brand-tag">HERMÈS</div>
            <div class="product-info">
                <h3 class="product-title">Twilly d'Hermès</h3>
                <p class="product-description">A spicy floral with notes of ginger, tuberose, and sandalwood.</p>
                <div class="product-size">85ml Eau de Parfum</div>
                <div class="product-price">$125.00</div>
                <div class="product-rating">★★★★★ (4.7)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 13 -->
        <div class="product-card">
            <img src="/online_store/images/Light Blue Intense.jpeg" alt="Dolce&Gabbana Light Blue" class="product-image">
            <div class="brand-tag">DOLCE&GABBANA</div>
            <div class="product-info">
                <h3 class="product-title">Light Blue Intense</h3>
                <p class="product-description">A fresh Mediterranean fragrance with notes of lemon, jasmine, and amberwood.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$92.00</div>
                <div class="product-rating">★★★★☆ (4.5)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 14 -->
        <div class="product-card">
            <div class="discount-badge">-30%</div>
            <img src="/online_store/images/La Vie Est Belle.jpeg" alt="Lancôme La Vie Est Belle" class="product-image">
            <div class="brand-tag">LANCÔME</div>
            <div class="product-info">
                <h3 class="product-title">La Vie Est Belle</h3>
                <p class="product-description">A gourmand oriental with notes of iris, patchouli, and praline.</p>
                <div class="product-size">75ml Eau de Parfum</div>
                <div class="product-price">$97.30 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$139.00</span></div>
                <div class="product-rating">★★★★★ (4.8)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
        
        <!-- Product Card 15 -->
        <div class="product-card">
            <img src="/online_store/images/flowerbomb.jpeg" alt="Viktor&Rolf Flowerbomb" class="product-image">
            <div class="brand-tag">VIKTOR&ROLF</div>
            <div class="product-info">
                <h3 class="product-title">Flowerbomb Dew</h3>
                <p class="product-description">A fresh floral explosion with notes of bergamot, peony, and musk.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$135.00</div>
                <div class="product-rating">★★★★☆ (4.6)</div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
    </div>
</body>

<?php include __DIR__ . '/footer.php'; ?>

</html>