<?php
session_start();
require_once '../db/connection.php';

// Перевірка авторизації
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Отримання інформації про користувача
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT firstname, secondname, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Отримання останніх переглянутих новин
$stmt = $conn->prepare("
    SELECT n.id, n.title, n.content, n.created_at 
    FROM recent_views rv
    JOIN news n ON rv.news_id = n.id
    WHERE rv.user_id = ?
    ORDER BY rv.viewed_at DESC
    LIMIT 5
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$recent_news = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Параметри пагінації
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$news_per_page = 3;
$offset = ($page - 1) * $news_per_page;

// Отримання кількості новин "Прочитати пізніше"
$stmt = $conn->prepare("
    SELECT COUNT(*) AS total 
    FROM read_later 
    WHERE user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_news = $stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_news / $news_per_page);

// Отримання новин для поточної сторінки "Прочитати пізніше"
$stmt = $conn->prepare("
    SELECT n.id, n.title, n.content, rl.added_at 
    FROM read_later rl
    JOIN news n ON rl.news_id = n.id
    WHERE rl.user_id = ?
    ORDER BY rl.added_at DESC
    LIMIT ?, ?
");
$stmt->bind_param("iii", $user_id, $offset, $news_per_page);
$stmt->execute();
$read_later_news = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../style/profile.css">
    <title>Профіль</title>
</head>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Лівий блок -->
            <div class="col-md-4">
                <div class="profile-card p-3 border rounded">
                    <div class="d-flex align-items-center">
                        <img src="data:image/jpeg;base64,<?= base64_encode($user['avatar']) ?>" alt="Аватар" class="avatar me-3">
                        <div>
                            <h4><?= htmlspecialchars($user['firstname']) ?></h4>
                            <h5><?= htmlspecialchars($user['secondname']) ?></h5>
                        </div>
                    </div>
                    <a href="set_new_password.php" class="btn btn-outline-primary mt-3">Змінити пароль</a>
                </div>
            </div>

            <!-- Останні переглянуті новини -->
            <div class="col-md-4">
                <div class="news-card p-3 border rounded">
                    <h5>Останні переглянуті</h5>
                    <?php if (count($recent_news) > 0): ?>
                        <?php foreach ($recent_news as $news): ?>
                            <div class="content mb-3">
                                <h6>
                                    <a href="single_news.php?id=<?= $news['id']; ?>" class="news-title">
                                        <?= htmlspecialchars($news['title']); ?>
                                    </a>
                                </h6>
                                <p class="text-muted">
                                    <?= substr(strip_tags($news['content']), 0, 50); ?>...
                                </p>
                                <small class="text-secondary">
                                    Опубліковано: <?= htmlspecialchars($news['created_at']); ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">Немає переглянутих новин.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Прочитати пізніше -->
            <div class="col-md-4">
                <div class="news-card p-3 border rounded">
                    <h5>Прочитати пізніше</h5>
                    <?php if (count($read_later_news) > 0): ?>
                        <?php foreach ($read_later_news as $news): ?>
                            <div class="content mb-3">
                                <h6>
                                    <a href="single_news.php?id=<?= $news['id']; ?>" class="news-title">
                                        <?= htmlspecialchars($news['title']); ?>
                                    </a>
                                </h6>
                                <p class="text-muted">
                                    <?= substr(strip_tags($news['content']), 0, 50); ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Додано: <?= date('Y-m-d H:i', strtotime($news['added_at'])); ?>
                                    </small>
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeReadLater(<?= $news['id'] ?>)">
                                        <ion-icon name="bookmark"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-- Пагінація -->
                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php else: ?>
                        <p class="text-center">Список порожній.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function removeReadLater(newsId) {
            fetch('../db/remove_read_later.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ news_id: newsId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Новину видалено зі списку "Прочитати пізніше".');
                    location.reload();
                } else {
                    alert('Не вдалося видалити новину: ' + (data.error || 'Помилка сервера.'));
                }
            })
            .catch(error => console.error('Помилка:', error));
        }
    </script>
</body>
</html>
