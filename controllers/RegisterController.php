<?php

class RegisterController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $password_confirm = htmlspecialchars($_POST['password_confirm']);
    
            if ($password === $password_confirm) {
                try {
                    if ($this->userModel->register($username, $email, $password)) {
                        $_SESSION['success'] = "Registration successful!";
                        header('Location: index.php?page=register');
                        exit();
                    } else {
                        // Assume failure without specifics
                        $_SESSION['error'] = "Invalid name or email.";
                        header('Location: index.php?page=register');
                        exit();
                    }
                } catch (Exception $e) {
                    // Generic error message for any exception
                    $_SESSION['error'] = "Invalid name or email.";
                    header('Location: index.php?page=register');
                    exit();
                }
            } else {
                $_SESSION['error'] = "Passwords don't match.";
                header('Location: index.php?page=register');
                exit();
            }
        } else {
            require 'private/register.php';
        }
    }
}