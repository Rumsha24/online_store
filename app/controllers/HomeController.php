<?php
class HomeController {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function index() {
        include __DIR__ . '/../../view/home/index.php';
    }
}
