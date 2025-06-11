<?php
require_once __DIR__ . '/../models/Cart.php';

class CartController {
    private $cartModel;
    private $userId;

    public function __construct($db) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->cartModel = new Cart($db);
        $this->userId = $_SESSION['user_id'] ?? null;
    }

    public function add() {
        if (!$this->userId) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please login to add to cart']);
            return;
        }

        $productId = $_POST['productID'] ?? null;
        if (!$productId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            return;
        }

        $result = $this->cartModel->addProduct($this->userId, $productId);
        
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Product added to cart' : 'Failed to add product'
        ]);
    }

    public function view() {
        if (!$this->userId) {
            header('Location: /login?redirect=cart');
            exit();
        }

        $products = $this->cartModel->getProductsByUser($this->userId);
        $total = 0;
        
        foreach ($products as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        require_once __DIR__ . '/../views/cart/view.php';
    }

    public function remove() {
        if (!$this->userId) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please login to modify cart']);
            return;
        }

        $productId = $_POST['productID'] ?? null;
        if (!$productId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            return;
        }

        $success = $this->cartModel->removeProduct($this->userId, $productId);
        
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Product removed from cart' : 'Failed to remove product'
        ]);
    }
}