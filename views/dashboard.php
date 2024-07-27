<?php
session_start(); // Start the session

// Function to check if the user is logged in
function checkIfLoggedIn()
{
    if (!isset($_SESSION['username']) || !isset($_SESSION['session_key'])) {
        header('Location: ../index.php?page=login');
        exit();
    }
}

// Call the function to check login status
checkIfLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <div class="container">
        <nav class="sidebar">
            <div class="user-info">
                <!-- The user picture will be styled via CSS -->
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <div id="userProfilePic" style="background: url('../assets/users/profile/<?php echo $userProfilePicPath ?? 'default.png'; ?>') no-repeat center left;">
            </div>
            <ul>
                <?php
                // Get the current page from query parameters
                $currentPage = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

                // Array of pages
                $pages = [
                    'dashboard' => 'Dashboard',
                    'acc' => 'Accounts',
                    'mail' => 'Email'
                ];

                // Generate menu items
                foreach ($pages as $page => $title) {
                    $activeClass = ($currentPage == $page) ? 'active' : '';
                    echo "<li><a href=\"dashboard.php?page=$page\" class=\"$activeClass\">$title</a></li>";
                }
                ?>
            </ul>
            <div class="sidebar-buttons">
                <?php
                $settingsActive = ($currentPage == 'settings') ? 'active' : '';
                ?>
                <a href="dashboard.php?page=settings" class="button <?php echo $settingsActive; ?>">Settings</a>
                <a href="../index.php?page=logout" class="button logout">Logout</a>
            </div>
        </nav>
        <div class="content">
            <?php
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'acc':
                        require '../public/acc.php';
                        break;
                    case 'mail':
                        require '../public/mail.php';
                        break;
                    case 'settings':
                        require '../private/settings.php'; // Load settings page
                        break;
                    case 'dashboard':
                    default:
                        require '../public/dashboard.php'; // Show the content of public/dashboard.php
                        break;
                }
            } else {
                require '../public/dashboard.php'; // Show the content of public/dashboard.php
            }
            ?>
        </div>
    </div>
</body>
</html>
