<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Andreev Estate</title>
  <link rel="stylesheet" href="styles.css" />
</head>

<body>

  <header class="top-bar">
    <div class="logo">
      <img src="../Andreev_Estate/img/Group 7 (3).png" alt="Логотип" />
    </div>
    <nav class="nav-menu">
      <a href="objects.php">Объекты</a>
      <a href="personal-account.php">Личный кабинет</a>
      <a href="about-us.php">О нас</a>
      <a href="contacts.php">Контакты</a>
      <a href="feedback.php">Обратная связь</a>
      <a href="registration.php">Регистрация</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-text">
      <h1>Andreev Estate –</h1>
      <h2 class="subline">ключ к исключительной жизни</h2>
    </div>
  </section>

  <section class="exclusive">
    <div class="exclusive-header">
      <p class="">Эксклюзивные предложения</p>
      <a href="objects.php" class="view-all-btn">Смотреть все</a>
    </div>

    <div class="exclusive-cards">
      <div class="card"><img src="../Andreev_Estate/img/object.png" alt="Объект 1" /></div>
      <div class="card"><img src="../Andreev_Estate/img/object2.png" alt="Объект 2" /></div>
      <div class="card"><img src="../Andreev_Estate/img/object3.png" alt="Объект 3" /></div>
    </div>
  </section>


  <section class="custom-layout">
    <div class="row">
      <!-- Блок 1: Офис -->
      <div class="block-office">
        <div class="bg-layer"></div>
        <img src="../Andreev_Estate/img/handshake.png" alt="Офис" class="overlay-image">
        <div class="text-group" style="padding-left: 60px; padding-top: 102px;">
          <h3>Приглашаем на<br>встречу в наш офис</h3>
          <a href="contacts.php" class="btn white-outline">Узнать больше</a>
        </div>
      </div>

      <!-- Блок 2: О компании -->
      <div class="block-about">
        <div class="bg-darken"></div>
        <img src="../Andreev_Estate/img/signage.png" alt="О компании" class="overlay-image">
        <div class="text-group">
          <h3>Узнать больше<br>о Andreev<br>Estate</h3>
          <div class="button-wrapper">
            <a href="about-us.php" class="btn white-outline">Подробнее</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Блок 3: Личный кабинет -->
      <div class="block-cabinet">
        <img src="../Andreev_Estate/img/businessmen.png" alt="Личный кабинет" class="overlay-image">
        <div class="text-group">
          <h3><span>Личный</span><br><span class="indent">кабинет</span></h3>
          <div class="button-wrapper">
            <a href="personal-account.php" class="btn white-outline">Подробнее</a>
          </div>
        </div>
      </div>

      <!-- Блок 4: Обратная связь -->


<form class="feedback-form" method="POST" action="main-feedback-handler.php">
  <h3>Обратная связь</h3>
<a id="feedback"></a>
  <?php
  $success_main = $_SESSION['feedback_main_success'] ?? null;
  $error_main = $_SESSION['feedback_main_error'] ?? null;
  unset($_SESSION['feedback_main_success'], $_SESSION['feedback_main_error']);
  ?>

  <?php if ($success_main): ?>
    <div style="color: black; font-size: 16px;"><?= htmlspecialchars($success_main) ?></div>
  <?php elseif ($error_main): ?>
    <div style="color: black; font-size: 16px;"><?= htmlspecialchars($error_main) ?></div>
  <?php endif; ?>

  <input type="text" name="name" placeholder="Имя" required style="margin-top: 15px;">

  <div class="contact-input-group">
    <label for="email">Почта</label>
    <input type="email" id="email" name="email" class="contact-form-input" placeholder="Ваш email" required>
  </div>

  <textarea name="message" placeholder="Ваше сообщение" required></textarea>

  <button type="submit">Отправить</button>
</form>



    </div>
  </section>

  <div class="footer-rounded-transition"></div>

  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-logo-block">
        <img src="../Andreev_Estate/img/logoW.png" alt="Andreev Estate">
      </div>

      <div class="footer-nav">
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





</body>

</html>