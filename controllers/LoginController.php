<?php
class LoginController {
    private $userModel;
    private $sessionTimeout = 1800; // 30 minutes

    public function __construct($userModel) {
        $this->userModel = $userModel;

        $this->checkSessionTimeout();
    }

    public function showLoginForm() {
        require 'private/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $this->sanitizeInput($_POST['username']);
            $password = $this->sanitizeInput($_POST['password']);
            $remember_me = isset($_POST['remember_me']);

            try {
                $user = $this->userModel->authenticate($username, $password);

                if ($user) {
                    $session_key = $this->userModel->generateSessionKey($username);
                    $_SESSION['username'] = $username;
                    $_SESSION['session_key'] = $session_key;
                    $_SESSION['last_activity'] = time();

                    // Set logged status to 1
                    $this->userModel->setLoggedStatus($username, 1);

                    if ($remember_me) {
                        setcookie('username', $username, time() + (30 * 24 * 60 * 60), "/");
                        setcookie('session_key', $session_key, time() + (30 * 24 * 60 * 60), "/");
                    }

                    header('Location: ../views/dashboard.php?page=dashboard'); // Redirect to clean URL
                    exit();
                } else {
                    $this->userModel->incrementFailedLogin($username);
                    $error = "Invalid username or password.";
                    error_log($error); // Log the error
                    require 'private/login.php';
                }
            } catch (Exception $e) {
                error_log($e->getMessage()); // Log any exceptions
                $error = "An error occurred during login. Please try again later.";
                require 'private/login.php';
            }
        } else {
            require 'private/login.php';
        }
    }

    
    private function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    

    private function checkSessionTimeout() {
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $this->sessionTimeout)) {
            session_unset(); 
            session_destroy(); 
            header('Location: ../index.php?page=login');
            exit();
        }
        $_SESSION['last_activity'] = time();
    }
}
?>
