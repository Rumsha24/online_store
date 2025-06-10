<?php
// models/Cart.php

class Cart {
    private $conn;
    private $table = 'cart';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addProduct($productId) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['userID'])) {
            error_log("User not logged in.");
            return false;
        }

        $userId = $_SESSION['userID'];

        try {
            // Check if the product exists
            $sqlCheckProduct = "SELECT productID FROM products WHERE productID = :productID";
            $stmtCheckProduct = $this->conn->prepare($sqlCheckProduct);
            $stmtCheckProduct->bindParam(':productID', $productId, PDO::PARAM_INT);
            $stmtCheckProduct->execute();

            if (!$stmtCheckProduct->fetch()) {
                error_log("Product ID $productId does not exist in products table.");
                return false;
            }

            // Check if the product already exists in cart
            $sqlCheckCart = "SELECT quantity FROM {$this->table} WHERE userID = :userID AND productID = :productID";
            $stmtCheckCart = $this->conn->prepare($sqlCheckCart);
            $stmtCheckCart->bindParam(':userID', $userId, PDO::PARAM_INT);
            $stmtCheckCart->bindParam(':productID', $productId, PDO::PARAM_INT);
            $stmtCheckCart->execute();

            if ($existing = $stmtCheckCart->fetch(PDO::FETCH_ASSOC)) {
                $newQuantity = $existing['quantity'] + 1;

                $sqlUpdate = "UPDATE {$this->table} SET quantity = :quantity WHERE userID = :userID AND productID = :productID";
                $stmtUpdate = $this->conn->prepare($sqlUpdate);
                $stmtUpdate->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':userID', $userId, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':productID', $productId, PDO::PARAM_INT);
                return $stmtUpdate->execute();
            } else {
                $sqlInsert = "INSERT INTO {$this->table} (userID, productID, quantity) VALUES (:userID, :productID, :quantity)";
                $stmtInsert = $this->conn->prepare($sqlInsert);
                $stmtInsert->bindParam(':userID', $userId, PDO::PARAM_INT);
                $stmtInsert->bindParam(':productID', $productId, PDO::PARAM_INT);
                $quantity = 1;
                $stmtInsert->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                return $stmtInsert->execute();
            }
        } catch (PDOException $e) {
            error_log("Cart insert/update failed: " . $e->getMessage());
            return false;
        }
    }

    public function getProductsByUser($userId) {
        $sql = "SELECT p.productID, p.name, p.price, c.quantity
                FROM {$this->table} c
                JOIN products p ON c.productID = p.productID
                WHERE c.userID = :userID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeProduct($userId, $productId) {
        $sql = "DELETE FROM {$this->table} WHERE userID = :userID AND productID = :productID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
