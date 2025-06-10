<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<?php
class WishlistModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getWishlistItems($userId) {
        $query = "SELECT p.* FROM products p 
                  JOIN wishlists w ON p.id = w.product_id 
                  WHERE w.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToWishlist($userId, $productId) {
        // Check if already in wishlist
        $checkQuery = "SELECT * FROM wishlists 
                      WHERE user_id = :user_id AND product_id = :product_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':user_id', $userId);
        $checkStmt->bindParam(':product_id', $productId);
        $checkStmt->execute();

        if ($checkStmt->rowCount() == 0) {
            $insertQuery = "INSERT INTO wishlists (user_id, product_id, created_at) 
                           VALUES (:user_id, :product_id, NOW())";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindParam(':user_id', $userId);
            $insertStmt->bindParam(':product_id', $productId);
            return $insertStmt->execute();
        }
        return false;
    }

    public function removeFromWishlist($userId, $productId) {
        $query = "DELETE FROM wishlists 
                 WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':product_id', $productId);
        return $stmt->execute();
    }

    public function getWishlistCount($userId) {
        $query = "SELECT COUNT(*) as count FROM wishlists WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?><?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<?php
class WishlistModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getWishlistItems($userId) {
        $query = "SELECT p.* FROM products p 
                  JOIN wishlists w ON p.id = w.product_id 
                  WHERE w.user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToWishlist($userId, $productId) {
        // Check if already in wishlist
        $checkQuery = "SELECT * FROM wishlists 
                      WHERE user_id = :user_id AND product_id = :product_id";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindParam(':user_id', $userId);
        $checkStmt->bindParam(':product_id', $productId);
        $checkStmt->execute();

        if ($checkStmt->rowCount() == 0) {
            $insertQuery = "INSERT INTO wishlists (user_id, product_id, created_at) 
                           VALUES (:user_id, :product_id, NOW())";
            $insertStmt = $this->db->prepare($insertQuery);
            $insertStmt->bindParam(':user_id', $userId);
            $insertStmt->bindParam(':product_id', $productId);
            return $insertStmt->execute();
        }
        return false;
    }

    public function removeFromWishlist($userId, $productId) {
        $query = "DELETE FROM wishlists 
                 WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':product_id', $productId);
        return $stmt->execute();
    }

    public function getWishlistCount($userId) {
        $query = "SELECT COUNT(*) as count FROM wishlists WHERE user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
}
?>