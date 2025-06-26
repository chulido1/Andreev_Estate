<?php
session_start();
$conn = new mysqli("localhost", "root", "", "andreev_estate");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if (!isset($_SESSION['user']) || !isset($_POST['house_id'])) {
    $_SESSION['flash_error'] = "Ошибка: пользователь не авторизован или ID дома не передан.";
    header("Location: house.php?id=" . $_POST['house_id']);
    exit();
}

$user_id = $_SESSION['user']['id'];
$house_id = (int)$_POST['house_id'];

// Проверка: существует ли уже заявка на этот объект от этого пользователя
// Проверка: есть ли уже заявка от этого пользователя на этот дом
$check = $conn->prepare("SELECT id FROM applications WHERE user_id = ? AND house_id = ?");
$check->bind_param("ii", $user_id, $house_id);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    $_SESSION['flash_warning'] = "Вы уже отправляли заявку на этот объект.";
    header("Location: house.php?id=$house_id");
    exit();
}


// Если заявки ещё нет — вставляем
$stmt = $conn->prepare("INSERT INTO applications (user_id, house_id, created_at) VALUES (?, ?, NOW())");
$stmt->bind_param("ii", $user_id, $house_id);

if ($stmt->execute()) {
    $_SESSION['flash_success'] = "Ваша заявка успешно отправлена!";
} else {
    $_SESSION['flash_error'] = "Ошибка при отправке заявки: " . $stmt->error;
}

header("Location: house.php?id=$house_id");
exit();
