<?php
session_start();
require_once '../db/connection.php';

$currentNewsID = $_GET['id'] ?? 0;

// Збільшення лічильника переглядів
$updateViewsQuery = "UPDATE news SET views = views + 1 WHERE id = $currentNewsID";
mysqli_query($conn, $updateViewsQuery);

// Отримуємо новину
$newsQuery = "SELECT * FROM news WHERE id = $currentNewsID";
$newsResult = mysqli_query($conn, $newsQuery);
$news = mysqli_fetch_assoc($newsResult);

// Якщо новина не знайдена
if (!$news) {
    echo "Новину не знайдено.";
    exit;
}

// Логіка для збереження новини на потім (тільки для авторизованих користувачів)
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Видаляємо старі записи про цю новину для унікальності
    $stmt = $conn->prepare("DELETE FROM recent_views WHERE user_id = ? AND news_id = ?");
    $stmt->bind_param("ii", $user_id, $currentNewsID);
    $stmt->execute();

    // Додаємо новий запис
    $stmt = $conn->prepare("INSERT INTO recent_views (user_id, news_id, viewed_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $user_id, $currentNewsID);
    $stmt->execute();

    // Лімітуємо кількість записів у таблиці recent_views до останніх 5 новин
    $stmt = $conn->prepare("
        DELETE FROM recent_views 
        WHERE user_id = ? 
        AND id NOT IN (
            SELECT id FROM (
                SELECT id FROM recent_views WHERE user_id = ? ORDER BY viewed_at DESC LIMIT 5
            ) tmp
        )
    ");
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
}

// Отримуємо категорію новини для підбору новин по темі
$categoryQuery = "SELECT * FROM categories WHERE id = {$news['category_id']}";
$categoryResult = mysqli_query($conn, $categoryQuery);
$category = mysqli_fetch_assoc($categoryResult);

// Якщо категорія не знайдена
if (!$category) {
    echo "Категорію не знайдено.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $news['title']; ?></title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/components.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Ліва панель -->
            <div class="col-md-3">
                <?php include '../components/sidebar.php'; ?>
            </div>

            <!-- Основний контент -->
            <div class="col-md-6">
                <div class="news-container">
                    <!-- Блок 1: Заголовок і сама новина -->
                    <div class="news-section news-header-block">
                        <h2 class="news-header"><?php echo $news['title']; ?></h2>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php
                            $user_id = $_SESSION['user_id'];
                            $savedQuery = "SELECT * FROM read_later WHERE user_id = $user_id AND news_id = $currentNewsID";
                            $savedResult = mysqli_query($conn, $savedQuery);
                            $isSaved = mysqli_num_rows($savedResult) > 0;
                            ?>
                            <form action="../db/toggle_read_later.php" method="POST">
                                <input type="hidden" name="news_id" value="<?php echo $currentNewsID; ?>">
                                <button type="submit" class="btn btn-secondary">
                                    <?php echo $isSaved ? '<ion-icon name="bookmark"></ion-icon>' : '<ion-icon name="bookmark-outline"></ion-icon>'; ?>
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-secondary">Увійдіть, щоб додати до прочитати пізніше</a>
                        <?php endif; ?>
                        <div class="news-body">
                            <?php echo htmlspecialchars_decode($news['content']); ?>
                        </div>
                    </div>

                    <!-- Блок 2: Схожі новини, категорія і дата -->
                    <div class="news-section related-news-block">
                        <h5>Новини по темі</h5>
                        <ul>
                            <?php
                            $relatedNewsQuery = "SELECT * FROM news WHERE category_id = {$news['category_id']} AND id != $currentNewsID ORDER BY created_at DESC LIMIT 4";
                            $relatedNewsResult = mysqli_query($conn, $relatedNewsQuery);

                            if (mysqli_num_rows($relatedNewsResult) > 0) {
                                while ($relatedNews = mysqli_fetch_assoc($relatedNewsResult)) {
                                    echo "<li><a href='single_news.php?id={$relatedNews['id']}'>{$relatedNews['title']}</a></li>";
                                }
                            } else {
                                echo "<li>Немає новин по темі</li>";
                            }
                            ?>
                        </ul>
                        <p class="news-meta mt-2">Категорія: <a href="search_by_categories.php?id=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a> | Дата: <?php echo $news['created_at']; ?></p>
                    </div>

                    <!-- Блок 3: Форма для додавання коментаря -->
                    <div class="news-section add-comment-block">
                        <h5>Залишити коментар</h5>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form action="../db/add_comment.php" method="POST">
                                <textarea name="comment" class="form-control mb-2" placeholder="Напишіть ваш коментар..." required></textarea>
                                <input type="hidden" name="news_id" value="<?php echo $currentNewsID; ?>">
                                <button type="submit" class="btn btn-primary">Залишити коментар</button>
                            </form>
                        <?php else: ?>
                            <p><a href="login.php">Увійдіть</a>, щоб залишити коментар.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Блок 4: Вивід коментарів -->
                    <div class="comments-section">
                        <h5>Коментарі</h5>
                        <?php
                        $commentsQuery = "SELECT c.content, c.created_at, u.firstname, u.secondname, u.avatar 
                                        FROM comments c 
                                        JOIN users u ON c.user_id = u.id 
                                        WHERE c.news_id = $currentNewsID 
                                        ORDER BY c.created_at DESC";
                        $commentsResult = mysqli_query($conn, $commentsQuery);

                        if (mysqli_num_rows($commentsResult) > 0) {
                            while ($comment = mysqli_fetch_assoc($commentsResult)) {
                                echo "<div class='news-section comment-block'>";
                                echo "<div class='comment-header'>";
                                echo "<div class='d-flex align-items-center'>";
                                if (!empty($comment['avatar'])) {
                                    echo "<img src='data:image/png;base64," . base64_encode($comment['avatar']) . "' 
                                            alt='avatar' 
                                            class='comment-avatar rounded-circle' 
                                            width='40' height='40'>";
                                } else {
                                    echo "<img src='../img/user.png' 
                                            alt='avatar' 
                                            class='comment-avatar rounded-circle' 
                                            width='40' height='40'>";
                                }
                                echo "<strong>" . htmlspecialchars($comment['firstname'] . " " . $comment['secondname']) . "</strong>";
                                echo "</div>";
                                echo "<small class='comment-date'>" . $comment['created_at'] . "</small>";
                                echo "</div>"; // Закриття comment-header
                                echo "<p>" . htmlspecialchars($comment['content']) . "</p>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>Коментарів поки що немає.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Права панель -->
            <div class="col-md-3">
                <?php include '../components/rightbar.php'; ?>
            </div>
        </div>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
