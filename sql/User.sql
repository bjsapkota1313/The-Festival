-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 10, 2023 at 09:44 PM
-- Server version: 10.9.4-MariaDB-1:10.9.4+maria~ubu2204
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
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `registrationDate` date NOT NULL DEFAULT current_timestamp(),
  `picture` varchar(100) DEFAULT 'not available',
  `role` enum('Customer','Administrator','Employee') DEFAULT 'Customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `firstName`, `lastName`, `dateOfBirth`, `email`, `password`, `registrationDate`, `picture`, `role`) VALUES
(1, 'Sara', 'Eftekhar', '1993-02-03', 'Sara@gmail.com', '$2y$10$KCauhzvfh6VgUnbAQVk0tOc36q5hg1IPF3ABLgqIg0QYkBZMIi5HG', '2023-02-09', 'N/A', 'Administrator'),
(2, 'Alice', '', '0000-00-00', 'Alice@gmail.com', '$2y$10$4f9qMs.A5OHThQSFpjRGyuGifS8PBQkMOTuZjNgBly9Qxdyy4pJ9u', '2023-02-09', 'not available', 'Customer'),
(3, 'Bob', '', '0000-00-00', 'Bob@gmail.com', '$2y$10$HCBGn9o1aiWEPdC2nWGB9ecOizy2a9QERxnQc/ywrgmUaE2a7lt/e', '2023-02-09', 'not available', 'Employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
