<?php
session_start();
require 'db.php'; // Database connection
require 'models/User.php';
require 'controllers/LoginController.php';
require 'controllers/RegisterController.php';
require 'controllers/NavigationController.php';

$userModel = new User($db);
$loginController = new LoginController($userModel);
$registerController = new RegisterController($userModel);
$navigationController = new NavigationController($userModel);

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

if (isset($_SESSION['username'])) {
    // User is logged in
    switch ($page) {
        case 'logout':
            $userModel->logout($_SESSION['username']);
            session_destroy();
            setcookie('username', '', time() - 3600, "/");
            setcookie('session_key', '', time() - 3600, "/");
            header('Location: index.php?page=login');
            exit();
        case 'dashboard':
        case 'page1':
        case 'page2':
        default:
            $navigationController->showDashboard($page);
            break;
    }
} else {
    // User is not logged in
    switch ($page) {
        case 'login':
            $loginController->login();
            break;
        case 'register':
            $registerController->register();
            break;
        default:
            $loginController->showLoginForm();
            break;
    }
}
?>
