<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
    <title>Каталог недвижимости</title>
</head>

<body>

    <header class="top-bar">
        <div class="logo">
            <img src="../Andreev_Estate/img/Group 7 (3).png" alt="Логотип" />
        </div>
        <nav class="nav-menu">
                <a href="index.php">Главная</a>
                <a href="personal-account.php">Личный кабинет</a>
                <a href="about-us.php">О нас</a>
                <a href="contacts.php">Контакты</a>
                <a href="feedback.php">Обратная связь</a>
                <a href="registration.php">Регистрация</a>
        </nav>
    </header>



    <main>
        <h1 class="catalog-title">Элитная недвижимость <br> Москвы</h1>

        <div class="catalog-filter-wrapper">
            <div class="catalog-filter-row catalog-filter-top">
                <select id="type" required>
                    <option value="" selected>Тип</option>
                </select>
                <select id="area" required>
                    <option value="" selected>Площадь от</option>
                </select>
                <select id="rooms" required>
                    <option value="" selected>Комнат</option>
                </select>
                <select id="district" required>
                    <option value="" selected>Район</option>
                </select>
            </div>

            <div class="catalog-filter-row catalog-filter-bottom">
                <input type="number" id="price_min" placeholder="Цена от" step="100000" min="0" />
                <input type="number" id="price_max" placeholder="До" step="100000" min="0" />
                <button onclick="applyFilters()">Показать</button>
            </div>
        </div>

        <div id="house-list" class="catalog-house-grid"></div>
        <button id="load-more" onclick="loadMore()">Ещё</button>
    </main>


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
        let offset = 0;
        const limit = 3;

        function applyFilters(reset = true) {
            if (reset) {
                offset = 0;
                document.getElementById("house-list").innerHTML = "";
            }

            const params = new URLSearchParams();
            params.set("limit", limit);
            params.set("offset", offset);


            const filters = ["type", "area", "rooms", "district", "price_min", "price_max"];
            filters.forEach((f) => {
                const val = document.getElementById(f).value;
                if (val) params.set(f, val);
            });

            fetch("get_objects.php?" + params.toString())
                .then((res) => res.json())
                .then((data) => {
                    if (!Array.isArray(data)) {
                        console.error("Ошибка: получен не массив", data);
                        return;
                    }

                    data.forEach((h) => {
                        const card = `
                      <div class="house-card">
                          <img src="${h.image}" alt="${h.title}" onclick="location.href='house.php?id=${h.id}'">
                          <div class="house-card-info">
                              <div class="price-title">
                                  <p>${parseInt(h.price).toLocaleString()} ₽</p>
                                  <button class="like-button" onclick="event.stopPropagation(); toggleFavorite(${h.id}, this)">
                                      <span class="heart-icon">🤍</span>
                                  </button>
                              </div>
                              <p>${h.title}</p>
                                </div>
                      </div>`;
                        document.getElementById("house-list").insertAdjacentHTML("beforeend", card);
                    });

                    offset += limit;
                })
                .catch((err) => console.error("Ошибка загрузки:", err));
        }

        function loadMore() {
            applyFilters(false);
        }

        function loadFilters() {
            fetch("get_filters.php")
                .then((res) => res.json())
                .then((data) => {
                    if (data.error) {
                        console.error("Ошибка загрузки фильтров:", data.error);
                        return;
                    }

                    const addOptions = (selectId, options, getLabel = x => x, getValue = x => x) => {
                        const select = document.getElementById(selectId);
                        options.forEach(opt => {
                            const option = document.createElement("option");
                            option.value = getValue(opt);
                            option.textContent = getLabel(opt);
                            select.appendChild(option);
                        });
                    };

                    addOptions("type", data.types, t => t.type_name, t => t.id);
                    addOptions("district", data.districts, d => d.name, d => d.id);
                    addOptions("rooms", data.rooms);
                    addOptions("area", data.areas, a => `от ${a} м²`, a => a);
                })
                .catch((err) => console.error("Ошибка при получении фильтров:", err));
        }

        window.onload = () => {
            loadFilters();
            applyFilters();
        };


const favorites = new Set();

function toggleFavorite(id, btn) {
    const formData = new FormData();
    formData.append("house_id", id);

    fetch("toggle_favorite.php", {
        method: "POST",
        body: formData
    }).then(res => res.json())
      .then(data => {
          if (data.status === "added") {
              btn.classList.add("favorited");
              btn.querySelector(".heart-icon").textContent = "🖤";
          } else if (data.status === "removed") {
              btn.classList.remove("favorited");
              btn.querySelector(".heart-icon").textContent = "🤍";
          } else if (data.error === "not_logged_in") {
              alert("Пожалуйста, войдите в аккаунт, чтобы добавлять в избранное.");
          } else {
              alert("Ошибка: " + (data.error || "Неизвестная ошибка"));
          }
      });
}


    </script>

</body>

</html>