<?php
class Order {
    private $conn;
    private $table = "orders";

    public function __construct(\PDO $db) {
        $this->conn = $db;
    }

    public function placeOrder(int $userId, float $totalAmount): bool 
    {
        try {
            $query = "INSERT INTO $this->table (userID, totalAmount, status, createdAt) 
                      VALUES (?, ?, 'pending', NOW())";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$userId, $totalAmount]);
        } catch (\PDOException $e) {
            // Log error
            throw new \RuntimeException("Failed to place order: " . $e->getMessage());
        }
    }

    public function getUserOrders(int $userId, int $limit = null, int $offset = null): array 
    {
        try {
            $query = "SELECT * FROM $this->table WHERE userID = ? ORDER BY createdAt DESC";
            
            if ($limit !== null) {
                $query .= " LIMIT ? OFFSET ?";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$userId, $limit, $offset]);
            } else {
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$userId]);
            }
            
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RuntimeException("Failed to fetch orders: " . $e->getMessage());
        }
    }

    public function getOrderById(int $orderId): ?array 
    {
        try {
            $query = "SELECT * FROM $this->table WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$orderId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        } catch (\PDOException $e) {
            throw new \RuntimeException("Failed to fetch order: " . $e->getMessage());
        }
    }

    public function updateOrderStatus(int $orderId, string $status): bool 
    {
        try {
            $query = "UPDATE $this->table SET status = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$status, $orderId]);
        } catch (\PDOException $e) {
            throw new \RuntimeException("Failed to update order status: " . $e->getMessage());
        }
    }
}