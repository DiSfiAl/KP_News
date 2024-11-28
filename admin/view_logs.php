<?php
require_once '../db/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$query = "
    SELECT admin_logs.id, admins.username, admin_logs.action, admin_logs.performed_at
    FROM admin_logs
    INNER JOIN admins ON admin_logs.admin_id = admins.id
    ORDER BY admin_logs.performed_at DESC
";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Logs</title>
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
    <?php include '../components/admin_navbar.php'; ?>

    <div class="dashboard-container">
        <h1>Admin Logs</h1>
        <table class="admins-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Admin Username</th>
                    <th>Action</th>
                    <th>Performed At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($log = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><?= htmlspecialchars($log['username']) ?></td>
                        <td><?= htmlspecialchars($log['action']) ?></td>
                        <td><?= $log['performed_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
