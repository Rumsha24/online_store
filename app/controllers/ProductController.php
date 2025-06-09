<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $db;
    private $productModel;

    public function __construct($db) {
        $this->db = $db;
        $this->productModel = new Product($this->db);
    }

    public function getAllProducts() {
        $result = $this->productModel->getAll();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSingleProduct() {
        $stmt = $this->productModel->getAll();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $result = $this->productModel->getById($id);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($description, $image, $price, $shippingCost = 0) {
        return $this->productModel->create($description, $image, $price, $shippingCost);
    }
}
