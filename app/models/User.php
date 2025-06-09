<?php

class User {
    private $conn;
    private $table = 'users'; // make sure your DB table is named 'users'

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
        $success = $stmt->execute([$email, $hashedPassword, $username, $shippingAddress]);

        if (!$success) {
            // log error info to check what went wrong
            $errorInfo = $stmt->errorInfo();
            file_put_contents(__DIR__ . '/../log.txt', "Signup Error: " . print_r($errorInfo, true), FILE_APPEND);
        }

        return $success;
    }

    // Get user record by email (used for login)
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
