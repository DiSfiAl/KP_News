<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $access_level = $_POST['access_level'];

    if (!empty($username) && !empty($password) && !empty($access_level)) {
        $stmt = $conn->prepare("INSERT INTO admins (username, password, access_level, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("ssi", $username, $password, $access_level);

        if ($stmt->execute()) {
            header("Location: ../admin/manage_admins.php?success=Admin added successfully!");
        } else {
            header("Location: ../admin/manage_admins.php?error=Failed to add admin.");
        }
    } else {
        header("Location: ../admin/manage_admins.php?error=All fields are required!");
    }
}
?>
