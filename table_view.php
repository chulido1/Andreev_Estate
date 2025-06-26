<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['table'])) {
    die("Не указана таблица");
}

$table = $_GET['table'];

// Подключение к БД
$pdo = new PDO('mysql:host=localhost;dbname=andreev_estate;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);


// Проверяем, есть ли таблица в БД
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
if (!in_array($table, $tables)) {
    die("Таблица не найдена");
}

// Получаем колонки таблицы
$stmt = $pdo->prepare("DESCRIBE `$table`");
$stmt->execute();
$columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Получаем все записи
$stmt = $pdo->prepare("SELECT * FROM `$table`");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Таблица <?= htmlspecialchars($table) ?></title>
    <style>
        body { font-family: 'EB Garamond', serif; padding:20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #eee; }
        a.button { display: inline-block; padding: 6px 12px; background: #04304B; color: #fff; text-decoration: none; border-radius: 4px; }
        a.button:hover { background: #04304B; }
        .actions a { margin-right: 5px; }
        a {text-decoration: underline; color: black;}
    </style>
</head>
<body>
    <h1>Управление таблицей: <?= htmlspecialchars($table) ?></h1>
    <p><a href="admin.php" style="text-decoration: none;">← Назад к списку таблиц</a></p>
    <p><a class="button" href="record_add.php?table=<?= urlencode($table) ?>">Добавить запись</a></p>
    <table>
        <thead>
            <tr>
                <?php foreach ($columns as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rows) === 0): ?>
                <tr><td colspan="<?= count($columns) + 1 ?>">Записей нет</td></tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <?php foreach ($columns as $col): ?>
                            <td><?= htmlspecialchars($row[$col]) ?></td>
                        <?php endforeach; ?>
                        <td class="actions">
                            <a href="record_edit.php?table=<?= urlencode($table) ?>&id=<?= urlencode($row[$columns[0]]) ?>">Редактировать</a>
                            <a href="record_delete.php?table=<?= urlencode($table) ?>&id=<?= urlencode($row[$columns[0]]) ?>" onclick="return confirm('Удалить запись?')">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
