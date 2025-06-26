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

$pdo = new PDO('mysql:host=localhost;dbname=andreev_estate;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// Внешние ключи для формирования выпадающих списков
$foreignKeys = [

    'applications' => [
        'house_id' => ['table' => 'houses', 'id' => 'id', 'name' => 'title'],
        'user_id' => ['table' => 'users', 'id' => 'id', 'name' => 'login'],
    ],
    'deals' => [
        'agent_id' => ['table' => 'users', 'id' => 'id', 'name' => 'id'],
        'client_id' => ['table' => 'users', 'id' => 'id', 'name' => 'login'],
        'house_id' => ['table' => 'houses', 'id' => 'id', 'name' => 'id'],
    ],
    'favorites' => [
        'house_id' => ['table' => 'houses', 'id' => 'id', 'name' => 'title'],
        'user_id' => ['table' => 'users', 'id' => 'id', 'name' => 'id'],
    ],
    'houses' => [
        'district_id' => ['table' => 'districts', 'id' => 'id', 'name' => 'name'],
        'type_id' => ['table' => 'house_types', 'id' => 'id', 'name' => 'type_name'],
        'agent_id' => ['table' => 'users', 'id' => 'id', 'name' => 'login'],
    ],
];

$options = [];

if (isset($foreignKeys[$table])) {
    foreach ($foreignKeys[$table] as $field => $info) {
        if ($table === 'deals' && $field === 'agent_id') {
            $stmtOpt = $pdo->prepare("SELECT {$info['id']}, {$info['name']} FROM {$info['table']} WHERE role = 'agent' ORDER BY {$info['name']}");
            $stmtOpt->execute();
        } elseif ($table === 'deals' && $field === 'client_id') {
            $stmtOpt = $pdo->prepare("SELECT {$info['id']}, {$info['name']} FROM {$info['table']} WHERE role = 'client' ORDER BY {$info['name']}");
            $stmtOpt->execute();
        } elseif ($table === 'favorites' && $field === 'user_id') {
            $stmtOpt = $pdo->prepare("SELECT {$info['id']}, {$info['name']} FROM {$info['table']} WHERE role IN ('agent', 'client') ORDER BY {$info['name']}");
            $stmtOpt->execute();
        } elseif ($table === 'houses' && $field === 'agent_id') {
            $stmtOpt = $pdo->prepare("SELECT {$info['id']}, {$info['name']} FROM {$info['table']} WHERE role = 'agent' ORDER BY {$info['name']}");
            $stmtOpt->execute();
        } else {
            $stmtOpt = $pdo->query("SELECT {$info['id']}, {$info['name']} FROM {$info['table']} ORDER BY {$info['name']}");
        }
        $options[$field] = $stmtOpt->fetchAll(PDO::FETCH_ASSOC);
    }
}




// Проверка таблицы
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
if (!in_array($table, $tables)) {
    die("Таблица не найдена");
}

// Получаем описание таблицы (структуру)
$stmt = $pdo->prepare("DESCRIBE `$table`");
$stmt->execute();
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Обработка POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [];
    $placeholders = [];
    $values = [];
    foreach ($columns as $col) {
        $field = $col['Field'];
        // Пропускаем автоинкрементные поля (например, id)
        if (strpos($col['Extra'], 'auto_increment') !== false) {
            continue;
        }
        $fields[] = "`$field`";
        $placeholders[] = "?";
        $values[] = $_POST[$field] ?? null;
    }

    $sql = "INSERT INTO `$table` (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($values);

    header("Location: table_view.php?table=" . urlencode($table));
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Добавить запись в <?= htmlspecialchars($table) ?></title>
    <style>
        body { font-family: 'EB Garamond', serif;; padding:20px; }
        label { display:block; margin-top:10px; }
        input, select, textarea { width: 300px; padding: 5px; margin-top: 3px; }
        button { margin-top: 15px; padding: 8px 15px; background: #04304B; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        a { display: inline-block; margin-top: 15px; }
        a {text-decoration: none; color: black;}
    </style>
</head>
<body>
    <h1>Добавить запись в таблицу <?= htmlspecialchars($table) ?></h1>
    <form method="POST">
        <?php foreach ($columns as $col):
            // Пропускаем автоинкрементные поля
            if (strpos($col['Extra'], 'auto_increment') !== false) continue;
            $field = $col['Field'];
            $type = $col['Type'];
            ?>
            <label for="<?= htmlspecialchars($field) ?>"><?= htmlspecialchars($field) ?></label>
            <?php if (isset($options[$field])): ?>
    <select name="<?= htmlspecialchars($field) ?>" id="<?= htmlspecialchars($field) ?>" required>
        <option value="">Выберите...</option>
        <?php foreach ($options[$field] as $opt): ?>
            <option value="<?= htmlspecialchars($opt[$foreignKeys[$table][$field]['id']]) ?>">
                <?= htmlspecialchars($opt[$foreignKeys[$table][$field]['name']]) ?>
            </option>
        <?php endforeach; ?>
    </select>
<?php else: ?>
    <input type="text" name="<?= htmlspecialchars($field) ?>" id="<?= htmlspecialchars($field) ?>" />
<?php endif; ?>

        <?php endforeach; ?>
        <button type="submit">Добавить</button>
    </form>
    <p><a href="table_view.php?table=<?= urlencode($table) ?>">← Назад к таблице</a></p>
</body>
</html>
