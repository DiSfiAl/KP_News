<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$accessLevel = $_SESSION['access_level'];
?>
<nav class="admin-navbar">
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="add_news.php">Add News</a></li>
        <?php if ($accessLevel == 3): ?>
            <li><a href="manage_admins.php">Manage Admins</a></li>
        <?php endif; ?>
        <li><a href="view_logs.php">View Logs</a></li>
        <li><a href="../db/logout.php">Logout</a></li>
    </ul>
</nav>
