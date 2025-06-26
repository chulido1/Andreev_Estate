<?php
session_start();

$host = "localhost";
$db = "andreev_estate";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$recaptchaSecret = '6LfDGWsrAAAAAM-IxotbrsrP17YNGVISaz8LT2eM';
$recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
$captchaSuccess = json_decode($verify);

if (!$captchaSuccess->success) {
    $_SESSION['reg_error'] = "Пожалуйста, подтвердите, что вы не робот.";
    header("Location: registration.php");
    exit();
}


// Получение и фильтрация данных
$login = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$budget = trim($_POST['budget'] ?? '');

// Проверка
if ($login && $password) {
    // Хеширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL запрос
    $stmt = $conn->prepare("INSERT INTO users (login, password, name, email, phone, budget, role)
                            VALUES (?, ?, ?, ?, ?, ?, 'client')");
    $stmt->bind_param("ssssss", $login, $hashed_password, $name, $email, $phone, $budget);

    if ($stmt->execute()) {
        $_SESSION['reg_success'] = "Регистрация прошла успешно!";
    } else {
        $_SESSION['reg_error'] = "Ошибка при регистрации: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['reg_error'] = "Пожалуйста, заполните обязательные поля (логин и пароль)";
}

$conn->close();
header("Location: registration.php");
exit();
?>
