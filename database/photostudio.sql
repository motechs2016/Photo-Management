-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2016 at 11:27 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photostudio`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_uname` varchar(45) NOT NULL,
  `account_pass` text NOT NULL,
  `account_status` varchar(45) NOT NULL,
  `employee_id` varchar(45) NOT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_uname_UNIQUE` (`account_uname`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `account_uname`, `account_pass`, `account_status`, `employee_id`) VALUES
(1, 'client', '$2y$10$MDQRgp5ffKeoJw8kFjsx1ONVgJGdzJFIHgdbxwkvXAO3dY/zW1UoC', 'client', '1001'),
(2, 'head', '$2y$10$bPIbr9o.npT8nIcLESm0y.Hgxoot2qguytkus2Ve9wydP1Ds5KRLm', 'head', '2'),
(4, 'admin', '$2y$10$FSSTPZCUaLHzBj4F0mRvFem/tW5zjHcZuQVeCzietKXJQXKHEy9kK', 'admin', '5'),
(7, 'worker', '$2y$10$GLer4Uif1O/SZFqi6Vo1xeq0X9PWD4tpsz.kONRRdXcnMgiM25r9y', 'worker', '3'),
(8, 'rdunn', '$2y$10$op1oSM189pf7Zx2viCWe.uNwzbkawWvlvsh7lSL1xFbr9dIrMXnia', 'client', '1002'),
(9, 'spearja', '$2y$10$tjpePbPgOB7O3fPAOaL/N.wtD6lCZqnt8kgRWoi/NxrQDzkSVf8p2', 'worker', '4'),
(10, 'bmitchum', '$2y$10$24bnPVqj54IelWC2Qj365.wzuHIAl/OahPLSdF2xWjtCUFffInSyO', 'worker', '31');

-- --------------------------------------------------------

--
-- Table structure for table `assigns`
--

DROP TABLE IF EXISTS `assigns`;
CREATE TABLE IF NOT EXISTS `assigns` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `assign_done` int(11) DEFAULT '0',
  `assign_completed` date DEFAULT NULL,
  PRIMARY KEY (`assign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `assigns`
--

INSERT INTO `assigns` (`assign_id`, `order_id`, `worker_id`, `assign_done`, `assign_completed`) VALUES
(19, 20, 4, 20, '2016-01-15'),
(20, 21, 31, 15, '2016-01-14'),
(21, 22, 31, 9, '2016-01-26'),
(22, 23, 4, 27, '2016-01-20'),
(23, 24, 3, 25, '2016-01-31'),
(24, 25, 3, 31, '2016-02-15'),
(25, 26, 3, 15, '2016-02-10'),
(26, 27, 4, 28, '2016-02-09'),
(27, 28, 31, 34, '2016-03-02'),
(28, 33, 4, 47, '2016-03-25'),
(29, 34, 3, 15, '2016-03-13'),
(30, 35, 31, 30, '2016-03-27'),
(31, 36, 3, 11, '2016-03-23'),
(32, 37, 3, 15, '2016-04-10'),
(33, 38, 4, 20, '2016-04-15'),
(34, 39, 3, 20, '2016-04-20'),
(35, 40, 31, 22, '2016-04-23'),
(36, 41, 3, 11, NULL),
(37, 42, 4, 35, '2016-06-27'),
(38, 44, 31, 30, '2016-01-17'),
(39, 45, 4, 15, '2016-01-18'),
(40, 46, 4, 18, '2016-01-28'),
(41, 47, 3, 12, '2016-02-04'),
(42, 48, 31, 19, '2016-02-20'),
(43, 49, 3, 60, '2016-03-31'),
(44, 53, 31, 15, '2016-04-10'),
(45, 54, 4, 18, '2016-04-15'),
(46, 55, 3, 13, '2016-04-15'),
(47, 56, 3, 9, '2016-04-28'),
(48, 57, 3, 11, '2016-05-06'),
(49, 58, 31, 30, '2016-05-09'),
(50, 59, 3, 12, '2016-06-27'),
(51, 61, 3, 3, '2016-05-03'),
(52, 63, 3, 21, NULL),
(53, 43, 31, 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(45) DEFAULT NULL,
  `client_surname` varchar(45) DEFAULT NULL,
  `client_date` varchar(45) DEFAULT NULL,
  `client_firm` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `client_surname`, `client_date`, `client_firm`) VALUES
(1001, 'Ed', 'Laur', '2015-05-18', 'Man of the world'),
(1002, 'Ryan', 'Dunn', '2015-09-20', 'Aramark');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_sender` varchar(45) NOT NULL,
  `message_receiver` varchar(45) NOT NULL,
  `message_text` text NOT NULL,
  `message_date` datetime NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `message_sender`, `message_receiver`, `message_text`, `message_date`) VALUES
(25, '2', '1001', 'Welcome to company!', '2016-05-02 23:19:42'),
(26, '1001', '2', 'Thank you. I have a couple of folders already.', '2016-05-02 23:20:06'),
(27, '1001', '2', 'How long it takes to edit 20 photos?', '2016-05-02 23:20:39'),
(28, '2', '1001', 'No longer than 4 working days.', '2016-05-02 23:23:18'),
(29, '2', '3', 'I like your attitude, keep it going!', '2016-05-02 23:23:56'),
(30, '2', '4', 'Welcome to company!', '2016-05-02 23:26:35'),
(31, '2', '4', 'Try to finish Swimsuits as soon as possible', '2016-05-02 23:26:48'),
(32, '4', '2', 'I am trying my best', '2016-05-02 23:27:20'),
(33, '31', '2', 'I have done everything. Waiting on new orders!', '2016-05-03 01:10:35'),
(34, '1002', '2', 'Hello Sasha, tomorrow I will send some new photos.', '2016-05-03 01:11:59'),
(35, '2', '1002', 'OK. We are waiting', '2016-05-03 01:12:43'),
(36, '2', '31', 'Wait for it. Connie will send some soon.', '2016-05-03 01:13:12'),
(37, '3', '2', 'Thank you!', '2016-05-03 01:14:46'),
(38, '2', '3', 'You are doing awesome job.', '2016-05-03 01:22:56'),
(39, '1001', '2', 'Thanks bro', '2016-06-26 21:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(45) NOT NULL,
  `order_folder` varchar(45) NOT NULL,
  `order_submitted` date NOT NULL,
  `order_due` varchar(45) NOT NULL,
  `order_photos` varchar(45) NOT NULL,
  `order_status` varchar(45) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `client_id`, `order_folder`, `order_submitted`, `order_due`, `order_photos`, `order_status`) VALUES
(20, '1001', 'Bikes', '2016-01-10', '2016-01-17', '20', 'Done'),
(21, '1001', 'Valentines Day', '2016-01-13', '2016-01-15', '15', 'Done'),
(22, '1001', 'Furniture', '2016-01-15', '2016-01-26', '9', 'Done'),
(23, '1001', 'Drinks', '2016-01-19', '2016-05-21', '27', 'Done'),
(24, '1001', 'Food', '2016-01-23', '2016-02-05', '25', 'Done'),
(25, '1001', 'Cases', '2016-01-31', '2016-02-18', '31', 'Done'),
(26, '1001', 'Grill', '2016-02-04', '2016-02-12', '15', 'Done'),
(27, '1001', 'Women Day', '2016-02-15', '2016-02-22', '28', 'Done'),
(28, '1001', 'Clothes', '2016-02-21', '2016-03-08', '34', 'Done'),
(33, '1001', 'Fashion', '2016-03-14', '2016-03-29', '47', 'Done'),
(34, '1001', 'Toys', '2016-03-11', '2016-03-14', '15', 'Done'),
(35, '1001', 'Pants', '2016-03-19', '2016-03-28', '30', 'Done'),
(36, '1001', 'iPhone Cases', '2016-03-22', '2016-03-23', '11', 'Done'),
(37, '1001', 'Laptops', '2016-04-02', '2016-04-11', '15', 'Done'),
(38, '1001', 'Rugs', '2016-04-15', '2016-04-19', '20', 'Done'),
(39, '1001', 'Beds', '2016-04-20', '2016-04-24', '20', 'Done'),
(40, '1001', 'Kids', '2016-04-22', '2016-04-29', '22', 'Done'),
(41, '1001', 'Games', '2016-04-27', '2016-05-05', '27', 'In progress'),
(42, '1001', 'Swimsuits', '2016-04-29', '2016-05-12', '35', 'Done'),
(43, '1001', 'Vacation Goals', '2016-05-02', '2016-05-24', '20', 'In progress'),
(44, '1002', 'Boys clothes', '2016-01-10', '2016-01-20', '30', 'Done'),
(45, '1002', 'Ammo', '2016-01-18', '2016-01-22', '15', 'Done'),
(46, '1002', 'Crossbows', '2016-01-25', '2016-01-30', '18', 'Done'),
(47, '1002', 'Health', '2016-02-01', '2016-02-10', '12', 'Done'),
(48, '1002', 'Lake', '2016-02-11', '2016-02-26', '19', 'Done'),
(49, '1002', 'Little secrets', '2016-03-02', '2016-03-31', '60', 'Done'),
(53, '1002', 'Keyboards', '2016-04-02', '2016-04-11', '15', 'Done'),
(54, '1002', 'Rottens', '2016-04-09', '2016-04-17', '28', 'Done'),
(55, '1002', 'Chairs', '2016-04-10', '2016-04-15', '13', 'Done'),
(56, '1002', 'IKEA', '2016-04-21', '2016-04-29', '9', 'Done'),
(57, '1002', 'Housekeeping', '2016-05-02', '2016-05-06', '11', 'Done'),
(58, '1002', 'Summer', '2016-05-03', '2016-05-10', '30', 'Done'),
(59, '1002', 'Powell', '2016-05-09', '2016-05-17', '12', 'Done'),
(60, '1002', 'Kayaking', '2016-05-09', '2016-05-27', '21', 'Not started'),
(61, '1002', 'Urgent', '2016-05-03', '2016-05-04', '3', 'Done'),
(63, '1001', 'WoW Legion', '2016-06-27', '2016-08-30', '69', 'In progress');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

DROP TABLE IF EXISTS `workers`;
CREATE TABLE IF NOT EXISTS `workers` (
  `worker_id` int(11) NOT NULL AUTO_INCREMENT,
  `worker_name` varchar(45) DEFAULT NULL,
  `worker_surname` varchar(45) DEFAULT NULL,
  `worker_date` date DEFAULT NULL,
  `worker_status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`worker_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`worker_id`, `worker_name`, `worker_surname`, `worker_date`, `worker_status`) VALUES
(2, 'Sasha', 'Beliy', '2012-02-28', 'Head'),
(3, 'Nice', 'Girl', '2016-01-14', 'Worker'),
(4, 'Stanislav', 'Pearja', '2015-04-09', 'Worker'),
(5, 'Johnny', 'Knoxville', '2012-01-12', 'Admin'),
(31, 'Bic', 'Mitchum', '2014-03-08', 'Worker');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
