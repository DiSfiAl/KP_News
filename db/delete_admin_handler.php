<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Видалення адміністратора
    $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->bind_param("i", $admin_id);

    if ($stmt->execute()) {
        header("Location: ../admin/manage_admins.php?success=Admin deleted successfully!");
    } else {
        header("Location: ../admin/manage_admins.php?error=Failed to delete admin.");
    }
} else {
    header("Location: ../admin/manage_admins.php?error=Invalid admin ID.");
}
?>
