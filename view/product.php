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
            font-family: 'Segoe UI', Arial, sans-serif;
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
        .product-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
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
        .wishlist-btn {
            background: none;
            border: 1.5px solid #ffb3c1;
            color: #c9184a;
            border-radius: 6px;
            padding: 8px 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.18s, color 0.18s;
            display: flex;
            align-items: center;
        }
        .wishlist-btn:hover {
            background: #ffb3c1;
            color: #fff;
        }
        .wishlist-btn i {
            margin-right: 6px;
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
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="1">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="1">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="product-card">
            <img src="/online_store/images/no .5 e.jpeg" alt="Chanel No. 5" class="product-image">
            <div class="brand-tag">CHANEL</div>
            <div class="product-info">
                <h3 class="product-title">No. 5 Eau de Parfum</h3>
                <p class="product-description">The ultimate feminine fragrance. A timeless floral-aldehydic composition.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$132.00</div>
                <div class="product-rating">★★★★★ (4.8)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="2">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="2">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 3 -->
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
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="3">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="3">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 4 -->
        <div class="product-card">
            <img src="/online_store/images/jadore.jpeg" alt="Dior J'adore" class="product-image">
            <div class="brand-tag">DIOR</div>
            <div class="product-info">
                <h3 class="product-title">J'adore Infinissime</h3>
                <p class="product-description">An intense floral bouquet with notes of jasmine, ylang-ylang, and Damascus rose.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$145.00</div>
                <div class="product-rating">★★★★★ (4.9)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="4">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="4">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 5 -->
        <div class="product-card">
            <img src="/online_store/images/bloom aqua.jpeg" alt="Gucci Bloom" class="product-image">
            <div class="brand-tag">GUCCI</div>
            <div class="product-info">
                <h3 class="product-title">Bloom Acqua di Fiori</h3>
                <p class="product-description">A green and floral fragrance with notes of honeysuckle, jasmine, and tuberose.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$98.00</div>
                <div class="product-rating">★★★★☆ (4.5)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="5">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="5">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 6 -->
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
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="6">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="6">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 7 -->
        <div class="product-card">
            <img src="/online_store/images/Daisy Love.jpeg" alt="Marc Jacobs Daisy" class="product-image">
            <div class="brand-tag">MARC JACOBS</div>
            <div class="product-info">
                <h3 class="product-title">Daisy Love</h3>
                <p class="product-description">A playful floral fragrance with notes of cloudberry, daisy petals, and cashmere musk.</p>
                <div class="product-size">75ml Eau de Toilette</div>
                <div class="product-price">$86.00</div>
                <div class="product-rating">★★★★☆ (4.4)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="7">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="7">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 8 -->
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
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="8">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="8">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 9 -->
        <div class="product-card">
            <img src="/online_store/images/Black orchid.jpeg" alt="Tom Ford Black Orchid" class="product-image">
            <div class="brand-tag">TOM FORD</div>
            <div class="product-info">
                <h3 class="product-title">Black Orchid</h3>
                <p class="product-description">A luxurious oriental floral with notes of black truffle, ylang-ylang, and patchouli.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$142.00</div>
                <div class="product-rating">★★★★★ (4.8)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="9">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="9">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 10 -->
        <div class="product-card">
            <img src="/online_store/images/Wood Sage & Sea Salt.jpeg" alt="Jo Malone Wood Sage" class="product-image">
            <div class="brand-tag">JO MALONE</div>
            <div class="product-info">
                <h3 class="product-title">Wood Sage & Sea Salt</h3>
                <p class="product-description">A fresh, woody fragrance with notes of ambrette seeds, sea salt, and sage.</p>
                <div class="product-size">100ml Cologne</div>
                <div class="product-price">$138.00</div>
                <div class="product-rating">★★★★★ (4.9)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="10">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="10">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 11 -->
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
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="11">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="11">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 12 -->
        <div class="product-card">
            <img src="/online_store/images/Twilly d'Hermès.jpeg" alt="Hermès Twilly" class="product-image">
            <div class="brand-tag">HERMÈS</div>
            <div class="product-info">
                <h3 class="product-title">Twilly d'Hermès</h3>
                <p class="product-description">A spicy floral with notes of ginger, tuberose, and sandalwood.</p>
                <div class="product-size">85ml Eau de Parfum</div>
                <div class="product-price">$125.00</div>
                <div class="product-rating">★★★★★ (4.7)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="12">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="12">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 13 -->
        <div class="product-card">
            <img src="/online_store/images/Light Blue Intense.jpeg" alt="Dolce&Gabbana Light Blue" class="product-image">
            <div class="brand-tag">DOLCE&GABBANA</div>
            <div class="product-info">
                <h3 class="product-title">Light Blue Intense</h3>
                <p class="product-description">A fresh Mediterranean fragrance with notes of lemon, jasmine, and amberwood.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$92.00</div>
                <div class="product-rating">★★★★☆ (4.5)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="13">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="13">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 14 -->
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
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="14">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="14">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

        <!-- Product 15 -->
        <div class="product-card">
            <img src="/online_store/images/flowerbomb.jpeg" alt="Viktor&Rolf Flowerbomb" class="product-image">
            <div class="brand-tag">VIKTOR&ROLF</div>
            <div class="product-info">
                <h3 class="product-title">Flowerbomb Dew</h3>
                <p class="product-description">A fresh floral explosion with notes of bergamot, peony, and musk.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$135.00</div>
                <div class="product-rating">★★★★☆ (4.6)</div>
                <div class="product-actions">
                    <form method="POST" action="/cart/add">
                        <input type="hidden" name="productID" value="15">
                        <button type="submit" class="add-to-cart">Add to Cart</button>
                    </form>
                    <button class="wishlist-btn" data-product-id="15">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </div>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.wishlist-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const productId = this.getAttribute('data-product-id');
                const isAdded = this.classList.contains('added');
                try {
                    const response = await fetch(isAdded ? '/wishlist/remove' : '/wishlist/add', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ product_id: productId })
                    });
                    const data = await response.json();
                    if (data.success) {
                        if (!isAdded) {
                            this.classList.add('added');
                            this.innerHTML = '<i class="fas fa-heart"></i> In Wishlist';
                            Swal.fire({
                                icon: 'success',
                                title: 'Added!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            this.classList.remove('added');
                            this.innerHTML = '<i class="far fa-heart"></i> Add to Wishlist';
                            Swal.fire({
                                icon: 'success',
                                title: 'Removed!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred'
                    });
                }
            });
        });
    });
    </script>
</body>

<?php include __DIR__ . '/footer.php'; ?>

</html>
