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

    $delete_query = "DELETE FROM read_later WHERE user_id = ? AND news_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("ii", $user_id, $news_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Не вдалося видалити новину']);
    }
}
?>
