<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(["error" => "not_logged_in"]);
    exit();
}

if (!isset($_POST['house_id'])) {
    echo json_encode(["error" => "no_house_id"]);
    exit();
}

$houseId = intval($_POST['house_id']);
$userId = $_SESSION['user']['id'];

$conn = new mysqli("localhost", "root", "", "andreev_estate");
if ($conn->connect_error) {
    echo json_encode(["error" => "db_connect"]);
    exit();
}

// Проверяем, есть ли уже запись
$sql_check = "SELECT * FROM favorites WHERE user_id = ? AND house_id = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("ii", $userId, $houseId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Удаляем
    $sql_delete = "DELETE FROM favorites WHERE user_id = ? AND house_id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("ii", $userId, $houseId);
    $stmt->execute();
    echo json_encode(["status" => "removed"]);
} else {
    // Добавляем
    $sql_insert = "INSERT INTO favorites (user_id, house_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ii", $userId, $houseId);
    $stmt->execute();
    echo json_encode(["status" => "added"]);
}

$conn->close();
