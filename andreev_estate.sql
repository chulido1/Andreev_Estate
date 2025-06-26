-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 26 2025 г., 10:11
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `andreev_estate`
--

-- --------------------------------------------------------

--
-- Структура таблицы `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `house_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `house_id`) VALUES
(2, 1, 4),
(3, 1, 6),
(4, 1, 4),
(5, 1, 4),
(6, 1, 9),
(7, 1, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `deals`
--

CREATE TABLE `deals` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `house_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `deals`
--

INSERT INTO `deals` (`id`, `client_id`, `house_id`, `agent_id`, `amount`) VALUES
(4, 1, 7, 3, '150000000'),
(5, 6, 9, 3, '300000000');

-- --------------------------------------------------------

--
-- Структура таблицы `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `districts`
--

INSERT INTO `districts` (`id`, `name`) VALUES
(1, 'Якиманка'),
(2, 'Арбат'),
(3, 'Патриаршие пруды'),
(4, 'Хамовники'),
(5, 'Пресненский'),
(6, 'Хорошёво-Мнёвники');

-- --------------------------------------------------------

--
-- Структура таблицы `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `house_id`) VALUES
(24, 1, 12),
(26, 1, 9);

-- --------------------------------------------------------

--
-- Структура таблицы `houses`
--

CREATE TABLE `houses` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `area` int(11) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `status` enum('available','sold') DEFAULT 'available',
  `type_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `date_available` date DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `houses`
--

INSERT INTO `houses` (`id`, `title`, `description`, `price`, `area`, `rooms`, `status`, `type_id`, `district_id`, `agent_id`, `date_available`, `image`) VALUES
(4, 'ЖК \"Онегин\"', 'Продается пентхаус в жилом комплексе \"Онегин\", расположенная по адресу улица Малая Полянка 2. Это самый прекрасный и видовой 2-х уровневый пентхаус во всем доме. На первом уровне квартиры вы найдете кухню-гостиную-столовую с террасой, откуда открывается великолепный вид на Кремль. Есть также две просторные спальни, каждая с собственным санузлом, а также гостевой санузел и постирочная.\r\nНа втором уровне расположена основная спальня, также с собственной террасой и ванной комнатой. Здесь также присутствует прекрасная входная группа, и самое главное - безопасность. Комплекс оборудован охраной, а большой огороженный двор имеет детскую площадку, что сделает жизнь в нем максимально комфортной и беззаботной. Не упустите возможность стать обладателем этого уникального и роскошного пентхауса.', 329000000.00, 273, 4, 'available', 4, 1, 3, '2025-06-18', '../Andreev_Estate/img/onegin.jpg'),
(5, 'Клубный дом \"Булгаков\"', 'Клубный дом «Булгаков» расположен в Большом Козихинском переулке на Патриарших прудах. Авторы проекта, ведущее российское архитектурное бюро, проектируя здание, руководствовались принципами абсолютного комфорта, элегантности и благородства, изящного стиля и выраженной индивидуальности, подчеркивающих высокий статус жителей. Выразительный фасад восьмиэтажного здания украшен французскими балконами и террасами, последний этаж отдан под пентхаус. Легкий, сдержанный стиль внешней отделки, четкий и спокойный облик дома «Булгаков» органично вписывается в архитектурное окружение района. Изысканный интерьер общих зон – лобби с каминным залом и библиотеки – располагает к комфортному спокойному времяпрепровождению. Просторные квартиры наполнены светом благодаря панорамному остеклению, открывающему вид на живописные улочки старой Москвы. Для владельцев автомобилей предусмотрен двухуровневый подземный паркинг. Дом оснащен системой очистки воды, центральным кондиционированием, единой сетью инженерных систем, вентиляцией с увлажнением воздуха, системой видеонаблюдения. Безопасность жителей обеспечивает круглосуточная служба охраны с контролем доступа. На Чистых Прудах располагаются лучшие образовательные учреждения Москвы, большое количество магазинов, салонов красоты, бытовые службы.', 452603500.00, 193, 3, 'available', 1, 3, 3, '2025-06-18', '../Andreev_Estate/img/bulgakov.jpg'),
(6, 'Дом «Лаврушинский»', '«Лаврушинский» — бескомпромиссный дом с лучшими видами на Кремль. Благодаря расположению всего в 1 км от Кремля, своей высоте и малоэтажной окружающей застройке, из квартир открываются прямые виды на главные достопримечательности центра Москвы. Расположение в глубине квартала, посередине парка, дает удивительное для центра ощущение тишины и простора. На закрытой территории находится самый большой в элитном классе в пределах Садового кольца двор-парк площадью 1,4 га с фонтаном, ручьём, зонами для воркаута, тихого отдыха и развивающей детской площадкой. Только для жителей в доме предусмотрен Clubhouse с бесплатным фитнес-центром по стандарту Fit Lab с 25-метровым бассейном и детская игровая комната по стандарту Kid’s Lab.', 190000000.00, 86, 2, 'available', 1, 1, 3, '2025-06-18', '../Andreev_Estate/img/lavr.jpg'),
(7, 'КД «Обыденский № 1»', '«Обыденский №1» — самый приватный дом в тихом переулке престижной Остоженки. Комплекс включает всего 26 квартир, ситихаусов, вилл и пентхаусов с изысканной архитектурой, просторным лобби высотой 6,5 м и видами на главные достопримечательности Москвы. В доме создана насыщенная инфраструктура: Lounge с библиотекой, лобби-бар, бесплатный фитнес Fit Lab, детская комната и игровая площадка Kid’s Lab, уютный внутренний двор-сад. Рядом — набережные, парки «Музеон», Парк Горького и Нескучный сад. За комфорт жителей отвечает Служба комфорта Sminex, предоставляющая сервис уровня 5-звёздочных отелей. Девелопер — компания Sminex.', 1243380000.00, 503, 5, 'available', 2, 4, 3, '2025-06-19', '../Andreev_Estate/img/hamovniki.jpg'),
(8, 'Пентхаус \"Над Арбатом\" ', 'Роскошный видовой пентхаус \"Над Арбатом\" — это элегантная гармония пространственных ритмов в сочетании с роскошным дизайном от ведущих архитекторов. Пентхаус общей площадью 340 кв. м. располагает просторными террасами, откуда открываются красивые виды на город, на нижнем уровне расположились спальни, а на верхнем создана комфортная зона отдыха для всей семьи - просторная гостиная с камином, объединённая со столовой и кухней, большие террасы с зоной отдыха, барбекю и великолепными видами на район Арбат. Холл – первое помещение, которое открывается при входе в пентхаус, на противоположной стороне от двери находится зеркальный шкаф. На фоне красуется напоминающая арт-объект знаменитая вешалка-кактус компании Gufram. Из холла лестница ведет на второй этаж, где находится главная зона дома.\r\nВ зоне гостиной расположена уютная диванная группа Diesel by Moroso со знаменитым торшером Mite дизайна Марка Сандлера для Foscarini и элегантный бездымный биокамин.', 490000000.00, 340, 6, 'available', 4, 2, 3, '2025-06-21', '../Andreev_Estate/img/nadarbatom.jpg'),
(9, 'МФК «Берег Столицы»', 'Элитный проект с атмосферой загородных резиденций в Серебряном Бору.\r\nПрестижная локация на берегу острова-заповедника гармонично сочетает ритм мегаполиса с тишиной и уединением. Отсутствие крупных магистралей и реликтовый лес обеспечивают благоприятную экологическую обстановку. Поблизости располагаются станции вейк и SUP-борда, яхт-клуб, базы для летних и зимних видов спорта и конные клубы, площадки для пляжного волейбола. Среди вековых сосен проложены эко-тропы. Огороженная территория комплекса занимает 8 гектаров. Здесь обустроят собственный ландшафтный парк и променад с выходом к причалу, оборудуют спортивную площадку с зоной work-out, откроют фермерскую лавку, кабинет семейного врача и прачечную. Для самых маленьких жителей предусмотрен детский клуб. С решением бытовых вопросов поможет профессиональный консьерж-сервис. Также к услугам резидентов садовник, клубный автомобиль с водителем, valet parking. Транспортную доступность обеспечивает близость проспекта Маршала Жукова – на машине дорога до Садового кольца и центра города займет 15 минут.', 199000000.00, 353, 7, 'available', 2, 6, 3, '2025-06-12', '../Andreev_Estate/img/mnevki.jpg'),
(10, 'МФК «Берег Столицы»', 'Расположенная в излучине Москвы-реки самого сердца Серебряного Бора, эта роскошная резиденция является настоящим фамильным имением для творения богатой семейной истории. Безмятежная атмосфера нетронутой природы с захватывающей панорамой на мягкие волны и пейзаж заповедника заворожит даже искушенного видами. Интерьер поместья впечатляет: 6 спален, 8 ванных комнат, собственный бассейн, хаммам, каминная комната и просторный винный погреб разместились на площади 1 852,60 квадратных метров. Вертикальный свет по высоте дома освещает каждую деталь грандиозного интерьера и наполняет дом натуральным светом и свежестью. Кухня для гурманов, собственный офис и игровая комната предлагают дополнительные пространства для отдыха и творчества, а приватный придомовой участок и эксплуатируемая кровля создают условия для наслаждения видами на Серебряный Бор и отражения закатов в глади реки.', 900000000.00, 1853, 8, 'available', 3, 6, 3, '2025-06-21', '../Andreev_Estate/img/beregctolicy.jpg'),
(11, 'Особняк \"Меценат\"', 'Комплекс особняков расположен в сердце Замоскворечья, между улицей Большая Ордынка и Кадашевским тупиком. В окружении старинные здания — объекты культурного, исторического и архитектурного наследия. В пешей доступности сквер на Болотной площади и парк искусств «Музеон». Жилой комплекс состоит из 9 особняков, среди которых 24 квартиры, 9 таунхаусов и 3 двухэтажных дома с действующими каминами. Особую атмосферу придают неповторимые виды на башни Кремля и Храма Воскресения Христова. Во внутреннем дворе организованы зона отдыха, ландшафтный парк с садом, прогулочными дорожками и уличным освещением. Отдельно расположена игровая площадка для детей.', 1470000000.00, 588, 9, 'available', 3, 1, 3, '2025-06-17', '../Andreev_Estate/img/mecenat.jpg'),
(12, 'ЖК \"Власьевская Слобода\"', 'Редкое предложение в ЖК \"Власьевская Слобода\" в тихих переулках Арбата.\r\nЧетырехкомнатная квартира с дизайнерским ремонтом. Планировка: кухня-столовая, отдельная большая гостиная, две спальни со своими санузлами, гостевой санузел. При необходимости из гостиной можно сделать третью спальню. Квартира продается с двумя машиноместами в подземном паркинге и подсобным помещением 17,5м. Приятные виды из всех окон. Клубный дом является проектом реставрации здания XX века. Архитекторы восстановили изысканный фасад и совершили техническое переоснащение всего дома. В процессе реставрации застройщик использовал для отделки фасада премиальные материалы: мрамор и гранит. При входе жителей и гостей встречает респектабельный холл с лестницей с коваными перилами и зеркалами на стенах. В 5-этажном здании представлены 15 квартир площадью от 106 до 365 кв. м. На верхнем этаже 2-уровневая квартира с мансардой. В лотах потолки высотой до 4 метров.', 250000000.00, 170, 4, 'available', 1, 4, 3, '2025-06-21', '../Andreev_Estate/img/vlsloboda.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `house_types`
--

CREATE TABLE `house_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `house_types`
--

INSERT INTO `house_types` (`id`, `type_name`) VALUES
(1, 'Квартира'),
(2, 'Таунхаус'),
(3, 'Особняк'),
(4, 'Пентхаус');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `role` enum('client','agent','admin') DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `name`, `email`, `phone`, `budget`, `role`) VALUES
(1, '123', '123', 'Егор', 'isip_e.n.andreev@mpt.ru', '+79032777301', '300000000', 'client'),
(3, 'agent', '123', 'Валентин', 'valentin@gmail.com', '+79031488400', NULL, 'agent'),
(6, 'chulido', '$2y$10$JPZ7bmo0F5RpERMGfDBrr.45Bn5NlWaM4cyOXrQTFoYqAhQzpeRYG', 'Егор', 'isip_e.n.andreev@mpt.ru', '+7 (966) 078-98-16', '1000000', 'client'),
(7, 'admin', 'admin', 'Валера', 'valeraadmin@gmail.com', '+79111110102', NULL, 'admin'),
(9, 'Genius', '$2y$10$F014rCScywd10xMN0gjrE.p7P77fGqqEPPGpO1.ERK1ySwfaGV8VC', 'Tom', 'tom@gmail.com', '+7 (666) 666-66-66', '10.000.000.000', 'client'),
(10, 'efgdf', '$2y$10$6vyc9v8hImbK2kBzODB1V.9zbtIU6Z37AQHc0dW8M25n73zAZtqoi', 'rferf', 'johnpiter5252@gmail.com', '+7 (904) 234-23-42', '121.111.111', 'client');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_01_houses_with_district`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_01_houses_with_district` (
`id` int(11)
,`title` varchar(100)
,`description` text
,`price` decimal(15,2)
,`area` int(11)
,`rooms` int(11)
,`status` enum('available','sold')
,`type_id` int(11)
,`district_id` int(11)
,`agent_id` int(11)
,`date_available` date
,`image` varchar(255)
,`district_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_02_clients_and_favorites_with_house_type`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_02_clients_and_favorites_with_house_type` (
`client_id` int(11)
,`client_login` varchar(50)
,`type_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_03_deals_with_agents`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_03_deals_with_agents` (
`id` int(11)
,`client_id` int(11)
,`house_id` int(11)
,`agent_id` int(11)
,`amount` varchar(255)
,`agent_login` varchar(50)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_04_houses_with_price_and_agent`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_04_houses_with_price_and_agent` (
`house_id` int(11)
,`title` varchar(100)
,`price` decimal(15,2)
,`agent_login` varchar(50)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_05_deals_with_clients_and_houses`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_05_deals_with_clients_and_houses` (
`deal_id` int(11)
,`amount` varchar(255)
,`client_id` int(11)
,`client_login` varchar(50)
,`house_id` int(11)
,`house_title` varchar(100)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_06_available_houses_by_date`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_06_available_houses_by_date` (
`id` int(11)
,`title` varchar(100)
,`description` text
,`price` decimal(15,2)
,`area` int(11)
,`rooms` int(11)
,`status` enum('available','sold')
,`type_id` int(11)
,`district_id` int(11)
,`agent_id` int(11)
,`date_available` date
,`image` varchar(255)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_07_agents_total_deals`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_07_agents_total_deals` (
`agent_id` int(11)
,`agent_login` varchar(50)
,`total_deals` double
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_08_available_houses_by_type`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_08_available_houses_by_type` (
`id` int(11)
,`title` varchar(100)
,`description` text
,`price` decimal(15,2)
,`area` int(11)
,`rooms` int(11)
,`status` enum('available','sold')
,`type_id` int(11)
,`district_id` int(11)
,`agent_id` int(11)
,`date_available` date
,`image` varchar(255)
,`type_name` varchar(50)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_09_clients_by_budget`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_09_clients_by_budget` (
`id` int(11)
,`login` varchar(50)
,`budget` varchar(255)
);

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_10_houses_with_sale_status`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_10_houses_with_sale_status` (
`id` int(11)
,`title` varchar(100)
,`rooms` int(11)
,`area` int(11)
,`price` decimal(15,2)
,`sale_status` varchar(8)
);

-- --------------------------------------------------------

--
-- Структура для представления `view_01_houses_with_district`
--
DROP TABLE IF EXISTS `view_01_houses_with_district`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_01_houses_with_district`  AS SELECT `h`.`id` AS `id`, `h`.`title` AS `title`, `h`.`description` AS `description`, `h`.`price` AS `price`, `h`.`area` AS `area`, `h`.`rooms` AS `rooms`, `h`.`status` AS `status`, `h`.`type_id` AS `type_id`, `h`.`district_id` AS `district_id`, `h`.`agent_id` AS `agent_id`, `h`.`date_available` AS `date_available`, `h`.`image` AS `image`, `d`.`name` AS `district_name` FROM (`houses` `h` join `districts` `d` on(`h`.`district_id` = `d`.`id`)) WHERE `d`.`name` = 'Якиманка' ;

-- --------------------------------------------------------

--
-- Структура для представления `view_02_clients_and_favorites_with_house_type`
--
DROP TABLE IF EXISTS `view_02_clients_and_favorites_with_house_type`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_02_clients_and_favorites_with_house_type`  AS SELECT DISTINCT `u`.`id` AS `client_id`, `u`.`login` AS `client_login`, `ht`.`type_name` AS `type_name` FROM (((`favorites` `f` join `users` `u` on(`f`.`user_id` = `u`.`id`)) join `houses` `h` on(`f`.`house_id` = `h`.`id`)) join `house_types` `ht` on(`h`.`type_id` = `ht`.`id`)) WHERE `u`.`role` = 'client' AND `ht`.`type_name` = 'Квартира' ;

-- --------------------------------------------------------

--
-- Структура для представления `view_03_deals_with_agents`
--
DROP TABLE IF EXISTS `view_03_deals_with_agents`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_03_deals_with_agents`  AS SELECT `d`.`id` AS `id`, `d`.`client_id` AS `client_id`, `d`.`house_id` AS `house_id`, `d`.`agent_id` AS `agent_id`, `d`.`amount` AS `amount`, `u`.`login` AS `agent_login` FROM (`deals` `d` join `users` `u` on(`d`.`agent_id` = `u`.`id`)) WHERE `u`.`role` = 'agent' AND `u`.`id` = 3 ;

-- --------------------------------------------------------

--
-- Структура для представления `view_04_houses_with_price_and_agent`
--
DROP TABLE IF EXISTS `view_04_houses_with_price_and_agent`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_04_houses_with_price_and_agent`  AS SELECT `h`.`id` AS `house_id`, `h`.`title` AS `title`, `h`.`price` AS `price`, `u`.`login` AS `agent_login` FROM (`houses` `h` join `users` `u` on(`h`.`agent_id` = `u`.`id`)) WHERE `u`.`role` = 'agent' ;

-- --------------------------------------------------------

--
-- Структура для представления `view_05_deals_with_clients_and_houses`
--
DROP TABLE IF EXISTS `view_05_deals_with_clients_and_houses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_05_deals_with_clients_and_houses`  AS SELECT `d`.`id` AS `deal_id`, `d`.`amount` AS `amount`, `u`.`id` AS `client_id`, `u`.`login` AS `client_login`, `h`.`id` AS `house_id`, `h`.`title` AS `house_title` FROM ((`deals` `d` join `users` `u` on(`d`.`client_id` = `u`.`id`)) join `houses` `h` on(`d`.`house_id` = `h`.`id`)) WHERE `u`.`role` = 'client' AND `d`.`amount` >= 200000000 ;

-- --------------------------------------------------------

--
-- Структура для представления `view_06_available_houses_by_date`
--
DROP TABLE IF EXISTS `view_06_available_houses_by_date`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_06_available_houses_by_date`  AS SELECT `h`.`id` AS `id`, `h`.`title` AS `title`, `h`.`description` AS `description`, `h`.`price` AS `price`, `h`.`area` AS `area`, `h`.`rooms` AS `rooms`, `h`.`status` AS `status`, `h`.`type_id` AS `type_id`, `h`.`district_id` AS `district_id`, `h`.`agent_id` AS `agent_id`, `h`.`date_available` AS `date_available`, `h`.`image` AS `image` FROM (`houses` `h` left join `deals` `d` on(`h`.`id` = `d`.`house_id`)) WHERE `d`.`id` is null AND `h`.`date_available` >= '2025-06-19' ;

-- --------------------------------------------------------

--
-- Структура для представления `view_07_agents_total_deals`
--
DROP TABLE IF EXISTS `view_07_agents_total_deals`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_07_agents_total_deals`  AS SELECT `u`.`id` AS `agent_id`, `u`.`login` AS `agent_login`, sum(`d`.`amount`) AS `total_deals` FROM (`users` `u` join `deals` `d` on(`u`.`id` = `d`.`agent_id`)) WHERE `u`.`role` = 'agent' GROUP BY `u`.`id`, `u`.`login` ;

-- --------------------------------------------------------

--
-- Структура для представления `view_08_available_houses_by_type`
--
DROP TABLE IF EXISTS `view_08_available_houses_by_type`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_08_available_houses_by_type`  AS SELECT `h`.`id` AS `id`, `h`.`title` AS `title`, `h`.`description` AS `description`, `h`.`price` AS `price`, `h`.`area` AS `area`, `h`.`rooms` AS `rooms`, `h`.`status` AS `status`, `h`.`type_id` AS `type_id`, `h`.`district_id` AS `district_id`, `h`.`agent_id` AS `agent_id`, `h`.`date_available` AS `date_available`, `h`.`image` AS `image`, `ht`.`type_name` AS `type_name` FROM ((`houses` `h` join `house_types` `ht` on(`h`.`type_id` = `ht`.`id`)) left join `deals` `d` on(`h`.`id` = `d`.`house_id`)) WHERE `d`.`id` is null AND `ht`.`type_name` = 'Пентхаус' ;

-- --------------------------------------------------------

--
-- Структура для представления `view_09_clients_by_budget`
--
DROP TABLE IF EXISTS `view_09_clients_by_budget`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_09_clients_by_budget`  AS SELECT `users`.`id` AS `id`, `users`.`login` AS `login`, `users`.`budget` AS `budget` FROM `users` WHERE `users`.`role` = 'client' AND `users`.`budget` between 100000000 and 300000000 ;

-- --------------------------------------------------------

--
-- Структура для представления `view_10_houses_with_sale_status`
--
DROP TABLE IF EXISTS `view_10_houses_with_sale_status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_10_houses_with_sale_status`  AS SELECT `h`.`id` AS `id`, `h`.`title` AS `title`, `h`.`rooms` AS `rooms`, `h`.`area` AS `area`, `h`.`price` AS `price`, if(`d`.`id` is null,'Доступен','Продан') AS `sale_status` FROM (`houses` `h` left join `deals` `d` on(`h`.`id` = `d`.`house_id`)) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `house_id` (`house_id`);

--
-- Индексы таблицы `deals`
--
ALTER TABLE `deals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `house_id` (`house_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Индексы таблицы `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `house_id` (`house_id`);

--
-- Индексы таблицы `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `district_id` (`district_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Индексы таблицы `house_types`
--
ALTER TABLE `house_types`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `deals`
--
ALTER TABLE `deals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `houses`
--
ALTER TABLE `houses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `house_types`
--
ALTER TABLE `house_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`);

--
-- Ограничения внешнего ключа таблицы `deals`
--
ALTER TABLE `deals`
  ADD CONSTRAINT `deals_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `deals_ibfk_2` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`),
  ADD CONSTRAINT `deals_ibfk_3` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `houses`
--
ALTER TABLE `houses`
  ADD CONSTRAINT `houses_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `house_types` (`id`),
  ADD CONSTRAINT `houses_ibfk_2` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`),
  ADD CONSTRAINT `houses_ibfk_3` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
