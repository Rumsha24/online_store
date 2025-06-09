<?php

class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Check if email already exists
    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    // Create new user (password must be hashed before calling this)
    public function createUser($email, $hashedPassword, $username, $shippingAddress) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (email, password, username, shippingAddress) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$email, $hashedPassword, $username, $shippingAddress]);
    }

    // Get user record by email (used for login)
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
