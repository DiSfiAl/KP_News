<?php
session_start();
require_once '../db/connection.php';

// Перевірка авторизації
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['news_id']) || empty($data['news_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid or missing news_id']);
    exit();
}

if (isset($data['news_id'])) {
    $news_id = intval($data['news_id']);
    $stmt = $conn->prepare("DELETE FROM read_later WHERE user_id = ? AND news_id = ?");
    $stmt->bind_param("ii", $user_id, $news_id);
    $stmt->execute();

    echo json_encode(['success' => $stmt->affected_rows > 0]);
    exit();
}

http_response_code(400);
echo json_encode(['success' => false]);
