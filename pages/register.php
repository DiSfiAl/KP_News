<?php
require_once '../db/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = htmlspecialchars($_POST['login']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = htmlspecialchars($_POST['email']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $secondname = htmlspecialchars($_POST['secondname']);

    // Завантажуємо дефолтне зображення
    $default_avatar_path = '../img/user.png';
    $default_avatar = file_get_contents($default_avatar_path);

    $stmt = $conn->prepare("INSERT INTO users (login, password, email, firstname, secondname, avatar) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssb", $login, $password, $email, $firstname, $secondname, $default_avatar);

    if ($stmt->send_long_data(5, $default_avatar) && $stmt->execute()) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Не вдалося зареєструвати користувача.";
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
    <title>Реєстрація</title>
</head>
<body>
    <?php include '../components/navbar.php'; ?>
    <div class="container">
        <div class="content">
            <h3>Реєстрація</h3>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
                <label>Логін:</label>
                <input type="text" name="login" required>
                <label>Пароль:</label>
                <input type="password" name="password" required>
                <label>Електронна пошта:</label>
                <input type="email" name="email" required>
                <label>Ім'я:</label>
                <input type="text" name="firstname" required>
                <label>Прізвище:</label>
                <input type="text" name="secondname" required>
                <button type="submit">Зареєструватися</button>
            </form>
            <div class="text-end mt-3">
                <a href="login.php" class="text-primary">Вже маєте акаунт? Увійдіть</a>
            </div>
        </div>
    </div>
</body>
</html>
