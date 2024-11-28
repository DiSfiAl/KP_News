<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
include '../db/connection.php';

// Отримуємо рівень доступу адміністратора
$accessLevel = $_SESSION['access_level'];

// Отримуємо дані для статистики
$totalNews = $conn->query("SELECT COUNT(*) AS count FROM news WHERE is_deleted = 0")->fetch_assoc()['count'];
$totalAdmins = $conn->query("SELECT COUNT(*) AS count FROM admins")->fetch_assoc()['count'];
$totalCategories = $conn->query("SELECT COUNT(*) AS count FROM categories")->fetch_assoc()['count'];

// Отримуємо список новин (видиме для всіх рівнів)
$news = $conn->query("SELECT id, title, views, created_at FROM news WHERE is_deleted = 0 ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
    <?php include '../components/admin_navbar.php'; ?>

    <div class="dashboard-container">
        <h1>Welcome, Admin</h1>
        <div class="stats">
            <div class="stat-item">
                <h3>Total News</h3>
                <p><?= $totalNews ?></p>
            </div>
            <div class="stat-item">
                <h3>Total Admins</h3>
                <p><?= $totalAdmins ?></p>
            </div>
            <div class="stat-item">
                <h3>Total Categories</h3>
                <p><?= $totalCategories ?></p>
            </div>
        </div>

        <h2>News List</h2>
        <table class="news-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Views</th>
                    <th>Created At</th>
                    <?php if ($accessLevel >= 2): ?>
                        <th>Edit</th>
                        <th>Delete</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $news->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= $row['views'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <?php if ($accessLevel >= 2): ?>
                            <td>
                                <a href="edit_news.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
                            </td>
                            <td>
                                <a href="../db/delete_news_handler.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
