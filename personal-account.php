<?php
session_start();

// Подключение к БД
$conn = new mysqli("localhost", "root", "", "andreev_estate");
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$login_error = ""; // по умолчанию ошибки нет

// Обработка формы логина
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'], $_POST['password'])) {

    // === 1. Проверка капчи ===
    $recaptchaSecret = '6LfDGWsrAAAAAM-IxotbrsrP17YNGVISaz8LT2eM'; // секретный ключ
    $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

    if (empty($recaptchaResponse)) {
        $login_error = "Пожалуйста, подтвердите, что вы не робот.";
    } else {
        $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
        $captchaSuccess = json_decode($verify);

        if (!$captchaSuccess->success) {
            $login_error = "Проверка капчи не удалась. Попробуйте ещё раз.";
        } else {
            // === 2. Проверка логина и пароля ===
            $login = $_POST['login'];
            $password = $_POST['password'];

            $stmt = $conn->prepare("SELECT * FROM users WHERE login = ?");
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $userData = $result->fetch_assoc();

                // Хешированный пароль
                
                  if (password_verify($password, $userData['password']) || // новый способ — хеш
                    $password === $userData['password'] // старый способ — обычный текст
                    ) {

                    $_SESSION['user'] = $userData;

                    // Перенаправление
                    if ($userData['role'] === 'admin') {
                        header("Location: admin.php");
                    } else {
                        header("Location: personal-account.php");
                    }
                    exit();
                } else {
                    $login_error = "Неверный логин или пароль.";
                }
            } else {
                $login_error = "Неверный логин или пароль.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Личный кабинет</title>
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
    <a href="about-us.php">О нас</a>
    <a href="contacts.php">Контакты</a>
    <a href="feedback.php">Обратная связь</a>
    <a href="registration.php">Регистрация</a>
  </nav>
</header>

<main class="main-content">
<?php if (!isset($_SESSION['user'])): ?>
  <div class="logo-center">
    <img src="../Andreev_Estate/img/Group 1.png" alt="Andreev Estate Logo">
  </div>

  <div class="registration-box">
    <h2>Авторизация</h2>
    <?php if (!empty($login_error)): ?>
      <p style="color: red;"><?= htmlspecialchars($login_error) ?></p>
    <?php endif; ?>
    <form method="POST" class="formreg">
      <input type="text" name="login" placeholder="Логин" required>
      <input type="password" name="password" placeholder="Пароль" required>

      <div style = "margin-bottom: 20px" class="g-recaptcha" data-sitekey="6LfDGWsrAAAAAMetMCShaygcTcu_ocg3Ettk1--T"></div>

      <button type="submit">Войти</button>
    </form>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  </div>
<?php else: ?>
  <?php $user = $_SESSION['user']; ?>
  <div class="account-container">
    <aside class="account-sidebar">
      <h1 class="account-title">Мой кабинет</h1>
      <ul class="account-menu">
        <li class="account-subitem">Избранное</li>
        <li><a href="logout.php" class="logout-link">Выйти</a></li>
      </ul>
    </aside>

    <section class="favorites-section">
      <div class="favorites-list">
        <?php
        $userId = $user['id'];
        $sql = "SELECT houses.* FROM favorites 
                JOIN houses ON favorites.house_id = houses.id 
                WHERE favorites.user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($house = $result->fetch_assoc()) {
                echo "<div class='house-card'>";
                echo "<img src='{$house['image']}' alt='{$house['title']}' onclick=\"location.href='house.php?id={$house['id']}'\">";
                echo "<div class='house-card-info'>";
                echo "<div class='price-title'>";
                echo "<p>" . number_format($house['price'], 0, '', ' ') . " ₽</p>";
                echo "<form method='POST' action='remove_favorite.php' onsubmit='event.stopPropagation()'>";
                echo "<input type='hidden' name='house_id' value='{$house['id']}'>";
                echo "<button type='submit' class='like-button'><span class='heart-icon'>🖤</span></button>";
                echo "</form>";
                echo "</div>";
                echo "<p>{$house['title']}</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>У вас пока нет избранных объектов.</p>";
        }
        ?>
      </div>
    </section>
  </div>
<?php endif; ?>
</main>

<div class="footer-rounded-transition" style="margin-top: 450px"></div>
<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-logo-block">
      <img src="../Andreev_Estate/img/logoW.png" alt="Andreev Estate">
    </div>
    <div class="footer-nav">
      <a href="index.php">Главная</a>
      <a href="objects.php">Объекты</a>
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

</body>
</html>
