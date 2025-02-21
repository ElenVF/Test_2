-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 22 2025 г., 01:13
-- Версия сервера: 8.0.24
-- Версия PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `testovoe`
--

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE `history` (
  `id` int NOT NULL,
  `text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `list_error` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Ошибок не найдено',
  `lang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `history`
--

INSERT INTO `history` (`id`, `text`, `created_at`, `list_error`, `lang`) VALUES
(9, 'ыфвjjbhj', '2025-02-21 20:45:36', 'ы, ф, в', 'Английский'),
(10, 'апяквпFHGH', '2025-02-21 20:52:51', 'F, H, G', 'Русский'),
(11, 'ммрпрмрРМПппыукацу', '2025-02-21 21:04:38', '', 'Русский'),
(12, 'fzsetszgNJNK', '2025-02-21 21:05:51', 'Ошибок не найдено', 'Английский'),
(13, 'рироиромРРР', '2025-02-21 21:06:13', 'Ошибок не найдено', 'Русский'),
(14, 'adssaьлдьдл', '2025-02-21 21:19:49', 'a, d, s', 'Русский'),
(15, 'sdsdsППП', '2025-02-21 21:36:13', 'П', 'Английский'),
(16, 'sdsdsППП', '2025-02-21 21:36:17', 'П', 'Английский'),
(17, 'sdsdsППП', '2025-02-21 21:36:19', 'П', 'Английский'),
(18, 'sdsdsППП', '2025-02-21 21:39:17', 'П', 'Английский'),
(19, 'sdsdsППП', '2025-02-21 21:39:19', 'П', 'Английский'),
(20, 'sdsds', '2025-02-21 21:39:36', 'Ошибок не найдено', 'Английский'),
(21, 'sdsds', '2025-02-21 21:39:39', 'Ошибок не найдено', 'Английский'),
(22, 'sdsds', '2025-02-21 21:39:42', 'Ошибок не найдено', 'Английский'),
(23, 'sdsds', '2025-02-21 21:39:44', 'Ошибок не найдено', 'Английский'),
(24, 'sdsds', '2025-02-21 21:39:47', 'Ошибок не найдено', 'Английский'),
(25, 'dfsssssssssssРГИРИ', '2025-02-21 21:40:15', 'Р, Г, И', 'Английский'),
(26, 'выатлотМПпрsdfser', '2025-02-21 21:41:35', 's, d, f, e, r', 'Русский'),
(27, 'drtxlknkGVGHVGHsdfфвцкв', '2025-02-21 21:49:22', 'ф, в, ц, к', 'Английский'),
(28, 'drtxlknkGVGHVGHsdfфвцкв', '2025-02-21 21:49:26', 'ф, в, ц, к', 'Английский'),
(29, 'sdaТОЛиол', '2025-02-21 21:50:49', 's, d, a', 'Русский'),
(30, 'bjbl;lml', '2025-02-21 21:51:08', 'Ошибок не найдено', 'Английский'),
(31, 'scdzfотлтолт', '2025-02-21 22:09:14', 's, c, d, z, f', 'Русский'),
(32, 'zdfesfd HBJHJблысьл', '2025-02-21 22:12:24', 'б, л, ы, с, ь', 'Английский');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `history`
--
ALTER TABLE `history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
