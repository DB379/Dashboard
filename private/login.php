<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/global.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>'; } ?>
        <form action="index.php?page=login" method="POST">
            <label for="username">Account Name</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <a href="index.php?page=register">Don't have an account? Register here</a>
        </div>
    </div>
</body>
</html>
