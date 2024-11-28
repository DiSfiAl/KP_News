<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<link rel="stylesheet" href="../style/bootstrap.min.css">
<link rel="stylesheet" href="../style/components.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Логотип</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Головна <ion-icon name="home-outline"></ion-icon></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/categories.php">Категорії <ion-icon name="bookmarks-outline"></ion-icon></a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Профіль <ion-icon name="person-outline"></ion-icon></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../db/logout.php">Вийти <ion-icon name="exit-outline"></ion-icon></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Авторизація <ion-icon name="person-outline"></ion-icon></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Реєстрація <ion-icon name="person-add-outline"></ion-icon></a>
                    </li>
                <?php endif; ?>
            </ul>
            <!-- Форма пошуку -->
            <form class="d-flex ms-3" action="search.php" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Пошук новин" aria-label="Search" required>
                <button class="btn btn-outline-light" type="submit">Шукати</button>
            </form>
        </div>
    </div>
</nav>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
