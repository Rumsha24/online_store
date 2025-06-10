<?php
require_once __DIR__ . '/../models/Cart.php';

class CartController {
    private $cartModel;

    public function __construct($db = null) {
        $this->cartModel = new Cart($db);
    }

public function add() {
    session_start();
    $productId = $_POST['product_id'] ?? null;

    if (!$productId) {
        echo "Product ID missing.";
        return;
    }

    // Load DB connection and cart model
    require_once __DIR__ . '/../models/Cart.php';
    $db = (new Database())->getConnection();
    $cartModel = new Cart($db);

    // Hardcoded user_id for now, replace with $_SESSION['user_id'] if login exists
    $userId = $_SESSION['user_id'] ?? 1; 

    // Add product to cart
    $result = $cartModel->addToCart($userId, $productId, 1); // default quantity = 1

    if ($result) {
        echo "Product added";
    } else {
        echo "Insert failed";
    }
}


    public function view() {
        echo json_encode($_SESSION['cart'] ?? []);
    }
}
