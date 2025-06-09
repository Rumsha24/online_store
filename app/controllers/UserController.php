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
        // Set session timeout to 1 hour
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.gc_maxlifetime', 3600);
            session_start();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Optional debug log
        file_put_contents(__DIR__ . '/../../log.txt', "Login attempt: $email\n", FILE_APPEND);

        if (empty($email) || empty($password)) {
            $error = "Email and password are required.";
            include __DIR__ . '/../../view/user/login.php';
            return;
        }

        $user = $this->userModel->getUserByEmail($email);

        if (!$user) {
            $error = "Invalid email or password.";
            file_put_contents(__DIR__ . '/../../log.txt', "User not found\n", FILE_APPEND);
            include __DIR__ . '/../../view/user/login.php';
            return;
        }

        // Debug logs before password verification
        file_put_contents(__DIR__ . '/../../log.txt', "Input password: $password\n", FILE_APPEND);
        file_put_contents(__DIR__ . '/../../log.txt', "Stored hash: " . $user['password'] . "\n", FILE_APPEND);
        file_put_contents(__DIR__ . '/../../log.txt', "Verify result: " . (password_verify($password, $user['password']) ? "true" : "false") . "\n", FILE_APPEND);

        if (!password_verify($password, $user['password'])) {
            $error = "Invalid email or password.";
            file_put_contents(__DIR__ . '/../../log.txt', "Invalid password\n", FILE_APPEND);
            include __DIR__ . '/../../view/user/login.php';
            return;
        }

        // Set session on successful login
        $_SESSION['user_id'] = $user['userID'];
        $_SESSION['username'] = $user['username'];

        // Log successful login
        file_put_contents(__DIR__ . '/../../log.txt', "Login successful for user ID: " . $user['userID'] . "\n", FILE_APPEND);

        header('Location: /online_store/public/index.php?url=home/index');
        exit;
    }
}
