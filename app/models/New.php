<?php
<?php
class NewProduct {
    private $conn;
    private $table = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all products marked as new (assuming 'is_new' column exists)
    public function getAllNew() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE is_new = 1");
        $stmt->execute();
        return $stmt;
    }

    // Get a single new product
    public function getOneNew() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE is_new = 1 LIMIT 1");
        $stmt->execute();
        return $stmt;
    }

    // Get a new product by ID
    public function getNewById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE productID = ? AND is_new = 1");
        $stmt->execute([$id]);
        return $stmt;
    }
}