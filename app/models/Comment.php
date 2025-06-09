<?php

class Comment {
    private $conn;
    private $table = 'comments';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addComment($productID, $userID, $rating, $text, $imagePath = null) {
        $sql = "INSERT INTO comments (productID, userID, rating, image, text) VALUES (:productID, :userID, :rating, :image, :text)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':productID', $productID);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':text', $text);

        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }

    public function getCommentsByProduct($productID) {
        $stmt = $this->conn->prepare("SELECT c.*, u.username FROM $this->table c JOIN users u ON c.userID = u.userID WHERE productID = ? ORDER BY commentID DESC");
        $stmt->execute([$productID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
