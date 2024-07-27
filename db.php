<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=website', 'root', 'ascent');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . htmlspecialchars($e->getMessage());
}
?>