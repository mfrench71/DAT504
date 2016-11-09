-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2016 at 03:36 PM
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
(6, 'Dog Walking');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `timeBalance` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Running total of user''s time credit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `firstname`, `lastname`, `timeBalance`) VALUES
(25, 'matthew1@timebank.com', 'password', 'Matthew', 'French', 1),
(26, 'matthew@timebank.com', 'password', 'Matthew', 'French', 1),
(27, 'chris@timebank.com', 'password', 'Chris', 'Maycock', 1),
(28, 'ged@timebank.com', 'password', 'Ged', 'Kauri', 1);

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
(40, 25, 6, 0, 1, 0, 0, 0, 0),
(41, 25, 1, 0, 0, 0, 0, 0, 0),
(42, 25, 2, 1, 1, 0, 0, 0, 0),
(43, 26, 6, 0, 1, 0, 0, 0, 0),
(44, 26, 3, 0, 1, 0, 0, 0, 0),
(45, 26, 1, 1, 0, 0, 0, 0, 0),
(46, 26, 4, 1, 0, 0, 0, 0, 0),
(47, 27, 2, 0, 1, 0, 0, 0, 0),
(48, 27, 3, 1, 0, 0, 0, 0, 0),
(49, 28, 5, 0, 1, 0, 0, 0, 0),
(50, 28, 3, 0, 1, 0, 0, 0, 0),
(51, 28, 2, 0, 0, 0, 0, 0, 0),
(52, 28, 6, 1, 0, 0, 0, 0, 0),
(53, 27, 1, 0, 1, 0, 0, 0, 0),
(54, 27, 5, 1, 0, 0, 0, 0, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `userskills`
--
ALTER TABLE `userskills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
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
