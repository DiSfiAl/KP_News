<?php
require_once '../db/connection.php';
?>

<link rel="stylesheet" href="../style/bootstrap.min.css">
<link rel="stylesheet" href="../style/components.css">

<div class="sidebar">
    <h5>Останні новини</h5>
    <ul>
        <?php
        $userId = $_SESSION['user_id'] ?? null; // Ідентифікатор користувача
        $query = "SELECT id, title FROM news WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT 10";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $newsId = $row['id'];

            // Перевірка, чи новина вже додана до "Прочитати пізніше"
            $bookmarkQuery = $userId
                ? "SELECT 1 FROM read_later WHERE user_id = $userId AND news_id = $newsId"
                : null;
            $isBookmarked = $userId && mysqli_num_rows(mysqli_query($conn, $bookmarkQuery)) > 0;

            echo "
                <li>
                    <a href='single_news.php?id={$row['id']}'>{$row['title']}</a>
                    <button class='bookmark-btn' data-news-id='{$row['id']}'>
                        <ion-icon name='" . ($isBookmarked ? "bookmark" : "bookmark-outline") . "'></ion-icon>
                    </button>
                </li>
            ";
        }
        ?>
    </ul>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="../script/main.js"></script>
