<?php
session_start();
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['redirect' => '../pages/login.php']);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $news_id = $data['news_id'];

    // Перевірка на існування
    $check_query = "SELECT 1 FROM read_later WHERE user_id = ? AND news_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $user_id, $news_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        exit();
    }

    // Додавання до "Прочитати пізніше"
    $insert_query = "INSERT INTO read_later (user_id, news_id, added_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ii", $user_id, $news_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Не вдалося додати новину']);
    }
}
?>
