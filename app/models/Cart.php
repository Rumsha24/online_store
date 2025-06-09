<?php
// models/Cart.php
class Cart {
    private $conn;
    private $table = "cart_items";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getCartItems($userId) {
        $query = "SELECT ci.*, p.description, p.image, p.price, p.shippingCost 
                  FROM $this->table ci
                  JOIN products p ON ci.productID = p.productID
                  WHERE ci.userID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($userId, $productId, $quantity = 1) {
        // Check if item already exists in cart
        $checkQuery = "SELECT * FROM $this->table WHERE userID = ? AND productID = ?";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->execute([$userId, $productId]);
        
        if ($checkStmt->rowCount() > 0) {
            // Update quantity if exists
            $updateQuery = "UPDATE $this->table SET quantity = quantity + ? WHERE userID = ? AND productID = ?";
            $updateStmt = $this->conn->prepare($updateQuery);
            return $updateStmt->execute([$quantity, $userId, $productId]);
        } else {
            // Insert new item
            $insertQuery = "INSERT INTO $this->table (userID, productID, quantity) VALUES (?, ?, ?)";
            $insertStmt = $this->conn->prepare($insertQuery);
            return $insertStmt->execute([$userId, $productId, $quantity]);
        }
    }

    public function updateCartItem($userId, $productId, $quantity) {
        if ($quantity <= 0) {
            return $this->removeFromCart($userId, $productId);
        }
        
        $query = "UPDATE $this->table SET quantity = ? WHERE userID = ? AND productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$quantity, $userId, $productId]);
    }

    public function removeFromCart($userId, $productId) {
        $query = "DELETE FROM $this->table WHERE userID = ? AND productID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId, $productId]);
    }

    public function clearCart($userId) {
        $query = "DELETE FROM $this->table WHERE userID = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId]);
    }

    public function getCartTotal($userId) {
        $items = $this->getCartItems($userId);
        $total = 0;
        
        foreach ($items as $item) {
            $total += ($item['price'] + $item['shippingCost']) * $item['quantity'];
        }
        
        return $total;
    }
}