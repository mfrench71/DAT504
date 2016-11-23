-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2016 at 03:47 PM
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
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `timeBalance` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Running total of user''s time credit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `timeBalance`) VALUES
(1, 'mfrench71', 'password', 'matthew@timebank.com', 'Matthew', 'French', 0),
(2, 'cyemm71', 'password', 'cass@timebank.com', 'Catherine', 'Yemm', 2),
(3, 'ged', 'password', 'ged@timebank.com', 'Ged', 'Kauri', 1);

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
  `timeAcceptedByUserId` tinyint(11) NOT NULL DEFAULT '0' COMMENT 'Which user has accepted time?',
  `timeApproved` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Has user approved time? (1=Yes, 0=No)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userskills`
--

INSERT INTO `userskills` (`id`, `user_id`, `skill_id`, `skillRequested`, `skillOffered`, `timeOffered`, `timeOfferedByUserId`, `timeAccepted`, `timeAcceptedByUserId`, `timeApproved`) VALUES
(1, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(2, 1, 2, 0, 0, 0, 0, 0, 0, 0),
(3, 1, 3, 0, 1, 0, 0, 0, 0, 0),
(4, 1, 4, 1, 0, 0, 0, 0, 0, 0),
(5, 1, 5, 0, 0, 0, 0, 0, 0, 0),
(6, 1, 6, 0, 1, 0, 0, 0, 0, 0),
(7, 1, 7, 0, 0, 0, 0, 0, 0, 0),
(8, 1, 8, 1, 0, 0, 0, 0, 0, 0),
(9, 2, 1, 0, 0, 0, 0, 0, 0, 0),
(10, 2, 2, 0, 0, 0, 0, 0, 0, 0),
(11, 2, 3, 1, 0, 0, 0, 0, 0, 0),
(12, 2, 4, 0, 1, 0, 0, 0, 0, 0),
(13, 2, 5, 0, 0, 0, 0, 0, 0, 0),
(14, 2, 6, 1, 0, 0, 0, 0, 0, 0),
(15, 2, 7, 0, 0, 0, 0, 0, 0, 0),
(16, 2, 8, 0, 1, 0, 0, 0, 0, 0),
(23, 3, 5, 0, 1, 0, 0, 0, 0, 0),
(24, 3, 7, 0, 1, 0, 0, 0, 0, 0),
(25, 3, 1, 1, 0, 0, 0, 0, 0, 0),
(26, 3, 3, 1, 0, 0, 0, 0, 0, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `userskills`
--
ALTER TABLE `userskills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
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
