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
-- База данных: `attachments`
--

-- --------------------------------------------------------

--
-- Структура таблицы `24`
--

CREATE TABLE `24` (
  `id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `allowed` tinyint(1) DEFAULT NULL,
  `pay` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `24`
--

INSERT INTO `24` (`id`, `member_id`, `allowed`, `pay`) VALUES
(1, 2, 1, 100),
(2, 1, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `26`
--

CREATE TABLE `26` (
  `id` int NOT NULL,
  `member_id` int DEFAULT NULL,
  `allowed` tinyint(1) DEFAULT NULL,
  `pay` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `26`
--

INSERT INTO `26` (`id`, `member_id`, `allowed`, `pay`) VALUES
(1, 2, 1, 500),
(2, 3, 1, 200),
(3, 1, 1, 100);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `24`
--
ALTER TABLE `24`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `26`
--
ALTER TABLE `26`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `24`
--
ALTER TABLE `24`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `26`
--
ALTER TABLE `26`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
