-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2016 at 03:07 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timebank`
--
CREATE DATABASE IF NOT EXISTS `timebank` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `timebank`;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `skillname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skillname`) VALUES
(1, 'Gardening'),
(2, 'Painting & Decorating'),
(3, 'Information Technology'),
(4, 'Shopping'),
(5, 'Baby Sitting'),
(6, 'Dog Walking'),
(7, 'Car Washing'),
(8, 'Accounts & Book Keeping');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(16) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `timeBalance` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Running total of user''s time credit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `timeBalance`) VALUES
(1, 'matthew@timebank.com', 'password', 'Matthew', 'French', 8),
(2, 'catherine@timebank.com', 'password', 'Catherine', 'Yemm', 11),
(5, 'chris@timebank.com', 'password', 'Chris', 'Maycock', 2),
(6, 'ged@timebank.com', 'password', 'Ged', 'Kauri', 1),
(7, 'ryan@timebank.com', 'password', 'Ryan', 'Curnow', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userskills`
--

CREATE TABLE `userskills` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `skillRequested` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is user requesting this skill? (1=Yes, 0=No)',
  `skillOffered` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Is user offering this skill? (1=Yes, 0=No)',
  `timeOffered` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Has a user offered their time? (1=Yes, 0=No) ',
  `timeOfferedByUserId` int(11) NOT NULL DEFAULT '0' COMMENT 'Which user has offered time?',
  `timeAccepted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Has a user accepted their time offer? (1=Yes, 0=No)',
  `timeAcceptedByUserId` tinyint(11) NOT NULL DEFAULT '0' COMMENT 'Which user has accepted time?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userskills`
--

INSERT INTO `userskills` (`id`, `user_id`, `skill_id`, `skillRequested`, `skillOffered`, `timeOffered`, `timeOfferedByUserId`, `timeAccepted`, `timeAcceptedByUserId`) VALUES
(3, 1, 3, 0, 1, 0, 0, 0, 0),
(10, 2, 3, 1, 0, 0, 0, 0, 0),
(20, 1, 6, 1, 0, 0, 0, 0, 0),
(21, 2, 6, 0, 1, 0, 0, 0, 0),
(22, 5, 6, 0, 1, 0, 0, 0, 0),
(23, 5, 1, 0, 1, 0, 0, 0, 0),
(24, 5, 3, 0, 1, 0, 0, 0, 0),
(25, 5, 2, 1, 0, 0, 0, 0, 0),
(26, 5, 4, 1, 0, 0, 0, 0, 0),
(27, 6, 7, 0, 1, 0, 0, 0, 0),
(28, 6, 3, 0, 1, 0, 0, 0, 0),
(29, 6, 4, 0, 1, 0, 0, 0, 0),
(30, 6, 8, 1, 0, 0, 0, 0, 0),
(31, 6, 2, 1, 0, 0, 0, 0, 0),
(32, 7, 6, 0, 1, 0, 0, 0, 0),
(33, 7, 3, 0, 1, 0, 0, 0, 0),
(34, 7, 8, 1, 0, 0, 0, 0, 0),
(35, 7, 2, 1, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `userskills`
--
ALTER TABLE `userskills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userskillsIndex` (`user_id`,`skill_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `userskills`
--
ALTER TABLE `userskills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `userskills`
--
ALTER TABLE `userskills`
  ADD CONSTRAINT `userskills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `userskills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
