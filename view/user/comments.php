<?php include __DIR__ . '/../header.php'; ?>

<style>
    body {
        background-color: #fff0f3;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #590d22;
    }

    h2, h3 {
        text-align: center;
        color: #c9184a;
    }

    form {
        background-color: #ffe5ec;
        padding: 20px;
        margin: 20px auto;
        width: 90%;
        max-width: 600px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    form label {
        display: block;
        margin-top: 10px;
        font-weight: bold;
    }

    form input[type="text"],
    form select,
    form textarea,
    form input[type="file"] {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border-radius: 6px;
        border: 1px solid #c9184a;
        background: #fff0f3;
    }

    form input[type="submit"] {
        background: #c9184a;
        color: #fff0f3;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }

    form input[type="submit"]:hover {
        background: #800f2f;
    }

    .comment-box {
        background-color: #fff;
        border: 1px solid #ccc;
        border-left: 5px solid #c9184a;
        padding: 15px;
        margin: 20px auto;
        width: 90%;
        max-width: 600px;
        border-radius: 8px;
    }

    .comment-box img {
        max-width: 150px;
        margin-top: 10px;
        border-radius: 6px;
    }
</style>

<?php
// Start session and redirect if not logged in
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /online_store/public/index.php?url=user/showLoginForm");
    exit;
}
?>

<h2>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>

<?php $product = ['productID' => 1, 'description' => 'Sample Product']; ?>

<h3>Product: <?= $product['description'] ?></h3>

<h3>Leave a Comment</h3>
<form action="?url=comment/add" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="productID" value="<?= $product['productID'] ?>">

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

<?php
require_once __DIR__ . '/../../app/core/Database.php';
require_once __DIR__ . '/../../app/models/Comment.php';

$db = (new Database())->getConnection();
$commentModel = new Comment($db);
$comments = $commentModel->getCommentsByProduct($product['productID']);
?>

<?php foreach ($comments as $comment): ?>
    <div class="comment-box">
        <strong><?= htmlspecialchars($comment['username']) ?></strong> rated: <?= str_repeat('⭐', $comment['rating']) ?><br>
        <p><?= nl2br(htmlspecialchars($comment['text'])) ?></p>
        <?php if (!empty($comment['image'])): ?>
            <img src="/online_store/public/<?= $comment['image'] ?>" alt="Comment Image">
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>
