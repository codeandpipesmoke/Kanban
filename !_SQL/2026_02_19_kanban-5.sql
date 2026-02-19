-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Feb 19. 14:57
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `kanban-5`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `colors`
--

CREATE TABLE `colors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(20) NOT NULL,
  `pos` int(11) NOT NULL DEFAULT 1000,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `task_count` int(10) UNSIGNED DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Colors table';

--
-- A tábla adatainak kiíratása `colors`
--

INSERT INTO `colors` (`id`, `name`, `color`, `pos`, `visible`, `task_count`, `created`, `modified`) VALUES
(1, 'Alacsony', '#cccccc', 1000, 1, 1, '2026-02-17 13:04:17', '2026-02-19 09:45:04'),
(2, 'Normál', '#00cc66', 900, 1, 4, '2026-02-17 13:04:22', '2026-02-18 11:07:26'),
(3, 'Magas', '#ff3300', 1100, 1, 2, '2026-02-17 13:04:27', '2026-02-18 10:41:30');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cols`
--

CREATE TABLE `cols` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` varchar(50) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `pos` int(11) NOT NULL DEFAULT 1000,
  `task_count` int(10) UNSIGNED DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Cols table';

--
-- A tábla adatainak kiíratása `cols`
--

INSERT INTO `cols` (`id`, `project_id`, `name`, `status`, `visible`, `pos`, `task_count`, `created`, `modified`) VALUES
(1, 1, 'Új feladatok', 'new', 1, 1000, 2, '2026-02-17 13:35:06', '2026-02-18 08:08:28'),
(2, 1, 'Folyamatban', 'todo', 1, 1100, 1, '2026-02-17 13:36:30', '2026-02-17 13:37:22'),
(3, 1, 'Tesztelés alatt', 'test', 1, 1200, 0, '2026-02-17 13:36:59', '2026-02-17 13:37:34'),
(4, 1, 'Kész', 'done', 1, 1400, 0, '2026-02-17 13:37:46', '2026-02-19 13:47:25'),
(5, 1, 'Ügyfélre vár', 'delete', 1, 1300, 2, '2026-02-17 13:38:05', '2026-02-19 13:47:21'),
(6, 1, 'Töröltek', 'deleted', 0, 2000, 2, '2026-02-18 12:06:06', '2026-02-19 10:26:28');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comments`
--

CREATE TABLE `comments` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `text` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Comments table';

--
-- A tábla adatainak kiíratása `comments`
--

INSERT INTO `comments` (`id`, `task_id`, `user_id`, `text`, `created`, `modified`) VALUES
(1771493678720, 4, 2, 'Kész, csak meg kell figyelni, hogy hogy viselkedik majd éles környezetben.', '2026-02-19 09:35:11', '2026-02-19 09:35:11'),
(1771508993845, 19, 1, '2026.01.26 - legyűjtve (számlák 2025.12.31-ig)', '2026-02-19 13:52:29', '2026-02-19 13:54:08'),
(1771508993847, 19, 1, '2026.02.11 - legyűjtve (számlák 2026.02.11-ig)', '2026-02-19 13:52:48', '2026-02-19 13:54:15'),
(1771509276623, 19, 1, '2026.11.18. - értesítő levelek postára adva', '2026-02-19 13:55:01', '2026-02-19 13:55:01');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(2048) NOT NULL,
  `project` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `pos` int(11) NOT NULL DEFAULT 1000,
  `col_count` int(10) UNSIGNED DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Projects table';

--
-- A tábla adatainak kiíratása `projects`
--

INSERT INTO `projects` (`id`, `name`, `project`, `description`, `visible`, `pos`, `col_count`, `created`, `modified`) VALUES
(1, 'Napi teendők', 'kanbanlist', '<p>asdfasdf</p>', 1, 1000, 6, '2026-02-17 13:06:00', '2026-02-18 13:13:38'),
(2, 'Weboldal', 'satweb', '', 1, 1000, NULL, '2026-02-17 13:06:33', '2026-02-18 13:13:48');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `pos` int(11) NOT NULL DEFAULT 1000,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `task_count` int(10) UNSIGNED DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='TAGs table';

--
-- A tábla adatainak kiíratása `tags`
--

INSERT INTO `tags` (`id`, `name`, `pos`, `visible`, `task_count`, `created`, `modified`) VALUES
(1, 'Weboldal', 1000, 1, 4, '2026-02-17 13:13:05', '2026-02-17 13:13:05'),
(2, 'Számlázó', 1000, 1, NULL, '2026-02-17 13:13:12', '2026-02-17 13:13:12'),
(3, 'Agent', 1000, 1, 6, '2026-02-17 13:13:16', '2026-02-17 13:13:16'),
(4, 'Adatbázis', 1000, 1, 5, '2026-02-17 13:13:22', '2026-02-17 13:13:22'),
(5, 'Képújság', 1000, 1, 2, '2026-02-17 13:13:27', '2026-02-17 13:13:27'),
(6, 'Ügyintézés', 1000, 1, NULL, '2026-02-17 13:53:10', '2026-02-17 13:53:10');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tags_tasks`
--

CREATE TABLE `tags_tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  `task_id` int(10) UNSIGNED NOT NULL,
  `visible` tinyint(1) UNSIGNED NOT NULL,
  `pos` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='TAGS + TASKS';

--
-- A tábla adatainak kiíratása `tags_tasks`
--

INSERT INTO `tags_tasks` (`id`, `tag_id`, `task_id`, `visible`, `pos`, `created`, `modified`) VALUES
(7, 3, 4, 0, 0, '2026-02-18 09:33:27', '2026-02-18 09:33:27'),
(8, 4, 4, 0, 0, '2026-02-18 09:33:27', '2026-02-18 09:33:27'),
(9, 2, 5, 0, 0, '2026-02-18 09:41:38', '2026-02-18 09:41:38'),
(15, 6, 7, 0, 0, '2026-02-18 09:41:52', '2026-02-18 09:41:52'),
(19, 4, 5, 0, 0, '2026-02-18 11:07:56', '2026-02-18 11:07:56'),
(27, 3, 11, 0, 0, '2026-02-18 12:12:38', '2026-02-18 12:12:38'),
(28, 1, 12, 0, 0, '2026-02-18 12:26:05', '2026-02-18 12:26:05'),
(30, 3, 14, 0, 0, '2026-02-18 13:54:47', '2026-02-18 13:54:47'),
(31, 3, 15, 0, 0, '2026-02-18 13:57:49', '2026-02-18 13:57:49'),
(32, 3, 16, 0, 0, '2026-02-18 14:01:08', '2026-02-18 14:01:08'),
(33, 4, 16, 0, 0, '2026-02-18 14:01:08', '2026-02-18 14:01:08'),
(34, 5, 16, 0, 0, '2026-02-18 14:01:08', '2026-02-18 14:01:08'),
(35, 2, 7, 0, 0, '2026-02-18 14:14:33', '2026-02-18 14:14:33'),
(36, 1, 6, 0, 0, '2026-02-18 14:14:49', '2026-02-18 14:14:49'),
(37, 4, 12, 0, 0, '2026-02-18 14:15:02', '2026-02-18 14:15:02'),
(41, 1, 1, 0, 0, '2026-02-19 08:17:52', '2026-02-19 08:17:52'),
(42, 2, 1, 0, 0, '2026-02-19 08:17:52', '2026-02-19 08:17:52'),
(43, 3, 1, 0, 0, '2026-02-19 08:17:52', '2026-02-19 08:17:52'),
(47, 4, 6, 0, 0, '2026-02-19 10:16:01', '2026-02-19 10:16:01'),
(49, 5, 4, 0, 0, '2026-02-19 12:34:12', '2026-02-19 12:34:12'),
(52, 1, 18, 0, 0, '2026-02-19 12:49:47', '2026-02-19 12:49:47'),
(53, 4, 18, 0, 0, '2026-02-19 12:49:47', '2026-02-19 12:49:47'),
(54, 1, 13, 0, 0, '2026-02-19 13:14:24', '2026-02-19 13:14:24'),
(55, 4, 13, 0, 0, '2026-02-19 13:14:24', '2026-02-19 13:14:24'),
(56, 6, 19, 0, 0, '2026-02-19 13:49:47', '2026-02-19 13:49:47');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `col_id` int(10) UNSIGNED NOT NULL,
  `color_id` int(10) UNSIGNED NOT NULL,
  `position` int(11) DEFAULT 0,
  `name` varchar(1000) NOT NULL,
  `description` text DEFAULT NULL,
  `priority` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `visible` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `pos` int(11) NOT NULL DEFAULT 1000,
  `tag_count` int(10) UNSIGNED DEFAULT NULL,
  `comment_count` int(10) UNSIGNED DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci COMMENT='Tasks table';

--
-- A tábla adatainak kiíratása `tasks`
--

INSERT INTO `tasks` (`id`, `user_id`, `col_id`, `color_id`, `position`, `name`, `description`, `priority`, `deleted`, `visible`, `pos`, `tag_count`, `comment_count`, `created`, `modified`) VALUES
(4, 1, 5, 2, 0, 'Számlázóban Hitelkártya befizetéseket automatikusan elrakni, ne kerüljön a Csoportos befizetések közé', '', 0, 0, 1, 1000, 3, 0, '2026-02-17 13:15:06', '2026-02-19 13:48:19'),
(6, 3, 1, 2, 0, 'Új weboldal adatait, híreit minimálisan tudjam szerkeszteni ', '', 0, 0, 1, 1000, 2, 0, '2026-02-17 13:52:20', '2026-02-19 13:30:07'),
(11, 1, 1, 1, 0, 'MHB bank befizetések automatikus letöltése, beolvasása', '', 0, 0, 1, 1000, 2, 0, '2026-02-18 12:12:38', '2026-02-19 13:45:22'),
(12, 1, 6, 2, 0, 'Web oldalra - Telefon hívásvégződtetési díj.', '', 0, 1, 1, 1000, 2, 0, '2026-02-18 12:26:05', '2026-02-19 13:48:36'),
(13, 1, 6, 2, 1, 'Web oldalra - NMHH - MKSZ \"Online Hősök\" Gyekmekvédelmi Kampány. Részletek - #47136 munkalapszámon', '', 0, 1, 1, 1000, 1, 0, '2026-02-18 13:52:06', '2026-02-19 13:14:24'),
(18, 1, 2, 3, 0, 'Új weboldal felélesztése', '', 1, 0, 1, 1000, NULL, NULL, '2026-02-19 12:49:47', '2026-02-19 13:44:42'),
(19, 1, 5, 3, 1, 'Hátralékosok kezelése, legyűjtése, átnézése, felszólító kiküldése, átadása', NULL, 0, 0, 1, 1000, NULL, 3, '2026-02-19 13:49:47', '2026-02-19 13:55:01');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `value` (`name`),
  ADD KEY `pos` (`pos`);

--
-- A tábla indexei `cols`
--
ALTER TABLE `cols`
  ADD PRIMARY KEY (`id`),
  ADD KEY `header` (`name`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `visible` (`visible`);

--
-- A tábla indexei `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- A tábla indexei `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- A tábla indexei `tags_tasks`
--
ALTER TABLE `tags_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `task_id` (`task_id`);

--
-- A tábla indexei `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`name`),
  ADD KEY `priority` (`priority`),
  ADD KEY `visible` (`visible`),
  ADD KEY `deleted` (`deleted`),
  ADD KEY `pos` (`pos`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `position` (`position`),
  ADD KEY `user_id` (`user_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT a táblához `cols`
--
ALTER TABLE `cols`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `tags_tasks`
--
ALTER TABLE `tags_tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT a táblához `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
