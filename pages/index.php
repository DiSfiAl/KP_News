<?php
require_once '../db/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новини</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/global.css">
</head>
<body>
    <!-- Навігаційна панель -->
    <?php include '../components/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Лівий блок -->
            <div class="col-md-3">
                <?php include '../components/sidebar.php'; ?>
            </div>

            <!-- Основний контент -->
            <div class="col-md-6">
                <div class="content">
                    <!-- Блок "Про нас" -->
                    <div class="mb-4">
                        <h2>Про нас</h2>
                        <p>Ми молода журналістська організація, яка ставить за цілі висвітлювати всі досягнення Чехії. Ми віримо в силу інформації та її роль у формуванні сучасного суспільства.</p>
                        <p>Крім того, ми прагнемо тримати наших читачів у курсі найважливіших подій світу. Достовірність, об'єктивність та оперативність — основи нашої роботи.</p>
                    </div>

                    <!-- Блок "Останні новини" -->
                    <div class="mb-4">
                        <h2>Останні новини</h2>
                        <div class="row">
                            <?php
                            $latestNewsQuery = "SELECT id, title, created_at FROM news WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT 4";
                            $latestNewsResult = mysqli_query($conn, $latestNewsQuery);
                            while ($news = mysqli_fetch_assoc($latestNewsResult)): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="single_news.php?id=<?php echo $news['id']; ?>" class="news-title">
                                                <h5 class="card-title"><?php echo htmlspecialchars($news['title']); ?></h5>
                                            </a>
                                            <p class="card-text text-muted"><?php echo date('d.m.Y', strtotime($news['created_at'])); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <!-- Блок "Ми в соц-мережах" -->
                    <div>
                        <h2>Ми в соц-мережах</h2>
                        <p>Ми завжди відкриті для співпраці та спілкування. Ви можете знайти нас у таких соціальних мережах:</p>
                        <div class="social-links">
                            <a href="https://facebook.com" target="_blank"><img src="https://banner2.cleanpng.com/20200525/hor/transparent-facebook-round-logo-1713861749674.webp" alt="Facebook"></a>
                            <a href="https://twitter.com" target="_blank"><img src="https://e7.pngegg.com/pngimages/708/311/png-clipart-icon-logo-twitter-logo-twitter-logo-blue-social-media-thumbnail.png" alt="Twitter"></a>
                            <a href="https://instagram.com" target="_blank"><img src="https://banner2.cleanpng.com/20240112/pil/transparent-instagram-logo-colorful-camera-with-red-light-on-black-1710926114455.webp" alt="Instagram"></a>
                            <a href="mailto:newestbornwork@gmail.com"><img src="https://image.similarpng.com/very-thumbnail/2020/12/Gmail-logo-design-on-transparent-background-PNG.png" alt="Email"></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правий блок -->
            <div class="col-md-3">
                <?php include '../components/rightbar.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>
