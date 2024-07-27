<?php
session_start();
require 'db.php';  // Ensure your database connection settings are correct

if (!isset($_SESSION['user_id'])) {
    exit('You must be logged in to change your profile picture.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['upload-pic'])) {
    $userId = $_SESSION['user_id'];
    $uploadDir = '../assets/users/profile/';
    $fileName = basename($_FILES['upload-pic']['name']);
    $targetPath = $uploadDir . $fileName;

    // Validate the file (ensure it's an image, check size, etc.)
    if (move_uploaded_file($_FILES['upload-pic']['tmp_name'], $targetPath)) {
        $stmt = $db->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
        $stmt->execute([$fileName, $userId]);
        echo "Profile picture updated successfully.";
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "No file uploaded.";
}
?>
