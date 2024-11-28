<?php
require_once '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $error = "Користувача з таким логіном не знайдено.";
    } else {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit();
        } else {
            $error = "Неправильний пароль.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/profile.css">
    <title>Авторизація</title>
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <div class="container">
        <div class="content">
            <h3>Авторизація</h3>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <label>Логін:</label>
                <input type="text" name="login" required>
                <label>Пароль:</label>
                <input type="password" name="password" required>
                <button type="submit">Увійти</button>
            </form>
            <div class="d-flex justify-content-between mt-3">
                <a href="register.php" class="text-primary">Ще не маєте акаунту? Зареєструйтесь</a>
                <a href="forteit_password.php" class="text-danger">Забули пароль?</a>
            </div>
        </div>
    </div>
</body>
</html>
