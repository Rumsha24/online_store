<?php

class HomeController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $productController = new ProductController($this->db);
        $products = $productController->getAllProducts(); // or your custom method

        include __DIR__ . '/../../view/home/index.php';
    }
}
