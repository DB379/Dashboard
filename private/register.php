<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/global.css">
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php 
        if (isset($_SESSION['error'])) {
            echo '<p style="color:red;">' . htmlspecialchars($_SESSION['error']) . '</p>';
            unset($_SESSION['error']); // Clear the message after displaying
        }
        if (isset($_SESSION['success'])) {
            echo '<p style="color:green;">' . htmlspecialchars($_SESSION['success']) . '</p>';
            unset($_SESSION['success']); // Clear the message after displaying
        }
        ?>
        <form action="index.php?page=register" method="POST">
            <label for="username">Account Name</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <label for="password_confirm">Confirm Password</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <a href="index.php?page=login">Already have an account? Login here</a>
        </div>
    </div>
</body>
</html>
