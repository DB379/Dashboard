<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="settings-container">
                <nav class="tabs">
                    <button class="tab-button" onclick="showTab('profile')">Profile</button>
                    <button class="tab-button" onclick="showTab('security')">Security</button>
                    <button class="tab-button" onclick="showTab('website')">Website</button>
                </nav>
                <div id="profile" class="tab-content active">
                    <form id="profilePicForm" method="post" enctype="multipart/form-data">
                        <h2>Profile</h2>
                        <div class="form-group">
                            <label for="upload-pic">Change Picture</label>
                            <input type="file" id="upload-pic" name="upload-pic">
                            <button type="button" onclick="uploadPicture()">Change Picture</button>
                        </div>
                    </form>
                    <h3>Recent Activity</h3>
                    <!-- Include the PHP script here -->
                    <?php include '../views/fetch.php'; ?>
                </div>
                <div id="security" class="tab-content">
                    <h2>Security</h2>
                    <div class="form-group">
                        <h3>Change Password</h3>
                        <label for="old-password">Old Password</label>
                        <input type="password" id="old-password" name="old-password" required>
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" name="new-password" required>
                        <label for="retype-password">Retype New Password</label>
                        <input type="password" id="retype-password" name="retype-password" required>
                        <button type="button" onclick="changePassword()">Change Password</button>
                    </div>
                    <div class="form-group">
                        <h3>Change Email</h3>
                        <label for="old-email">Old Email</label>
                        <input type="email" id="old-email" name="old-email" required>
                        <label for="new-email">New Email</label>
                        <input type="email" id="new-email" name="new-email" required>
                        <label for="retype-email">Retype New Email</label>
                        <input type="email" id="retype-email" name="retype-email" required>
                        <button type="button" onclick="changeEmail()">Change Email</button>
                    </div>
                </div>
                <div id="website" class="tab-content">
                    <h2>Website</h2>
                    <div class="form-group">
                        <h3>Website Color Theme</h3>
                        <button type="button" onclick="toggleTheme('dark')">Dark Theme</button>
                        <button type="button" onclick="toggleTheme('light')">Light Theme</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/script/script.js"></script>
</body>

</html>