<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../app/core/Database.php';
require_once '../app/models/User.php';
require_once '../app/models/Comment.php';
require_once '../app/controllers/UserController.php';
require_once '../app/controllers/ProductController.php';
require_once '../app/controllers/CommentController.php';


// Change default route to user/showSignupForm for signup as default page
$url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
$url = explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));

$controllerName = ucfirst($url[0]) . 'Controller';
$method = $url[1] ?? 'index';
$params = array_slice($url, 2);

$database = new Database();
$db = $database->getConnection();

if (file_exists("../app/controllers/$controllerName.php")) {
    require_once "../app/controllers/$controllerName.php";
    $controller = new $controllerName($db);

    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        echo "Method $method not found in controller $controllerName.";
    }
} else {
    echo "Controller $controllerName not found.";
}
