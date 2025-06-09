<?php
// controllers/CartController.php
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Product.php';

class CartController {
    private $db;
    private $cartModel;
    private $productModel;

    public function __construct($db) {
        $this->db = $db;
        $this->cartModel = new Cart($this->db);
        $this->productModel = new Product($this->db);
    }

    public function viewCart() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /online_store/public/index.php?url=user/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItems($userId);
        $cartTotal = $this->cartModel->getCartTotal($userId);

        include __DIR__ . '/../../view/cart/view.php';
    }

    public function addToCart() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /online_store/public/index.php?url=user/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'] ?? 0;
        $quantity = $_POST['quantity'] ?? 1;

        // Validate product exists
        $product = $this->productModel->getById($productId)->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            $_SESSION['error'] = "Product not found.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }

        $this->cartModel->addToCart($userId, $productId, $quantity);
        $_SESSION['success'] = "Product added to cart!";
        header('Location: /online_store/public/index.php?url=cart/viewCart');
        exit;
    }

    public function updateCart() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /online_store/public/index.php?url=user/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user_id'];
        
        foreach ($_POST['quantity'] as $productId => $quantity) {
            $this->cartModel->updateCartItem($userId, $productId, $quantity);
        }

        $_SESSION['success'] = "Cart updated!";
        header('Location: /online_store/public/index.php?url=cart/viewCart');
        exit;
    }

    public function removeFromCart($productId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /online_store/public/index.php?url=user/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $this->cartModel->removeFromCart($userId, $productId);
        
        $_SESSION['success'] = "Item removed from cart.";
        header('Location: /online_store/public/index.php?url=cart/viewCart');
        exit;
    }

    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /online_store/public/index.php?url=user/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItems($userId);
        
        if (empty($cartItems)) {
            $_SESSION['error'] = "Your cart is empty.";
            header('Location: /online_store/public/index.php?url=cart/viewCart');
            exit;
        }

        include __DIR__ . '/../../view/cart/checkout.php';
    }

    public function processCheckout() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /online_store/public/index.php?url=user/showLoginForm');
            exit;
        }

        $userId = $_SESSION['user_id'];
        
        // Here you would typically:
        // 1. Process payment
        // 2. Create an order record
        // 3. Clear the cart
        // 4. Send confirmation email
        
        // For now, we'll just clear the cart and show a success message
        $this->cartModel->clearCart($userId);
        
        $_SESSION['success'] = "Order placed successfully! Thank you for your purchase.";
        header('Location: /online_store/public/index.php?url=home/index');
        exit;
    }
}