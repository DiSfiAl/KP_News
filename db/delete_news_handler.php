<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    // Пом'якшене видалення новини (ставимо is_deleted = 1)
    $stmt = $conn->prepare("UPDATE news SET is_deleted = 1 WHERE id = ?");
    $stmt->bind_param("i", $news_id);

    if ($stmt->execute()) {
        header("Location: ../admin/dashboard.php?success=News deleted successfully!");
    } else {
        header("Location: ../admin/dashboard.php?error=Failed to delete news.");
    }
} else {
    header("Location: ../admin/dashboard.php?error=Invalid news ID.");
}
?>
