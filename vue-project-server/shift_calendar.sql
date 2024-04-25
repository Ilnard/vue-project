-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 25 2024 г., 06:52
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shift calendar`
--

-- --------------------------------------------------------

--
-- Структура таблицы `2024-04-12`
--

CREATE TABLE `2024-04-12` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `reason` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `2024-04-12`
--

INSERT INTO `2024-04-12` (`id`, `order_id`, `member_id`, `hours`, `reason`) VALUES
(1, 24, 2, 0, NULL),
(2, 24, 1, 0, NULL),
(3, 26, 2, 0, NULL),
(4, 26, 3, 0, NULL),
(5, 26, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `2024-04-23`
--

CREATE TABLE `2024-04-23` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `reason` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `2024-04-25`
--

CREATE TABLE `2024-04-25` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `reason` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `2024-04-25`
--

INSERT INTO `2024-04-25` (`id`, `order_id`, `member_id`, `hours`, `reason`) VALUES
(1, 26, 2, 500, NULL),
(2, 26, 3, 0, 'Больничный'),
(3, 26, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `2024-04-26`
--

CREATE TABLE `2024-04-26` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `member_id` int DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `reason` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `2024-04-26`
--

INSERT INTO `2024-04-26` (`id`, `order_id`, `member_id`, `hours`, `reason`) VALUES
(1, 26, 2, 0, NULL),
(2, 26, 3, 0, NULL),
(3, 26, 1, 0, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `2024-04-12`
--
ALTER TABLE `2024-04-12`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `2024-04-23`
--
ALTER TABLE `2024-04-23`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `2024-04-25`
--
ALTER TABLE `2024-04-25`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `2024-04-26`
--
ALTER TABLE `2024-04-26`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `2024-04-12`
--
ALTER TABLE `2024-04-12`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `2024-04-23`
--
ALTER TABLE `2024-04-23`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `2024-04-25`
--
ALTER TABLE `2024-04-25`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `2024-04-26`
--
ALTER TABLE `2024-04-26`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
