<?php
session_start();
require_once '../db/connection.php';

// Перевірка авторизації користувача
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

// Отримуємо дані з форми
$comment = $_POST['comment'] ?? '';
$news_id = $_POST['news_id'] ?? 0;

if (empty($comment) || $news_id == 0) {
    header("Location: ../pages/single_news.php?id=$news_id");
    exit;
}

$user_id = $_SESSION['user_id'];

// Додаємо коментар до бази даних
$query = "INSERT INTO comments (news_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param("iis", $news_id, $user_id, $comment);
$stmt->execute();

// Повертаємося назад до новини
header("Location: ../pages/single_news.php?id=$news_id");
exit;
?>
