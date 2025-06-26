<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['table']) || !isset($_GET['id'])) {
    die("Не указаны параметры");
}

$table = $_GET['table'];
$id = $_GET['id'];

$pdo = new PDO('mysql:host=localhost;dbname=andreev_estate;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
if (!in_array($table, $tables)) {
    die("Таблица не найдена");
}

// Получаем PK (первый столбец)
$stmt = $pdo->prepare("DESCRIBE `$table`");
$stmt->execute();
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pk = $columns[0]['Field'];

// Удаляем запись
$stmt = $pdo->prepare("DELETE FROM `$table` WHERE `$pk` = ?");
$stmt->execute([$id]);

header("Location: table_view.php?table=" . urlencode($table));
exit;
