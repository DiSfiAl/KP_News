-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Лис 28 2024 р., 14:10
-- Версія сервера: 10.4.32-MariaDB
-- Версія PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `newsdb`
--

-- --------------------------------------------------------

--
-- Структура таблиці `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `access_level` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `access_level`, `created_at`) VALUES
(1, 'viewer', '65375049b9e4d7cad6c9ba286fdeb9394b28135a3e84136404cfccfdcc438894', 3, '2024-11-27 02:35:53'),
(2, 'editor', 'ef5e5a1fb95055e0e56cccf98a41e784a132c14e7f6e1ba244302f0e72b29baf', 2, '2024-11-27 02:35:53'),
(3, 'superadmin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 3, '2024-11-27 02:35:53'),
(5, 'fial', '$2y$10$qEbL.cLSShcfS/Lk7mlNS.hWfn20v.PHo7/tjh1LMH9EP2syWKqRm', 1, '2024-11-28 11:06:16');

-- --------------------------------------------------------

--
-- Структура таблиці `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `performed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `admin_id`, `action`, `performed_at`) VALUES
(1, 1, 'Added a news article: \"How to Code in PHP\"', '2024-11-28 11:02:07'),
(7, 3, 'Added a new admin: \"John Doe\"', '2024-11-28 11:02:07'),
(10, 1, 'Added a news article: \"How to Code in PHP\"', '2024-11-28 11:02:55'),
(11, 1, 'Edited a news article: \"How to Code in PHP\"', '2024-11-28 11:02:55'),
(12, 1, 'Deleted a news article: \"How to Code in PHP\"', '2024-11-28 11:02:55'),
(17, 3, 'Deleted an admin: \"John Doe\"', '2024-11-28 11:02:55'),
(23, 1, 'Deleted a news article: \"How to Code in PHP\"', '2024-11-28 11:03:19'),
(28, 2, 'Edited a category: \"Technology\" to \"Tech & Gadgets\"', '2024-11-28 11:03:19'),
(29, 2, 'Deleted a category: \"Tech & Gadgets\"', '2024-11-28 11:03:19'),
(30, 2, 'Deleted a category: \"Tech & Gadgets\"', '2024-11-28 11:03:19'),
(31, 3, 'Added a new admin: \"John Doe\"', '2024-11-28 11:03:19'),
(32, 3, 'Added a new admin: \"John Doe\"', '2024-11-28 11:03:19'),
(33, 3, 'Deleted an admin: \"John Doe\"', '2024-11-28 11:03:19'),
(34, 3, 'Deleted an admin: \"John Doe\"', '2024-11-28 11:03:19'),
(37, 1, 'Added a news article: \"Sample News\"', '2024-11-28 11:04:59');

-- --------------------------------------------------------

--
-- Структура таблиці `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'спорт', 'Новини про спорт, включаючи футбол, олімпіади та інші події.'),
(2, 'кіберспорт', 'Новини про кіберспортивні турніри та гравців.'),
(3, 'війна', 'Оновлення про ситуацію на фронті, військові новини.'),
(4, 'суспільні', 'Новини про суспільні події, економіку та соціальні зміни.'),
(5, 'Технології', 'Новини про розробки, тестування та продажі найрізноманітніших технологій, як вже відомих людству, так і принципіально нових'),
(6, 'Культура', 'Новини про культурні виставки або розвиток культурних згадок');

-- --------------------------------------------------------

--
-- Структура таблиці `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `user_id`, `content`, `created_at`) VALUES
(1, 14, 1, 'Дай боже всім здоровля', '2024-11-24 11:40:26'),
(2, 14, 1, '0_o', '2024-11-24 13:26:31');

-- --------------------------------------------------------

--
-- Структура таблиці `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `category_id`, `views`, `created_at`, `is_deleted`) VALUES
(1, 'Футбольний матч: Результати та огляд', '<p>У суботу відбувся захопливий матч між командами <strong>Динамо</strong> та <strong>Шахтар</strong>. Перемогу здобула команда Шахтар з рахунком 2:1.</p><img src=\"https://ichef.bbci.co.uk/ace/ws/640/cpsprodpb/17B42/production/_128009079_1hi081051078.jpg.webp\" alt=\"Футбольний матч\">', 1, 0, '2024-11-21 09:22:42', 0),
(2, 'Олімпіада 2024: Підготовка українських спортсменів', '<p>Україна активно готується до наступної Олімпіади. Найбільші надії покладають на легкоатлетів.</p><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/abcd1234\" title=\"Олімпіада 2024\"></iframe>', 1, 3, '2024-11-21 09:22:42', 0),
(3, 'Новий тренер збірної України з футболу', '<p>Федерація футболу України офіційно підтвердила призначення нового головного тренера.</p>', 1, 0, '2024-11-21 09:22:42', 0),
(4, 'CS:GO Major 2024: Українська команда у фіналі!', '<p>Команда <strong>NAVI</strong> здобула місце у фіналі престижного турніру <a href=\"https://example.com/csgo-major\">CS:GO Major</a>.</p><img src=\"https://example.com/navi.jpg\" alt=\"Команда NAVI\">', 2, 0, '2024-11-21 09:22:42', 0),
(5, 'Dota 2: The International 2024', '<p>Уже стартував найочікуваніший турнір року з Dota 2. Команда Team Spirit представляє регіон СНД.</p><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/efgh5678\" title=\"Dota 2 TI 2024\"></iframe>', 2, 0, '2024-11-21 09:22:42', 0),
(6, 'Оновлення з фронту: Поточна ситуація', '<p>Станом на сьогодні Збройні Сили України утримують позиції на сході країни. Більше деталей за <a href=\"https://example.com/front-news\">посиланням</a>.</p>', 3, 0, '2024-11-21 09:22:42', 0),
(7, 'Допомога армії: Нові поставки техніки', '<p>США надали Україні нову партію військової техніки, яка вже направлена на фронт.</p><img src=\"https://example.com/tech.jpg\" alt=\"Техніка для ЗСУ\">', 3, 0, '2024-11-21 09:22:42', 0),
(8, 'Відновлення деокупованих територій', '<p>В уряді заявили про початок відновлення інфраструктури у деокупованих регіонах.</p>', 3, 0, '2024-11-21 09:22:42', 0),
(9, 'Молодіжний фестиваль у Києві', '<p>Цими вихідними у Києві відбувся молодіжний фестиваль, присвячений сучасній музиці.</p><img src=\"https://example.com/festival.jpg\" alt=\"Молодіжний фестиваль\">', 4, 0, '2024-11-21 09:22:42', 0),
(10, 'Збільшення тарифів на електроенергію', '<p>В Україні збільшено тарифи на електроенергію. Зміни вступають в силу з наступного місяця.</p><a href=\"https://example.com/tariffs-news\">Деталі за посиланням</a>', 4, 0, '2024-11-21 09:22:42', 0),
(11, 'Нові реформи у сфері податків', '<p>Уряд представив план реформ, який включає суттєві зміни у податковій системі. Основна увага приділяється підтримці малого бізнесу.</p>\r\n    <p>Реформи передбачають зниження податків на прибуток для стартапів та впровадження податкових канікул на перший рік діяльності.</p>\r\n    <img src=\"https://example.com/tax-reform.jpg\" alt=\"Податкові реформи\">\r\n    <p>Докладніше про реформи можна дізнатися за <a href=\"https://example.com/reforms\">цим посиланням</a>. Водночас експерти попереджають про можливі ризики у вигляді дефіциту бюджету.</p>\r\n    <p>Реформа також спрямована на стимулювання інвестицій, що повинно позитивно вплинути на економічний розвиток країни.</p>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/example\" title=\"Реформи\"></iframe>\r\n    <p>Громадські організації закликають до відкритого обговорення реформ для досягнення консенсусу.</p>', 2, 0, '2024-11-24 10:04:43', 0),
(12, 'Інновації в галузі ШІ', '<p>Штучний інтелект стає все більш інтегрованим у наше життя. Новітні розробки дозволяють автоматизувати складні процеси.</p>\r\n    <p>Наприклад, нові алгоритми оптимізації забезпечують покращення ефективності промислових підприємств.</p>\r\n    <img src=\"https://example.com/ai-innovations.jpg\" alt=\"Інновації у ШІ\">\r\n    <p>Читайте більше про це у нашому матеріалі за <a href=\"https://example.com/ai-news\">посиланням</a>. Вчені вважають, що майбутнє лежить за інтелектуальними системами.</p>\r\n    <p>Компанія OpenAI представила нову модель GPT, яка ще краще розуміє природну мову.</p>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/ai-video\" title=\"ШІ\"></iframe>\r\n    <p>Проте є і виклики, пов’язані з етикою використання ШІ.</p>', 5, 0, '2024-11-24 10:04:43', 0),
(13, 'Зростання ВВП у третьому кварталі', '<p>За даними Держстату, ВВП України зріс на 3,2% у третьому кварталі. Це значно перевищує прогнози аналітиків.</p>\r\n    <p>Зростання пов’язане з відновленням експорту та високим рівнем внутрішнього споживання.</p>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/economy-video\" title=\"Економіка\"></iframe>\r\n    <p>Більше інформації можна знайти за <a href=\"https://example.com/gdp-news\">цим посиланням</a>. Економісти прогнозують подальше стабільне зростання.</p>\r\n    <img src=\"https://example.com/economy-growth.jpg\" alt=\"Економічне зростання\">\r\n    <p>Втім, існують ризики, пов’язані з високим рівнем інфляції та нестабільністю ринків.</p>', 3, 0, '2024-11-24 10:04:43', 0),
(14, 'Рекомендації для здорового способу життя', '<p>Фахівці рекомендують зберігати баланс між роботою та відпочинком, щоб підтримувати здоров’я.</p>\r\n    <p>Щоденні фізичні вправи та правильне харчування є ключем до здорового способу життя.</p>\r\n    <img src=\"https://www.bsmu.edu.ua/wp-content/uploads/2019/03/4442.jpg\">\r\n    <p>Детальні поради можна знайти за <a href=\"https://example.com/health-tips\">цим посиланням</a>. Важливо також регулярно проходити медичні обстеження.</p>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/health-video\" title=\"Здоров’я\"></iframe>\r\n    <p>Лікарі нагадують про необхідність вакцинації для профілактики хвороб.</p>', 4, 1, '2024-11-24 10:04:43', 0),
(15, 'Виставка сучасного мистецтва', '<p>У Києві відкрилася виставка сучасного мистецтва, яка привертає увагу тисяч відвідувачів.</p>\r\n    <p>Експозиція включає роботи художників з усього світу, що відображають сучасні тенденції у мистецтві.</p>\r\n    <img src=\"https://example.com/art-exhibition.jpg\" alt=\"Виставка\">\r\n    <p>Зацікавлені можуть дізнатися більше за <a href=\"https://example.com/exhibition-info\">цим посиланням</a>. Виставка триватиме до кінця місяця.</p>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/art-video\" title=\"Мистецтво\"></iframe>\r\n    <p>Організатори обіцяють інтерактивні заходи для всіх відвідувачів.</p>', 6, 0, '2024-11-24 10:04:43', 0),
(16, 'Чехія здобула золото на Чемпіонаті світу з хокею', '<p>Збірна Чехії здобула перемогу в фінальному матчі Чемпіонату світу з хокею, обігравши Канаду з рахунком 3:2.</p>\r\n    <p>Це перший подібний успіх Чехії за останні 10 років.</p>\r\n    <img src=\"https://example.com/hockey-champions.jpg\">\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/hockey-final\" title=\"Чемпіонат світу з хокею\"></iframe>\r\n    <p>Подробиці матчу можна дізнатися за <a href=\"https://example.com/hockey-details\">цим посиланням</a>.</p>', 1, 18, '2024-11-25 01:25:54', 0),
(17, 'Перемога Чехії на міжнародному турнірі з кіберспорту', '<p>Команда з Чехії здобула перемогу на міжнародному турнірі з кіберспорту в дисципліні Dota 2.</p>\r\n    <p>Фінальний матч проти шведської команди став справжнім шоу для фанатів.</p>\r\n    <img src=\"https://example.com/dota2-victory.jpg\">\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/dota2-final\" title=\"Фінал турніру з Dota 2\"></iframe>', 2, 17, '2024-11-25 01:25:54', 0),
(18, 'Чехія надає гуманітарну допомогу Україні', '<p>Чехія Все ще продовжує підтримувати Україну у війні, надавши новий пакет гуманітарної допомоги.</p>\r\n    <img src=\"https://example.com/czech-aid.jpg\">\r\n    <p>До пакету входять медикаменти, продукти харчування та інша необхідна допомога.</p>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/war-aid-video\" title=\"Допомога Україні\"></iframe>', 3, 20, '2024-11-25 01:25:54', 0),
(19, 'Чеські вчені створили інноваційний пристрій для екології', '<p>Вчені з Карлового університету представили новий пристрій для очищення повітря у промислових зонах.</p>\r\n    <img src=\"https://example.com/eco-device.jpg\">\r\n    <p>Пристрій знижує рівень шкідливих речовин у повітрі на 90%.</p>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/eco-device-demo\" title=\"Інновації в Чехії\"></iframe>', 5, 15, '2024-11-25 01:25:54', 0),
(20, 'Новий театральний сезон у Празі стартує з прем’єр', '<p>Національний театр Праги розпочав новий сезон з прем’єри опери \"Дон Жуан\".</p>\r\n    <img src=\"https://example.com/theatre-premiere.jpg\">\r\n    <p>Квитки на вистави вже розкуплені на місяць уперед.</p>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/theatre-opera\" title=\"Театр у Празі\"></iframe>', 6, 3, '2024-11-25 01:25:54', 0),
(21, 'Празький марафон 2024: новий рекорд', '<p>У Празі пройшов щорічний марафон, який зібрав понад 20 тисяч учасників із 50 країн світу.</p>\r\n    <p>Чеський бігун встановив новий рекорд дистанції.</p>\r\n    <img src=\"https://example.com/prague-marathon.jpg\">\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/prague-marathon\" title=\"Марафон у Празі\"></iframe>', 1, 12, '2024-11-25 01:25:54', 0),
(22, 'Геймери Чехії стали чемпіонами з CS:GO', '<p>Чеська команда виборола перше місце на турнірі з CS:GO у Берліні.</p>\r\n    <img src=https://lh4.googleusercontent.com/DbEXJupiKgv1Caq6yOMzfAkKxHMyj13OSGVSjPmkX0z7R6p93CmYNmOnzHIH4NAn1p3djYoUDAZGDRs2N1H4j8y1e0fg2gfpDQQ8_x82hW6xfNdSadrddWCbYQPu5DDLcS1lKQsBFoLmViSESJ6eVC7Jzt_PyhpnddErGlXYI1CUiKszLCIHnBkEfA>\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/csgo-final\" title=\"Фінал CS:GO\"></iframe>', 2, 11, '2024-11-25 01:25:54', 0),
(23, 'Міжнародна підтримка Чехії у вирішенні проблеми біженців', '<p>Чехія отримала підтримку ЄС у розв’язанні кризи, пов’язаної з біженцями з України.</p>\r\n    <img src=\"https://example.com/refugee-support.jpg\">\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/refugee-support\" title=\"Проблема біженців\"></iframe>', 4, 3, '2024-11-25 01:25:54', 0),
(24, 'Чеські інженери створили швидкісний електрокар', '<p>Нова розробка чеських інженерів — електрокар, який досягає швидкості 300 км/год.</p>\r\n    <p>Модель презентували на міжнародному автосалоні у Празі.</p>\r\n    <img src=\"https://example.com/electric-car.jpg\">\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/electric-car-demo\" title=\"Електрокар із Чехії\"></iframe>', 5, 8, '2024-11-25 01:25:54', 0),
(25, 'Фестиваль сучасної культури у Брно', '<p>У Брно відбувся фестиваль сучасної культури, де свої роботи представили художники з усього світу.</p>\r\n    <img src=\"https://example.com/art-festival.jpg\">\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/art-festival-brno\" title=\"Фестиваль у Брно\"></iframe>', 6, 0, '2024-11-25 01:25:54', 0),
(26, 'war', '<p>Це приклад тексту новини.</p>\r\n<img src=\"https://www.economist.com/cdn-cgi/image/width=1424,quality=80,format=auto/content-assets/images/20231118_TWEUP001.jpg\" alt=\"Опис зображення\">\r\n<p>Деталі за <a href=\"URL_посилання\">цим посиланням</a>.</p>\r\n<iframe src=\"https://www.youtube.com/watch?v=BI9fKfX5V68\"></iframe>\r\n<p>Деталі за <a href=\"URL_посилання\">цим посиланням</a>.</p>', 3, 0, '2024-11-28 02:06:28', 1),
(27, 'WARSZSZ', '<p>Це приклад тексту новини.</p>\r\n<img src=\"https://news.harvard.edu/wp-content/uploads/2023/02/Army.take3_.jpg\" alt=\"Опис зображення\">\r\n<p>Деталі за <a href=\"URL_посилання\">цим посиланням</a>.</p>\r\n<iframe src=\"https://www.youtube.com/watch?v=BI9fKfX5V68\"></iframe>\r\n<p>Деталі за <a href=\"URL_посилання\">цим посиланням</a>.</p>', 3, 1, '2024-11-28 02:17:34', 1),
(29, 'SUsp', '<p>Це приклад тексту новини.</p>\r\n<img src=\"https://t3.ftcdn.net/jpg/04/42/62/12/360_F_442621279_PYhie13pVGcSSYTAm1eqlC3e7Lcy0oNV.jpg\" alt=\"Опис зображення\">\r\n<p>Деталі за <a href=\"URL_посилання\">цим посиланням</a>.</p>\r\n<iframe src=\"https://www.youtube.com/watch?v=T5coGtGsBSk\"></iframe>\r\n<p>Деталі за <a href=\"URL_посилання\">цим посиланням</a>.</p>', 4, 0, '2024-11-28 11:00:16', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `news_tags`
--

CREATE TABLE `news_tags` (
  `news_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `read_later`
--

CREATE TABLE `read_later` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `added_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `read_later`
--

INSERT INTO `read_later` (`id`, `user_id`, `news_id`, `added_at`) VALUES
(7, 1, 1, '2024-11-24 02:45:57'),
(8, 1, 3, '2024-11-24 09:26:50'),
(9, 1, 4, '2024-11-24 09:29:17'),
(11, 1, 6, '2024-11-24 09:30:01'),
(19, 1, 14, '2024-11-24 23:29:34'),
(20, 1, 17, '2024-11-25 21:07:00'),
(21, 1, 19, '2024-11-25 21:10:15'),
(22, 1, 22, '2024-11-28 10:31:41');

-- --------------------------------------------------------

--
-- Структура таблиці `recent_views`
--

CREATE TABLE `recent_views` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `viewed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `recent_views`
--

INSERT INTO `recent_views` (`id`, `user_id`, `news_id`, `viewed_at`) VALUES
(10, 2, 6, '2024-11-23 13:49:04'),
(11, 2, 7, '2024-11-23 13:49:05'),
(12, 2, 8, '2024-11-23 13:49:05'),
(13, 2, 9, '2024-11-23 13:49:06'),
(14, 2, 10, '2024-11-23 13:49:07'),
(205, 1, 21, '2024-11-25 23:22:35'),
(206, 1, 20, '2024-11-25 23:22:35'),
(210, 1, 17, '2024-11-27 02:36:39'),
(211, 1, 18, '2024-11-28 10:31:37'),
(213, 1, 22, '2024-11-28 10:31:41');

-- --------------------------------------------------------

--
-- Структура таблиці `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(64) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `secondname` varchar(100) NOT NULL,
  `avatar` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `firstname`, `secondname`, `avatar`) VALUES
(1, 'pashakrasava', '$2y$10$umQZdJ.2PLtKFKHO1LH8IecESafZAr6ZyGNsODKHcGa9/UKEEHAyq', 'natusvinceretop1@gmail.com', 'Павло', 'Кіцанюк', 0x89504e470d0a1a0a0000000d49484452000000c8000000c80806000000ad58ae9e0000000473424954080808087c086488000000097048597300000b1300000b1301009a9c180000119049444154789ceddd7b9064757507f0ef39dd33c30ebb3bbd2f6170b76ff76cef0e8ec9061c050564c3cb0a02c523c84388185254f1365021a48ccac3524caa1485a041c3438a224804164552884416e421b8200416d9eded9edb3b30acfb98edd9c73cbaef39f9039228c5dcdb3d8f5fbfcee7df3e77ee777ae6f4bd7defeffe7e8031c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618d36ca8d6010c008056edb75fe7aececeb95ce279aa4ab40f8dedbb7bf78e57b66cd953eb70adcc1ac4b1d5581d7f2be5f707aa47a9ea41a4dc4b8c95003adf770391a28073c4fa2a29bdc0a44f6df4fd9701a8d3e02dca1ac481d5581ddfec0d1c474a9f1395139879deb47ea0e06d10d628e4ee5ca1f00cac59668d35c82ceae9e9e9a220b804429781b1ff6cec4380f5acf836b5c7efca66b3e3b3b18f56660d320b962e5d3aa79de37f4f2a5780b9cbc53e456533117d25e7fb77011017fb6c05d620332c9d4c9e40c4371390ae4d027d2120ba606060e0e5daecbfb95883cc90eeeeeece39ed1d3711f037b5ce22d032015fcef9fe3fc38e26d3620d320352a9546f4cf5c700fd49adb3fc11c12365d6737cdfdf59eb288dca1a649a56a452878ae211000b6b9de5fda8e07589e1f8818101bfd6591a9135c834a497a58f63d63598ec1e4614955794f82985be06e58d3192ed528eed9636610e789e52793f26ea85ea2a288e0273722abb1195cd2c6d476f1adc949d52ce16660d3245cb3def13003d0e604e551b8abcace03b02d61ff9beff76155b92e779bd31a57395f43c062dad6ab72a9b291e3f2297cb15aacadbe2ac41a66085e77d48404f035850c5664f13e1faecc0c06398e68dbdfefefeb6e16ddbce55d09718e8a9743b015ea3181f9ecbe58ad3d97f2bb106a9526f6fefbcf2e8e86f40bcb2a20d447e2f842bf385c23d98e13bde9ee7ed1353ba4a55fe91993b2ad946a13fcdf9fe29b0ab5b1589d53a4083a1c4dc79b781e8a8cacaf517128b1d97f7fd6767234cb1582c0f17773eb96441e261058e016851d43604ea5d98e81a192e16672553b3b123481596a7526742716f25b502bd39effb570008663916002093c9ccd752f941004747d58ac8448c7070b65058ef205a43e35a076814994c663e14375656add7e57dff0b70d41c0090cd6647a82dfe6951ac89aa65e67625ba15f60119c91aa4423251be064077549d2a6edce4fbd7a106236cb3d9ecb8909e2d8227a2abe988e5a9d419b31eaac1d92748053ccfdb9f450722bf080b1ed9b479e024d4f80bb0e7798918e8c5e8f160ba71a99fea5b8bb56537c91a8f1d412a1007ae8c6a0e01de8c95dbcf431d5c1df27d7fa70674a64023fef169c5666fe07437a91a93354884be257d7305b828aa8ea1976e18dab0cd45a64ae407f32f30f0cda83a52bdc2459e46650d12617ccede53193437ac46551edde4fb0fb9ca54a97dc7c6beaac05ba145c487a4d3e9558e22351c6b9028a49f8b2a89315f833a7cecf5952d5bf640f14f51751ce8d92ef234226b90109ee725000abdafa02a6b370e0cfcda55a66a8d96c6ff0dc08ed0229553dda4693cd62021e2424722e23d22e5db1dc59992a1a1a1bd0afc7b6811736f2a95f21c456a28d6206158438f1e2232de31d6f980ab3853452af744d5c4853ee9224ba3b10609d71ff622333fbd7eebfaddaec24cd5d242fa79111909ab5168e8efdaaaac4142886a6fd8ebaa58eb2acb74acc5da32837f155a445a5f8f0bd7096b90492493c9054cbc24b488f4554771a68fc3b30aa8e2e74a5a8935c8243a88a2277a0b621b1c44991102bc11f63a5730ceac1559834ca25cc1f4a0daa65b5d64990931e1a8ac733ccfdbc7499806620d32090a82d0bbe700303636b6cb459699a02c9564b506790f6b90c935d54867228abcd3afaa4df53bcf046b9049682c16f9893b67ce9cc8a34cdd08687e5489888cb988d248ac41261197e853122a95c2af72d51161591c51323a383838ea244c03b10699c468106c89aa51ae7066933a4040e83d1d01865c656924d62093181c1cdc21d0f0e73bb4cee6e20d159e9581bcab248dc41a24048342ef1d1061b5ab2cd3b11aabe3221231d6aa816e7a3a640d124ad785be2c387cd57efbedeb28cc94bde90d7c9499c3bfa42b85ffae2dca1a24dc2f435f65ecb3aba3e3144759a62c003e1b5553267dca459646630d12a2a4ba16114f0a32f1f98ee24cc9bb77c7239e18d48dbeef0fb8c8d368ac4142140a8561441d4580a3d34bd31f7391672ada80f319147589f74127611a9035480425dc1555c331bdc645966a7577777706aaff1055c7514f1cb6306b90086d1d1d0f28b027a2ec8474327da293405598d3d6f145265e1651b66ea3efffd649a006640d12e18d37ded805c5ad5175acc12dc964b29af5426655c6f30e5695aba2ea44a5c2f9865b93354805da34f8a6884c8416312763c01da883418e994c667e00dcc7cced617502cd2e5cb2e43e57b91a91ad0f5281ed2323bb162d482c06e8e361754474e0c244d73ec3c5e22f5c657bafbebebef6f2d8d81a025572e1e0d2f5afbf6eeba987b02348853416bb062291e3b300babac7f322bf18cf86fefefeb6d1ddbbef02e8b8a85a019ec9f97e456b9db4323b8254687878783cb120f11681fe32aa9640c72e4874cd1d2e161f87a31917fb96f4cddd3531f2201345deb814911249eca4e191e1dfbbc8d6c8ac41aab0b3587c35d135ff40a2e8418a043a6ce1fcc4214bf6fdc0a3db776fdf3b9bb9962f5bf6e1723c788c199fa86c0bfa626e73deee7d54a0e65f281b4d2693991f944aeb1894a970932152fa42b690ff3166f868d2d7d7d73eb667cf9504fa0a2a5d8eba4ed63069147604a9d28e1d3bc617ce5bf44b42700e882a79867b1e089f49cc4f1cb978616260c7ce9dfe7433acc6ea387b384bc627ee25e23301b455b29d0a5e0f584f28168bf6605485ec083245e965e94f32f4e7e02a273a50795e88eeec2895eefbdd5b6f6daf66d315c9644f003e47099faf667d74e09d057e047a848db9aa8e35c834f478dea749e8feaa9be41d0ae045553c49a0f5ccba418260bbb6b5ed8a97cbb1522c362fa6babf0a7a957495027f5ec569dd7b77f456003dc6f7fddf4d65fb56660d324d3dcb7a8e20c84fc148d43acbfb12792346387e43a1604f0c4e81dd0799a6dce6dcaf88e47008eaeed359557e3eae729835c7d4d997f419b0a358dcdadd71c00fcb6d13cb08f467b5ce032050c5b5b9827fe1c8c8c8ac5e626e76768a35b368b9e79d4ca23729478ea29d15227889492ed85428d823b433c04eb16650c6f30e15e054615e58ab0c445202f823dddddd9db5cad04cec08327d9c4e264f25e02a223eb4d661fec030a0dfd758ec5bb95cce86944c9135c8d4513a993c8d89ae8d9a73aac646a1b835566aff5a3dade3de28ac41a620bd34fd318ee98d000eaf75964a89c80881bfce1df16f67b3d9f15ae76914d62055e8e9e9e942205f23e06234ea7b27f206982edae4fb5193511834ea1fb9067a92c96394e84e062d9db11f2a5214e64d0c0c41651bc07b85b4cc4a71007394741101dd024a33b068c6f60b40815be68e8d5efdca962d51cfdbb7346b90087d7d7ded63bbf7de40842ba7f37344a404f0d3ccba16c07365e0b7beefbf5de9f62bbb572e2eb5950e62924355f548523e728a435cfe9fca8680f98c8181017baa7012d62021962f5fbe4c26821f55fe9cc51f139109063f4c44f7a23df668369b0d5d8ab91adddddd9d9df18e6341380b8493014cedb2ae604c582fc9fbfeed3395ad9958834c22e3791f57d187c0fc81aa37162928f1bfb497276eaf76c4ee54643299f93a31f157505c06e6d0650e26a7df59eaa7fe6e2dd69667365d63b306791f9964faf44083bb99b9a3ba2d752394be9a58b2e8de75ebd69566275d28eef1bc9349f55a10af9ac2f63fdb3b317ec6d0d0900d4f799735c87b2c4fa62e00e15654f1de08b09da05f5ab078f16d356a8cf7e24c32fdd980f41b0c7cb09a0d0578265039f1dd69575b9e35c81fe849a62e27c277aad946a13f28ab5e5d8fff507d4bfae68e75eeb9864057a28a614502bc18a81c5b8fbf936bd620efca78dec50abaa5d27a01de84d2e7f3857ccde6c0aa543a9d3e8445ee066845159badd3181f93cbe58ab316ac01d8604500e964f29c6a9a43a13f2905e5558dd01c0090cfe79fefd8bbef47a0f2c32a36ebd792ac7977f98496d5f2cf83a497a58f03e33f0854d187852abe9c2bf89736da73165bf76e9d182e161f4a24bab610e82f50c18723115204ac1c2e161f80a3f9bdea4d4b3788e7790792ca634c1c39658e888c93d239b9cd03df4303ffb3ec2c167f9398bfe0595539998822afd211e8c30bba12325cdcb9d645be7ad3b2df417a7a7aba28085ea8e4bc5ca0bb19386993ef3fe1209a1319cf3b38507d94892b5beb9d70caa6818187663956dd69d5ef204425b9bda2e610d9c5c0a79aa9390020ebfb2fc589565736df308000777a9e979add54f5a7251b6479327d0918a755503a4a84e337f9feb3b31eaa0636fafeeb801e2340f4dd7e468285ee418b9d96b7d42f0b00a954aa97050f80108f280d44e5b47ca1f0b8936035323c32b27571a2eb4980ce41c40c8d4458b6607e62eff0c8cea71dc5abb9563b82c438c09d958c8225e8e5f942e1672e42d55ad6f79f53e8b995d42ae4fa159ef7a1d9ce542f5aaa4196279317122374111c0010e8f7b3beff5d1799ea45cef71f00f4faa83a666e2f0b7d172d7281a7654eb192c96437291e8cbab429829784f09962b1d872a35a878bc5a71626ba0e032874de5f22a41289ae0d3b8bc5ff7695ad565ae6081227fe2a33cf8f281b459ccef27d7fcc49a8fa1308f3b9028d9cdc81456f6885bbec2dd120e9747a1501e74716aa5c95cfe737388854b7f2f9fc16a85e1859c89c8c295dee20524db544832008ae47f439f3d39b0a85efb98853eff285c2fd1044ae40a5a457f52de99beb2253ad347d83643cef60263e39a24c34e00b61ab2efd1fd6f2650042c79b3168f1d89cbd17398a54134ddf200244ae38ab8a7fcd0de65e7591a7516c1c1c7c531537441612feb6bfbfbfa215ae1a515337484f4f4f326a555a05f620ced7b9cad448464be3df0230145643c001c3dbb69dee2892734ddd2014041723ea52b6e2269bbbf6fd0d0d0ded85d2d7a3ea0874898b3cb5d0b40dd2dfdfdf06d1bf8e281be5f6f88d4e0235a87129dd0691a80f90c3d3e9f44a27811c6bda06d9b96ddb095153f6a8e28e6c36bbd555a64634383838aac43747d551a0e7b9c8e35ad33688026747d530a4e2c76c5b99c6e807efcc0c1952437a069a70f84953364877777727814e0cafd2a7b285c27a37891a5b3e9fdf424c6bc26a189449a55253998babae35658374c63b8e45d4549cca77b949d31cb482f72ba67a828b2c2e35658380707cd8cb022d9710dcef2a4e3358b864e1a30042e7c952d54f398ae34c5336881042ff500c3c6193a25567ddba7525853e1c56a3448737dbda884dd720bdcb961dc040e8706d055ae241a8994644a1ef1b83e2733b3a3eea2a8f0b4dd72001c5a397450b620d31e15bbda178fcbfa26a02d5c35c6471a5e91a4449a23ec176e40673af3909d364b2d9ec5615bc1e56a3aa07b9cae342d3358828855f6a14fc1a0d3cf15bad11e1b9f002fe5347519c68ba060169e892cc4a78c955942615f1fee9cad5581d35634cc368aa06f13c6f9fa8453695d44eafa68334f4b10006c5fd945fd59a24f5aca91a8499939145016f7410a56951b92df2fd8ba9a65d6471a1b91a44e480c8a236141c44695ad937b34391e3b280fd5de5996d4d73ae0800a4bc5829fcfb378bbebdbcf5a698758a5467744df75a6aaa23884217d63a8301146c0d528f14d1538a1a27aa5c1db87e355583a089fe300d4d9be7efd0540d42a4366d4f1d20d6a0d619664a533588aa86dfe5354e2822eeb63790a66a905ca1f00c04ff59eb1c2d4de5f99cefffa4d631664a533508008d77769c09c13db50ed29af4616a6f3f1140d39c6235dd43f6ff6bc5d2a51f2c535b1fb3b4cc120fb542445252dde0fbfe40adb318638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c693aff03a590f2a588b250080000000049454e44ae426082),
(2, 's1mple', '$2y$10$QUVYtBaatiDNL3aEsJJdleM6aIBwUaj2ZccT7hXcqGLvvzJhSc7dm', 's1mple@gmail.com', 'Олександр', 'Костилів', 0x89504e470d0a1a0a0000000d49484452000000c8000000c80806000000ad58ae9e0000000473424954080808087c086488000000097048597300000b1300000b1301009a9c180000119049444154789ceddd7b9064757507f0ef39dd33c30ebb3bbd2f6170b76ff76cef0e8ec9061c050564c3cb0a02c523c84388185254f1365021a48ccac3524caa1485a041c3438a224804164552884416e421b8200416d9eded9edb3b30acfb98edd9c73cbaef39f9039228c5dcdb3d8f5fbfcee7df3e77ee777ae6f4bd7defeffe7e8031c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618d36ca8d6010c008056edb75fe7aececeb95ce279aa4ab40f8dedbb7bf78e57b66cd953eb70adcc1ac4b1d5581d7f2be5f707aa47a9ea41a4dc4b8c95003adf770391a28073c4fa2a29bdc0a44f6df4fd9701a8d3e02dca1ac481d5581ddfec0d1c474a9f1395139879deb47ea0e06d10d628e4ee5ca1f00cac59668d35c82ceae9e9e9a220b804429781b1ff6cec4380f5acf836b5c7efca66b3e3b3b18f56660d320b962e5d3aa79de37f4f2a5780b9cbc53e456533117d25e7fb77011017fb6c05d620332c9d4c9e40c4371390ae4d027d2120ba606060e0e5daecbfb95883cc90eeeeeece39ed1d3711f037b5ce22d032015fcef9fe3fc38e26d3620d320352a9546f4cf5c700fd49adb3fc11c12365d6737cdfdf59eb288dca1a649a56a452878ae211000b6b9de5fda8e07589e1f8818101bfd6591a9135c834a497a58f63d63598ec1e4614955794f82985be06e58d3192ed528eed9636610e789e52793f26ea85ea2a288e0273722abb1195cd2c6d476f1adc949d52ce16660d3245cb3def13003d0e604e551b8abcace03b02d61ff9beff76155b92e779bd31a57395f43c062dad6ab72a9b291e3f2297cb15aacadbe2ac41a66085e77d48404f035850c5664f13e1faecc0c06398e68dbdfefefeb6e16ddbce55d09718e8a9743b015ea3181f9ecbe58ad3d97f2bb106a9526f6fefbcf2e8e86f40bcb2a20d447e2f842bf385c23d98e13bde9ee7ed1353ba4a55fe91993b2ad946a13fcdf9fe29b0ab5b1589d53a4083a1c4dc79b781e8a8cacaf517128b1d97f7fd6767234cb1582c0f17773eb96441e261058e016851d43604ea5d98e81a192e16672553b3b123481596a7526742716f25b502bd39effb570008663916002093c9ccd752f941004747d58ac8448c7070b65058ef205a43e35a076814994c663e14375656add7e57dff0b70d41c0090cd6647a82dfe6951ac89aa65e67625ba15f60119c91aa4423251be064077549d2a6edce4fbd7a106236cb3d9ecb8909e2d8227a2abe988e5a9d419b31eaac1d92748053ccfdb9f450722bf080b1ed9b479e024d4f80bb0e7798918e8c5e8f160ba71a99fea5b8bb56537c91a8f1d412a1007ae8c6a0e01de8c95dbcf431d5c1df27d7fa70674a64023fef169c5666fe07437a91a93354884be257d7305b828aa8ea1976e18dab0cd45a64ae407f32f30f0cda83a52bdc2459e46650d12617ccede53193437ac46551edde4fb0fb9ca54a97dc7c6beaac05ba145c487a4d3e9558e22351c6b9028a49f8b2a89315f833a7cecf5952d5bf640f14f51751ce8d92ef234226b90109ee725000abdafa02a6b370e0cfcda55a66a8d96c6ff0dc08ed0229553dda4693cd62021e2424722e23d22e5db1dc59992a1a1a1bd0afc7b6811736f2a95f21c456a28d6206158438f1e2232de31d6f980ab3853452af744d5c4853ee9224ba3b10609d71ff622333fbd7eebfaddaec24cd5d242fa79111909ab5168e8efdaaaac4142886a6fd8ebaa58eb2acb74acc5da32837f155a445a5f8f0bd7096b90492493c9054cbc24b488f4554771a68fc3b30aa8e2e74a5a8935c8243a88a2277a0b621b1c44991102bc11f63a5730ceac1559834ca25cc1f4a0daa65b5d64990931e1a8ac733ccfdbc7499806620d32090a82d0bbe700303636b6cb459699a02c9564b506790f6b90c935d54867228abcd3afaa4df53bcf046b9049682c16f9893b67ce9cc8a34cdd08687e5489888cb988d248ac41261197e853122a95c2af72d51161591c51323a383838ea244c03b10699c468106c89aa51ae7066933a4040e83d1d01865c656924d62093181c1cdc21d0f0e73bb4cee6e20d159e9581bcab248dc41a24048342ef1d1061b5ab2cd3b11aabe3221231d6aa816e7a3a640d124ad785be2c387cd57efbedeb28cc94bde90d7c9499c3bfa42b85ffae2dca1a24dc2f435f65ecb3aba3e3144759a62c003e1b5553267dca459646630d12a2a4ba16114f0a32f1f98ee24cc9bb77c7239e18d48dbeef0fb8c8d368ac4142140a8561441d4580a3d34bd31f7391672ada80f319147589f74127611a9035480425dc1555c331bdc645966a7577777706aaff1055c7514f1cb6306b90086d1d1d0f28b027a2ec8474327da293405598d3d6f145265e1651b66ea3efffd649a006640d12e18d37ded805c5ad5175acc12dc964b29af5426655c6f30e5695aba2ea44a5c2f9865b93354805da34f8a6884c8416312763c01da883418e994c667e00dcc7cced617502cd2e5cb2e43e57b91a91ad0f5281ed2323bb162d482c06e8e361754474e0c244d73ec3c5e22f5c657bafbebebef6f2d8d81a025572e1e0d2f5afbf6eeba987b02348853416bb062291e3b300babac7f322bf18cf86fefefeb6d1ddbbef02e8b8a85a019ec9f97e456b9db4323b8254687878783cb120f11681fe32aa9640c72e4874cd1d2e161f87a31917fb96f4cddd3531f2201345deb814911249eca4e191e1dfbbc8d6c8ac41aab0b3587c35d135ff40a2e8418a043a6ce1fcc4214bf6fdc0a3db776fdf3b9bb9962f5bf6e1723c788c199fa86c0bfa626e73deee7d54a0e65f281b4d2693991f944aeb1894a970932152fa42b690ff3166f868d2d7d7d73eb667cf9504fa0a2a5d8eba4ed63069147604a9d28e1d3bc617ce5bf44b42700e882a79867b1e089f49cc4f1cb978616260c7ce9dfe7433acc6ea387b384bc627ee25e23301b455b29d0a5e0f584f28168bf6605485ec083245e965e94f32f4e7e02a273a50795e88eeec2895eefbdd5b6f6daf66d315c9644f003e47099faf667d74e09d057e047a848db9aa8e35c834f478dea749e8feaa9be41d0ae045553c49a0f5ccba418260bbb6b5ed8a97cbb1522c362fa6babf0a7a957495027f5ec569dd7b77f456003dc6f7fddf4d65fb56660d324d3dcb7a8e20c84fc148d43acbfb12792346387e43a1604f0c4e81dd0799a6dce6dcaf88e47008eaeed359557e3eae729835c7d4d997f419b0a358dcdadd71c00fcb6d13cb08f467b5ce032050c5b5b9827fe1c8c8c8ac5e626e76768a35b368b9e79d4ca23729478ea29d15227889492ed85428d823b433c04eb16650c6f30e15e054615e58ab0c445202f823dddddd9db5cad04cec08327d9c4e264f25e02a223eb4d661fec030a0dfd758ec5bb95cce86944c9135c8d4513a993c8d89ae8d9a73aac646a1b835566aff5a3dade3de28ac41a620bd34fd318ee98d000eaf75964a89c80881bfce1df16f67b3d9f15ae76914d62055e8e9e9e942205f23e06234ea7b27f206982edae4fb5193511834ea1fb9067a92c96394e84e062d9db11f2a5214e64d0c0c41651bc07b85b4cc4a71007394741101dd024a33b068c6f60b40815be68e8d5efdca962d51cfdbb7346b90087d7d7ded63bbf7de40842ba7f37344a404f0d3ccba16c07365e0b7beefbf5de9f62bbb572e2eb5950e62924355f548523e728a435cfe9fca8680f98c8181017baa7012d62021962f5fbe4c26821f55fe9cc51f139109063f4c44f7a23df668369b0d5d8ab91adddddd9d9df18e6341380b8493014cedb2ae604c582fc9fbfeed3395ad9958834c22e3791f57d187c0fc81aa37162928f1bfb497276eaf76c4ee54643299f93a31f157505c06e6d0650e26a7df59eaa7fe6e2dd69667365d63b306791f9964faf44083bb99b9a3ba2d752394be9a58b2e8de75ebd69566275d28eef1bc9349f55a10af9ac2f63fdb3b317ec6d0d0900d4f799735c87b2c4fa62e00e15654f1de08b09da05f5ab078f16d356a8cf7e24c32fdd980f41b0c7cb09a0d0578265039f1dd69575b9e35c81fe849a62e27c277aad946a13f28ab5e5d8fff507d4bfae68e75eeb9864057a28a614502bc18a81c5b8fbf936bd620efca78dec50abaa5d27a01de84d2e7f3857ccde6c0aa543a9d3e8445ee066845159badd3181f93cbe58ab316ac01d8604500e964f29c6a9a43a13f2905e5558dd01c0090cfe79fefd8bbef47a0f2c32a36ebd792ac7977f98496d5f2cf83a497a58f03e33f0854d187852abe9c2bf89736da73165bf76e9d182e161f4a24bab610e82f50c18723115204ac1c2e161f80a3f9bdea4d4b3788e7790792ca634c1c39658e888c93d239b9cd03df4303ffb3ec2c167f9398bfe0595539998822afd211e8c30bba12325cdcb9d645be7ad3b2df417a7a7aba28085ea8e4bc5ca0bb19386993ef3fe1209a1319cf3b38507d94892b5beb9d70caa6818187663956dd69d5ef204425b9bda2e610d9c5c0a79aa9390020ebfb2fc589565736df308000777a9e979add54f5a7251b6479327d0918a755503a4a84e337f9feb3b31eaa0636fafeeb801e2340f4dd7e468285ee418b9d96b7d42f0b00a954aa97050f80108f280d44e5b47ca1f0b8936035323c32b27571a2eb4980ce41c40c8d4458b6607e62eff0c8cea71dc5abb9563b82c438c09d958c8225e8e5f942e1672e42d55ad6f79f53e8b995d42ae4fa159ef7a1d9ce542f5aaa4196279317122374111c0010e8f7b3beff5d1799ea45cef71f00f4faa83a666e2f0b7d172d7281a7654eb192c96437291e8cbab429829784f09962b1d872a35a878bc5a71626ba0e032874de5f22a41289ae0d3b8bc5ff7695ad565ae6081227fe2a33cf8f281b459ccef27d7fcc49a8fa1308f3b9028d9cdc81456f6885bbec2dd120e9747a1501e74716aa5c95cfe737388854b7f2f9fc16a85e1859c89c8c295dee20524db544832008ae47f439f3d39b0a85efb98853eff285c2fd1044ae40a5a457f52de99beb2253ad347d83643cef60263e39a24c34e00b61ab2efd1fd6f2650042c79b3168f1d89cbd17398a54134ddf200244ae38ab8a7fcd0de65e7591a7516c1c1c7c531537441612feb6bfbfbfa215ae1a515337484f4f4f326a555a05f620ced7b9cad448464be3df0230145643c001c3dbb69dee2892734ddd2014041723ea52b6e2269bbbf6fd0d0d0ded85d2d7a3ea0874898b3cb5d0b40dd2dfdfdf06d1bf8e281be5f6f88d4e0235a87129dd0691a80f90c3d3e9f44a27811c6bda06d9b96ddb095153f6a8e28e6c36bbd555a64634383838aac43747d551a0e7b9c8e35ad33688026747d530a4e2c76c5b99c6e807efcc0c1952437a069a70f84953364877777727814e0cafd2a7b285c27a37891a5b3e9fdf424c6bc26a189449a55253998babae35658374c63b8e45d4549cca77b949d31cb482f72ba67a828b2c2e35658380707cd8cb022d9710dcef2a4e3358b864e1a30042e7c952d54f398ae34c5336881042ff500c3c6193a25567ddba7525853e1c56a3448737dbda884dd720bdcb961dc040e8706d055ae241a8994644a1ef1b83e2733b3a3eea2a8f0b4dd72001c5a397450b620d31e15bbda178fcbfa26a02d5c35c6471a5e91a4449a23ec176e40673af3909d364b2d9ec5615bc1e56a3aa07b9cae342d3358828855f6a14fc1a0d3cf15bad11e1b9f002fe5347519c68ba060169e892cc4a78c955942615f1fee9cad5581d35634cc368aa06f13c6f9fa8453695d44eafa68334f4b10006c5fd945fd59a24f5aca91a8499939145016f7410a56951b92df2fd8ba9a65d6471a1b91a44e480c8a236141c44695ad937b34391e3b280fd5de5996d4d73ae0800a4bc5829fcfb378bbebdbcf5a698758a5467744df75a6aaa23884217d63a8301146c0d528f14d1538a1a27aa5c1db87e355583a089fe300d4d9be7efd0540d42a4366d4f1d20d6a0d619664a533588aa86dfe5354e2822eeb63790a66a905ca1f00c04ff59eb1c2d4de5f99cefffa4d631664a533508008d77769c09c13db50ed29af4616a6f3f1140d39c6235dd43f6ff6bc5d2a51f2c535b1fb3b4cc120fb542445252dde0fbfe40adb318638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c31c618638c693aff03a590f2a588b250080000000049454e44ae426082);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Індекси таблиці `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Індекси таблиці `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Індекси таблиці `news_tags`
--
ALTER TABLE `news_tags`
  ADD KEY `news_id` (`news_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Індекси таблиці `read_later`
--
ALTER TABLE `read_later`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `news_id` (`news_id`);

--
-- Індекси таблиці `recent_views`
--
ALTER TABLE `recent_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `news_id` (`news_id`);

--
-- Індекси таблиці `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT для таблиці `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблиці `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблиці `read_later`
--
ALTER TABLE `read_later`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблиці `recent_views`
--
ALTER TABLE `recent_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT для таблиці `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `admin_logs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `news_tags`
--
ALTER TABLE `news_tags`
  ADD CONSTRAINT `news_tags_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  ADD CONSTRAINT `news_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `read_later`
--
ALTER TABLE `read_later`
  ADD CONSTRAINT `read_later_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  ADD CONSTRAINT `read_later_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Обмеження зовнішнього ключа таблиці `recent_views`
--
ALTER TABLE `recent_views`
  ADD CONSTRAINT `recent_views_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`),
  ADD CONSTRAINT `recent_views_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
