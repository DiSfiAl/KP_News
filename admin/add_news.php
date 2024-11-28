<?php
include '../db/connection.php';
include '../components/admin_navbar.php';

// Отримання категорій
$categories = $conn->query("SELECT id, name FROM categories")->fetch_all(MYSQLI_ASSOC);

// Додавання новини
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $views = 0;
    $is_deleted = 0;

    // Перевірка полів
    if (empty($title) || empty($content) || empty($category_id)) {
        $error = "All fields are required!";
    } else {
        $stmt = $conn->prepare("INSERT INTO news (title, content, category_id, views, created_at, is_deleted) VALUES (?, ?, ?, ?, NOW(), ?)");
        $stmt->bind_param("ssiii", $title, $content, $category_id, $views, $is_deleted);

        if ($stmt->execute()) {
            header("Location: dashboard.php?success=News added successfully!");
            exit;
        } else {
            $error = "Failed to add news. Please try again.";
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News Form</title>
    <link rel="stylesheet" href="../style/admin.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Add News</h1>
        <?php if (isset($error)): ?>
            <p class="error-msg"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Методичка -->
        <div class="news-methodical">
            <h2>Методичка: Як правильно створювати новину</h2>
            <ul>
                <li>Обгорніть кожен текстовий блок тегами <code>&lt;p&gt;</code> і <code>&lt;/p&gt;</code>.</li>
                <li>Для вставки зображення використовуйте тег <code>&lt;img&gt;</code> з атрибутом <code>src</code>.</li>
                <li>Для посилань застосовуйте тег <code>&lt;a&gt;</code> з атрибутом <code>href</code>.</li>
                <li>Якщо потрібно додати відео, використовуйте тег <code>&lt;iframe&gt;</code>.</li>
            </ul>
            <p>Приклад структури новини:</p>
            <pre>
            &lt;div class="news-article"&gt;
                &lt;p&gt;Це приклад тексту новини.&lt;/p&gt;
                &lt;img src="URL_зображення" alt="Опис зображення"&gt;
                &lt;p&gt;Деталі за &lt;a href="URL_посилання"&gt;цим посиланням&lt;/a&gt;.&lt;/p&gt;
                &lt;iframe src="URL_відео"&gt;&lt;/iframe&gt;
            &lt;/div&gt;
            </pre>
        </div>

        <!-- Форма додавання новини -->
        <form action="add_news.php" method="post" class="form-add-news">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="8" required></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn-submit">Add News</button>
        </form>
    </div>
</body>
