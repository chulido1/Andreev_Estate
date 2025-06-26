<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Contacts</title>
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
            <a href="feedback.php">Обратная связь</a>
            <a href="registration.php">Регистрация</a>
        </nav>
    </header>

    <section class="contacts">
        <div class="contacts-bg">
            <h2>Контакты</h2>
        </div>
    </section>

<section class="contact-info-map">
  <div class="contacts-card">
    <p>Наш телефон<br>+7 (903) 277 73 01</p>

    <p>Наш e-mail<br>isip_e.n.andreev@mpt.ru</p>

    <p>Наш адрес<br>Правительство Российской Федерации<br>Москва<br>Москва, Краснопресненская наб., 2</p>

    <p>Время работы<br>Пн – Вс с 07:00 до 23:00</p>
  </div>

  <div class="map-container">
    <iframe
      src="https://yandex.kz/map-widget/v1/?ll=37.584010%2C55.751170&mode=poi&poi%5Bpoint%5D=37.573092%2C55.754935&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D1222602059&z=15.25"
      width="560"
      height="400"
      frameborder="0"
      allowfullscreen="true"
      style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    </iframe>
  </div>
</section>

    
<div class="footer-rounded-transition"></div>

<footer class="site-footer">
  <div class="footer-container">
    <div class="footer-logo-block">
      <img src="../Andreev_Estate/img/logoW.png" alt="Andreev Estate">
    </div>

    <div class="footer-nav">
      <a href="index.php">Главная</a>
      <a href="personal-account.php">Личный кабинет</a>
      <a href="about-us.php">О нас</a>
      <a href="feedback.php">Обратная связь</a>
      <a href="registration.php">Регистрация</a>
      <a href="objects.php">Объекты</a>
    </div>

    <div class="footer-copy">
      <p>© 2025 «Andreev Estate»</p>
    </div>
  </div>
</footer>

</body>

</html>