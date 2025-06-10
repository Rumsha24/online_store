<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Core + Models + Controllers
require_once '../app/core/Database.php';
require_once '../app/models/User.php';
require_once '../app/models/Comment.php';
require_once '../app/models/Product.php';
require_once '../app/models/Cart.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/ProductController.php';
require_once '../app/controllers/CartController.php';

// Parse the URL from query string
$url = isset($_GET['url']) ? $_GET['url'] : 'user/showSignupForm';
$url = explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));

// Resolve controller and method
$controllerName = ucfirst($url[0]) . 'Controller';
$method = $url[1] ?? 'index';
$params = array_slice($url, 2);

// Get DB connection
$database = new Database();
$db = $database->getConnection();

// Controller Dispatch
if (file_exists("../app/controllers/$controllerName.php")) {
    require_once "../app/controllers/$controllerName.php";

    // Pass DB to controller constructor if needed
    $controller = new $controllerName($db);

    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        echo "Method <strong>$method</strong> not found in controller <strong>$controllerName</strong>.";
    }
} else {
    echo "Controller <strong>$controllerName</strong> not found.";
}
