<?php
session_start();
require_once '../db/connection.php';

// Перевірка авторизації користувача
if (!isset($_SESSION['user_id'])) {
    echo "Користувач не авторизований.";
    exit;
}

$user_id = $_SESSION['user_id'];
$news_id = $_POST['news_id'] ?? 0;

if ($news_id == 0) {
    echo "Некоректний ідентифікатор новини.";
    exit;
}

// Перевіряємо, чи новина вже додана в список "Прочитати пізніше"
$query = "SELECT * FROM read_later WHERE user_id = ? AND news_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $news_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Якщо вже додана, видаляємо запис
    $deleteQuery = "DELETE FROM read_later WHERE user_id = ? AND news_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $user_id, $news_id);
    $deleteStmt->execute();
} else {
    // Якщо ще не додана, додаємо запис
    $insertQuery = "INSERT INTO read_later (user_id, news_id, added_at) VALUES (?, ?, NOW())";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ii", $user_id, $news_id);
    $insertStmt->execute();
}

// Перенаправляємо назад на сторінку новини
header("Location: ../pages/single_news.php?id=" . $news_id);
exit;
?>
