<?php include __DIR__ . '/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Luxury Perfumes Collection</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        body {
            background: #fff0f3;
            color: #590d22;
            font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page-title {
            color: #c9184a;
            text-align: center;
            margin: 36px 0 28px 0;
            font-size: 2.2em;
            letter-spacing: 1px;
            font-weight: 700;
        }

        .products-container {
            max-width: 1200px;
            margin: 0 auto 40px auto;
            padding: 0 16px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
            justify-items: center;
        }

        @media (max-width: 1100px) {
            .products-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .products-container {
                grid-template-columns: 1fr;
            }
        }

        .product-card {
            background: #fff;
            border: 2px solid #ffb3c1;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(200,24,74,0.10);
            width: 270px;
            margin-bottom: 24px;
            transition: transform 0.18s, box-shadow 0.18s;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            padding: 18px 14px 22px 14px;
        }

        .product-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px #ffb3c1;
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ffb3c1;
            background: #fff0f3;
            margin-bottom: 14px;
        }

        .discount-badge {
            position: absolute;
            top: 18px;
            left: 18px;
            background: #ff4d6d;
            color: #fff0f3;
            font-size: 0.95em;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 12px;
            letter-spacing: 1px;
            box-shadow: 0 1px 4px #ffb3c1;
        }

        .brand-tag {
            color: #a4133c;
            font-weight: 600;
            font-size: 1.05em;
            margin-bottom: 6px;
            letter-spacing: 1px;
        }

        .product-info {
            width: 100%;
            text-align: left;
        }

        .product-title {
            color: #c9184a;
            font-size: 1.15em;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .product-description {
            color: #800f2f;
            font-size: 1em;
            margin-bottom: 8px;
        }

        .product-size {
            color: #590d22;
            font-size: 0.98em;
            margin-bottom: 8px;
        }

        .product-price {
            color: #c9184a;
            font-weight: bold;
            font-size: 1.1em;
            margin-bottom: 8px;
        }

        .product-price span {
            color: #999;
            font-size: 0.98em;
            margin-left: 6px;
        }

        .product-rating {
            color: #ff4d6d;
            font-size: 1em;
            margin-bottom: 10px;
        }

        .add-to-cart-form {
            display: flex;
            justify-content: center;
            margin-top: 8px;
        }

        .add-to-cart {
            background: #c9184a;
            color: #fff0f3;
            border: none;
            border-radius: 6px;
            padding: 8px 22px;
            font-weight: 600;
            font-size: 1em;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.18s;
            box-shadow: 0 2px 8px #ffb3c1;
        }

        .add-to-cart:hover {
            background: #a4133c;
        }

        @media (max-width: 900px) {
            .products-container {
                gap: 18px;
            }
            .product-card {
                width: 90vw;
                max-width: 340px;
            }
        }
    </style>
</head>
<body>
    <h1 class="page-title">Luxury Perfume Collection</h1>

    <div class="products-container">
        <!-- Product 1 -->
        <div class="product-card">
            <div class="discount-badge">-15%</div>
            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Versace Bright Crystal" class="product-image" />
            <div class="brand-tag">VERSACE</div>
            <div class="product-info">
                <h3 class="product-title">Bright Crystal</h3>
                <p class="product-description">A luminous floral fragrance sparkling with fresh and juicy pomegranate and chilled yuzu.</p>
                <div class="product-size">100ml Eau de Toilette</div>
                <div class="product-price">$89.99 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$105.99</span></div>
                <div class="product-rating">★★★★★ (4.9)</div>
               <form method="POST" action="/cart/add">
    <input type="hidden" name="productID" value="<?= $product['productID'] ?>">
    <button type="submit">Add to Cart</button>
</form>

            </div>
        </div>

        <!-- Product 2 -->
        <div class="product-card">
            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Chanel No. 5" class="product-image" />
            <div class="brand-tag">CHANEL</div>
            <div class="product-info">
                <h3 class="product-title">No. 5 Eau de Parfum</h3>
                <p class="product-description">The ultimate feminine fragrance. A timeless floral-aldehydic composition.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$132.00</div>
                <div class="product-rating">★★★★★ (4.8)</div>
                <form class="add-to-cart-form" data-product-id="2">
                    <button class="add-to-cart" type="submit">Add to Cart</button>
                </form>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="product-card">
            <div class="discount-badge">-20%</div>
            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Burberry Her" class="product-image" />
            <div class="brand-tag">BURBERRY</div>
            <div class="product-info">
                <h3 class="product-title">Her London Dream</h3>
                <p class="product-description">A vibrant fruity floral fragrance with notes of pear, blackcurrant, and jasmine.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$95.20 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$119.00</span></div>
                <div class="product-rating">★★★★☆ (4.6)</div>
                <form class="add-to-cart-form" data-product-id="3">
                    <button class="add-to-cart" type="submit">Add to Cart</button>
                </form>
            </div>
        </div>

        <!-- Product 4 -->
        <div class="product-card">
            <div class="discount-badge">-20%</div>
            <img src="https://images.unsplash.com/photo-1594035910387-fea47794261f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Burberry Her" class="product-image" />
            <div class="brand-tag">BURBERRY</div>
            <div class="product-info">
                <h3 class="product-title">Her London Dream</h3>
                <p class="product-description">A vibrant fruity floral fragrance with notes of pear, blackcurrant, and jasmine.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$95.20 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$119.00</span></div>
                <div class="product-rating">★★★★☆ (4.6)</div>
                <form class="add-to-cart-form" data-product-id="4">
                    <button class="add-to-cart" type="submit">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
<script>
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault(); // prevent normal form submission

            const productId = this.getAttribute('data-product-id');

            try {
                const response = await fetch('/online_store/public/?url=cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `product_id=${productId}`
                });

                const result = await response.text();
                console.log(result);

                if (response.ok) {
                    alert("Product added to cart!");
                } else {
                    alert("Failed to add product: " + result);
                }
            } catch (error) {
                alert("Fetch error: " + error);
            }
        });
    });
</script>


    
</body>

<?php include __DIR__ . '/footer.php'; ?>

</html>
