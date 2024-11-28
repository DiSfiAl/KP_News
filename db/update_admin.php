<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $access_level = $_POST['access_level'];

    if (is_numeric($id) && is_numeric($access_level)) {
        $stmt = $conn->prepare("UPDATE admins SET access_level = ? WHERE id = ?");
        $stmt->bind_param('ii', $access_level, $id);

        if ($stmt->execute()) {
            echo json_encode(['message' => 'Access level updated successfully!']);
        } else {
            echo json_encode(['message' => 'Failed to update access level.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['message' => 'Invalid data.']);
    }
}
