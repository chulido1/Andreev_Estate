<?php
session_start();
$flash_success = $_SESSION['flash_success'] ?? null;
$flash_error = $_SESSION['flash_error'] ?? null;
$flash_warning = $_SESSION['flash_warning'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error'], $_SESSION['flash_warning']);
$conn = new mysqli("localhost", "root", "", "andreev_estate");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Некорректный ID объекта.");
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("
    SELECT h.*, t.type_name AS type_name, d.name AS district_name
    FROM houses h
    LEFT JOIN house_types t ON h.type_id = t.id
    LEFT JOIN districts d ON h.district_id = d.id
    WHERE h.id = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Объект не найден.");
}

$house = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($house['title']) ?> — Andreev Estate</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="top-bar">
    <div class="logo">
        <img src="../Andreev_Estate/img/Group 7 (3).png" alt="Логотип" />
    </div>
    <nav class="nav-menu">
        <a href="index.php">Главная</a>
        <a href="objects.php">Объекты</a>
        <a href="personal-account.php">Личный кабинет</a>
        <a href="about-us.php">О нас</a>
        <a href="contacts.php">Контакты</a>
        <a href="feedback.php">Обратная связь</a>
        <a href="registration.php">Регистрация</a>
    </nav>
</header>

<main class="house-wrapper">
    <?php if ($flash_success): ?>
    <div class="flash-message success"><?= htmlspecialchars($flash_success) ?></div>
<?php endif; ?>

<?php if ($flash_warning): ?>
    <div class="flash-message warning"><?= htmlspecialchars($flash_warning) ?></div>
<?php endif; ?>

<?php if ($flash_error): ?>
    <div class="flash-message error"><?= htmlspecialchars($flash_error) ?></div>
<?php endif; ?>

    <div class="house-box">
        <h1><?= htmlspecialchars($house['title']) ?></h1>
        <img src="<?= htmlspecialchars($house['image']) ?>" alt="<?= htmlspecialchars($house['title']) ?>" class="house-image">
        <p class="house-info"><strong>Цена:</strong> <?= number_format($house['price'], 0, '', ' ') ?> ₽</p>
        <p class="house-info"><strong>Описание:</strong><br> <?= nl2br(htmlspecialchars($house['description'])) ?></p>
        <p class="house-info"><strong>Площадь:</strong> <?= htmlspecialchars($house['area']) ?> м²</p>
        <p class="house-info"><strong>Комнат:</strong> <?= htmlspecialchars($house['rooms']) ?></p>
        <p class="house-info"><strong>Район:</strong> <?= htmlspecialchars($house['district_name']) ?></p>
        <p class="house-info"><strong>Тип:</strong> <?= htmlspecialchars($house['type_name']) ?></p>

<?php if (!empty($_SESSION['user']['id'])): ?>
    <form action="submit_application.php" method="POST" class="apply-form">
        <input type="hidden" name="house_id" value="<?= $house['id'] ?>">
        <button type="submit" class="apply-button">Оставить заявку</button>
    </form>
<?php else: ?>
    <p class="login-reminder">Войдите в аккаунт, чтобы оставить заявку.</p>
<?php endif; ?>


    </div>
</main>


<div class="footer-rounded-transition"></div>

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-logo-block">
            <img src="../Andreev_Estate/img/logoW.png" alt="Andreev Estate">
        </div>
        <div class="footer-nav">
        <a href="index.php">Главная</a>
        <a href="objects.php">Объекты</a>
        <a href="personal-account.php">Личный кабинет</a>
        <a href="about-us.php">О нас</a>
        <a href="contacts.php">Контакты</a>
        <a href="feedback.php">Обратная связь</a>
        <a href="registration.php">Регистрация</a>
        </div>
        <div class="footer-copy">
            <p>© 2025 «Andreev Estate»</p>
        </div>
    </div>
</footer>



<script>
    // Автоматическое скрытие flash-сообщения
    document.addEventListener("DOMContentLoaded", () => {
        const message = document.querySelector(".flash-message");
        if (message) {
            setTimeout(() => {
                message.remove();
            }, 3000); // 3 секунды
        }
    });
</script>


</body>
</html>
