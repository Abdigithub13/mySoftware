-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 12:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flight_booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('pending','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flights`
--

CREATE TABLE `flights` (
  `id` int(11) NOT NULL,
  `flight_model` varchar(100) NOT NULL,
  `name` varchar(150) NOT NULL,
  `total_seats` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `departure_city` varchar(100) NOT NULL,
  `destination_city` varchar(100) NOT NULL,
  `departure_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flights`
--

INSERT INTO `flights` (`id`, `flight_model`, `name`, `total_seats`, `price`, `departure_city`, `destination_city`, `departure_date`, `created_at`) VALUES
(3, 'B19', 'Boing234', 300, 2000.00, 'Addis Ababa', 'Dubai', '2025-01-25', '2025-01-23 21:43:01'),
(4, 'F12', 'NNM', 200, 1000.00, 'Addid Ababa', 'Dire Dawa', '2025-01-24', '2025-01-24 09:35:56'),
(5, 'BOING', 'G3', 100, 2000.00, 'Dire Dawa', 'Makele', '2025-01-24', '2025-01-24 09:37:15');

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `age` int(11) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `passenger`
--

INSERT INTO `passenger` (`id`, `username`, `gender`, `age`, `address`, `created_at`) VALUES
(6, 'bona@gmail.com', 'male', 21, 'Dire-Dawa University, Dire Dawa, Ethiopia', '2025-01-24 09:10:48'),
(7, 'bona@gmail.com', 'male', 21, 'Dire-Dawa University, Dire Dawa, Ethiopia', '2025-01-24 09:22:27'),
(8, 'bona@gmail.com', 'male', 2, 'Adama', '2025-01-24 09:25:33'),
(9, 'bona@gmail.com', '', 0, '', '2025-01-24 09:33:27'),
(10, 'sena@gmail.com', '', 0, '', '2025-01-24 09:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `flight_id` int(11) NOT NULL,
  `seat_number` varchar(10) NOT NULL,
  `is_reserved` tinyint(1) DEFAULT 0,
  `reserved_by` int(11) DEFAULT NULL,
  `is_booked` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$0IPSyqn6LKByqd3rXiq0yeKW3YwZ2bNG4Tdqr44slrxFf8hLY7wb.', 'admin', '2025-01-23 20:00:40'),
(2, 'Geda Mulatu', 'geda@gmail.com', '$2y$10$z9jBy2pAotDvzrMfBBD1tuTHY/7/FJBDfC1TQWNYG9w2zzO8sHJNG', 'user', '2025-01-23 20:21:04'),
(5, 'Dibora Mulatu', 'dibora@gmail.com', '$2y$10$uE5JyKCMUYOyNSdOBhExgeOROnHk0F5S.gJYOIWurLAhnl2Kf9SKq', 'user', '2025-01-23 22:03:04'),
(6, 'Chera Geda', 'chero@gmail.com', '$2y$10$DPx7N6L8nb3aXGW.G9Ibg.j4DWPP1/rNzzOPz.rjg9gxbD4OLPciS', 'user', '2025-01-23 23:44:27'),
(7, 'Abdi', 'abdi@gmail.com', '$2y$10$8xyyNjc.7/7glMQeAXwM5.pD7e9TGBAZUOz3zrQ2LlM6XcbyFCWpC', 'user', '2025-01-24 06:47:56'),
(8, 'Bona ', 'bona@gmail.com', '$2y$10$LWP2M6a7/rgmulwP2fJUse5wZpstG1F9hHZrFdvPOKb5rk2oi71ky', 'user', '2025-01-24 07:55:18'),
(9, 'Sena', 'sena@gmail.com', '$2y$10$FLuCDgAqHjZHYkYAlUFBEO9br1D6gsmFeXtZaFXCOxzwSb1U5VLEm', 'user', '2025-01-24 09:40:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `flight_id` (`flight_id`,`seat_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `flight_id` (`flight_id`,`seat_number`),
  ADD KEY `reserved_by` (`reserved_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `flights`
--
ALTER TABLE `flights`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `passenger`
--
ALTER TABLE `passenger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seats_ibfk_2` FOREIGN KEY (`reserved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
