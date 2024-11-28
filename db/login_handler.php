<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Перевірка на існування користувача
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Порівнюємо введений пароль з хешем у базі
        $hashedPassword = hash('sha256', $password);
        if ($hashedPassword === $admin['password']) {
            // Зберігаємо дані у сесії
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['access_level'] = $admin['access_level'];
            
            // Перенаправляємо на dashboard
            header('Location: ../admin/dashboard.php');
            exit;
        } else {
            // Невірний пароль
            header('Location: ../admin/login.php?error=Invalid password');
            exit;
        }
    } else {
        // Користувач не знайдений
        header('Location: ../admin/login.php?error=User not found');
        exit;
    }
} else {
    // Неправильний метод запиту
    header('Location: ../admin/login.php');
    exit;
}
?>
