-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 10.01.2022 klo 12:02
-- Palvelimen versio: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e2000693_harkka`
--
CREATE DATABASE IF NOT EXISTS `e2000693_harkka` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `e2000693_harkka`;

-- --------------------------------------------------------

--
-- Rakenne taululle `categories`
--
-- Luotu: 21.12.2021 klo 13:25
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `categories`:
--

--
-- Vedos taulusta `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Yleinen'),
(2, 'Politiikka'),
(3, 'Valokuvaus'),
(4, 'Videot'),
(5, 'Tarinat'),
(6, 'Taide'),
(7, 'Pelit'),
(8, 'Elokuvat'),
(9, 'Musiikki'),
(10, 'Urheilu'),
(11, 'Harrastukset'),
(12, 'NSFW');

-- --------------------------------------------------------

--
-- Rakenne taululle `comments`
--
-- Luotu: 03.01.2022 klo 10:50
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `date` datetime NOT NULL,
  `content` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `comments`:
--   `post_id`
--       `posts` -> `post_id`
--

--
-- Vedos taulusta `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `name`, `date`, `content`) VALUES
(443, 401, 35, 'Vilho Luoma', '2022-01-04 16:31:17', '<p>Kiva</p>'),
(444, 401, 35, 'Vilho Luoma', '2022-01-04 16:32:29', '<p>Ei kiva :(</p>'),
(445, 401, 35, 'Vilho Luoma', '2022-01-04 16:32:54', '<p><img src=\"images/0b443c537a79780d89c894d639ec7a87.jpg\" alt=\"\" /></p>'),
(446, 402, 35, 'Vilho Luoma', '2022-01-04 16:34:37', '<p>hahahaha 😂</p>'),
(448, 404, 35, 'Vilho Luoma', '2022-01-04 16:38:30', '<p><span style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; text-align: justify; background-color: #ffffff;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</span></p>'),
(449, 404, 35, 'Vilho Luoma', '2022-01-02 16:38:52', '<p>💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯💯</p>'),
(450, 403, 35, 'Vilho Luoma', '2022-01-04 16:39:26', '<p><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/3t3UnFSe8zI\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen=\"allowfullscreen\"></iframe></p>\n<p></p>\n<p>💯💯💯💯💯💯</p>'),
(451, 404, 36, 'testiukko', '2022-01-04 23:42:50', '<p>asdasdasd</p>'),
(452, 404, 36, 'testiukko', '2022-01-04 23:48:51', '<p>lolololol</p>'),
(457, 402, 0, 'admin', '2022-01-05 12:22:32', '<p>wqeqweqwezxc</p>'),
(458, 402, 0, 'admin', '2022-01-05 12:23:14', '<p><img src=\"images/cdbd1f314a5313bf7120c4af238519a5.jpg\" alt=\"\" /></p>');

-- --------------------------------------------------------

--
-- Näkymän vararakenne `comment_owner`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `comment_owner`;
CREATE TABLE `comment_owner` (
`comment_owner` int(11)
,`comment_id` int(11)
,`post_id` int(11)
,`content` mediumtext
,`date` datetime
,`user_id` int(11)
,`name` varchar(30)
,`image` varchar(255)
);

-- --------------------------------------------------------

--
-- Rakenne taululle `posts`
--
-- Luotu: 04.01.2022 klo 14:19
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `category` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `topic` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `posts`:
--

--
-- Vedos taulusta `posts`
--

INSERT INTO `posts` (`post_id`, `name`, `email`, `user_id`, `date`, `category`, `title`, `topic`) VALUES
(401, 'Vilho Luoma', 'vilho.luoma@gmail.com', 35, '2022-01-04 16:04:09', 'Yleinen', 'Testi postaus 1', '<p>T&auml;m&auml; on testi postaus</p>'),
(402, 'Vilho Luoma', 'vilho.luoma@gmail.com', 35, '2022-01-04 16:04:56', 'Pelit', 'Testi postaus kuvalla', '<p><img src=\"images/54a1ec7621509378b91b87861df2da3a.jpg\" alt=\"\" /></p>\r\n<p>Hieno kuva bro</p>'),
(403, 'Vilho Luoma', 'vilho.luoma@gmail.com', 35, '2022-01-04 16:07:35', 'Yleinen', 'Testi postaus youtube iframe', '<p><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/T5o_0BoTvWg\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen=\"allowfullscreen\"></iframe></p>'),
(404, 'Vilho Luoma', 'vilho.luoma@gmail.com', 35, '2022-01-04 16:29:16', 'Politiikka', 'Testi postaus 3', '<p><span style=\"margin: 0px; padding: 0px; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; text-align: justify; background-color: #ffffff;\">Lorem </span><strong style=\"margin: 0px; padding: 0px; font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; text-align: justify; background-color: #ffffff;\">Ipsum</strong><span style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; text-align: justify; background-color: #ffffff;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br /><br /></span><strong><span style=\"color: #000000;\"></span></strong></p>\r\n<p><img src=\"images/263e7008cf36274710061e31a934960b.jpg\" alt=\"\" /></p>'),
(405, 'Vilho Luoma', 'vilho.luoma@gmail.com', 35, '2022-01-04 16:47:26', 'Yleinen', 'Suosituin postaus', '<p>💯💯💯💯💯💯🔥🔥🔥🔥🔥🔥🔥🔥🔥</p>'),
(410, 'admin', 'admin@admin.com', 0, '2022-01-04 16:58:23', 'Nsfw', 'Testi postaus 4', '<p><a href=\"https://www.lipsum.com/\">https://www.lipsum.com/</a></p>');

-- --------------------------------------------------------

--
-- Rakenne taululle `rating_info`
--
-- Luotu: 03.01.2022 klo 14:57
--

DROP TABLE IF EXISTS `rating_info`;
CREATE TABLE `rating_info` (
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `rating_action` varchar(30) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `reply_id` int(11) DEFAULT NULL,
  `like_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `rating_info`:
--

--
-- Vedos taulusta `rating_info`
--

INSERT INTO `rating_info` (`user_id`, `post_id`, `rating_action`, `comment_id`, `reply_id`, `like_id`) VALUES
(27, 370, 'like', NULL, NULL, 879),
(27, 376, 'like', NULL, NULL, 881),
(27, NULL, 'like', 348, NULL, 885),
(27, 389, 'like', NULL, NULL, 886),
(27, NULL, 'like', NULL, 796, 889),
(31, 388, 'like', NULL, NULL, 890),
(29, NULL, 'dislike', NULL, 788, 935),
(29, NULL, 'like', 344, NULL, 944),
(29, NULL, 'dislike', 355, NULL, 980),
(29, NULL, 'like', NULL, 800, 981),
(29, NULL, 'dislike', NULL, 807, 988),
(35, NULL, 'like', 443, NULL, 990),
(35, NULL, 'dislike', NULL, 817, 991),
(35, NULL, 'dislike', 444, NULL, 992),
(35, NULL, 'like', 445, NULL, 993),
(35, 401, 'like', NULL, NULL, 994),
(35, 402, 'dislike', NULL, NULL, 995),
(35, NULL, 'like', 446, NULL, 996),
(35, 405, 'like', NULL, NULL, 997),
(0, NULL, 'like', 445, NULL, 998),
(0, NULL, 'dislike', 444, NULL, 999),
(0, NULL, 'dislike', NULL, 817, 1001),
(0, 405, 'like', NULL, NULL, 1004),
(0, 401, 'like', NULL, NULL, 1005),
(36, 405, 'like', NULL, NULL, 1006),
(36, 402, 'dislike', NULL, NULL, 1007),
(36, NULL, 'dislike', 444, NULL, 1009),
(0, NULL, 'like', 456, NULL, 1010),
(0, NULL, 'dislike', 457, NULL, 1011),
(0, NULL, 'like', 446, NULL, 1012);

-- --------------------------------------------------------

--
-- Rakenne taululle `replies`
--
-- Luotu: 04.01.2022 klo 14:37
--

DROP TABLE IF EXISTS `replies`;
CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `replies`:
--   `comment_id`
--       `comments` -> `comment_id`
--

--
-- Vedos taulusta `replies`
--

INSERT INTO `replies` (`id`, `comment_id`, `post_id`, `content`, `date`, `user_id`, `name`) VALUES
(817, 443, 401, '<p>Nice</p>', '2022-01-04 14:32:01', 35, 'Vilho Luoma'),
(818, 443, 401, '<p>@Vilho Luoma Nice</p>', '2022-01-04 14:32:10', 35, 'Vilho Luoma'),
(819, 446, 402, '<p>😎😎😎😎😎</p>', '2022-01-04 14:34:53', 35, 'Vilho Luoma'),
(820, 448, 404, '<p><span style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 14px; text-align: justify; background-color: #ffffff;\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</span></p>', '2022-01-04 14:38:38', 35, 'Vilho Luoma'),
(821, 457, 402, '<p>asdasdasd</p>', '2022-01-05 10:23:28', 0, 'admin');

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--
-- Luotu: 15.12.2021 klo 17:01
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login_status` tinyint(4) NOT NULL DEFAULT 1,
  `last_login` datetime NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `login_status`, `last_login`, `image`, `created`) VALUES
(0, 'admin', 'admin@admin.com', '$2y$10$NwGR8mYeWRx9ygNkpGORFOKkY9ycK.0F/ZswCIVLAg/LqTj9r9yMS', 0, '2022-01-05 12:25:48', 'images/profile_images/71ffef5e2aaa95bbc8ee786c3f984889.jpg', '2022-01-05 10:25:48'),
(35, 'Vilho Luoma', 'vilho.luoma@gmail.com', '$2y$10$mjfL8S4ERwk56R/0uI0Lb.aGNqBu6SSbj3/gFWrsGZrfpWacwQuSe', 0, '2022-01-04 05:00:21', 'images/profile_images/331cb832bb849c937f55229610f33102.jpg', '2022-01-04 15:00:21'),
(36, 'testiukko', 'vilho1.luoma@gmail.com', '$2y$10$Xv6xY2q2jEZM0T.PcsVMb./qK1wEAYNE2xdSsWMsUAQ1psh/LVLaG', 1, '2022-01-04 11:57:05', 'images/profile_images/9c394d69966a6594486ed743d30e0ab0.jpg', '2022-01-04 22:09:22');

-- --------------------------------------------------------

--
-- Näkymän rakenne `comment_owner`
--
DROP TABLE IF EXISTS `comment_owner`;

DROP VIEW IF EXISTS `comment_owner`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `comment_owner`  AS SELECT `c`.`user_id` AS `comment_owner`, `c`.`comment_id` AS `comment_id`, `c`.`post_id` AS `post_id`, `c`.`content` AS `content`, `c`.`date` AS `date`, `u`.`user_id` AS `user_id`, `u`.`name` AS `name`, `u`.`image` AS `image` FROM (`comments` `c` join `users` `u` on(`c`.`user_id` = `u`.`user_id`)) ORDER BY `c`.`date` DESC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `FK_comment` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `rating_info`
--
ALTER TABLE `rating_info`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `UC_rating_info` (`user_id`,`post_id`),
  ADD UNIQUE KEY `UC_rating_info_cmt` (`user_id`,`comment_id`),
  ADD UNIQUE KEY `UC_rating_info_reply` (`user_id`,`reply_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_reply` (`comment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=411;

--
-- AUTO_INCREMENT for table `rating_info`
--
ALTER TABLE `rating_info`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1013;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=822;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_comment` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Rajoitteet taululle `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `FK_reply` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
