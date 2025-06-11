<?php
require_once __DIR__ . '/../models/WishlistModel.php';

class WishlistController {
    private $model;
    private $userId;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new WishlistModel($db);
        $this->userId = $_SESSION['user_id'] ?? null;
    }

    public function index() {
        if (!$this->userId) {
            header('Location: /login?redirect=wishlist');
            exit();
        }

        $wishlistItems = $this->model->getWishlistItems($this->userId);
        $wishlistCount = $this->model->getWishlistCount($this->userId);
        
        require_once __DIR__ . '/../views/wishlist/index.php';
    }

    public function add() {
        session_start();
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'login' => false, 'message' => 'Please login to add to wishlist']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? null;
        if (!$productId) {
            echo json_encode(['success' => false, 'login' => true, 'message' => 'No product specified.']);
            exit;
        }

        // Add to wishlist logic here
        // $result = $this->model->addToWishlist($_SESSION['user_id'], $productId);
        // $count = $this->model->getWishlistCount($_SESSION['user_id']);

        // For demonstration, always succeed:
        echo json_encode(['success' => true, 'login' => true, 'message' => 'Added to wishlist!']);
        exit;
    }

    public function remove() {
        if (!$this->userId) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'Please login to modify wishlist'
            ]);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $productId = $data['product_id'] ?? null;

        if (!$productId) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Product ID is required'
            ]);
            return;
        }

        $success = $this->model->removeFromWishlist($this->userId, $productId);
        $count = $this->model->getWishlistCount($this->userId);

        echo json_encode([
            'success' => $success,
            'count' => $count,
            'message' => $success ? 'Removed from wishlist' : 'Failed to remove item'
        ]);
    }
}
