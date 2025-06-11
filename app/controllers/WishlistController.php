<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/WishlistModel.php';

class WishlistController {
    private $model;
    private $userId; // You'll need to get this from your session

    public function __construct($db) {
        $this->model = new WishlistModel($db);
        $this->userId = $_SESSION['user_id'] ?? null; // Adjust based on your auth system
    }

    public function index() {
        if (!$this->userId) {
            header('Location: /login?redirect=wishlist');
            exit();
        }

        $wishlistItems = $this->model->getWishlistItems($this->userId);
        require_once __DIR__ . '/../views/wishlist/index.php';
    }

    public function add() {
        if (!$this->userId) {
            echo json_encode(['success' => false, 'message' => 'Please login to add to wishlist']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? null;
        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            return;
        }

        // Add to wishlist logic (implement this in your model)
        $success = $this->model->addToWishlist($this->userId, $productId);
        $count = $this->model->getWishlistCount($this->userId);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Added to wishlist!' : 'Already in wishlist.',
            'count' => $count
        ]);
    }

    public function remove() {
        if (!$this->userId) {
            echo json_encode(['success' => false, 'message' => 'Please login to modify wishlist']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? null;
        if (!$productId) {
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            return;
        }

        $success = $this->model->removeFromWishlist($this->userId, $productId);
        $count = $this->model->getWishlistCount($this->userId);

        echo json_encode([
            'success' => $success,
            'count' => $count,
            'message' => 'Removed from wishlist'
        ]);
    }

    public function status() {
        if (!$this->userId) {
            echo json_encode(['success' => false, 'message' => 'Not logged in']);
            return;
        }

        $wishlistItems = $this->model->getWishlistItems($this->userId);
        $productIds = array_column($wishlistItems, 'id');

        echo json_encode([
            'success' => true,
            'wishlistItems' => $productIds
        ]);
    }
}
?>