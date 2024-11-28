<?php
require_once '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE login = ? AND email = ?");
    $stmt->bind_param("ss", $login, $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header('Location: set_new_password.php');
        exit();
    } else {
        $error = "Некоректний логін або email.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../style/profile.css">
    <title>Відновлення пароля</title>
</head>
<body>
    <div class="container">
        <div class="content">
            <h3>Відновлення пароля</h3>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <label>Логін:</label>
                <input type="text" name="login" required>
                <label>Email:</label>
                <input type="email" name="email" required>
                <button type="submit">Відновити пароль</button>
            </form>
        </div>
    </div>
</body>
</html>
