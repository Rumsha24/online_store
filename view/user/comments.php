<?php
// ✅ MUST be at the top to prevent output before session_start()
if (session_status() === PHP_SESSION_NONE) session_start();

// ✅ Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /online_store/public/index.php?url=user/showLoginForm");
    exit;
}

include __DIR__ . '/../header.php';

require_once __DIR__ . '/../../app/core/Database.php';
require_once __DIR__ . '/../../app/models/Product.php';
require_once __DIR__ . '/../../app/models/Comment.php';

$db = (new Database())->getConnection();
$productModel = new Product($db);
$commentModel = new Comment($db);

// Fetch all products for the dropdown
$products = $productModel->getAll()->fetchAll(PDO::FETCH_ASSOC);

// Determine selected product
$selectedProductID = $_POST['productID'] ?? ($_GET['productID'] ?? ($products[0]['productID'] ?? null));

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'], $_POST['text'], $_POST['productID'])) {
    $userID = $_SESSION['user_id'];
    $productID = $_POST['productID'];
    $rating = $_POST['rating'];
    $text = $_POST['text'];
    $imagePath = null;

    // Handle image upload if provided
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = 'uploads/' . $imageName;
        }
    }

    // Save comment
    $commentModel->addComment($userID, $productID, $rating, $text, $imagePath);

  
}

// Fetch comments for selected product
$comments = [];
if ($selectedProductID) {
    $comments = $commentModel->getCommentsByProduct($selectedProductID);
}
?>

<style>
body {
    background: #fff0f3;
    font-family: 'Montserrat', Arial, sans-serif;
    margin: 0;
    padding: 0;
}
.container {
    max-width: 600px;
    margin: 40px auto 0 auto;
    background: #fff;
    padding: 32px 28px 32px 28px;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(201, 24, 74, 0.10);
    border: 2px solid #ffb3c1;
}
h2, h3 {
    color: #c9184a;
    text-align: center;
    font-weight: 700;
    letter-spacing: 1px;
}
form {
    margin-bottom: 32px;
}
label {
    color: #590d22;
    font-weight: 500;
    margin-bottom: 6px;
    display: block;
}
select, textarea, input[type="file"] {
    width: 100%;
    padding: 10px;
    margin: 8px 0 18px 0;
    border-radius: 6px;
    border: 1.5px solid #ffb3c1;
    background: #fff0f3;
    font-size: 1em;
    transition: border 0.2s;
    box-sizing: border-box;
}
select:focus, textarea:focus, input[type="file"]:focus {
    border: 1.5px solid #c9184a;
    outline: none;
}
input[type="submit"] {
    width: 100%;
    padding: 12px 0;
    background: #c9184a;
    color: #fff0f3;
    border: none;
    border-radius: 6px;
    font-size: 1.1em;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
    transition: background 0.2s;
}
input[type="submit"]:hover {
    background: #a4133c;
}
.comment-box {
    background: #fff0f3;
    border: 1.5px solid #ffb3c1;
    border-radius: 8px;
    padding: 16px 18px;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(201, 24, 74, 0.06);
}
.comment-box strong {
    color: #c9184a;
    font-weight: 600;
}
.comment-box img {
    display: block;
    max-width: 120px;
    max-height: 120px;
    margin-top: 10px;
    border-radius: 6px;
    border: 1px solid #ffb3c1;
}
hr {
    border: none;
    border-top: 1.5px solid #ffb3c1;
    margin: 32px 0 24px 0;
}
</style>

<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

    <form action="comments.php" method="POST" enctype="multipart/form-data">
        <label for="productID">Select Product:</label>
        <select name="productID" id="productID" required onchange="this.form.submit()">
            <option value="">-- Select Product --</option>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product['productID'] ?>" <?= $product['productID'] == $selectedProductID ? 'selected' : '' ?>>
                    <?= htmlspecialchars($product['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Rating:</label>
        <select name="rating" required>
            <option value="">Select</option>
            <option value="1">⭐</option>
            <option value="2">⭐⭐</option>
            <option value="3">⭐⭐⭐</option>
            <option value="4">⭐⭐⭐⭐</option>
            <option value="5">⭐⭐⭐⭐⭐</option>
        </select>

        <label>Comment:</label>
        <textarea name="text" required></textarea>

        <label>Upload Image:</label>
        <input type="file" name="image" accept="image/*">

        <input type="submit" value="Submit Comment">
    </form>

    <hr>

    <h3>All Comments</h3>

    <?php if (empty($comments)): ?>
        <div style="text-align:center; color:#c9184a;">No comments for this product yet.</div>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment-box">
                <strong><?= htmlspecialchars($comment['username']) ?></strong> rated: <?= str_repeat('⭐', $comment['rating']) ?><br>
                <p><?= nl2br(htmlspecialchars($comment['text'])) ?></p>
                <?php if (!empty($comment['image'])): ?>
                    <img src="/online_store/public/<?= $comment['image'] ?>" alt="Comment Image">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>