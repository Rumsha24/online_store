<?php
require_once __DIR__ . '/../models/ShopAll.php';

class ShopAllController {
    private $db;
    private $shopAllModel;

    public function __construct($db) {
        $this->db = $db;
        $this->shopAllModel = new ShopAll($this->db);
    }

    public function getAllItems() {
        $result = $this->shopAllModel->getAll();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSingleItem() {
        $stmt = $this->shopAllModel->getOne();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getItemById($id) {
        $result = $this->shopAllModel->getById($id);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function createItem($name, $description, $image, $price, $category) {
        return $this->shopAllModel->create($name, $description, $image, $price, $category);
    }
}
