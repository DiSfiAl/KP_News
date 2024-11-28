<?php
require_once 'connection.php';

function logAction($adminId, $action) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO admin_logs (admin_id, action, performed_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $adminId, $action);
    $stmt->execute();
    $stmt->close();
}
?>
