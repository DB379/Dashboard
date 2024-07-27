<?php
class NavigationController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function showDashboard($page) {
        $this->checkIfLoggedIn();
        require 'views/dashboard.php';
    }

    private function checkIfLoggedIn() {
        if (!isset($_SESSION['username']) || !isset($_SESSION['session_key'])) {
            header('Location: ../index.php?page=login');
            exit();
        }
    }
}
?>
