<?php include __DIR__ . '/../header.php'; ?>

<?php
// Example: Fetch wishlist items for the current user
// Replace this with your actual fetching logic

// If you store wishlist in session:
$wishlistItems = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : [];

// OR if you fetch from database, do something like:
// require_once __DIR__ . '/../../app/models/Wishlist.php';
// $wishlistModel = new Wishlist($db);
// $wishlistItems = $wishlistModel->getWishlistByUser($userId);

?>

<style>
    .wishlist-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
        min-height: 60vh;
        background: #fff0f3;
        border-radius: 10px;
    }
    .wishlist-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #ffb3c1;
        padding-bottom: 15px;
    }
    .wishlist-title {
        color: #c9184a;
        font-size: 2rem;
        margin: 0;
    }
    .wishlist-count {
        background: #ff4d6d;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
    }
    .wishlist-empty {
        text-align: center;
        padding: 60px 0;
        background: #fff0f3;
        border-radius: 10px;
        margin-top: 30px;
    }
    .wishlist-empty h3 {
        color: #c9184a;
        margin-bottom: 20px;
    }
    .wishlist-empty a {
        color: #800f2f;
        text-decoration: underline;
    }
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 30px;
        justify-items: center;
    }
    .wishlist-item {
        width: 100%;
        max-width: 320px;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(201, 24, 74, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .wishlist-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(201, 24, 74, 0.15);
    }
    .wishlist-item-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-bottom: 2px solid #ffb3c1;
    }
    .wishlist-item-details {
        padding: 20px;
    }
    .wishlist-item-name {
        color: #590d22;
        font-size: 1.1rem;
        margin: 0 0 10px 0;
    }
    .wishlist-item-price {
        color: #c9184a;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 10px 0;
    }
    .wishlist-item-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }
    .wishlist-remove-btn {
        background: none;
        border: none;
        color: #c9184a;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color 0.2s;
    }
    .wishlist-remove-btn:hover {
        color: #800f2f;
    }
    .wishlist-add-to-cart {
        background: #c9184a;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .wishlist-add-to-cart:hover {
        background: #800f2f;
    }
    @media (max-width: 768px) {
        .wishlist-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
    }
</style>

<body>
    <div class="wishlist-container">
        <div class="wishlist-header">
            <h1 class="wishlist-title">My Wishlist</h1>
            <span class="wishlist-count"><?php echo count($wishlistItems); ?> items</span>
        </div>

        <?php if (empty($wishlistItems)): ?>
            <div class="wishlist-empty">
                <h3>Your wishlist is empty</h3>
                <p>Start adding items you love to your wishlist!</p>
                <p><a href="/product.php">Browse our collection</a></p>
            </div>
        <?php else: ?>
            <div class="wishlist-grid">
                <?php foreach ($wishlistItems as $item): ?>
                    <div class="wishlist-item" data-product-id="<?php echo $item['id']; ?>">
                        <img src="/images/products/<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="wishlist-item-img">
                        <div class="wishlist-item-details">
                            <h3 class="wishlist-item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <div class="wishlist-item-price">$<?php echo number_format($item['price'], 2); ?></div>
                            <div class="wishlist-item-actions">
                                <button class="wishlist-remove-btn" onclick="removeFromWishlist(<?php echo $item['id']; ?>)">
                                    <i class="fas fa-heart"></i> Remove
                                </button>
                                <button class="wishlist-add-to-cart">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function removeFromWishlist(productId) {
    fetch('/wishlist/remove', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the product from the DOM
            const item = document.querySelector(`.wishlist-item[data-product-id="${productId}"]`);
            if (item) item.remove();

            // Update the count
            const countElement = document.querySelector('.wishlist-count');
            countElement.textContent = data.count + ' items';

            // If no items left, show empty state
            if (data.count == 0) {
                document.querySelector('.wishlist-container').innerHTML = `
                    <div class="wishlist-header">
                        <h1 class="wishlist-title">My Wishlist</h1>
                        <span class="wishlist-count">0 items</span>
                    </div>
                    <div class="wishlist-empty">
                        <h3>Your wishlist is empty</h3>
                        <p>Start adding items you love to your wishlist!</p>
                        <p><a href="/products">Browse our collection</a></p>
                    </div>
                `;
            }

            Swal.fire({
                icon: 'success',
                title: 'Removed!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'An error occurred'
        });
    });
}

document.querySelectorAll('.wishlist-add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.closest('.wishlist-item').dataset.productId;

        // Add to cart logic here
        // For example, send a request to your server to add the item to the cart

        Swal.fire({
            icon: 'success',
            title: 'Added!',
            text: 'Item has been added to your cart.',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '/wishlist';
        });
    });
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>