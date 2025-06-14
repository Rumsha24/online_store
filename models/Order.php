<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Order {
    private $conn;
    private $table = 'orders';

    public $orderID;
    public $userID;
    public $orderDate;
    public $totalAmount;
    public $status;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function save() {
        if (isset($this->orderID)) {
            // Update
            $query = "UPDATE {$this->table} SET userID = ?, orderDate = ?, totalAmount = ?, status = ? WHERE orderID = ?";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([$this->userID, $this->orderDate, $this->totalAmount, $this->status, $this->orderID]);
        } else {
            // Create
            $query = "INSERT INTO {$this->table} (userID, orderDate, totalAmount, status) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$this->userID, $this->orderDate, $this->totalAmount, $this->status]);
            $this->orderID = $this->conn->lastInsertId();
            return true;
        }
    }

    public static function find($orderID) {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT * FROM orders WHERE orderID = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$orderID]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $order = new self();
            foreach ($data as $key => $value) {
                $order->$key = $value;
            }
            return $order;
        }

        return null;
    }
}
