<?php
require_once '../db/connection.php';
?>

<link rel="stylesheet" href="../style/bootstrap.min.css">
<link rel="stylesheet" href="../style/components.css">

<div class="rightbar">
    <section class="popular-news">
        <h4>Популярні новини</h4>
        <ul>
            <?php
            $userId = $_SESSION['user_id'] ?? null; // Ідентифікатор користувача
            $popular_query = "SELECT id, title FROM news WHERE is_deleted = 0 ORDER BY views DESC LIMIT 5";
            $popular_result = $conn->query($popular_query);

            while ($popular = $popular_result->fetch_assoc()) {
                $newsId = $popular['id'];

                // Перевірка, чи новина вже додана до "Прочитати пізніше"
                $bookmarkQuery = $userId
                    ? "SELECT 1 FROM read_later WHERE user_id = $userId AND news_id = $newsId"
                    : null;
                $isBookmarked = $userId && mysqli_num_rows(mysqli_query($conn, $bookmarkQuery)) > 0;

                echo "
                    <li>
                        <a href='single_news.php?id={$popular['id']}'>{$popular['title']}</a>
                        <button class='bookmark-btn' data-news-id='{$popular['id']}'>
                            <ion-icon name='" . ($isBookmarked ? "bookmark" : "bookmark-outline") . "'></ion-icon>
                        </button>
                    </li>
                ";
            }
            ?>
        </ul>
    </section>
    <hr>
    <section class="categories">
        <h4>Категорії</h4>
        <ul>
            <?php
            $categories_query = "SELECT id, name FROM categories";
            $categories_result = $conn->query($categories_query);

            while ($category = $categories_result->fetch_assoc()) {
                echo "
                    <li>
                        <a href='search_by_categories.php?id={$category['id']}'>
                            " . htmlspecialchars($category['name']) . "
                        </a>
                    </li>
                ";
            }
            ?>
        </ul>
    </section>
</div>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="../script/main.js"></script>
