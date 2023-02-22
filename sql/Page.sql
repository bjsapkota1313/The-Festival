-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 21, 2023 at 07:38 PM
-- Server version: 10.10.2-MariaDB-1:10.10.2+maria~ubu2204
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `TheFestivalDb`
--

-- --------------------------------------------------------

--
-- Table structure for table `Page`
--

CREATE TABLE `Page` (
  `id` int(11) NOT NULL,
  `URI` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `bodyContentHTML` text NOT NULL,
  `creationTime` datetime NOT NULL DEFAULT current_timestamp(),
  `creatorUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Page`
--

INSERT INTO `Page` (`id`, `URI`, `title`, `bodyContentHTML`, `creationTime`, `creatorUserId`) VALUES
(1, 'home/page', 'Test1', '<h1>Test1</h1>\n<h2>Test2</h2>\n<p>Hello, World!</p>', '2023-02-21 18:46:29', 1),
(2, 'home/page', 'Test2', '<h1>Test1</h1>\r\n<h2>Test2</h2>\r\n<p>Hello, World!</p>\r\n<p>test test test</p>', '2023-02-21 18:48:32', 1),
(3, 'home/page', 'Test3', '<p>Hello, World!</p>\r\n<p>Test 3</p>', '2023-02-21 18:52:58', 1),
(4, 'home/page', 'Test5', '<p>Hello, World!</p>\r\n<p>asdf</p>\r\n<p>sdaf</p>\r\n<p>sdaf</p>\r\n<p>sdaf</p>\r\n<p>&nbsp;</p>', '2023-02-21 19:28:53', 1),
(5, 'home/page', 'Test6', '<p>Hello, World!</p>\r\n<p>test</p>\r\n<p>test</p>\r\n<p>test</p>\r\n<p>test</p>\r\n<p>asdf</p>\r\n<p>test</p>\r\n<p>asdf</p>\r\n<p>qwerty</p>', '2023-02-21 19:31:12', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Page`
--
ALTER TABLE `Page`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Page`
--
ALTER TABLE `Page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
