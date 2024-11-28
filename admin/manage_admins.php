<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
include '../db/connection.php';

// Отримуємо дані для статистики
$totalNews = $conn->query("SELECT COUNT(*) AS count FROM news WHERE is_deleted = 0")->fetch_assoc()['count'];
$totalAdmins = $conn->query("SELECT COUNT(*) AS count FROM admins")->fetch_assoc()['count'];
$totalCategories = $conn->query("SELECT COUNT(*) AS count FROM categories")->fetch_assoc()['count'];

// Отримуємо список адміністраторів
$admins = $conn->query("SELECT id, username, access_level, created_at FROM admins");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="../style/admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        <div class="dashboard-container">
            <h1>Manage Admins</h1>
            <table class="admins-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Access Level</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $admins->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td>
                                <select class="access-level" data-id="<?= $row['id'] ?>">
                                    <option value="1" <?= $row['access_level'] == 1 ? 'selected' : '' ?>>1</option>
                                    <option value="2" <?= $row['access_level'] == 2 ? 'selected' : '' ?>>2</option>
                                    <option value="3" <?= $row['access_level'] == 3 ? 'selected' : '' ?>>3</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn-update" data-id="<?= $row['id'] ?>" >Update</button>
                            </td>
                            <td>
                                <a href="../db/delete_admin_handler.php?id=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <form action="../db/add_admin_handler.php" method="post" class="form-add-admin">
            <h3>Add New Admin</h3>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="access_level">Access Level:</label>
                <select id="access_level" name="access_level" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <button type="submit" class="btn-submit">Add Admin</button>
        </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Обробка кнопки Update
            $('.btn-update').on('click', function () {
                const adminId = $(this).data('id');
                const accessLevel = $(`.access-level[data-id="${adminId}"]`).val();

                $.ajax({
                    url: '../db/update_admin.php',
                    method: 'POST',
                    data: { id: adminId, access_level: accessLevel },
                    success: function (response) {
                        alert(response.message);
                    },
                    error: function () {
                        alert('Error updating access level.');
                    }
                });
            });
        });
    </script>
</body>
</html>
