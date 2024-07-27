<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['verifier'])) {
            return $user;
        }
        return false;
    }

    public function generateSessionKey($username) {
        $session_key = bin2hex(random_bytes(32));
        $stmt = $this->db->prepare("UPDATE accounts SET session_key = :session_key, last_ip = :last_ip, failed_login = 0 WHERE username = :username");
        $stmt->bindParam(':session_key', $session_key);
        $stmt->bindParam(':last_ip', $_SERVER['REMOTE_ADDR']);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Insert login status
        $this->logLogin($username);

        return $session_key;
    }

    public function logout($username) {
        // Update session_key, logged columns
        $stmt = $this->db->prepare("UPDATE accounts SET session_key = NULL, logged = 0 WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    
        // Update the most recent login record with the logout time
        $stmt = $this->db->prepare("UPDATE login_status SET logged_out = NOW() WHERE username = :username AND logged_out IS NULL ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }
    

    private function logLogin($username) {
        $stmt = $this->db->prepare("INSERT INTO login_status (username, logged_at) VALUES (:username, NOW())");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }


    public function incrementFailedLogin($username) {
        $stmt = $this->db->prepare("UPDATE accounts SET failed_login = failed_login + 1 WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
    }

    public function setLoggedStatus($username, $status) {
        $stmt = $this->db->prepare("UPDATE accounts SET logged = :status WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    }

    public function register($username, $email, $password) {
        $verifier = password_hash($password, PASSWORD_ARGON2ID);
        try {
            $stmt = $this->db->prepare("INSERT INTO accounts (username, verifier, email, last_ip) VALUES (:username, :verifier, :email, :last_ip)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':verifier', $verifier);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':last_ip', $_SERVER['REMOTE_ADDR']);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // This will pass the error message to the controller
            throw new Exception("Failed to register. " . $e->getMessage());
        }
    }
}
?>
