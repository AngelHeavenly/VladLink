-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 03 2021 г., 10:24
-- Версия сервера: 10.5.11-MariaDB
-- Версия PHP: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `categories`
--

-- --------------------------------------------------------

--
-- Структура таблицы `catalog`
--

CREATE TABLE `catalog` (
  `id` int(10) NOT NULL,
  `name` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `childrens` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `catalog`
--

INSERT INTO `catalog` (`id`, `name`, `alias`, `childrens`) VALUES
(1, 'Пользователи', 'users', 'Создание'),
(2, 'Заявки', 'requests', 'Заявки на поключение'),
(3, 'Отчёты', 'reports', 'Отдел маркетинга');

-- --------------------------------------------------------

--
-- Структура таблицы `fourth_advent`
--

CREATE TABLE `fourth_advent` (
  `id` int(10) NOT NULL,
  `name` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `childrens` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `second_advent`
--

CREATE TABLE `second_advent` (
  `id` int(10) NOT NULL,
  `name` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `childrens` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `second_advent`
--

INSERT INTO `second_advent` (`id`, `name`, `alias`, `childrens`) VALUES
(1, 'Создание', 'create', ''),
(2, 'Список', 'list', 'Array'),
(3, 'Поиск', 'search', ''),
(4, 'Заявки на поключение', 'connecting', ''),
(5, 'Заявки на ремонт', 'repairs', ''),
(6, 'Заявки на обход', 'round', ''),
(7, 'Отдел маркетинга', 'marketing', 'Array'),
(8, 'Управление', 'control', 'Array');

-- --------------------------------------------------------

--
-- Структура таблицы `third_advent`
--

CREATE TABLE `third_advent` (
  `id` int(10) NOT NULL,
  `name` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `childrens` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `third_advent`
--

INSERT INTO `third_advent` (`id`, `name`, `alias`, `childrens`) VALUES
(1, 'Отчёт по подключениям', 'connecting', ''),
(2, 'Активные', 'active', ''),
(3, 'Удаленные', 'deleted', ''),
(4, 'Отчёт по расходам', 'costs', ''),
(5, 'Отчёт по списаниям', 'write-offs', ''),
(6, 'Годовой отчёт', 'year', ''),
(7, 'Отчёт по эффективности работы', 'efficiency', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `name` (`name`) USING HASH,
  ADD KEY `childrens` (`childrens`(768));

--
-- Индексы таблицы `fourth_advent`
--
ALTER TABLE `fourth_advent`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `second_advent`
--
ALTER TABLE `second_advent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING HASH;

--
-- Индексы таблицы `third_advent`
--
ALTER TABLE `third_advent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`) USING HASH;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `fourth_advent`
--
ALTER TABLE `fourth_advent`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `second_advent`
--
ALTER TABLE `second_advent`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `third_advent`
--
ALTER TABLE `third_advent`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
