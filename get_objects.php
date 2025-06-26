<?php


session_start();

header('Content-Type: application/json');

$host = "localhost";
$db = "andreev_estate";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Ошибка подключения к БД: " . $e->getMessage()]);
    exit;
}

$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 3;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

$where = ["status = 'available'"]; // Показывать только доступные объекты
$params = [];

if (!empty($_GET['type'])) {
    $where[] = "type_id = :type";
    $params[':type'] = (int)$_GET['type'];
}
if (!empty($_GET['area'])) {
    $where[] = "area >= :area";
    $params[':area'] = (int)$_GET['area'];
}
if (!empty($_GET['rooms'])) {
    $where[] = "rooms = :rooms";
    $params[':rooms'] = (int)$_GET['rooms'];
}
if (!empty($_GET['district'])) {
    $where[] = "district_id = :district";
    $params[':district'] = (int)$_GET['district'];
}
if (!empty($_GET['price_min'])) {
    $where[] = "price >= :min";
    $params[':min'] = (float)$_GET['price_min'];
}
if (!empty($_GET['price_max'])) {
    $where[] = "price <= :max";
    $params[':max'] = (float)$_GET['price_max'];
}

$sql = "SELECT id, title, price, IF(image = '', 'img/default-house.jpg', image) as image FROM houses";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " LIMIT :offset, :limit";

try {
    $stmt = $conn->prepare($sql);

    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();
    $houses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($houses);
} catch (PDOException $e) {
    echo json_encode(["error" => "Ошибка запроса: " . $e->getMessage()]);
}