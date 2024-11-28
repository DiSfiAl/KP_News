<?php
// Підключення до бази даних
include '../db/connection.php';

// Отримуємо запит з пошуку
$query = $_GET['query'] ?? '';

// Перевіряємо, чи введений запит
if (empty($query)) {
    echo "Введіть текст для пошуку.";
    exit;
}

// Пошук новин за назвою або контентом
$searchQuery = "SELECT * FROM news WHERE title LIKE '%$query%' OR content LIKE '%$query%' ORDER BY created_at DESC";
$searchResult = mysqli_query($conn, $searchQuery);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результати пошуку</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/global.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="container mt-4">
        <h3 class="text-center">Результати пошуку</h3>
        <div class="row">
            <?php if (mysqli_num_rows($searchResult) > 0): ?>
                <?php while ($news = mysqli_fetch_assoc($searchResult)): ?>
                    <!-- Перевірка на наявність посилань на YouTube або фото -->
                    <?php
                    $contentPreview = substr(strip_tags($news['content']), 0, 50);
                    if (strpos($news['content'], 'youtube.com') !== false || strpos($news['content'], '<img') !== false) {
                        $contentPreview = "Опис недоступний через мультимедійний вміст.";
                    }
                    ?>
                    <div class="col-12 mb-3">
                        <div class="content">
                            <h5><a href="single_news.php?id=<?php echo $news['id']; ?>" class="news-title"><?php echo $news['title']; ?></a></h5>
                            <p class="text-muted"><?php echo $contentPreview; ?>...</p>
                            <small class="text-secondary">Опубліковано: <?php echo $news['created_at']; ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Новин за запитом "<?php echo htmlspecialchars($query); ?>" не знайдено.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
