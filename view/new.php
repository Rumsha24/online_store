<?php include __DIR__ . '/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>New Perfumes Collection</title>
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
    <h1 class="page-title"> New Perfumes Collection</h1>
    <div class="products-container">

        <!-- Product 1 -->
        <div class="product-card">
            <div class="discount-badge">-15%</div>
            <img src="/online_store/images/Velvet Aurora.jpeg" alt="Velvet Aurora" class="product-image" />
            <div class="brand-tag">NOIRE ESSENCE</div>
            <div class="product-info">
                <h3 class="product-title">Velvet Aurora</h3>
                <p class="product-description">A radiant blend of violet, musk, and soft amber for a dreamy evening.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$99.00 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$115.00</span></div>
                <div class="product-rating">★★★★★ (4.8)</div>
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
            <img src="/online_store/images/Midnight Peony.jpeg" alt="Midnight Peony" class="product-image">
            <div class="brand-tag">LUMIÈRE</div>
            <div class="product-info">
                <h3 class="product-title">Midnight Peony</h3>
                <p class="product-description">Peony and blackcurrant wrapped in a mysterious vanilla base.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$120.00</div>
                <div class="product-rating">★★★★☆ (4.5)</div>
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
            <img src="/online_store/images/Amber Whisper.jpeg" alt="Amber Whisper" class="product-image">
            <div class="brand-tag">AMBER & CO.</div>
            <div class="product-info">
                <h3 class="product-title">Amber Whisper</h3>
                <p class="product-description">Warm amber, sandalwood, and a hint of fig for a cozy embrace.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$88.00 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$110.00</span></div>
                <div class="product-rating">★★★★★ (4.7)</div>
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
            <img src="/online_store/images/Celestial Bloom.jpeg" alt="Celestial Bloom" class="product-image">
            <div class="brand-tag">CELESTE</div>
            <div class="product-info">
                <h3 class="product-title">Celestial Bloom</h3>
                <p class="product-description">A celestial bouquet of jasmine, neroli, and white tea.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$135.00</div>
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
            <img src="/online_store/images/ROSEWOOD.jpeg" alt="Rosewood Reverie" class="product-image">
            <div class="brand-tag">ROSEWOOD</div>
            <div class="product-info">
                <h3 class="product-title">Rosewood Reverie</h3>
                <p class="product-description">Rose, cedar, and a touch of citrus for a modern classic.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$105.00</div>
                <div class="product-rating">★★★★☆ (4.4)</div>
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
            <img src="/online_store/images/Golden Mirage.jpeg" alt="Golden Mirage" class="product-image">
            <div class="brand-tag">MIRAGE</div>
            <div class="product-info">
                <h3 class="product-title">Golden Mirage</h3>
                <p class="product-description">A sparkling blend of saffron, pear, and golden woods.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$112.50 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$125.00</span></div>
                <div class="product-rating">★★★★★ (4.6)</div>
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
            <img src="/online_store/images/Lush Serenity.jpeg" alt="Lush Serenity" class="product-image">
            <div class="brand-tag">SERENITY</div>
            <div class="product-info">
                <h3 class="product-title">Lush Serenity</h3>
                <p class="product-description">Green tea, bamboo, and lotus for a calming escape.</p>
                <div class="product-size">75ml Eau de Toilette</div>
                <div class="product-price">$89.00</div>
                <div class="product-rating">★★★★☆ (4.3)</div>
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
            <img src="/online_store/images/Moonlit Jasmine.jpeg" alt="Moonlit Jasmine" class="product-image">
            <div class="brand-tag">LUNA</div>
            <div class="product-info">
                <h3 class="product-title">Moonlit Jasmine</h3>
                <p class="product-description">Night-blooming jasmine with hints of citrus and musk.</p>
                <div class="product-size">80ml Eau de Parfum</div>
                <div class="product-price">$75.00 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$100.00</span></div>
                <div class="product-rating">★★★★☆ (4.2)</div>
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
            <img src="/online_store/images/Saffron Veil.jpeg" alt="Saffron Veil" class="product-image">
            <div class="brand-tag">SAFFRON</div>
            <div class="product-info">
                <h3 class="product-title">Saffron Veil</h3>
                <p class="product-description">Saffron, rose, and creamy sandalwood for a rich finish.</p>
                <div class="product-size">50ml Eau de Parfum</div>
                <div class="product-price">$120.00</div>
                <div class="product-rating">★★★★★ (4.7)</div>
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
            <img src="/online_store/images/Petal Noir.jpeg" alt="Petal Noir" class="product-image">
            <div class="brand-tag">NOIR</div>
            <div class="product-info">
                <h3 class="product-title">Petal Noir</h3>
                <p class="product-description">Dark rose, patchouli, and black pepper for a bold statement.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$130.00</div>
                <div class="product-rating">★★★★★ (4.8)</div>
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
            <img src="/online_store/images/Azure Muse.jpeg" alt="Azure Muse" class="product-image">
            <div class="brand-tag">AZURE</div>
            <div class="product-info">
                <h3 class="product-title">Azure Muse</h3>
                <p class="product-description">Aquatic notes, blue lotus, and driftwood for a fresh vibe.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$108.00 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$127.00</span></div>
                <div class="product-rating">★★★★☆ (4.5)</div>
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
            <img src="/online_store/images/Blush Ember.jpeg" alt="Blush Ember" class="product-image">
            <div class="brand-tag">EMBER</div>
            <div class="product-info">
                <h3 class="product-title">Blush Ember</h3>
                <p class="product-description">Pink pepper, rose, and smoky woods for a warm embrace.</p>
                <div class="product-size">85ml Eau de Parfum</div>
                <div class="product-price">$118.00</div>
                <div class="product-rating">★★★★★ (4.6)</div>
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
            <img src="/online_store/images/Opal Essence.jpeg" alt="Opal Essence" class="product-image">
            <div class="brand-tag">OPAL</div>
            <div class="product-info">
                <h3 class="product-title">Opal Essence</h3>
                <p class="product-description">Iris, white musk, and pear for a luminous signature.</p>
                <div class="product-size">100ml Eau de Parfum</div>
                <div class="product-price">$95.00</div>
                <div class="product-rating">★★★★☆ (4.4)</div>
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
            <img src="/online_store/images/Wild Iris.jpeg" alt="Wild Iris" class="product-image">
            <div class="brand-tag">WILD BLOOM</div>
            <div class="product-info">
                <h3 class="product-title">Wild Iris</h3>
                <p class="product-description">Wild iris, bergamot, and vetiver for a fresh, green scent.</p>
                <div class="product-size">75ml Eau de Parfum</div>
                <div class="product-price">$89.00 <span style="text-decoration: line-through; color: #999; font-size: 1rem;">$127.00</span></div>
                <div class="product-rating">★★★★★ (4.7)</div>
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
            <img src="/online_store/images/Enchanted Fig.jpeg" alt="Enchanted Fig" class="product-image">
            <div class="brand-tag">ENCHANTÉ</div>
            <div class="product-info">
                <h3 class="product-title">Enchanted Fig</h3>
                <p class="product-description">Fig, coconut, and tonka bean for a sweet, creamy finish.</p>
                <div class="product-size">90ml Eau de Parfum</div>
                <div class="product-price">$122.00</div>
                <div class="product-rating">★★★★☆ (4.5)</div>
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