-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2024 at 05:34 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `budget_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `id` int(11) NOT NULL,
  `type` enum('weekly','monthly') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`id`, `type`, `amount`, `start_date`, `end_date`, `user_id`) VALUES
(20, 'monthly', '5000.00', '2024-08-01', '2024-08-31', 1),
(21, 'monthly', '15000.00', '2024-08-01', '2024-08-31', 2);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `expense` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `savings_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `budget_id`, `category`, `expense`, `date`, `savings_id`, `user_id`) VALUES
(19, 20, 'boarding house', '3000.00', '2024-08-31', NULL, 1),
(20, 20, 'grocery', '2000.00', '2024-08-11', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `id` int(11) NOT NULL,
  `budget_id` int(11) NOT NULL,
  `category` enum('emergency','education','vacation','gadget','home purchases','investment','vehicle','personal','others') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`id`, `budget_id`, `category`, `amount`, `date`, `user_id`) VALUES
(8, 20, 'vacation', '15000.00', '2024-08-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `pass`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Noriel Bagacay', 'norielbagacay1@gmail.com', '$2y$10$NvTzV8EOjsMKcDlZ5b8T0.Tt82awlD/nemonDJoB0sRDtjRwYZYY6', '53b5d01ab9bd39a6b827be65d19ef89e95f05f0231434cfc4419beb6ecb61929', '2024-08-11 16:38:07'),
(2, 'Darth', 'darthzeether@gmail.com', '$2y$10$ygWVgLajnFpnQTAErKn8nuKCpiIDibz601RTaAbIl5JX5mQ1tDSCm', NULL, NULL),
(3, 'user1', 'darthzeether1@gmail.com', '$2y$10$Xo8Ug6LBknqImXkHM8IBRuLHv1ONwT9xzfq7Z3gg9LRxUxDuanaua', '0cdb0a113bc2b4c1581dcd3b9cf76a3d242fe572b83f1dc12a1075bb72490637', '2024-08-10 16:34:21'),
(5, 'Rose Mica Janoyan', 'rosemicajanoyan@gmail.com', '$2y$10$usDSEzQDK78IrZez7N2AD.gebmagdoE6yrCEh2fimEU5MHsFrWqrK', '6a3d674bf201b1f11ccb26e84dd619c656a9599cac0ff8365a2dfe4716476977', '2024-08-10 17:47:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_ibfk_1` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_id` (`budget_id`),
  ADD KEY `expenses_ibfk_2` (`savings_id`),
  ADD KEY `expenses_ibfk_3` (`user_id`);

--
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_id` (`budget_id`),
  ADD KEY `savings_ibfk_2` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`budget_id`) REFERENCES `budget` (`id`),
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`savings_id`) REFERENCES `savings` (`id`),
  ADD CONSTRAINT `expenses_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `savings`
--
ALTER TABLE `savings`
  ADD CONSTRAINT `savings_ibfk_1` FOREIGN KEY (`budget_id`) REFERENCES `budget` (`id`),
  ADD CONSTRAINT `savings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
