<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $message = trim($_POST["message"] ?? '');

    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && $message) {
    $to = "test@localhost"; // Почта для MailHog
    $subject = "Новое сообщение с главной страницы";
    $body = "Имя: $name\nПочта: $email\nСообщение:\n$message";
    $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=utf-8";

    if (mail($to, $subject, $body, $headers)) {
        $_SESSION["feedback_main_success"] = "Ваше cообщение успешно отправлено!";
    } else {
        $_SESSION["feedback_main_error"] = "Не удалось отправить сообщение. Попробуйте позже.";
    }
} else {
    $_SESSION["feedback_main_error"] = "Пожалуйста, заполните все поля корректно.";
}


    header("Location: index.php#feedback");
    exit();
}
