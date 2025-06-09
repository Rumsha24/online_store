<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $db;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new User($this->db);
    }

    // Show Signup Form
    public function showSignupForm() {
        include __DIR__ . '/../../view/user/signup.php';
    }

    // Handle Signup POST
public function signup() {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $shippingAddress = $_POST['shippingAddress'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($shippingAddress)) {
        $error = "All fields are required.";
        include __DIR__ . '/../../view/user/signup.php';
        return;
    }

    if ($this->userModel->emailExists($email)) {
        $error = "Email already registered.";
        include __DIR__ . '/../../view/user/signup.php';
        return;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($this->userModel->createUser($email, $hashedPassword, $username, $shippingAddress)) {
        // ✅ Redirect to login page after signup
        header('Location: /online_store/public/index.php?url=user/showLoginForm');
        exit;
    } else {
        $error = "Signup failed. Please try again.";
        include __DIR__ . '/../../view/user/signup.php';
    }
}


    // Show Login Form
    public function showLoginForm() {
        include __DIR__ . '/../../view/user/login.php';
    }

    // Handle Login POST
 public function login() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
        include __DIR__ . '/../../view/user/login.php';
        return;
    }

    $user = $this->userModel->getUserByEmail($email);

    if (!$user || !password_verify($password, $user['password'])) {
        $error = "Invalid email or password.";
        include __DIR__ . '/../../view/user/login.php';
        return;
    }

    // ✅ Set session
    $_SESSION['user_id'] = $user['userID'];
    $_SESSION['username'] = $user['username'];

    // ✅ Redirect
    header('Location: /online_store/public/index.php?url=home/index');
    exit;
}

}
