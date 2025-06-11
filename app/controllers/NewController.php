<?php
<?php
require_once __DIR__ . '/../models/Product.php';

class NewController {
    private $db;
    private $productModel;

    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new Product($this->db);
    }

    // Get only new products (assuming 'is_new' column exists)
    public function getNewProducts() {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE is_new = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Show the new products page
    public function index() {
        $newProducts = $this->getNewProducts();
        require __DIR__ . '/../../view/new.php';
    }
}