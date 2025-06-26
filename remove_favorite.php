<?php
session_start();
$conn = new mysqli("localhost", "root", "", "andreev_estate");

if (!isset($_SESSION['user']) || !isset($_POST['house_id'])) {
    header("Location: personal-account.php");
    exit();
}

$userId = $_SESSION['user']['id'];
$houseId = (int)$_POST['house_id'];

$stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND house_id = ?");
$stmt->bind_param("ii", $userId, $houseId);
$stmt->execute();

header("Location: personal-account.php");
exit();
?>
