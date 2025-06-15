<?php
require_once '../config/Database.php';
require_once '../models/Comment.php';
require_once '../models/Product.php';

session_start();

$database = new Database();
$db = $database->getConnection();
$comment = new Comment($db);
$product = new Product($db);

// Get product ID from URL
$productId = isset($_GET['id']) ? $_GET['id'] : null;

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id']) && $productId) {
    $rating = $_POST['rating'];
    $text = $_POST['text'];
    $image = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = $fileName;
        }
    }

    $comment->addComment($productId, $_SESSION['user_id'], $rating, $text, $image);
    
    // Redirect with a flag to highlight the new review
    header("Location: ?page=comments&id=" . $productId . "&new_review=1");
    exit();
}

// Get all products
$products = $product->getAll();

// Get specific product data if ID is provided
if ($productId) {
    $productData = $product->getProductById($productId);
    if (!$productData) {
        header("Location: index.php");
        exit();
    }
    // Get comments for the selected product
    $comments = $comment->getCommentsByProductId($productId);
} else {
    $comments = [];
}

include 'header.php';
?>

<style>
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
        background: #fff0f3;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(89, 13, 34, 0.08);
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        position: relative;
        border: 1px solid #ffccd5;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(89, 13, 34, 0.12);
    }

    .product-card.selected {
        border: 2px solid #c9184a;
        background: #fff0f3;
    }

    .selected-label {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        background: #c9184a;
        color: white;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.8em;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(201, 24, 74, 0.2);
    }

    .product-card img {
        width: 100%;
        height: 180px;
        object-fit: contain;
        border-radius: 8px;
        margin-bottom: 12px;
        padding: 10px;
        background: #fff0f3;
    }

    .product-card h3 {
        color: #590d22;
        margin: 0 0 10px 0;
        font-size: 0.95em;
        line-height: 1.4;
        height: 2.8em;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-weight: 600;
    }

    .rating {
        color: #ffc107;
        font-size: 1.1em;
        margin-bottom: 8px;
    }

    .rating span {
        color: #800f2f;
        font-size: 0.85em;
        margin-left: 5px;
    }

    .page-title {
        color: #800f2f;
        text-align: center;
        margin-bottom: 30px;
        font-size: 2.2em;
        position: relative;
        padding-bottom: 15px;
    }

    .page-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #ff4d6d, #c9184a);
        border-radius: 4px;
    }

    .review-section {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #ffb3c1;
    }

    .review-form {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(89, 13, 34, 0.1);
        margin-bottom: 30px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid #ffccd5;
    }

    .sign-in-prompt {
        background: #fff0f3;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 30px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid #ffb3c1;
    }

    .sign-in-prompt h3 {
        color: #800f2f;
        margin: 0 0 15px 0;
        font-size: 1.5em;
    }

    .sign-in-prompt p {
        color: #590d22;
        margin: 0 0 20px 0;
    }

    .sign-in-btn {
        display: inline-block;
        background: linear-gradient(135deg, #ff4d6d, #c9184a);
        color: white;
        text-decoration: none;
        padding: 12px 28px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(201, 24, 74, 0.2);
    }

    .sign-in-btn:hover {
        background: linear-gradient(135deg, #c9184a, #a4133c);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(201, 24, 74, 0.3);
    }

    .review-form h3 {
        color: #590d22;
        margin: 0 0 25px 0;
        font-size: 1.5em;
        text-align: center;
        position: relative;
        padding-bottom: 15px;
    }

    .review-form h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #ff4d6d, #c9184a);
        border-radius: 2px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 10px;
        color: #590d22;
        font-weight: 500;
        font-size: 1.1em;
    }

    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        gap: 8px;
        justify-content: center;
        margin: 15px 0;
    }

    .rating-input input {
        display: none;
    }

    .rating-input label {
        font-size: 2.5em;
        color: #ffb3c1;
        cursor: pointer;
        transition: all 0.2s;
        padding: 5px;
    }

    .rating-input input:checked ~ label,
    .rating-input label:hover,
    .rating-input label:hover ~ label {
        color: #ffc107;
        transform: scale(1.1);
    }

    .rating-input label:hover {
        transform: scale(1.2);
    }

    textarea {
        width: 100%;
        min-height: 150px;
        padding: 15px;
        border: 2px solid #ffb3c1;
        border-radius: 12px;
        resize: vertical;
        font-size: 1em;
        line-height: 1.6;
        transition: all 0.3s ease;
        background: #fff0f3;
    }

    textarea:focus {
        outline: none;
        border-color: #ff4d6d;
        background: white;
        box-shadow: 0 0 0 3px rgba(255, 77, 109, 0.2);
    }

    .image-upload {
        border: 2px dashed #ffb3c1;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        background: #fff0f3;
    }

    .image-upload:hover {
        border-color: #ff4d6d;
        background: white;
    }

    .image-upload input[type="file"] {
        display: none;
    }

    .image-upload label {
        display: block;
        cursor: pointer;
        color: #800f2f;
    }

    .image-upload i {
        font-size: 2em;
        color: #ff4d6d;
        margin-bottom: 10px;
    }

    .image-preview {
        margin-top: 15px;
        display: none;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(89, 13, 34, 0.1);
    }

    .remove-image {
        display: inline-block;
        margin-top: 10px;
        color: #ff4d6d;
        cursor: pointer;
        font-size: 0.9em;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .remove-image:hover {
        color: #c9184a;
        text-decoration: underline;
    }

    .submit-btn {
        background: linear-gradient(135deg, #ff4d6d, #c9184a);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 1.1em;
        transition: all 0.3s ease;
        display: block;
        width: 220px;
        margin: 30px auto 0;
        text-align: center;
        box-shadow: 0 4px 12px rgba(201, 24, 74, 0.2);
    }

    .submit-btn:hover {
        background: linear-gradient(135deg, #c9184a, #a4133c);
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(201, 24, 74, 0.3);
    }

    .reviews-grid {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .review-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(89, 13, 34, 0.08);
        transition: all 0.3s ease;
        border: 1px solid #ffccd5;
    }

    .review-card.new-review {
        animation: highlightNew 2s ease-out;
    }

    @keyframes highlightNew {
        0% {
            background: #fff0f3;
            transform: translateY(-10px);
            opacity: 0;
        }
        100% {
            background: white;
            transform: translateY(0);
            opacity: 1;
        }
    }

    .review-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #ff4d6d, #c9184a);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2em;
    }

    .review-content {
        flex: 1;
    }

    .reviewer-name {
        font-weight: bold;
        color: #590d22;
        margin-bottom: 5px;
        font-size: 1.1em;
    }

    .review-rating {
        color: #ffc107;
        font-size: 1.2em;
        margin-bottom: 8px;
    }

    .review-text {
        color: #590d22;
        margin: 0;
        line-height: 1.6;
    }

    .review-image-container {
        margin-top: 20px;
        max-width: 300px;
        max-height: 300px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(89, 13, 34, 0.1);
    }

    .review-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-reviews {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(89, 13, 34, 0.08);
        border: 1px solid #ffccd5;
    }

    .no-reviews p {
        color: #800f2f;
        margin: 0;
        font-size: 1.1em;
    }

    @media (max-width: 1200px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .review-form, 
        .sign-in-prompt {
            padding: 20px;
        }
        
        .submit-btn {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr;
        }
        
        .page-title {
            font-size: 1.8em;
        }
        
        .review-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="container">
    <h1 class="page-title">Select a Perfume to Comment</h1>
    
    <div class="products-grid">
        <?php foreach ($products as $p): 
            $productComments = $comment->getCommentsByProductId($p['productID']);
            $avgRating = 0;
            if (!empty($productComments)) {
                $totalRating = array_sum(array_column($productComments, 'rating'));
                $avgRating = $totalRating / count($productComments);
            }
            $isSelected = $productId == $p['productID'];
        ?>
            <a href="?page=comments&id=<?= $p['productID'] ?>" class="product-card <?= $isSelected ? 'selected' : '' ?>">
                <?php if ($isSelected): ?>
                    <div class="selected-label">Selected Perfume</div>
                <?php endif; ?>
                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['description']) ?>">
                <h3><?= htmlspecialchars($p['description']) ?></h3>
                <div class="rating">
                    <?= str_repeat('★', round($avgRating)) . str_repeat('☆', 5 - round($avgRating)) ?>
                    <span>(<?= number_format($avgRating, 1) ?> / 5)</span>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <?php if ($productId): ?>
        <div class="review-section">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="review-form">
                    <h3>Write a Comment</h3>
                    <form action="?page=comments&id=<?= $productId ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>How would you rate this perfume?</label>
                            <div class="rating-input">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required>
                                    <label for="star<?= $i ?>">★</label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="text">Share your thoughts about this perfume</label>
                            <textarea name="text" id="text" placeholder="Write your review here..." required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Add a photo to your comment (optional)</label>
                            <div class="image-upload">
                                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(this)">
                                <label for="image">
                                    <i>📷</i>
                                    <div>Click to upload an image</div>
                                    <small>or drag and drop</small>
                                </label>
                                <div class="image-preview" id="imagePreview">
                                    <img id="previewImg" src="" alt="Preview">
                                    <div class="remove-image" onclick="removeImage()">Remove image</div>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="submit-btn">Submit Review</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="sign-in-prompt">
                    <h3>Want to share your thoughts?</h3>
                    <p>Sign in to write a comment for this book.</p>
                    <a href="signup.php" class="sign-in-btn">Sign In</a>
                </div>
            <?php endif; ?>

            <div class="reviews-grid">
                <?php if (empty($comments)): ?>
                    <div class="no-reviews">
                        <p>No comments yet. Be the first to comment on this perfume!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($comments as $index => $c): 
                        $isNewReview = isset($_GET['new_review']) && $index === 0;
                    ?>
                        <div class="review-card <?= $isNewReview ? 'new-review' : '' ?>">
                            <div class="review-header">
                                <div class="user-avatar">
                                    <?= strtoupper(substr($c['username'], 0, 1)) ?>
                                </div>
                                <div class="review-content">
                                    <div class="reviewer-name"><?= htmlspecialchars($c['username']) ?></div>
                                    <div class="review-rating">
                                        <?= str_repeat('★', $c['rating']) . str_repeat('☆', 5 - $c['rating']) ?>
                                    </div>
                                </div>
                            </div>
                            <p class="review-text"><?= htmlspecialchars($c['text']) ?></p>
                            <?php if ($c['image']): ?>
                                <div class="review-image-container">
                                    <img src="../uploads/<?= htmlspecialchars($c['image']) ?>" alt="Review image" class="review-image">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    input.value = '';
    previewImg.src = '';
    preview.style.display = 'none';
}
</script>

<?php include 'footer.php'; ?>
