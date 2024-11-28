<?php
// Підключення до бази даних
include '../db/connection.php';

// Отримання всіх категорій
$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);
?>

<style>
.password {
  color: e74c3c;
  border-color: black;
  background-color: white;
  font-weight: bold;
}

.password:hover {
  background-color: #c0392b;
  color: white;
  border-color: black;
  font-weight: bold;
}
</style>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Категорії</title>
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../style/global.css">
</head>
<body>
    <?php include '../components/navbar.php'; ?>

    <div class="container mt-4">
        <h3 class="text-center">Категорії</h3>
        <div class="accordion" id="categoriesAccordion">
            <?php while ($category = mysqli_fetch_assoc($result)): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?php echo $category['id']; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $category['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $category['id']; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </button>
                    </h2>
                    <div id="collapse<?php echo $category['id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $category['id']; ?>" data-bs-parent="#categoriesAccordion">
                        <div class="accordion-body">
                            <p><?php echo htmlspecialchars($category['description']); ?></p>
                            <a href="search_by_categories.php?id=<?php echo $category['id']; ?>" class="btn btn-primary">Перейти до новин</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="../script/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
