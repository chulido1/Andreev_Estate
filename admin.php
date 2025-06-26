<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: personal-account.php");
    exit;
}

// Подключение к БД
$pdo = new PDO('mysql:host=localhost;dbname=andreev_estate;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// Получаем список таблиц из базы
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель — список таблиц</title>
    <style>
        body { font-family: 'EB Garamond', serif; padding: 20px;}
        ul { list-style: none; padding: 0;}
        li { margin-bottom: 8px;}
        a { text-decoration: none; font-weight: bold; color: #49560E;}
        a:hover { text-decoration: underline;}
        .logout { display: inline-block; margin-top: 10px; background-color: #d9534f; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px;}
        .logout:hover { background-color: #c9302c;}
    </style>
</head>
<body>
    <h1>Админ-панель</h1>
    <h2>Список таблиц базы данных</h2>
    <ul>
        <?php foreach ($tables as $table): ?>
            <li><a href="table_view.php?table=<?= urlencode($table) ?>"><?= htmlspecialchars($table) ?></a></li>
        <?php endforeach; ?>
    </ul>
    <a class="logout" href="logout.php">Выйти</a>
</body>
</html>
