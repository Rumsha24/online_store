<?php
class Database {
    private $host = "localhost";
    private $db_name = "ecommerce";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );

            // Enable detailed error reporting
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Optional: Set default fetch mode
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Optional: Enable emulated prepares (for debugging compatibility)
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Optional: Ensure foreign key checks are enabled (mostly needed for SQLite)
            $this->conn->exec("SET FOREIGN_KEY_CHECKS=1");

        } catch (PDOException $exception) {
            echo "<strong>Database Connection Error:</strong> " . $exception->getMessage();
            exit; // Stop script on connection error
        }

        return $this->conn;
    }
}
