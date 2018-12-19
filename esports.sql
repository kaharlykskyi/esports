-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Ноя 28 2018 г., 15:04
-- Версия сервера: 5.7.23-0ubuntu0.18.04.1
-- Версия PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `esports`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `login`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '$2y$13$fu6tTKkJhjNdac9tj96xOuHPBR1YyGaZPrASnjltWQXPVYzUMP7o2', '2018-11-06 11:11:49', '2018-11-06 11:11:49');

-- --------------------------------------------------------

--
-- Структура таблицы `forum_post`
--

CREATE TABLE `forum_post` (
  `id` int(11) NOT NULL,
  `forum_topic_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` text,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `forum_topic`
--

CREATE TABLE `forum_topic` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `num_schedule` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(3) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `logo` varchar(200) NOT NULL,
  `filed` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `games`
--

INSERT INTO `games` (`id`, `name`, `alias`, `logo`, `filed`) VALUES
(1, 'HearthStone', 'hearthstone', 'hart5-0.png', '[{\"name\":\"system\",\"class\":\"system_select\",\"title\":\"Game mode\",\"type\":\"select\",\"options\":[\"Bo1\",\"Bo3\",\"Bo5\"]},\n                {\"name\":\"validate\",\"title\":\"Require a Capture at the end of each game to validate the result?\",\"type\":\"checkbox\",\"options\":[\"1\"]},\n                {\"name\":\"game_mode\",\"title\":\"Game mode select\",\"class\":\"game_mode\",\"type\":\"select\",\"options\":[\" Conquist\",\"Last hero standing\"]}]'),
(2, 'Pokémon', 'pokemon', 'pokemon.png', '[{\"name\":\"system\",\"title\":\"Game mode\",\"type\":\"select\",\"options\":[\"Bo1\",\"Bo3\",\"Bo5\"]},{\"name\":\"format\",\"title\":\"Format\",\"type\":\"select\",\"options\":[\"VGC19\",\"OU\",\"Ubers\",\"Monotype\",\"Doubles OU\",\"Doubles Ubers\"]},{\"name\":\"console\",\"title\":\"Game console\",\"type\":\"select\",\"options\":[\"Nintendo 3DS\",\"Pokémon Showdown\"]}]'),
(3, 'World of Warcraft', 'wow', 'wow.png', '[{\"name\":\"system\",\"title\":\"System\",\"class\":\"sistem_wow\",\"type\":\"select\",\"options\":[\"Bo1\",\"Bo3\",\"Bo5\"]},{\"name\":\"format\",\"title\":\"Format\",\"class\":\"select_format\",\"type\":\"select\",\"options\":[\"PvP\",\"PvE\"]},\n                {\"name\":\"terrain\",\"title\":\"Terrain\",\"class\":\"terrain\",\"type\":\"select\",\"options\":[\"Arena\",\"Battleground\"]},\n            {\"name\":\"pvp\",\"title\":\"PvP\",\"class\":\"hidden_select2\",\"type\":\"select\",\"options\":[\"10vs10\", \"15vs15\", \"40vs40\"]},{\"name\":\"pvp\",\"title\":\"PvP\",\"class\":\"hidden_select1\",\"type\":\"select\",\"options\":[\"1vs1\", \"2vs2\", \"3vs3\", \"5vs5\"]}]');

-- --------------------------------------------------------

--
-- Структура таблицы `message_user`
--

CREATE TABLE `message_user` (
  `id` int(11) NOT NULL,
  `sender` int(11) DEFAULT NULL,
  `recipient` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `text` text,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message_user`
--

INSERT INTO `message_user` (`id`, `sender`, `recipient`, `title`, `text`, `created_at`, `updated_at`) VALUES
(11, 2, 17, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541607918, 1541607918),
(12, 2, 18, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541607952, 1541607952),
(13, 2, 26, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541607953, 1541607953),
(14, 2, 3, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541607990, 1541607990),
(15, 2, 27, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541607991, 1541607991),
(16, 2, 4, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608014, 1541608014),
(17, 2, 20, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608015, 1541608015),
(18, 2, 5, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608054, 1541608054),
(19, 2, 29, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608055, 1541608055),
(20, 2, 14, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608087, 1541608087),
(21, 2, 22, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608089, 1541608089),
(22, 2, 7, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608103, 1541608103),
(23, 2, 31, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608105, 1541608105),
(24, 2, 16, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608136, 1541608136),
(25, 2, 24, 'You have been chosen to participate in the tournament', '<p><b>Vasa</b> chose you to participate in tournament \n                            <a href=\"http://wow.esports/tournaments/api-string/7\" >Super Man</a></p><a href=\"http://wow.esports/tournaments/api-string/7\">http://wow.esports/tournaments/api-string/7</a>', 1541608137, 1541608137),
(26, 1, 77, 'Invitation to join the tournament', '<p>Invitation to enter the tournament for the player <b>User101</b> to confirm or reject the move click on the link <br> <a href=\"http://wow.esports/tournaments/invitation?tokin=35c4366b53ba3f6ad143584dc498bad2a5a895bd595bb4db&amp;tournament=8\">http://wow.esports/tournaments/invitation?tokin=35c4366b53ba3f6ad143584dc498bad2a5a895bd595bb4db&tournament=8</a></p>', 1542982373, 1542982373),
(27, 1, 79, 'Invitation to join the tournament', '<p>Invitation to enter the tournament for the player <b>User103</b> to confirm or reject the move click on the link <br> <a href=\"http://wow.esports/tournaments/invitation?tokin=0133b1685109a787afb9c904685481dd2b0e92d3e765cabd&amp;tournament=8\">http://wow.esports/tournaments/invitation?tokin=0133b1685109a787afb9c904685481dd2b0e92d3e765cabd&tournament=8</a></p>', 1542982376, 1542982376),
(28, 1, 78, 'Invitation to join the tournament', '<p>Invitation to enter the tournament for the player <b>User102</b> to confirm or reject the move click on the link <br> <a href=\"http://wow.esports/tournaments/invitation?tokin=8de7cbdff6277f836b5e66f16141bb7be41e5e78b3604f07&amp;tournament=8\">http://wow.esports/tournaments/invitation?tokin=8de7cbdff6277f836b5e66f16141bb7be41e5e78b3604f07&tournament=8</a></p>', 1542982378, 1542982378),
(29, 1, 80, 'Invitation to join the tournament', '<p>Invitation to enter the tournament for the player <b>User104</b> to confirm or reject the move click on the link <br> <a href=\"http://wow.esports/tournaments/invitation?tokin=8dde92829b56af0b6758efeeecf4daf493fad68ea924cdd2&amp;tournament=8\">http://wow.esports/tournaments/invitation?tokin=8dde92829b56af0b6758efeeecf4daf493fad68ea924cdd2&tournament=8</a></p>', 1542982380, 1542982380),
(30, 1, 77, 'You are participating in a tournament.', '<p> To participate in the tournament, enter the data <a href=\"http://wow.esports/tournaments/api-string/8\">http://wow.esports/tournaments/api-string/8</a> </p>', 1542982573, 1542982573),
(31, 1, 78, 'You are participating in a tournament.', '<p> To participate in the tournament, enter the data <a href=\"http://wow.esports/tournaments/api-string/8\">http://wow.esports/tournaments/api-string/8</a> </p>', 1542982855, 1542982855),
(32, 1, 79, 'You are participating in a tournament.', '<p> To participate in the tournament, enter the data <a href=\"http://wow.esports/tournaments/api-string/8\">http://wow.esports/tournaments/api-string/8</a> </p>', 1542983039, 1542983039),
(33, 1, 80, 'You are participating in a tournament.', '<p> To participate in the tournament, enter the data <a href=\"http://wow.esports/tournaments/api-string/8\">http://wow.esports/tournaments/api-string/8</a> </p>', 1542983227, 1542983227);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1541502664),
('m180730_102428_create_table_users', 1541502668),
('m180803_085539_create_table_games', 1541502669),
('m180803_085541_create_table_teams', 1541502672),
('m180803_085590_create_table_users_team', 1541502674),
('m180807_095103_isert_users', 1541502677),
('m180817_074620_create_table_tournaments', 1541502679),
('m180820_192430_create_table_tournament_team', 1541502682),
('m180820_192459_create_table_tournament_user', 1541502684),
('m180821_113143_create_table_tournamet_data', 1541502686),
('m180822_102459_create_table_streem', 1541502687),
('m180904_162853_insert_tournament', 1541502688),
('m180910_074140_table_forum_topic', 1541502691),
('m180910_084924_table_forum_post', 1541502693),
('m180910_111515_update_games', 1541502693),
('m180911_171240_table_schedule_teams', 1541502697),
('m180911_171250_table_schedule_post', 1541502700),
('m180912_154133_table_news_category', 1541502700),
('m180920_071232_table_uset_team_tournament', 1541502705),
('m180920_134806_table_message', 1541502707),
('m180927_105514_table_admins', 1541502709),
('m180927_134405_table_news', 1541502710),
('m181002_151233_add_players_team', 1541502779),
('m181003_082809_users_match', 1541502784),
('m181016_143520_table_results_statistics', 1541502786),
('m181018_152936_table_results_statistic_users', 1541502790),
('m181107_132355_column_users_sistem_bal', 1541598060),
('m181113_150853_table_point_user', 1542207040);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text,
  `logo` varchar(250) DEFAULT NULL,
  `state` int(3) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `news_category`
--

CREATE TABLE `news_category` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `results_statistics`
--

CREATE TABLE `results_statistics` (
  `id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `victories` int(11) DEFAULT '0',
  `loss` int(11) DEFAULT '0',
  `rate` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `results_statistics`
--

INSERT INTO `results_statistics` (`id`, `team_id`, `game_id`, `victories`, `loss`, `rate`, `created_at`, `updated_at`) VALUES
(3, 6, 1, 3, 5, 0, '2018-11-07 18:03:50', '2018-11-25 18:52:07'),
(4, 7, 1, 2, 6, 0, '2018-11-07 18:03:50', '2018-11-25 18:49:47'),
(5, 5, 1, 5, 3, 1, '2018-11-08 17:08:51', '2018-11-25 18:52:07'),
(6, 4, 1, 4, 4, 1, '2018-11-08 17:08:51', '2018-11-25 18:44:46'),
(7, 1, 1, 4, 2, 2, '2018-11-08 17:09:24', '2018-11-25 18:47:21'),
(8, 3, 1, 5, 3, 1, '2018-11-08 17:09:24', '2018-11-25 18:45:04'),
(9, 8, 1, 4, 1, 4, '2018-11-08 17:09:58', '2018-11-25 18:46:45'),
(10, 2, 1, 4, 7, 0, '2018-11-08 17:09:58', '2018-11-25 18:50:53');

-- --------------------------------------------------------

--
-- Структура таблицы `results_statistic_users`
--

CREATE TABLE `results_statistic_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `game_id` int(11) DEFAULT NULL,
  `victories` int(11) DEFAULT '0',
  `loss` int(11) DEFAULT '0',
  `rate` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `results_statistic_users`
--

INSERT INTO `results_statistic_users` (`id`, `user_id`, `team_id`, `game_id`, `victories`, `loss`, `rate`, `created_at`, `updated_at`) VALUES
(1, 31, 7, 1, 6, 2, 3, '2018-11-07 18:03:49', '2018-11-25 18:49:46'),
(2, 14, 6, 1, 5, 4, 1, '2018-11-07 18:03:49', '2018-11-25 18:52:07'),
(3, 7, 7, 1, 7, 2, 3, '2018-11-07 18:03:49', '2018-11-25 18:49:47'),
(4, 22, 6, 1, 5, 4, 1, '2018-11-07 18:03:49', '2018-11-25 18:52:07'),
(5, 4, 4, 1, 5, 4, 1, '2018-11-08 17:08:51', '2018-11-25 18:44:45'),
(6, 5, 5, 1, 3, 5, 0, '2018-11-08 17:08:51', '2018-11-25 18:52:07'),
(7, 20, 4, 1, 5, 4, 1, '2018-11-08 17:08:51', '2018-11-25 18:44:45'),
(8, 29, 5, 1, 3, 5, 0, '2018-11-08 17:08:51', '2018-11-25 18:52:07'),
(9, 27, 3, 1, 3, 4, 0, '2018-11-08 17:09:23', '2018-11-25 18:45:03'),
(10, 17, 1, 1, 2, 4, 0, '2018-11-08 17:09:23', '2018-11-25 18:47:21'),
(11, 3, 3, 1, 3, 6, 0, '2018-11-08 17:09:24', '2018-11-25 18:45:03'),
(12, 1, 1, 1, 2, 4, 0, '2018-11-08 17:09:24', '2018-11-25 18:47:20'),
(13, 18, 2, 1, 7, 4, 1, '2018-11-08 17:09:56', '2018-11-25 18:50:52'),
(14, 24, 8, 1, 1, 4, 0, '2018-11-08 17:09:56', '2018-11-25 18:46:45'),
(15, 26, 2, 1, 6, 4, 1, '2018-11-08 17:09:56', '2018-11-25 18:50:52'),
(16, 16, 8, 1, 1, 4, 0, '2018-11-08 17:09:56', '2018-11-25 18:46:45'),
(17, 77, 10, 1, 2, 0, 2, '2018-11-23 14:36:09', '2018-11-23 14:37:52'),
(18, 80, 13, 1, 0, 1, 0, '2018-11-23 14:36:10', '2018-11-23 14:36:10'),
(19, 78, 11, 1, 1, 1, 1, '2018-11-23 14:37:02', '2018-11-23 14:37:52'),
(20, 79, 12, 1, 0, 1, 0, '2018-11-23 14:37:02', '2018-11-23 14:37:02');

-- --------------------------------------------------------

--
-- Структура таблицы `schedule_post`
--

CREATE TABLE `schedule_post` (
  `id` int(11) NOT NULL,
  `schedule_teams_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` text,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `schedule_teams`
--

CREATE TABLE `schedule_teams` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `team1` int(11) DEFAULT NULL,
  `team2` int(11) DEFAULT NULL,
  `results1` int(11) DEFAULT NULL,
  `results2` int(11) DEFAULT NULL,
  `tur` int(11) DEFAULT NULL,
  `format` int(3) DEFAULT NULL,
  `status` int(3) DEFAULT NULL,
  `group` int(11) DEFAULT NULL,
  `active_result` int(3) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `schedule_teams`
--

INSERT INTO `schedule_teams` (`id`, `tournament_id`, `team1`, `team2`, `results1`, `results2`, `tur`, `format`, `status`, `group`, `active_result`, `date`) VALUES
(36, 8, 11, 10, NULL, NULL, 1, 1, NULL, NULL, NULL, '2018-11-23 17:24:00'),
(37, 8, 12, 13, NULL, NULL, 1, 1, NULL, NULL, NULL, '2018-11-23 17:24:00'),
(38, 7, 6, 8, 1, 0, 1, 2, NULL, 1, NULL, '2018-11-24 19:14:00'),
(39, 7, 4, 7, 0, 1, 1, 2, NULL, 1, NULL, '2018-11-24 19:14:00'),
(40, 7, 5, 1, 1, 0, 1, 2, NULL, 1, NULL, '2018-11-24 19:14:00'),
(41, 7, 2, 3, 1, 0, 1, 2, NULL, 1, NULL, '2018-11-24 19:14:00'),
(46, 7, 6, 7, 1, 0, 2, 2, NULL, 1, NULL, '2018-11-24 19:14:00'),
(47, 7, 5, 2, 1, 0, 2, 2, NULL, 1, NULL, '2018-11-24 19:14:00'),
(48, 7, 8, 4, 1, 0, 1, 2, NULL, 2, NULL, '2018-11-24 19:14:00'),
(49, 7, 1, 3, 1, 0, 1, 2, NULL, 2, NULL, '2018-11-24 19:14:00'),
(50, 7, 6, 5, 1, 0, 3, 2, NULL, 1, NULL, '2018-11-24 19:14:00'),
(51, 7, 2, 8, 1, 0, 2, 2, NULL, 2, NULL, '2018-11-24 19:14:00'),
(52, 7, 7, 1, 1, 0, 2, 2, NULL, 2, NULL, '2018-11-24 19:14:00'),
(53, 7, 2, 7, 1, 0, 3, 2, NULL, 2, NULL, '2018-11-24 19:14:00'),
(54, 7, 5, 2, 1, 0, 4, 2, NULL, 2, NULL, '2018-11-24 19:14:00'),
(55, 7, 6, 5, 1, 0, 1, 2, NULL, 3, NULL, '2018-11-21 19:14:00');

-- --------------------------------------------------------

--
-- Структура таблицы `stream`
--

CREATE TABLE `stream` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `stream_chanal` int(4) DEFAULT NULL,
  `stream_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(250) DEFAULT NULL,
  `logo` varchar(200) NOT NULL,
  `background` varchar(200) NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `capitan` int(11) DEFAULT NULL,
  `single_user` int(3) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teams`
--

INSERT INTO `teams` (`id`, `name`, `slug`, `logo`, `background`, `game_id`, `website`, `capitan`, `single_user`, `created_at`, `updated_at`) VALUES
(1, 'The Bears', 'the-bears', '/images/test_logo/logo1.png', '/images/test_logo/bac.png', 1, NULL, 2, NULL, 1534947950, 1534947950),
(2, 'Grasshoppers', 'grasshoppers', '/images/test_logo/logo2.png', '/images/test_logo/bac.png', 1, NULL, 2, NULL, 1534947950, 1534947950),
(3, 'Ancient Greeks', 'ancient-greeks', '/images/test_logo/logo3.png', '/images/test_logo/bac.png', 1, NULL, 2, NULL, 1534947950, 1534947950),
(4, 'Athletic Brotherhood', 'athletic-brotherhood', '/images/test_logo/logo4.png', '/images/test_logo/bac.png', 1, NULL, 2, NULL, 1534947950, 1534947950),
(5, 'Druzhina', 'druzhina', '/images/test_logo/logo5.png', '/images/test_logo/bac.png', 1, NULL, 2, NULL, 1534947950, 1534947950),
(6, 'Udaltsy', 'udaltsy', '/images/test_logo/logo6.png', '/images/test_logo/bac.png', 1, NULL, 2, NULL, 1534947950, 1534947950),
(7, 'Adrenalin', 'adrenalin', '/images/test_logo/logo7.png', '/images/test_logo/bac.png', 1, NULL, 2, NULL, 1534947950, 1534947950),
(8, 'Arrow', 'arrow', '/images/test_logo/logo8.png', '/images/test_logo/bac.png', 1, NULL, 2, NULL, 1534947950, 1534947950),
(9, 'my teams', 'my-teams', '/images/logo/1/den_programmista_13_sentyabrya_javascript.jpg', '/images/background/1/den_programmista_13_sentyabrya_javascript.jpg', 1, '', 1, NULL, 1541505649, 1541505649),
(10, 'User101', NULL, '-----', '-----', 1, NULL, 77, 1, 1542982573, 1542982573),
(11, 'User102', NULL, '-----', '-----', 1, NULL, 78, 1, 1542982855, 1542982855),
(12, 'User103', NULL, '-----', '-----', 1, NULL, 79, 1, 1542983038, 1542983038),
(13, 'User104', NULL, '-----', '-----', 1, NULL, 80, 1, 1542983227, 1542983227);

-- --------------------------------------------------------

--
-- Структура таблицы `tournaments`
--

CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `format` int(3) NOT NULL,
  `rules` text NOT NULL,
  `prizes` text NOT NULL,
  `prize_pool` int(11) DEFAULT NULL,
  `banner` varchar(250) DEFAULT NULL,
  `flag` int(3) DEFAULT NULL,
  `region` varchar(200) DEFAULT NULL,
  `time_limit` int(11) DEFAULT NULL,
  `max_players` int(11) NOT NULL,
  `data` text,
  `match_schedule` int(4) DEFAULT NULL,
  `league_table` text,
  `cup` text,
  `partisipation_data` text,
  `league_p` int(3) DEFAULT NULL,
  `league_g` int(3) DEFAULT NULL,
  `state` int(3) DEFAULT NULL,
  `forum_text` text,
  `start_date` datetime NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tournaments`
--

INSERT INTO `tournaments` (`id`, `name`, `game_id`, `user_id`, `format`, `rules`, `prizes`, `prize_pool`, `banner`, `flag`, `region`, `time_limit`, `max_players`, `data`, `match_schedule`, `league_table`, `cup`, `partisipation_data`, `league_p`, `league_g`, `state`, `forum_text`, `start_date`, `created_at`, `updated_at`) VALUES
(1, 'The International', 1, 1, 1, 'United States', 'United States', NULL, NULL, NULL, NULL, NULL, 4, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-04 11:11:27', 1534947950, 1534947950),
(2, 'WESG 2018', 1, 1, 2, 'United States', 'United States', NULL, NULL, NULL, NULL, NULL, 4, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-08 11:11:27', 1534947950, 1534947950),
(3, 'Mars Dota League', 1, 1, 3, 'United States', 'United States', NULL, NULL, NULL, NULL, NULL, 4, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-08 11:11:27', 1534947950, 1534947950),
(4, 'The Summit', 1, 1, 4, 'United States', 'United States', NULL, NULL, NULL, NULL, NULL, 4, NULL, 7, NULL, NULL, NULL, 4, NULL, NULL, NULL, '2018-11-08 11:11:27', 1534947950, 1534947950),
(5, 'Sunrise Cup', 1, 1, 5, 'United States', 'United States', NULL, NULL, NULL, NULL, NULL, 4, NULL, 7, NULL, NULL, NULL, 2, 4, NULL, NULL, '2018-11-08 11:11:27', 1534947950, 1534947950),
(6, 'new 06 11', 1, 1, 2, '..Exception: SQLSTATE[42S01]: Base table or view already exists: 1050 Table \'news\' already exists\r\nThe SQL being executed was: CREATE TABLE `news` (\r\n	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,\r\n	`category_id` int(11),\r\n	`title` varchar(200) NOT NULL,\r\n	`description` text,\r\n	`logo` varchar(250) NULL DEFAULT NULL,\r\n	`state` int(3) DEFAULT 1,\r\n	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\r\n	`updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\r\n) (/home/kokos/html/esports/vendor/yiisoft/yii2/db/Schema.php:664)\r\n#0 /home/kokos/html/esports/vendor/yiisoft/yii2/db/Command.php(1263', '..Exception: SQLSTATE[42S01]: Base table or view already exists: 1050 Table \'news\' already exists\r\nThe SQL being executed was: CREATE TABLE `news` (\r\n	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,\r\n	`category_id` int(11),\r\n	`title` varchar(200) NOT NULL,\r\n	`description` text,\r\n	`logo` varchar(250) NULL DEFAULT NULL,\r\n	`state` int(3) DEFAULT 1,\r\n	`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\r\n	`updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP\r\n) (/home/kokos/html/esports/vendor/yiisoft/yii2/db/Schema.php:664)\r\n#0 /home/kokos/html/esports/vendor/yiisoft/yii2/db/Command.php(1263', NULL, NULL, 2, 'Europe', NULL, 4, '{\"system\":\"Bo1\",\"game_mode\":\" Conquist\"}', 1, NULL, NULL, NULL, 2, 2, NULL, NULL, '2018-11-17 02:40:00', 1541502925, 1541503546),
(7, 'Super Man', 1, 1, 2, 'Rules of the tournament', 'Rules of the tournament', NULL, NULL, 2, 'Europe', NULL, 2, '{\"system\":\"Bo1\",\"game_mode\":\"Last hero standing\"}', 1, NULL, '{\"teams\":[[{\"id\":6,\"name\":\"Udaltsy\",\"logo\":\"\\/images\\/test_logo\\/logo6.png\"},{\"id\":8,\"name\":\"Arrow\",\"logo\":\"\\/images\\/test_logo\\/logo8.png\"}],[{\"id\":4,\"name\":\"Athletic Brotherhood\",\"logo\":\"\\/images\\/test_logo\\/logo4.png\"},{\"id\":7,\"name\":\"Adrenalin\",\"logo\":\"\\/images\\/test_logo\\/logo7.png\"}],[{\"id\":5,\"name\":\"Druzhina\",\"logo\":\"\\/images\\/test_logo\\/logo5.png\"},{\"id\":1,\"name\":\"The Bears\",\"logo\":\"\\/images\\/test_logo\\/logo1.png\"}],[{\"id\":2,\"name\":\"Grasshoppers\",\"logo\":\"\\/images\\/test_logo\\/logo2.png\"},{\"id\":3,\"name\":\"Ancient Greeks\",\"logo\":\"\\/images\\/test_logo\\/logo3.png\"}]],\"results\":[[[[1,0],[0,1],[1,0],[1,0]],[[1,0],[1,0]],[[1,0]]],[[[1,0],[1,0]],[[0,1],[0,1]],[[1,0]],[[0,1]]],[[[1,0]]],[[[6,7,5,2],[6,5],[null]],[[8,4,1,3],[8,2,1,7],[2,7],[2,5],[null]],[6,5]]]}', NULL, 2, 2, 2, '<p><a href=\"/matches/public/1\" >Athletic Brotherhood vs Druzhina</a></p><p><a href=\"/matches/public/2\" >Adrenalin vs The Bears</a></p><p><a href=\"/matches/public/3\" >Udaltsy vs Arrow</a></p><p><a href=\"/matches/public/4\" >Ancient Greeks vs Grasshoppers</a></p><p><a href=\"/matches/public/5\" >The Bears vs Druzhina</a></p><p><a href=\"/matches/public/6\" >Grasshoppers vs Udaltsy</a></p><p><a href=\"/matches/public/7\" >Adrenalin vs Athletic Brotherhood</a></p><p><a href=\"/matches/public/8\" >Ancient Greeks vs Arrow</a></p><p><a href=\"/matches/public/9\" >Udaltsy vs Druzhina</a></p><p><a href=\"/matches/public/10\" >Athletic Brotherhood vs Grasshoppers</a></p><p><a href=\"/matches/public/11\" >Arrow vs The Bears</a></p><p><a href=\"/matches/public/12\" >The Bears vs Grasshoppers</a></p><p><a href=\"/matches/public/13\" >Grasshoppers vs Udaltsy</a></p><p><a href=\"/matches/public/14\" >Grasshoppers vs Druzhina</a></p><p><a href=\"/matches/public/15\" >Udaltsy vs Adrenalin</a></p><p><a href=\"/matches/public/16\" >Druzhina vs Athletic Brotherhood</a></p><p><a href=\"/matches/public/17\" >The Bears vs Ancient Greeks</a></p><p><a href=\"/matches/public/18\" >Arrow vs Grasshoppers</a></p><p><a href=\"/matches/public/19\" >Athletic Brotherhood vs Adrenalin</a></p><p><a href=\"/matches/public/20\" >Grasshoppers vs Ancient Greeks</a></p><p><a href=\"/matches/public/21\" >Druzhina vs Udaltsy</a></p><p><a href=\"/matches/public/22\" >Arrow vs The Bears</a></p><p><a href=\"/matches/public/23\" >Ancient Greeks vs Adrenalin</a></p><p><a href=\"/matches/public/24\" >Udaltsy vs Grasshoppers</a></p><p><a href=\"/matches/public/25\" >The Bears vs Athletic Brotherhood</a></p><p><a href=\"/matches/public/26\" >Athletic Brotherhood vs Grasshoppers</a></p><p><a href=\"/matches/public/27\" >Athletic Brotherhood vs Ancient Greeks</a></p><p><a href=\"/matches/public/28\" >Ancient Greeks vs Adrenalin</a></p><p><a href=\"/matches/public/29\" >Udaltsy vs Athletic Brotherhood</a></p><p><a href=\"/matches/public/30\" >Druzhina vs Grasshoppers</a></p><p><a href=\"/matches/public/31\" >Ancient Greeks vs Adrenalin</a></p><p><a href=\"/matches/public/32\" >Arrow vs The Bears</a></p><p><a href=\"/matches/public/38\" >Arrow vs Udaltsy</a></p><p><a href=\"/matches/public/39\" >Adrenalin vs Athletic Brotherhood</a></p><p><a href=\"/matches/public/40\" >The Bears vs Druzhina</a></p><p><a href=\"/matches/public/41\" >Ancient Greeks vs Grasshoppers</a></p><p><a href=\"/matches/public/42\" >Adrenalin vs Udaltsy</a></p><p><a href=\"/matches/public/43\" >Grasshoppers vs Druzhina</a></p><p><a href=\"/matches/public/44\" >Athletic Brotherhood vs Arrow</a></p><p><a href=\"/matches/public/45\" >Ancient Greeks vs The Bears</a></p><p><a href=\"/matches/public/46\" >Adrenalin vs Udaltsy</a></p><p><a href=\"/matches/public/47\" >Grasshoppers vs Druzhina</a></p><p><a href=\"/matches/public/48\" >Athletic Brotherhood vs Arrow</a></p><p><a href=\"/matches/public/49\" >Ancient Greeks vs The Bears</a></p><p><a href=\"/matches/public/50\" >Druzhina vs Udaltsy</a></p><p><a href=\"/matches/public/51\" >Arrow vs Grasshoppers</a></p><p><a href=\"/matches/public/52\" >The Bears vs Adrenalin</a></p><p><a href=\"/matches/public/53\" >Adrenalin vs Grasshoppers</a></p><p><a href=\"/matches/public/54\" >Grasshoppers vs Druzhina</a></p><p><a href=\"/matches/public/55\" >Druzhina vs Udaltsy</a></p>', '2018-11-06 02:25:00', 1541606791, 1543171927),
(8, 'qwerty', 1, 1, 1, 'qwwrrty', 'qweertyyu', NULL, NULL, 1, 'Europe', NULL, 1, '{\"system\":\"Bo1\",\"game_mode\":\" Conquist\"}', 1, NULL, NULL, NULL, 2, 2, NULL, '<p><a href=\"/matches/public/36\" >User101 vs User102</a></p><p><a href=\"/matches/public/37\" >User104 vs User103</a></p>', '2018-11-23 05:10:00', 1542982261, 1542990866);

-- --------------------------------------------------------

--
-- Структура таблицы `tournament_data`
--

CREATE TABLE `tournament_data` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `value` varchar(700) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tournament_team`
--

CREATE TABLE `tournament_team` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `status` int(3) DEFAULT '0',
  `tokin` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tournament_team`
--

INSERT INTO `tournament_team` (`id`, `tournament_id`, `team_id`, `status`, `tokin`) VALUES
(1, 1, 1, 2, NULL),
(2, 1, 2, 2, NULL),
(3, 1, 3, 2, NULL),
(4, 1, 4, 2, NULL),
(5, 1, 5, 2, NULL),
(6, 1, 6, 2, NULL),
(7, 1, 7, 2, NULL),
(8, 1, 8, 2, NULL),
(9, 2, 1, 2, NULL),
(10, 2, 2, 2, NULL),
(11, 2, 3, 2, NULL),
(12, 2, 4, 2, NULL),
(13, 2, 5, 2, NULL),
(14, 2, 6, 2, NULL),
(15, 2, 7, 2, NULL),
(16, 2, 8, 2, NULL),
(17, 3, 1, 2, NULL),
(18, 3, 2, 2, NULL),
(19, 3, 3, 2, NULL),
(20, 3, 4, 2, NULL),
(21, 3, 5, 2, NULL),
(22, 3, 6, 2, NULL),
(23, 3, 7, 2, NULL),
(24, 3, 8, 2, NULL),
(25, 4, 1, 2, NULL),
(26, 4, 2, 2, NULL),
(27, 4, 3, 2, NULL),
(28, 4, 4, 2, NULL),
(29, 4, 5, 2, NULL),
(30, 4, 6, 2, NULL),
(31, 4, 7, 2, NULL),
(32, 4, 8, 2, NULL),
(33, 5, 1, 2, NULL),
(34, 5, 2, 2, NULL),
(35, 5, 3, 2, NULL),
(36, 5, 4, 2, NULL),
(37, 5, 5, 2, NULL),
(38, 5, 6, 2, NULL),
(39, 5, 7, 2, NULL),
(40, 5, 8, 2, NULL),
(41, 6, 5, 3, 'ok'),
(42, 7, 1, 2, 'ok'),
(43, 7, 2, 2, 'ok'),
(44, 7, 3, 2, 'ok'),
(45, 7, 4, 2, 'ok'),
(46, 7, 5, 2, 'ok'),
(47, 7, 6, 2, 'ok'),
(48, 7, 7, 2, 'ok'),
(49, 7, 8, 2, 'ok'),
(50, 8, 10, 2, NULL),
(51, 8, 11, 2, NULL),
(52, 8, 12, 2, NULL),
(53, 8, 13, 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tournament_user`
--

CREATE TABLE `tournament_user` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(3) DEFAULT '0',
  `tokin` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tournament_user`
--

INSERT INTO `tournament_user` (`id`, `tournament_id`, `user_id`, `status`, `tokin`) VALUES
(1, 8, 77, 2, 'ok'),
(2, 8, 79, 2, 'ok'),
(3, 8, 78, 2, 'ok'),
(4, 8, 80, 2, 'ok');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(1) DEFAULT '0',
  `country` varchar(255) NOT NULL,
  `logo` varchar(250) DEFAULT NULL,
  `background` varchar(250) DEFAULT NULL,
  `sex` int(3) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `favorite_game` int(3) DEFAULT NULL,
  `activities` text,
  `interests` text,
  `restore_token` varchar(255) DEFAULT NULL,
  `tokin_conf` varchar(250) DEFAULT NULL,
  `is_verified` int(1) DEFAULT '0',
  `visible` int(1) DEFAULT '0',
  `fair_play` int(11) DEFAULT '100',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `system_ball` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `country`, `logo`, `background`, `sex`, `birthday`, `favorite_game`, `activities`, `interests`, `restore_token`, `tokin_conf`, `is_verified`, `visible`, `fair_play`, `created_at`, `updated_at`, `system_ball`) VALUES
(1, 'Admin User Good', 'admin', 'admin@admin.com', '$2y$13$WlhWSxi4QWRdYRNydm0naeloGRdBEvn9wSx5i0GMYC/mFhfT9mn46', 0, 'United States', '/images/users/1/1541528722.jpg', '/images/users/1/1541527982.jpg', 1, '2006-03-10', 2, '', '', NULL, '81db5214d8148ed512673205d133471b30ce66c6a693d754', 0, 1, 100, '2018-11-06 11:11:08', '2018-11-16 12:08:08', 100),
(2, 'Vasa', 'vasa', 'vasan@vasa.com', '$2y$13$GfYcKN5i8X7aguQXAe3bveacbysxlyKA8Vto7KkSGH5FbXzqfd/Ei', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:11:15', '2018-11-06 11:11:15', NULL),
(3, 'peta', 'peta', 'peta@peta.com', '$2y$13$Qb0jTgFieSpJzsNfLdL26.hB4ceZdM.HnOB7a6MjQGWHz2GEMTZNe', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:11:16', '2018-11-08 17:17:19', 110),
(4, 'feda', 'feda', 'feda@feda.com', '$2y$13$JZGm23W2x34JBg9Bj669XufZ7TvFTv3QYiSP8Yz1TU8/zmLtttkbu', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:11:17', '2018-11-08 17:14:31', 120),
(5, 'User11', 'user11', 'user11@user.com', '$2y$13$jfwx7Y1VY3EJe2t9Dk6GDucQqe1.9/J4W/yiI3aUZu2ORaecYckVW', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:11:51', '2018-11-08 17:10:38', 80),
(6, 'User12', 'user12', 'user12@user.com', '$2y$13$6BeTN0oH1SRa4qzS02cb2Os5M/gGHqbWgKY/airQhc.mLsD6SQY6i', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:11:52', '2018-11-06 11:11:52', NULL),
(7, 'User13', 'user13', 'user13@user.com', '$2y$13$wLF9zgLc4ZL9DulVJg0C/u783Ter2IGv/uAJmQcCcy25X7tJJMyva', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:11:53', '2018-11-08 17:17:19', 340),
(8, 'User14', 'user14', 'user14@user.com', '$2y$13$xd3nu6AfQy0A6mFZsZX2HexK8olVf93FFEmrVWEJjcztLFLEqD1Gy', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:11:54', '2018-11-06 11:11:54', NULL),
(9, 'User15', 'user15', 'user15@user.com', '$2y$13$n12s1cQprMhilQ5GbnGqGetMwm5lBiurIJm9E5d8GM5SoVljvNHKW', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:11:55', '2018-11-06 11:11:55', NULL),
(10, 'User16', 'user16', 'user16@user.com', '$2y$13$G7OPRsHccGhAXF/CZEGm6O7waTJ//hmvplt0tN0P3gApgFh6MtQo2', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:11:55', '2018-11-06 11:11:55', NULL),
(11, 'User17', 'user17', 'user17@user.com', '$2y$13$6/3mL1Q36fYfKz7BFEniTe.ytNQqCZtfP9AxbK.2sf.3Krko5ywG2', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:11:56', '2018-11-08 12:59:01', NULL),
(12, 'User18', 'user18', 'user18@user.com', '$2y$13$FWNtUYbdnMyrlN36WtWQweacLj1gFtO.fvkYoAEfHqUcs.Pqyjy6y', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:11:57', '2018-11-06 11:11:57', NULL),
(13, 'User21', 'user21', 'user21@user.com', '$2y$13$9fwqNrDEpl78g9xGrrzPu.3yUAQLc2TUqgV/EFM93cNAowsDAMOsG', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:11:58', '2018-11-06 11:11:58', NULL),
(14, 'User22', 'user22', 'user22@user.com', '$2y$13$aryI0HFXYoCbWX2tcLz6WOyHFncYw4Ifpjn/hnBHXXqVveNlQTEAi', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:11:59', '2018-11-08 17:12:22', 200),
(15, 'User23', 'user23', 'user23@user.com', '$2y$13$6ydpgvj7d4Eo1hPVmDItr.zZC9v8MLrrEtodvXvP2S.uqB0q6jmS2', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:00', '2018-11-06 11:12:00', NULL),
(16, 'User24', 'user24', 'user24@user.com', '$2y$13$YNuFymnxf7XdsA/NBE9auO2tQLrlizokNUJJswRROwA1IkS//v60q', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:00', '2018-11-08 17:11:03', 60),
(17, 'User25', 'user25', 'user25@user.com', '$2y$13$PMvUCYmcHhvHjL0CQ4h5veuCRgxKlxG7Aa2twTVVrH3EpNXhgze9K', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:01', '2018-11-08 17:12:34', 100),
(18, 'User26', 'user26', 'user26@user.com', '$2y$13$93xCLuflUVJ1HWYxYS20FOflOWCmVvveiQf7RiKJ2Kt4mP/2Z4B62', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:02', '2018-11-08 17:13:49', 170),
(19, 'User27', 'user27', 'user27@user.com', '$2y$13$dta4CtKgynAS82H4pIkj8ueRJMtwKpLfv0gOdVEeNGNTpBY0EkMCK', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:03', '2018-11-06 11:12:03', NULL),
(20, 'User28', 'user28', 'user28@user.com', '$2y$13$tmeZrwuIfNn7umgtHAnei.bDeAJfx1RiU.2M4CoEoyzMsMbGQNJaO', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:04', '2018-11-08 17:14:31', 140),
(21, 'User31', 'user31', 'user31@user.com', '$2y$13$k/uLJFfX5hmy6SGieJvqa.BYJ1KytwQOo59lFbNxmcHHKi/LwW76u', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:05', '2018-11-08 12:59:01', NULL),
(22, 'User32', 'user32', 'user32@user.com', '$2y$13$cTcOCIzYYsDutL5VHKq5uudcukY8r79k9XaMALSa.YuxEoF5ncZGa', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:06', '2018-11-08 17:12:22', 210),
(23, 'User33', 'user33', 'user33@user.com', '$2y$13$67ncH/nriFdldXsP8Do7Yu8PntxRlOAww1lrPECXxyz0NhcAtdDli', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:06', '2018-11-06 11:12:06', NULL),
(24, 'User34', 'user34', 'user34@user.com', '$2y$13$ALZDDJLzUL0q0Ba//Xmpc.zXqFDfKApwlzp18iQyklTrsbVhlujzO', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:07', '2018-11-08 17:11:03', 60),
(25, 'User35', 'user35', 'user35@user.com', '$2y$13$xjlgAa.ZmK19b8InpvCCpOfjbkECi2S8xbIhCfbnDrckLzEdAff9G', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:08', '2018-11-06 11:12:08', NULL),
(26, 'User36', 'user36', 'user36@user.com', '$2y$13$42go/54saScFzdLcfrq5C.eCBSxZkkVa/ZWHqzpmk8tNDjZzfK35O', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:09', '2018-11-08 17:13:49', 170),
(27, 'User37', 'user37', 'user37@user.com', '$2y$13$2Te2FI.WKE9Ucun3Y8i1uOm6bph2PCCQJlTlrzYPtfRKW9ElbfB4q', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:10', '2018-11-08 17:17:19', 100),
(28, 'User38', 'user38', 'user38@user.com', '$2y$13$C5tTsXoqp.2HV1XhTqcXUe4Sr.SATe3cTrXjOLkmYna6kP6qzhMnu', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:11', '2018-11-06 11:12:11', NULL),
(29, 'User41', 'user41', 'user41@user.com', '$2y$13$0WUm5l4G9uqTJUgZtpp.le4KhF8mTUId2UTgJU9x14AfYdyhu5t7m', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:12', '2018-11-08 17:10:38', 110),
(30, 'User42', 'user42', 'user42@user.com', '$2y$13$Z07k48RfwZQNAFmP0t4ApeHXHhIUeASgeJAoVdJSfNKImVAWOoEVK', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:12', '2018-11-06 11:12:12', NULL),
(31, 'User43', 'user43', 'user43@user.com', '$2y$13$qmPRHFpdAccjtF9lS6DkBOm2VZM5MeztTDknxeea0Q3jtiMAgZUle', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:13', '2018-11-08 17:17:19', 300),
(32, 'User44', 'user44', 'user44@user.com', '$2y$13$OPlOCbfiw9Zdb8IuHvhl0.m9VAOTZ7U0SLIDUeYpFUCLdZQQlJWx2', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:14', '2018-11-06 11:12:14', NULL),
(33, 'User45', 'user45', 'user45@user.com', '$2y$13$r.1aMmiQ4gexrgqb.t1tYenZi2kZ8kjtDz0YrdEzeWmOIQrQZ5UIC', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:15', '2018-11-06 11:12:15', NULL),
(34, 'User46', 'user46', 'user46@user.com', '$2y$13$uO3dKCaZiPCRBXnldPrCmuW7HdIocPBgvVzIz0R75yjo0qtULX4f.', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:16', '2018-11-06 11:12:16', NULL),
(35, 'User47', 'user47', 'user47@user.com', '$2y$13$I5MKIWma8w1JiUTe5ZPVp.fLxVRX0zC7EqJw5U02SVfMK51i97Kr6', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:17', '2018-11-06 11:12:17', NULL),
(36, 'User48', 'user48', 'user48@user.com', '$2y$13$cU3bJMLZQ0Q2DIxstOP5QOzqQbowfwIhTwI6TAKxeQAxSw6TDcYre', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:18', '2018-11-06 11:12:18', NULL),
(37, 'User51', 'user51', 'user51@user.com', '$2y$13$XJmqtZBNeUi295EKwvbhZu1ihubiKRgyw0LeENFHVuyrUTqZPTWVG', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:18', '2018-11-06 11:12:18', NULL),
(38, 'User52', 'user52', 'user52@user.com', '$2y$13$cjZ2oY9gHknEu18RMC9S1eUXfEzR6Jo1Aky03Cetd9c5r.xnLxUtS', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:19', '2018-11-06 11:12:19', NULL),
(39, 'User53', 'user53', 'user53@user.com', '$2y$13$It6VZYn0kHBiV2aNeQhGzOeU6RDRPNAA.1IvCgBMFQZZmk4N0EgOi', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:20', '2018-11-06 11:12:20', NULL),
(40, 'User54', 'user54', 'user54@user.com', '$2y$13$apdh0.GAZaDEPS7btiF2zeXnnkyJFtqUqJv//QSyT4ld79hZnCELi', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:21', '2018-11-06 11:12:21', NULL),
(41, 'User55', 'user55', 'user55@user.com', '$2y$13$.UoHiFqiWqWEuF2oV1xVg.Kc6Mytp0kn3LFNfVIb79GpaB.XrGciW', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:22', '2018-11-06 11:12:22', NULL),
(42, 'User56', 'user56', 'user56@user.com', '$2y$13$rL0TXf8eyXMkdVNjissqm.3uM4rAIuS7b3ljKAOcPX4yx2FFL.waK', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:23', '2018-11-06 11:12:23', NULL),
(43, 'User57', 'user57', 'user57@user.com', '$2y$13$edzwYU3j4r8vTgejEHGqweNx.99RIzhONyY8LwySWBZUSxkvGpyxy', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:23', '2018-11-06 11:12:23', NULL),
(44, 'User58', 'user58', 'user58@user.com', '$2y$13$f7u4nqeO.epgtDZ5FbN46.BpFUBX18SgCI4Fm5RAatki9E2oKLgZ.', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:24', '2018-11-06 11:12:24', NULL),
(45, 'User61', 'user61', 'user61@user.com', '$2y$13$zEKYdjEuJbwOBH3faxjsGOJvm.JOR8wjj5ZKIlmzgqTEKXAAShxGG', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:25', '2018-11-06 11:12:25', NULL),
(46, 'User62', 'user62', 'user62@user.com', '$2y$13$Mi8fujg1JtsZbR/s50bRrOu3HmWBgzrJAm3bu5pwdq6V9R.WOFaeq', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:26', '2018-11-06 11:12:26', NULL),
(47, 'User63', 'user63', 'user63@user.com', '$2y$13$t5pWeJQ8PLmQ9Ce6WLI03ORu6/8KRi1p4WH0K9LG5m524e0QST5hm', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:27', '2018-11-06 11:12:27', NULL),
(48, 'User64', 'user64', 'user64@user.com', '$2y$13$eoCXkX/ISXlKHC.hfwbVG.S78b72a6HZ6vVc2JNbRaxTW6kmlFXeO', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:28', '2018-11-06 11:12:28', NULL),
(49, 'User65', 'user65', 'user65@user.com', '$2y$13$1lxInXmUXXkK55PpPJPJAu.jqfuBs7sWZBitij065ZcmZW9/DIeWC', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:29', '2018-11-06 11:12:29', NULL),
(50, 'User66', 'user66', 'user66@user.com', '$2y$13$4hnpC/jjvkt2e4UqtEK/nO2WRBzHQzefIwOy0/vkVZ6DZ19xuyr5u', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:29', '2018-11-06 11:12:29', NULL),
(51, 'User67', 'user67', 'user67@user.com', '$2y$13$FfUe5p3KhdgSPZnTwqQ8wu1fCTyehPr91mzSoRtPd1DXqpj32NyzK', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:30', '2018-11-06 11:12:30', NULL),
(52, 'User68', 'user68', 'user68@user.com', '$2y$13$mUA/K9xuUuyjuOZXJHw1xO5vruMW/2uSrNMePfqcQEtuwctynr5EO', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:31', '2018-11-06 11:12:31', NULL),
(53, 'User71', 'user71', 'user71@user.com', '$2y$13$cNmKDVV6CHnmjN3yGFSr1.cenn7O6PQRTaQ0D.1a/w5Dv/rxPEXMi', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:32', '2018-11-06 11:12:32', NULL),
(54, 'User72', 'user72', 'user72@user.com', '$2y$13$rKxyWP5LzJRIsKxrPCSR/e8xVmAfy3buX954R/lzCkTs.pyLgUoBy', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:33', '2018-11-06 11:12:33', NULL),
(55, 'User73', 'user73', 'user73@user.com', '$2y$13$trKoCEoxyqpkEgZTaruKmueu1uysPtPJW2tqd4PmH12NtETke5jCO', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:34', '2018-11-06 11:12:34', NULL),
(56, 'User74', 'user74', 'user74@user.com', '$2y$13$.g/KNToMimv019s2JKdCLuh9eliphV6u3Nh6dJxumeaeMmjp070Mu', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:34', '2018-11-06 11:12:34', NULL),
(57, 'User75', 'user75', 'user75@user.com', '$2y$13$NNvJafsXHWdYIwJqz62/YOxbFFj7YQcy.L7NDta9HnnDBl8Dqrw6W', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:35', '2018-11-06 11:12:35', NULL),
(58, 'User76', 'user76', 'user76@user.com', '$2y$13$cTeVzq304OmrbFf7/orxg.l0a5T1qkG4lTZk8fcxCsERicyGJ1rbu', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:36', '2018-11-06 11:12:36', NULL),
(59, 'User77', 'user77', 'user77@user.com', '$2y$13$9IgzTCG9TMHiCoY3i5i7duFl1RdWRMkFFjXCvU4.un5mNvnj0Pf3G', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:37', '2018-11-06 11:12:37', NULL),
(60, 'User78', 'user78', 'user78@user.com', '$2y$13$mYV23xiNM/OY0ZkGTuoEge8ltKSv42zzyJZ6Pc6qS3LaysehLDhxO', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:38', '2018-11-06 11:12:38', NULL),
(61, 'User81', 'user81', 'user81@user.com', '$2y$13$0uXfDiGMW7SLK5ZIW0e3EelUSz5MenclgO.BVVtg3adIw/gsFA4KS', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:39', '2018-11-06 11:12:39', NULL),
(62, 'User82', 'user82', 'user82@user.com', '$2y$13$IdkmJxanl4X08unqwaMakONlakEC7IgFcZ4MrbTUM1Gxv.lMMBQaO', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:40', '2018-11-06 11:12:40', NULL),
(63, 'User83', 'user83', 'user83@user.com', '$2y$13$grUjfTC3WbcT55d.3YR9qee6eZdrPXK8054AZ6MW3/WqZLB4/SHh.', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:41', '2018-11-06 11:12:41', NULL),
(64, 'User84', 'user84', 'user84@user.com', '$2y$13$wzi6ZSnXty6/V7f5jOzv9uqCJa6SpjPqvgHTLE4v5U4VF1Hs8SDq6', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:41', '2018-11-06 11:12:41', NULL),
(65, 'User85', 'user85', 'user85@user.com', '$2y$13$7bYnAu.eZEYEAr4k5sHz.eB89AxAj4Z09g31RgQXRdtMvCNCJBE.m', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:42', '2018-11-06 11:12:42', NULL),
(66, 'User86', 'user86', 'user86@user.com', '$2y$13$dBr355vrsEtapyV3al9l9uJtAEcTtsgKfrYHCKZmOWy22xaREa41.', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:43', '2018-11-06 11:12:43', NULL),
(67, 'User87', 'user87', 'user87@user.com', '$2y$13$gkh9MIPb.Q24ai42FIN1iOPP8HK57R/kWb83x.wdEsFKpw85.KuPu', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:44', '2018-11-06 11:12:44', NULL),
(68, 'User88', 'user88', 'user88@user.com', '$2y$13$cjlDtAEMAzG9bqiGzSFDnumWWlTHs2CnY2uySY0/Woc9yEToC1hE6', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:45', '2018-11-06 11:12:45', NULL),
(69, 'User91', 'user91', 'user91@user.com', '$2y$13$6Av2Y3ofiU0vLOIuvI2Eeun3NV0TJBq1szhgVER1GC18uZPfMqtg2', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:46', '2018-11-06 11:12:46', NULL),
(70, 'User92', 'user92', 'user92@user.com', '$2y$13$kCPAdi7lJczQ7sFG/axCY.u32MzKQPA6v3eE/nEjkwa60mc9CYMdm', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:47', '2018-11-06 11:12:47', NULL),
(71, 'User93', 'user93', 'user93@user.com', '$2y$13$YVZrWTiOGi.TDfK.E7Xa8uT/Zqe7AIMBi.qrx20d8jTKlZqUVIc42', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:48', '2018-11-06 11:12:48', NULL),
(72, 'User94', 'user94', 'user94@user.com', '$2y$13$1DBur0vXHmZucXzvFyj4fu4yGWsyyvgRgbKjy91LPssZWdRr1xSYm', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:49', '2018-11-06 11:12:49', NULL),
(73, 'User95', 'user95', 'user95@user.com', '$2y$13$8FLoLOEZTkaosnG09xgpUeype1uSObShR2M/M5lbrQGKnGxIzVQO2', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:49', '2018-11-06 11:12:49', NULL),
(74, 'User96', 'user96', 'user96@user.com', '$2y$13$r69kE2wC1zP9r5ERyG3p5.ICx3P/50z8dND9/n9tUVzLF14Z.rcRi', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:50', '2018-11-06 11:12:50', NULL),
(75, 'User97', 'user97', 'user97@user.com', '$2y$13$uWZvMEkFUfQ6dDPV.W/JsudeBcW1BNIKtHsSa7fF2GpQPYOI7MbOy', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:51', '2018-11-06 11:12:51', NULL),
(76, 'User98', 'user98', 'user98@user.com', '$2y$13$v890ZBQUGZmGmhXaNKdr8uv8d..OQRYa5lSQSclOj.pWT9Jr/bqqK', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:52', '2018-11-06 11:12:52', NULL),
(77, 'User101', 'user101', 'user101@user.com', '$2y$13$iQLUSIybOPDzaF4zOYU7D.kAuiIJL3UrrvEkOTTY7vIwnymPHYh8K', 0, 'United States', NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, 0, 1, 100, '2018-11-06 11:12:53', '2018-11-23 18:59:02', NULL),
(78, 'User102', 'user102', 'user102@user.com', '$2y$13$A03.eHnMi.DD/WwRKsYaNOWcPauSbe4zdwzxKY9aAUjYQMLTS7rFe', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:54', '2018-11-06 11:12:54', NULL),
(79, 'User103', 'user103', 'user103@user.com', '$2y$13$5K1Gd1PXDgAI5BkeHlc3m.6f1lEjY0XtceFxQ3vXkWooBVgiL53Ka', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:55', '2018-11-06 11:12:55', NULL),
(80, 'User104', 'user104', 'user104@user.com', '$2y$13$Ua2f81J2GAaEL.pZqFD/tepVV.jommrExYdKrYGoJHp4yOOhqdJH2', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:55', '2018-11-06 11:12:55', NULL),
(81, 'User105', 'user105', 'user105@user.com', '$2y$13$vOCDEepvQdfFoGGRQhlEQehGoBjHeHoAYZxWYQcHqXJpfMQLBfC7G', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:56', '2018-11-06 11:12:56', NULL),
(82, 'User106', 'user106', 'user106@user.com', '$2y$13$p0bQ0GanR7Jx6U6j8byN2O80mM9cCO1JztDB3YdDI3fdWlnbhlOSW', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:57', '2018-11-06 11:12:57', NULL),
(83, 'User107', 'user107', 'user107@user.com', '$2y$13$2cLPNNbluMpSHrk/g9idpupAaHSLOl4ebiRbX813YE.yj85mulNb6', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:58', '2018-11-06 11:12:58', NULL),
(84, 'User108', 'user108', 'user108@user.com', '$2y$13$cUVl.95xB/tMeZ9K8PL2Q.raGObIpKpFQC2vU2s9mp4Sg8B86fBUu', 0, 'United States', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 100, '2018-11-06 11:12:59', '2018-11-06 11:12:59', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users_match`
--

CREATE TABLE `users_match` (
  `id` int(11) NOT NULL,
  `user1` int(11) DEFAULT NULL,
  `user2` int(11) DEFAULT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `match` int(11) DEFAULT NULL,
  `results1` int(11) DEFAULT NULL,
  `results2` int(11) DEFAULT NULL,
  `round` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users_match`
--

INSERT INTO `users_match` (`id`, `user1`, `user2`, `tournament_id`, `match`, `results1`, `results2`, `round`, `state`, `data`) VALUES
(69, 78, 77, 8, 36, NULL, NULL, 1, NULL, '[[\"MAGE\",\"WARLOCK\"],[\"DRUID\",\"WARLOCK\"]]'),
(70, 79, 80, 8, 37, NULL, NULL, 1, NULL, '[[\"DRUID\",\"MAGE\"],[\"DRUID\",\"MAGE\"]]'),
(71, 14, 16, 7, 38, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(72, 22, 24, 7, 38, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(73, 20, 7, 7, 39, 1, 2, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(74, 4, 31, 7, 39, 0, 1, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(75, 29, 1, 7, 40, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(76, 5, 17, 7, 40, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(77, 26, 27, 7, 41, 10, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(78, 18, 3, 7, 41, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(87, 22, 31, 7, 46, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(88, 14, 7, 7, 46, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(89, 29, 26, 7, 47, 11, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(90, 5, 18, 7, 47, 11, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(91, 24, 4, 7, 48, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(92, 16, 20, 7, 48, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(93, 17, 3, 7, 49, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(94, 1, 27, 7, 49, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(95, 14, 29, 7, 50, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(96, 22, 5, 7, 50, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(97, 18, 16, 7, 51, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(98, 26, 24, 7, 51, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(99, 31, 1, 7, 52, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(100, 7, 17, 7, 52, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(101, 26, 31, 7, 53, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(102, 18, 7, 7, 53, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(103, 5, 18, 7, 54, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(104, 29, 26, 7, 54, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(105, 14, 29, 7, 55, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]'),
(106, 22, 5, 7, 55, 1, 0, 1, 1, '[[\"DRUID\",\"WARLOCK\",\"MAGE\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]');

-- --------------------------------------------------------

--
-- Структура таблицы `user_point`
--

CREATE TABLE `user_point` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `bonus_id` int(11) DEFAULT NULL,
  `appraisal` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_point`
--

INSERT INTO `user_point` (`id`, `user_id`, `bonus_id`, `appraisal`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 10, '2018-11-14 14:54:00', '2018-11-14 14:54:00'),
(2, 9, 2, 20, '2018-11-14 14:54:00', '2018-11-14 14:54:00'),
(3, 9, 1, 10, '2018-11-14 14:54:05', '2018-11-14 14:54:05'),
(4, 9, 2, 20, '2018-11-14 14:54:05', '2018-11-14 14:54:05'),
(5, 9, 1, 10, '2018-10-16 21:00:00', '2018-11-14 15:26:37'),
(6, 9, 2, 20, '2018-10-09 21:00:00', '2018-11-14 15:26:37'),
(7, 9, 2, 90, '2018-09-11 21:00:00', '2018-11-14 15:28:47'),
(8, 9, 1, 10, '2018-09-11 21:00:00', '2018-11-14 15:28:47'),
(9, 9, 1, 0, '2018-08-21 21:00:00', '2018-11-14 15:30:41'),
(10, 9, 2, 10, '2018-08-15 21:00:00', '2018-11-14 15:31:20'),
(11, 18, 2, 20, '2018-11-15 15:27:31', '2018-11-15 15:27:31'),
(12, 26, 2, 20, '2018-11-15 15:27:31', '2018-11-15 15:27:31'),
(13, 5, 1, 10, '2018-11-15 15:27:31', '2018-11-15 15:27:31'),
(14, 29, 1, 10, '2018-11-15 15:27:31', '2018-11-15 15:27:31'),
(15, 77, 2, 20, '2018-11-23 14:36:10', '2018-11-23 14:36:10'),
(16, 80, 1, 10, '2018-11-23 14:36:10', '2018-11-23 14:36:10'),
(17, 78, 2, 20, '2018-11-23 14:37:03', '2018-11-23 14:37:03'),
(18, 79, 1, 10, '2018-11-23 14:37:03', '2018-11-23 14:37:03'),
(19, 77, 2, 20, '2018-11-23 14:37:52', '2018-11-23 14:37:52'),
(20, 78, 1, 10, '2018-11-23 14:37:52', '2018-11-23 14:37:52'),
(21, 14, 2, 20, '2018-11-25 18:28:53', '2018-11-25 18:28:53'),
(22, 22, 2, 20, '2018-11-25 18:28:53', '2018-11-25 18:28:53'),
(23, 16, 1, 10, '2018-11-25 18:28:53', '2018-11-25 18:28:53'),
(24, 24, 1, 10, '2018-11-25 18:28:53', '2018-11-25 18:28:53'),
(25, 7, 2, 20, '2018-11-25 18:29:31', '2018-11-25 18:29:31'),
(26, 31, 2, 20, '2018-11-25 18:29:31', '2018-11-25 18:29:31'),
(27, 4, 1, 10, '2018-11-25 18:29:31', '2018-11-25 18:29:31'),
(28, 20, 1, 10, '2018-11-25 18:29:31', '2018-11-25 18:29:31'),
(29, 5, 2, 20, '2018-11-25 18:30:04', '2018-11-25 18:30:04'),
(30, 29, 2, 20, '2018-11-25 18:30:04', '2018-11-25 18:30:04'),
(31, 1, 1, 10, '2018-11-25 18:30:04', '2018-11-25 18:30:04'),
(32, 17, 1, 10, '2018-11-25 18:30:04', '2018-11-25 18:30:04'),
(33, 18, 2, 20, '2018-11-25 18:30:38', '2018-11-25 18:30:38'),
(34, 26, 2, 20, '2018-11-25 18:30:38', '2018-11-25 18:30:38'),
(35, 3, 1, 10, '2018-11-25 18:30:38', '2018-11-25 18:30:38'),
(36, 27, 1, 10, '2018-11-25 18:30:38', '2018-11-25 18:30:38'),
(37, 18, 2, 20, '2018-11-25 18:42:45', '2018-11-25 18:42:45'),
(38, 26, 2, 20, '2018-11-25 18:42:45', '2018-11-25 18:42:45'),
(39, 3, 1, 10, '2018-11-25 18:42:45', '2018-11-25 18:42:45'),
(40, 27, 1, 10, '2018-11-25 18:42:46', '2018-11-25 18:42:46'),
(41, 14, 2, 20, '2018-11-25 18:44:02', '2018-11-25 18:44:02'),
(42, 22, 2, 20, '2018-11-25 18:44:02', '2018-11-25 18:44:02'),
(43, 7, 1, 10, '2018-11-25 18:44:03', '2018-11-25 18:44:03'),
(44, 31, 1, 10, '2018-11-25 18:44:03', '2018-11-25 18:44:03'),
(45, 5, 2, 20, '2018-11-25 18:44:30', '2018-11-25 18:44:30'),
(46, 29, 2, 20, '2018-11-25 18:44:30', '2018-11-25 18:44:30'),
(47, 18, 1, 10, '2018-11-25 18:44:30', '2018-11-25 18:44:30'),
(48, 26, 1, 10, '2018-11-25 18:44:30', '2018-11-25 18:44:30'),
(49, 16, 2, 20, '2018-11-25 18:44:46', '2018-11-25 18:44:46'),
(50, 24, 2, 20, '2018-11-25 18:44:46', '2018-11-25 18:44:46'),
(51, 4, 1, 10, '2018-11-25 18:44:46', '2018-11-25 18:44:46'),
(52, 20, 1, 10, '2018-11-25 18:44:46', '2018-11-25 18:44:46'),
(53, 1, 2, 20, '2018-11-25 18:45:04', '2018-11-25 18:45:04'),
(54, 17, 2, 20, '2018-11-25 18:45:04', '2018-11-25 18:45:04'),
(55, 3, 1, 10, '2018-11-25 18:45:04', '2018-11-25 18:45:04'),
(56, 27, 1, 10, '2018-11-25 18:45:04', '2018-11-25 18:45:04'),
(57, 18, 2, 20, '2018-11-25 18:46:45', '2018-11-25 18:46:45'),
(58, 26, 2, 20, '2018-11-25 18:46:45', '2018-11-25 18:46:45'),
(59, 16, 1, 10, '2018-11-25 18:46:45', '2018-11-25 18:46:45'),
(60, 24, 1, 10, '2018-11-25 18:46:45', '2018-11-25 18:46:45'),
(61, 7, 2, 20, '2018-11-25 18:47:21', '2018-11-25 18:47:21'),
(62, 31, 2, 20, '2018-11-25 18:47:21', '2018-11-25 18:47:21'),
(63, 1, 1, 10, '2018-11-25 18:47:21', '2018-11-25 18:47:21'),
(64, 17, 1, 10, '2018-11-25 18:47:21', '2018-11-25 18:47:21'),
(65, 14, 2, 20, '2018-11-25 18:49:04', '2018-11-25 18:49:04'),
(66, 22, 2, 20, '2018-11-25 18:49:04', '2018-11-25 18:49:04'),
(67, 5, 1, 10, '2018-11-25 18:49:04', '2018-11-25 18:49:04'),
(68, 29, 1, 10, '2018-11-25 18:49:04', '2018-11-25 18:49:04'),
(69, 18, 2, 20, '2018-11-25 18:49:47', '2018-11-25 18:49:47'),
(70, 26, 2, 20, '2018-11-25 18:49:47', '2018-11-25 18:49:47'),
(71, 7, 1, 10, '2018-11-25 18:49:47', '2018-11-25 18:49:47'),
(72, 31, 1, 10, '2018-11-25 18:49:47', '2018-11-25 18:49:47'),
(73, 5, 2, 20, '2018-11-25 18:50:53', '2018-11-25 18:50:53'),
(74, 29, 2, 20, '2018-11-25 18:50:53', '2018-11-25 18:50:53'),
(75, 18, 1, 10, '2018-11-25 18:50:53', '2018-11-25 18:50:53'),
(76, 26, 1, 10, '2018-11-25 18:50:53', '2018-11-25 18:50:53'),
(77, 14, 2, 20, '2018-11-25 18:52:07', '2018-11-25 18:52:07'),
(78, 22, 2, 20, '2018-11-25 18:52:07', '2018-11-25 18:52:07'),
(79, 5, 1, 10, '2018-11-25 18:52:07', '2018-11-25 18:52:07'),
(80, 29, 1, 10, '2018-11-25 18:52:07', '2018-11-25 18:52:07');

-- --------------------------------------------------------

--
-- Структура таблицы `user_team`
--

CREATE TABLE `user_team` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_team` int(11) DEFAULT NULL,
  `status` int(3) DEFAULT '0',
  `status_tokin` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_team`
--

INSERT INTO `user_team` (`id`, `id_user`, `id_team`, `status`, `status_tokin`) VALUES
(1, 1, 1, 2, NULL),
(2, 2, 2, 2, NULL),
(3, 3, 3, 2, NULL),
(4, 4, 4, 2, NULL),
(5, 5, 5, 2, NULL),
(6, 6, 6, 2, NULL),
(7, 7, 7, 2, NULL),
(8, 8, 8, 2, NULL),
(9, 9, 1, 2, NULL),
(10, 10, 2, 2, NULL),
(11, 11, 3, 2, NULL),
(12, 12, 4, 2, NULL),
(13, 13, 5, 2, NULL),
(14, 14, 6, 2, NULL),
(15, 15, 7, 2, NULL),
(16, 16, 8, 2, NULL),
(17, 17, 1, 2, NULL),
(18, 18, 2, 2, NULL),
(19, 19, 3, 2, NULL),
(20, 20, 4, 2, NULL),
(21, 21, 5, 2, NULL),
(22, 22, 6, 2, NULL),
(23, 23, 7, 2, NULL),
(24, 24, 8, 2, NULL),
(25, 25, 1, 2, NULL),
(26, 26, 2, 2, NULL),
(27, 27, 3, 2, NULL),
(28, 28, 4, 2, NULL),
(29, 29, 5, 2, NULL),
(30, 30, 6, 2, NULL),
(31, 31, 7, 2, NULL),
(32, 32, 8, 2, NULL),
(33, 1, 9, 2, NULL),
(34, 77, 10, 4, NULL),
(35, 78, 11, 4, NULL),
(36, 79, 12, 4, NULL),
(37, 80, 13, 4, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `uset_team_tournament`
--

CREATE TABLE `uset_team_tournament` (
  `id` int(11) NOT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `text` text,
  `fair_play` int(11) DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `uset_team_tournament`
--

INSERT INTO `uset_team_tournament` (`id`, `tournament_id`, `team_id`, `user_id`, `text`, `fair_play`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 1, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541607914, 1541608532),
(2, 7, 1, 17, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541607914, 1541608778),
(3, 7, 2, 18, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541607950, 1541607950),
(4, 7, 2, 26, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541607950, 1541607950),
(5, 7, 3, 3, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541607988, 1541607988),
(6, 7, 3, 27, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541607988, 1541607988),
(7, 7, 4, 4, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608012, 1541608012),
(8, 7, 4, 20, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608012, 1541608012),
(9, 7, 5, 5, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608052, 1541608052),
(10, 7, 5, 29, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608052, 1541608052),
(11, 7, 6, 14, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608085, 1541608085),
(12, 7, 6, 22, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608085, 1541608085),
(13, 7, 7, 7, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608101, 1541608101),
(14, 7, 7, 31, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608101, 1541608101),
(15, 7, 8, 16, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608133, 1541608133),
(16, 7, 8, 24, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"WARLOCK\",\"MAGE\"]]', 0, 1541608133, 1541608133),
(17, 8, 10, 77, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\"],[\"DRUID\",\"WARLOCK\"]]', 1, 1542982573, 1542984147),
(18, 8, 11, 78, '[[\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\",\"AAEBAf0GAA/yAaIC3ALgBPcE+wWKBs4H2QexCMII2Q31DfoN9g4A\"],[\"MAGE\",\"WARLOCK\"]]', 0, 1542982855, 1542982925),
(19, 8, 12, 79, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"MAGE\"]]', 0, 1542983039, 1542983103),
(20, 8, 13, 80, '[[\"AAECAZICCPIF+Az5DK6rAuC7ApS9AsnHApnTAgtAX/4BxAbkCLS7Asu8As+8At2+AqDNAofOAgA=\",\"AAECAf0EEnGKAasEtATFBOMFvAiXwQKswgKYxAKb0wKG1AL77AKM7wKQ7wLP8gLF8wKTgAMGTbsCywSWBewHuf8CAA==\"],[\"DRUID\",\"MAGE\"]]', 0, 1542983227, 1542983294);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `forum_post`
--
ALTER TABLE `forum_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-forum_post_id` (`forum_topic_id`),
  ADD KEY `idx-forum_post_user_id` (`user_id`);

--
-- Индексы таблицы `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-forum_topic_tor_id` (`tournament_id`),
  ADD KEY `idx-forum_topic_user_id` (`user_id`);

--
-- Индексы таблицы `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- Индексы таблицы `message_user`
--
ALTER TABLE `message_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-message_user_sender` (`sender`),
  ADD KEY `idx-message_user_recipient` (`recipient`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-news_category_id` (`category_id`);

--
-- Индексы таблицы `news_category`
--
ALTER TABLE `news_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `results_statistics`
--
ALTER TABLE `results_statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-results_statistics_team` (`team_id`),
  ADD KEY `idx-results_statistics_game` (`game_id`);

--
-- Индексы таблицы `results_statistic_users`
--
ALTER TABLE `results_statistic_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-results_statistic_users` (`team_id`),
  ADD KEY `idx-results_statistic_users_id` (`user_id`),
  ADD KEY `idx-results_statistic_user_game_id` (`game_id`);

--
-- Индексы таблицы `schedule_post`
--
ALTER TABLE `schedule_post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-schedule_post_id` (`schedule_teams_id`),
  ADD KEY `idx-schedule_post_user_id` (`user_id`);

--
-- Индексы таблицы `schedule_teams`
--
ALTER TABLE `schedule_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-schedule_teams1_id` (`team1`),
  ADD KEY `idx-schedule_teams2_id` (`team2`),
  ADD KEY `idx-schedule_teams_tournament_id` (`tournament_id`);

--
-- Индексы таблицы `stream`
--
ALTER TABLE `stream`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-stream_tournament_id` (`tournament_id`);

--
-- Индексы таблицы `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx-game_id` (`game_id`),
  ADD KEY `idx-capitan` (`capitan`);

--
-- Индексы таблицы `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `idx-game_id` (`game_id`),
  ADD KEY `idx-user_id` (`user_id`);

--
-- Индексы таблицы `tournament_data`
--
ALTER TABLE `tournament_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-tournament-data_id` (`tournament_id`);

--
-- Индексы таблицы `tournament_team`
--
ALTER TABLE `tournament_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-tournament_id` (`tournament_id`),
  ADD KEY `idx-team_id` (`team_id`);

--
-- Индексы таблицы `tournament_user`
--
ALTER TABLE `tournament_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-user_tournament_id` (`tournament_id`),
  ADD KEY `idx-user_user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `users_match`
--
ALTER TABLE `users_match`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-users_match_tournament_id` (`tournament_id`),
  ADD KEY `idx-users_match_user1` (`user1`),
  ADD KEY `idx-users_match_user2` (`user2`),
  ADD KEY `idx-match_match` (`match`);

--
-- Индексы таблицы `user_point`
--
ALTER TABLE `user_point`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-user_point_user_id` (`user_id`);

--
-- Индексы таблицы `user_team`
--
ALTER TABLE `user_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-id_user` (`id_user`),
  ADD KEY `idx-id_team` (`id_team`);

--
-- Индексы таблицы `uset_team_tournament`
--
ALTER TABLE `uset_team_tournament`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-uset_team_tournament_id` (`tournament_id`),
  ADD KEY `idx-uset_team_tournament_team_id` (`team_id`),
  ADD KEY `idx-uset_team_tournament_user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `forum_post`
--
ALTER TABLE `forum_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `forum_topic`
--
ALTER TABLE `forum_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `message_user`
--
ALTER TABLE `message_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `news_category`
--
ALTER TABLE `news_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `results_statistics`
--
ALTER TABLE `results_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT для таблицы `results_statistic_users`
--
ALTER TABLE `results_statistic_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT для таблицы `schedule_post`
--
ALTER TABLE `schedule_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `schedule_teams`
--
ALTER TABLE `schedule_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT для таблицы `stream`
--
ALTER TABLE `stream`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `tournament_data`
--
ALTER TABLE `tournament_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `tournament_team`
--
ALTER TABLE `tournament_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT для таблицы `tournament_user`
--
ALTER TABLE `tournament_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT для таблицы `users_match`
--
ALTER TABLE `users_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
--
-- AUTO_INCREMENT для таблицы `user_point`
--
ALTER TABLE `user_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT для таблицы `user_team`
--
ALTER TABLE `user_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT для таблицы `uset_team_tournament`
--
ALTER TABLE `uset_team_tournament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `forum_post`
--
ALTER TABLE `forum_post`
  ADD CONSTRAINT `fk-forum_forum_post_id` FOREIGN KEY (`forum_topic_id`) REFERENCES `forum_topic` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-forum_forum_post_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `forum_topic`
--
ALTER TABLE `forum_topic`
  ADD CONSTRAINT `fk-forum_forum_topic_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-forum_topic_tor_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `message_user`
--
ALTER TABLE `message_user`
  ADD CONSTRAINT `fk-message_user_recipient` FOREIGN KEY (`recipient`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-message_user_sender` FOREIGN KEY (`sender`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk-news_category_id` FOREIGN KEY (`category_id`) REFERENCES `news_category` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `results_statistics`
--
ALTER TABLE `results_statistics`
  ADD CONSTRAINT `fk-results_statistics_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-results_statistics_team` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `results_statistic_users`
--
ALTER TABLE `results_statistic_users`
  ADD CONSTRAINT `fk-results_statistic_user_game_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-results_statistic_users` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-results_statistic_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `schedule_post`
--
ALTER TABLE `schedule_post`
  ADD CONSTRAINT `fk-forum_schedule_post_id` FOREIGN KEY (`schedule_teams_id`) REFERENCES `schedule_teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-forum_schedule_post_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `schedule_teams`
--
ALTER TABLE `schedule_teams`
  ADD CONSTRAINT `fk-schedule_teams1` FOREIGN KEY (`team1`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-schedule_teams2` FOREIGN KEY (`team2`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-schedule_teams_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `stream`
--
ALTER TABLE `stream`
  ADD CONSTRAINT `fk-stream_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `fk-capitan` FOREIGN KEY (`capitan`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-game_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tournaments`
--
ALTER TABLE `tournaments`
  ADD CONSTRAINT `fk-games_id` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tournament_data`
--
ALTER TABLE `tournament_data`
  ADD CONSTRAINT `fk-tournament-data_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tournament_team`
--
ALTER TABLE `tournament_team`
  ADD CONSTRAINT `fk-team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tournament_user`
--
ALTER TABLE `tournament_user`
  ADD CONSTRAINT `fk-user_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_match`
--
ALTER TABLE `users_match`
  ADD CONSTRAINT `fk-schedule_teams_match` FOREIGN KEY (`match`) REFERENCES `schedule_teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-users_match_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-users_match_user1` FOREIGN KEY (`user1`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-users_match_user2` FOREIGN KEY (`user2`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_point`
--
ALTER TABLE `user_point`
  ADD CONSTRAINT `fk-user_point_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_team`
--
ALTER TABLE `user_team`
  ADD CONSTRAINT `fk-id_team` FOREIGN KEY (`id_team`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `uset_team_tournament`
--
ALTER TABLE `uset_team_tournament`
  ADD CONSTRAINT `fk-uset_team_tournament_id` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-uset_team_tournament_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-uset_team_tournament_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
