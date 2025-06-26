<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $_SESSION['feedback_error'] = 'Пожалуйста, заполните все поля.';
        header('Location: feedback.php');
        exit();
    }

    // Отправляем на MailHog
    $to = "test@localhost";
    $subject = "Новое сообщение со страницы обратной связи";
    $body = "Имя: $name\nEmail: $email\n\nСообщение:\n$message";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";

    if (mail($to, $subject, $body, $headers)) {
        $_SESSION['feedback_success'] = "Ваше сообщение успешно отправлено!";
    } else {
        $_SESSION['feedback_error'] = "Ошибка отправки. Проверьте настройки сервера.";
        error_log("Ошибка mail(): to=$to, subject=$subject");
    }

    header('Location: feedback.php');
    exit();
}

// Отображение формы и сообщений
$success = $_SESSION['feedback_success'] ?? null;
$error = $_SESSION['feedback_error'] ?? null;
unset($_SESSION['feedback_success'], $_SESSION['feedback_error']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обратная связь</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="top-bar">
    <div class="logo">
        <img src="img/Group 7 (3).png" alt="Логотип">
    </div>
    <nav class="nav-menu">
        <a href="index.php">Главная</a>
        <a href="objects.php">Объекты</a>
        <a href="personal-account.php">Личный кабинет</a>
        <a href="about-us.php">О нас</a>
        <a href="contacts.php">Контакты</a>
        <a href="registration.php">Регистрация</a>
    </nav>
</header>

<main class="contact-section">
    <p class="contact-intro-text">
        Мы ценим ваш интерес к нашим услугам и готовы ответить на любые вопросы о премиальной недвижимости Москвы, также рассмотрим ваши предложения.
    </p>

    <div class="contact-card">
        <h2>Свяжитесь с нами</h2>

        <?php if ($success): ?>
            <div class="feedback-flash-message.success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="feedback-flash-message.error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="feedback.php" class="contact-form-new">
            <div class="contact-input-group">
                <input type="text" name="name" class="contact-form-input" placeholder="Ваше имя" required>
            </div>

            <div class="contact-input-group">
                <input type="email" name="email" class="contact-form-input" placeholder="Ваш email" required>
            </div>

            <div class="contact-input-group">
                <textarea name="message" class="contact-form-input contact-message-input" placeholder="Ваше сообщение" required></textarea>
            </div>

            <button type="submit" class="contact-submit-button">Отправить</button>
        </form>
    </div>
</main>

    <div class="footer-rounded-transition"></div>
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-logo-block">
            <img src="img/logoW.png" alt="Andreev Estate">
        </div>
        <div class="footer-nav">
        <a href="index.php">Главная</a>
        <a href="objects.php">Объекты</a>
        <a href="personal-account.php">Личный кабинет</a>
        <a href="about-us.php">О нас</a>
        <a href="contacts.php">Контакты</a>
        <a href="registration.php">Регистрация</a>
        </div>
        <div class="footer-copy">
            <p>© 2025 «Andreev Estate»</p>
        </div>
    </div>
</footer>

</body>
</html>
