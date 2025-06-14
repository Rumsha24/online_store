
<?php
class OrderModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAllOrders() {
        $stmt = $this->db->prepare("SELECT * FROM orders");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($orderID) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE orderID = ?");
        $stmt->execute([$orderID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>