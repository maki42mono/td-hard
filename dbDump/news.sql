-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 27, 2021 at 06:24 PM
-- Server version: 10.4.12-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `td_hard`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `description_short` varchar(200) DEFAULT NULL,
  `description_long` varchar(500) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `img_name` varchar(30) DEFAULT NULL,
  `flag_draft` tinyint(1) DEFAULT 0,
  `flag_is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `description_short`, `description_long`, `published_date`, `img_name`, `flag_draft`, `flag_is_deleted`, `created`, `updated`, `deleted`) VALUES
(169, 'Новая новость 1', 'dsfsfdf', '<b>Болд</b>\n\n<i>Италик</i>\n<strike>Чебурашка</strike>\n<a href=\"http://tagline.ru\" target=\"_blank\">Просто ссылка</a>', '2021-04-01', '1619465318.jpeg', 1, 0, NULL, '2021-04-27 17:50:36', NULL),
(172, 'Новая новость', NULL, 'ыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлрлзщаыкпквапавыщшповзщопекщлр', NULL, '1619465997.jpeg', 0, 0, NULL, '2021-04-27 17:49:42', NULL),
(175, 'Новая новость', NULL, '', '2021-04-03', NULL, 0, 0, NULL, NULL, NULL),
(176, 'Новая новость', NULL, '', '2021-04-10', '1619515178.png', 0, 1, NULL, NULL, NULL),
(177, 'Новая новость', NULL, NULL, NULL, NULL, 0, 1, NULL, NULL, '2021-04-27 17:56:54'),
(178, 'Новая новость', NULL, '', NULL, '1619515475.png', 0, 0, NULL, NULL, NULL),
(180, 'Новая новость', NULL, NULL, NULL, '1619450810.jpeg', 1, 0, NULL, NULL, NULL),
(181, 'Новая новость', NULL, NULL, '2021-04-09', '1619466425.jpeg', 1, 0, NULL, NULL, NULL),
(182, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(183, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(184, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(185, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(186, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(187, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(188, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(189, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(190, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(191, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(192, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(194, 'Новая новость', NULL, NULL, NULL, '1619467299.jpeg', 1, 0, NULL, NULL, NULL),
(195, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(196, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(197, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(198, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(199, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(200, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(201, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(202, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(203, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(204, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(205, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(206, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(207, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(208, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(209, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(210, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(211, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(212, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(213, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(214, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(215, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(216, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(217, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(218, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(219, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(220, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(221, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(222, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(223, 'Новая новость', NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, NULL),
(224, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(225, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(226, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(227, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(228, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(229, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(230, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(231, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(232, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(233, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(234, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(235, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(236, 'Новая новость', NULL, '', NULL, NULL, 1, 0, NULL, NULL, NULL),
(237, 'Новая новость', NULL, '', NULL, NULL, 0, 0, '2021-04-27 17:34:28', '2021-04-27 17:34:43', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
