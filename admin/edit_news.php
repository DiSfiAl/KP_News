<?php
include '../db/connection.php';
include '../components/admin_navbar.php';

// Отримання категорій
$categories = $conn->query("SELECT id, name FROM categories")->fetch_all(MYSQLI_ASSOC);

// Завантаження новини для редагування
$news_id = $_GET['id'] ?? null;
$news = null;

if ($news_id) {
    $stmt = $conn->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->bind_param("i", $news_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $news = $result->fetch_assoc();
}

// Редагування новини
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];

    // Перевірка полів
    if (empty($title) || empty($content) || empty($category_id)) {
        $error = "All fields are required!";
    } else {
        $stmt = $conn->prepare("UPDATE news SET title = ?, content = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $title, $content, $category_id, $news_id);

        if ($stmt->execute()) {
            header("Location: dashboard.php?success=News updated successfully!");
            exit;
        } else {
            $error = "Failed to update news. Please try again.";
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News</title>
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Edit News</h1>
        <?php if (isset($error)): ?>
            <p class="error-msg"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Методичка -->
        <div class="news-methodical">
            <h2>Методичка: Як редагувати новину</h2>
            <ul>
                <li>Змініть заголовок або текст новини, зберігши ключові слова.</li>
                <li>Оновіть категорію, якщо новина стала стосуватись іншої теми.</li>
                <li>Перевірте текст на відсутність помилок і релевантність.</li>
            </ul>
        </div>

        <!-- Форма редагування новини -->
        <form action="edit_news.php?id=<?= htmlspecialchars($news_id) ?>" method="post" class="form-add-news">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($news['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="8" required><?= htmlspecialchars($news['content']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $news['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn-submit">Update News</button>
        </form>
    </div>
</body>
