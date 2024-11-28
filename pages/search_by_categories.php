<?php
// Підключення до бази даних
include '../db/connection.php';

// Отримання ID категорії з GET-запиту
$categoryId = $_GET['id'] ?? null;

if (!$categoryId) {
    echo "Категорія не знайдена.";
    exit;
}

// Отримання новин за категорією
$query = "SELECT * FROM news WHERE category_id = $categoryId ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

// Отримання назви категорії
$categoryQuery = "SELECT name FROM categories WHERE id = $categoryId";
$categoryResult = mysqli_fetch_assoc(mysqli_query($conn, $categoryQuery));
$categoryName = $categoryResult['name'] ?? 'Категорія';
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новини категорії <?php echo htmlspecialchars($categoryName); ?></title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/global.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="container mt-4">
        <h3 class="text-center">Новини в категорії "<?php echo htmlspecialchars($categoryName); ?>"</h3>
        <div class="row">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($news = mysqli_fetch_assoc($result)): ?>
                    <div class="col-12 mb-3">
                        <div class="content">
                            <h5><a href="single_news.php?id=<?php echo $news['id']; ?>" class="news-title"><?php echo $news['title']; ?></a></h5>
                            <p class="text-muted"><?php echo substr(strip_tags($news['content']), 0, 50); ?>...</p>
                            <small class="text-secondary">Опубліковано: <?php echo $news['created_at']; ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">У цій категорії немає новин.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
