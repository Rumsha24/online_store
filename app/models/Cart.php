<?php
namespace App\Models;

class Cart {
    private $conn;
    private $table = "cart";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($userId, $productId, $quantity) {
        $checkQuery = "SELECT quantity FROM $this->table WHERE userID = ? AND productID = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->execute([$userId, $productId]);

        if ($checkStmt->rowCount() > 0) {
            $existing = $checkStmt->fetch();
            $newQuantity = $existing['quantity'] + $quantity;
            $updateQuery = "UPDATE $this->table SET quantity = ? WHERE userID = ? AND productID = ?";
            $updateStmt = $this->conn->prepare($updateQuery);
            return $updateStmt->execute([$newQuantity, $userId, $productId]);
        } else {
            $query = "INSERT INTO $this->table (userID, productID, quantity) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$userId, $productId, $quantity]);
        }
    }

    public function getUserCartWithDetails($userId) {
        $query = "
            SELECT 
                p.productID,
                p.description, 
                p.image, 
                p.price, 
                c.quantity
            FROM cart c
            JOIN products p ON c.productID = p.productID
            WHERE c.userID = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateCart($userId, $productId, $quantity) {
        $query = "UPDATE $this->table SET quantity = ? WHERE userID = ? AND productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$quantity, $userId, $productId]);
    }

    public function removeItem($userId, $productId) {
        $query = "DELETE FROM $this->table WHERE userID = ? AND productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId, $productId]);
    }
}
