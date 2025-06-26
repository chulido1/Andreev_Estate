<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Registration</title>
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
  </nav>
</header>

  <main class="main-content">
    <div class="logo-center">
      <img src="../Andreev_Estate/img/Group 1.png" alt="Andreev Estate Logo">
    </div>

    <div class="registration-box">
      <h2>Регистрация</h2>
      <?php
if (!empty($_SESSION['reg_success'])) {
    echo '<p class="success-message">' . $_SESSION['reg_success'] . '</p>';
    unset($_SESSION['reg_success']);
}
if (!empty($_SESSION['reg_error'])) {
    echo '<p class="error-message">' . $_SESSION['reg_error'] . '</p>';
    unset($_SESSION['reg_error']);
}
?>

      <form class="formreg" method="POST" action="register-handler.php">
        <input type="text" name="login" placeholder="Логин" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <input type="text" name="name" placeholder="Имя">
        <input type="email" name="email" placeholder="Email">
        <div class="contact-input-group">
          <label for="new-phone">Телефон</label>
          <input type="tel" id="new-phone" name="phone" class="contact-form-input" placeholder="Телефон">
        </div>
        <input type="text" name="budget" id="budget" placeholder="Бюджет (₽)" required>
        <div style="margin-bottom: 20px;" class="g-recaptcha" data-sitekey="6LfDGWsrAAAAAMetMCShaygcTcu_ocg3Ettk1--T"></div>
        <button type="submit">Отправить</button>
      </form>
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </div>
  </main>

  <div class="footer-rounded-transition" style="margin-top: 250px;"></div>

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
      </div>
      <div class="footer-copy">
        <p>© 2025 «Andreev Estate»</p>
      </div>
    </div>
  </footer>

  <!-- Маска телефона -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const phoneInput = document.getElementById('new-phone');
      if (phoneInput) {
        phoneInput.addEventListener('input', function (e) {
          let value = e.target.value.replace(/\D/g, '');
          let formattedValue = '';
          if (value.length > 0) {
            formattedValue = '+7';
            if (value.length > 1) {
              formattedValue += ' (' + value.substring(1, 4);
            }
            if (value.length >= 4) {
              formattedValue += ') ' + value.substring(4, 7);
            }
            if (value.length >= 7) {
              formattedValue += '-' + value.substring(7, 9);
            }
            if (value.length >= 9) {
              formattedValue += '-' + value.substring(9, 11);
            }
          }
          e.target.value = formattedValue;
        });
      }
    });
  </script>

  <!-- Маска бюджета -->
  <script src="https://unpkg.com/imask"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const budgetInput = document.getElementById('budget');
      if (budgetInput) {
        IMask(budgetInput, {
          mask: Number,
          scale: 2,
          signed: false,
          thousandsSeparator: '.',
          padFractionalZeros: true,
          normalizeZeros: true,
          radix: '.'
        });
      }
    });
  </script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.querySelector('input[name="name"]');

    nameInput.addEventListener('input', function () {
      this.value = this.value.replace(/[^а-яА-ЯёЁa-zA-Z\s]/g, '');
    });
  });
</script>

</body>
</html>
