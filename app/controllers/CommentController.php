<?php
require_once __DIR__ . '/../models/Comment.php';

class CommentController {
    private $db;
    private $commentModel;

    public function __construct($db) {
        $this->db = $db;
        $this->commentModel = new Comment($db);
    }

    public function add() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        echo "<pre>";
        echo "POST Data:\n"; print_r($_POST);
        echo "FILES Data:\n"; print_r($_FILES);
        echo "SESSION:\n"; print_r($_SESSION);
        echo "</pre>";

        if (!isset($_SESSION['user_id'])) {
            echo "User not logged in!";
            header("Location: /online_store/public/index.php?url=user/showLoginForm");
            exit;
        }

        $userID = $_SESSION['user_id'];
        $productID = $_POST['productID'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $text = $_POST['text'] ?? '';
        $imagePath = null;

        if (!$productID || !$rating || !$text) {
            echo "All required fields are not present.";
            exit;
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                $imagePath = 'uploads/' . $fileName;
            }
        }

        $this->commentModel->addComment($userID, $productID, $rating, $text, $imagePath);

        header("Location: /online_store/view/user/comments.php");
        exit;
    }
}
