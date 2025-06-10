<?php
class ShopAll {
    private $conn;
    private $table = "shop_all"; // Make sure this matches your actual table name

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt;
    }

    public function getOne() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT 1");
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt;
    }

    public function create($name, $description, $image, $price, $category) {
        $query = "INSERT INTO $this->table (name, description, image, price, category) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $description, $image, $price, $category]);
    }

    public function update($id, $name, $description, $image, $price, $category) {
        $query = "UPDATE $this->table 
                  SET name = ?, description = ?, image = ?, price = ?, category = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $description, $image, $price, $category, $id]);
    }

    public function delete($id) {
        $query = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
