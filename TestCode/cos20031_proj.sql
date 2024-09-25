-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 04:10 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cos20031_proj`
--
CREATE DATABASE IF NOT EXISTS `cos20031_proj` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cos20031_proj`;

-- --------------------------------------------------------

--
-- Table structure for table `userlist`
--

CREATE TABLE `userlist` (
  `id` int(11) NOT NULL,
  `fname` varchar(64) NOT NULL,
  `lname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `userlist`
--
ALTER TABLE `userlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `userlist`
--
ALTER TABLE `userlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1440;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
