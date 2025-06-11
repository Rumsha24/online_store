<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
?>

<?php include __DIR__ . '/../header.php'; ?>

<?php
$wishlistItems = isset($wishlistItems) ? $wishlistItems : [];
?>

<style>
body {
    background: #fff0f3;
    font-family: 'Montserrat', Arial, sans-serif;
    margin: 0;
    padding: 0;
}
.wishlist-container {
    max-width: 900px;
    margin: 40px auto 0 auto;
    background: #fff;
    padding: 32px 28px 32px 28px;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(201, 24, 74, 0.10);
    border: 2px solid #ffb3c1;
}
.wishlist-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}
.wishlist-title {
    color: #c9184a;
    font-size: 2em;
    font-weight: 700;
    letter-spacing: 1px;
    margin: 0;
}
.wishlist-count {
    color: #590d22;
    font-size: 1.1em;
    font-weight: 600;
    background: #fff0f3;
    border: 1.5px solid #ffb3c1;
    border-radius: 6px;
    padding: 6px 18px;
}
.wishlist-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 350px;
    text-align: center;
}
.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 28px;
}
.wishlist-item {
    background: #fff0f3;
    border: 1.5px solid #ffb3c1;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(201, 24, 74, 0.06);
    padding: 18px 16px 18px 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: box-shadow 0.18s;
}
.wishlist-item-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #ffb3c1;
    margin-bottom: 12px;
    background: #fff;
}
.wishlist-item-details {
    width: 100%;
    text-align: center;
}
.wishlist-item-name {
    color: #c9184a;
    font-size: 1.15em;
    font-weight: 600;
    margin: 0 0 6px 0;
}
.wishlist-item-price {
    color: #590d22;
    font-size: 1.1em;
    font-weight: 500;
    margin-bottom: 10px;
}
.wishlist-item-actions {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 10px;
}
.wishlist-remove-btn, .wishlist-add-to-cart, .wishlist-add-btn {
    width: 100%;
    padding: 10px 0;
    background: #c9184a;
    color: #fff0f3;
    border: none;
    border-radius: 6px;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.18s;
    margin-bottom: 0;
}
.wishlist-remove-btn {
    background: #fff;
    color: #c9184a;
    border: 1.5px solid #c9184a;
}
.wishlist-remove-btn:hover {
    background: #c9184a;
    color: #fff0f3;
}
.wishlist-add-to-cart {
    background: #c9184a;
}
.wishlist-add-to-cart:hover {
    background: #a4133c;
}
.wishlist-add-btn {
    background: #ffb3c1;
    color: #c9184a;
    border: 1.5px solid #c9184a;
}
.wishlist-add-btn:hover {
    background: #c9184a;
    color: #fff0f3;
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
            <h3 style="margin-bottom: 12px;">Your wishlist is empty</h3>
            <p style="margin-bottom: 18px;">Start adding items you love to your wishlist!</p>
            <p>
                <a href="/online_store/shopall.php" style="color:#c9184a; text-decoration:underline; font-weight:600;">
                    Browse our collection
                </a>
            </p>
        </div>
    <?php else: ?>
        <div class="wishlist-grid">
            <?php foreach ($wishlistItems as $item): ?>
                <div class="wishlist-item" data-product-id="<?php echo $item['productID']; ?>">
                    <img src="/images/products/<?php echo $item['image']; ?>" 
                         alt="<?php echo htmlspecialchars($item['name']); ?>" 
                         class="wishlist-item-img">
                    <div class="wishlist-item-details">
                        <h3 class="wishlist-item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                        <div class="wishlist-item-price">$<?php echo number_format($item['price'], 2); ?></div>
                        <div class="wishlist-item-actions">
                            <button class="wishlist-remove-btn" onclick="removeFromWishlist(<?php echo $item['productID']; ?>)">
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
    fetch('/online_store/wishlist/remove', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`.wishlist-item[data-product-id="${productId}"]`);
            if (item) item.remove();

            const countElement = document.querySelector('.wishlist-count');
            countElement.textContent = data.count + ' items';

            if (data.count == 0) {
                document.querySelector('.wishlist-container').innerHTML = `
                    <div class="wishlist-header">
                        <h1 class="wishlist-title">My Wishlist</h1>
                        <span class="wishlist-count">0 items</span>
                    </div>
                    <div class="wishlist-empty" style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 350px; text-align: center;">
                        <h3 style="margin-bottom: 12px;">Your wishlist is empty</h3>
                        <p style="margin-bottom: 18px;">Start adding items you love to your wishlist!</p>
                        <p><a href="/online_store/shopall.php" style="color:#c9184a; text-decoration:underline; font-weight:600;">Browse our collection</a></p>
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
                text: data.message || 'Something went wrong. Please try again.'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'An unexpected error occurred. Please try again.'
        });
    });
}

document.querySelectorAll('.wishlist-add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.closest('.wishlist-item').dataset.productId;
        Swal.fire({
            icon: 'success',
            title: 'Added!',
            text: 'Item has been added to your cart.',
            timer: 1200,
            showConfirmButton: false
        }).then(() => {
            window.location.href = '/online_store/view/wishlist/index.php';
        });
    });
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>
