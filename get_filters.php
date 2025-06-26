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

    // Загружаем типы недвижимости
    $types = $conn->query("SELECT id, type_name FROM house_types")->fetchAll(PDO::FETCH_ASSOC);

    // Загружаем районы
    $districts = $conn->query("SELECT id, name FROM districts")->fetchAll(PDO::FETCH_ASSOC);

    // Комнаты — просто фиксированный список
    $rooms = [2, 3, 4, 5, 6, 7, 8];

    // Площадь — фиксированные значения (например)
    $areas = [70, 100, 200, 300, 350];

    echo json_encode([
        "types" => $types,
        "districts" => $districts,
        "rooms" => $rooms,
        "areas" => $areas
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
