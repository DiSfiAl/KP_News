<?php
require_once '../db/connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
        $stmt->execute();

        header('Location: index.php');
        exit();
    } else {
        $error = "Паролі не збігаються.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/profile.css">
    <title>Зміна пароля</title>
</head>
<body>
    <div class="container">
        <div class="content">
            <h3>Зміна пароля</h3>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <label>Новий пароль:</label>
                <input type="password" name="password" required>
                <label>Підтвердіть пароль:</label>
                <input type="password" name="confirm_password" required>
                <button type="submit">Змінити пароль</button>
            </form>
        </div>
    </div>
</body>
</html>
