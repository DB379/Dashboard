<?php
// Include the database connection file
require_once '../db.php';



// Ensure that a username is set in the session
if (!isset($_SESSION['username'])) {
    echo "<p>User is not logged in.</p>"; // Handling if the user is not logged in
    return; // Stop further execution if not logged in
}

$username = $_SESSION['username']; // Get the username from the session

// Function to format activity data
function formatActivity($value) {
    return $value ? htmlspecialchars($value) : '-';
}

try {
    // Prepare and execute the query to fetch user activities
    $stmt = $db->prepare("SELECT username, logged_at, logged_out FROM login_status WHERE username = :username");
    $stmt->execute(['username' => $username]);

    // Fetch all records
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="activity-table">
    <?php if ($activities): ?>
    <table>
        <tr>
            <th>Username</th>
            <th>Logged Time</th>
            <th>Logged Out</th>
        </tr>
        <?php foreach ($activities as $activity): ?>
        <tr>
            <td><?= formatActivity($activity['username']); ?></td>
            <td><?= formatActivity($activity['logged_at']); ?></td>
            <td><?= formatActivity($activity['logged_out']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>No recent activity found.</p>
    <?php endif; ?>
</div>
<?php
} catch (PDOException $e) {
    echo "<p>Error fetching activity: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
