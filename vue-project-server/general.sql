-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 22 2024 г., 15:37
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
-- База данных: `general`
--

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `patronymic` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `employmentdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `members`
--

INSERT INTO `members` (`id`, `name`, `surname`, `patronymic`, `birthdate`, `position`, `department`, `employmentdate`) VALUES
(1, 'Иван', 'Петров', 'Александрович', '1993-05-15', 'Разнорабочий', '', '2023-11-20'),
(2, 'Григорий', '', 'Алексеевич', '1980-01-05', 'Монтажник', 'Монтаж', '2015-04-10');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `number` int NOT NULL,
  `client` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `pay` double NOT NULL,
  `paid` double NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `number`, `client`, `title`, `datetime`, `pay`, `paid`, `status`) VALUES
(17, 123, 'Евгений', 'Постройка дома', '2024-03-13 16:19:26', 1000000, 500000, 'Не начата'),
(18, 455, 'Сергей', '', '2024-03-13 17:09:57', 500000, 100000, ''),
(19, 785498, 'Олег Антипов', 'Постройка гаража', '2024-03-19 12:00:00', 700000, 50000, 'Не начата');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
