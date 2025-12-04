-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 07:47 PM
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
-- Database: `game_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `platform` varchar(50) DEFAULT NULL,
  `release_date` int(11) DEFAULT NULL,
  `status` enum('Backlog','Playing','Completed','Dropped') DEFAULT 'Backlog',
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 10),
  `hours_played` decimal(6,1) DEFAULT 0.0,
  `notes` text DEFAULT NULL,
  `dates_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `user_id`, `title`, `genre`, `platform`, `release_date`, `status`, `rating`, `hours_played`, `notes`, `dates_added`) VALUES
(1, 9, 'Tekken 8', 'Fighting', 'PC', NULL, '', NULL, 1000.0, NULL, '2025-11-10 17:21:42'),
(2, 9, 'Tekken', 'Fighting', 'PC', NULL, 'Completed', NULL, 1000.0, NULL, '2025-11-10 17:23:42'),
(3, 9, 'Tekken', 'Fighting', 'PC', NULL, 'Completed', NULL, 1000.0, NULL, '2025-11-10 17:29:05'),
(6, 11, 'Tekken 8', 'Fighting', 'PC', NULL, 'Completed', 5, 0.0, NULL, '2025-11-22 11:51:31'),
(7, 12, 'Tekken 8', 'Fighting', 'PC', NULL, 'Playing', 10, 0.0, NULL, '2025-11-24 19:34:46'),
(8, 12, 'Fortnite', 'Fighting', 'PC', NULL, 'Backlog', 9, 0.0, NULL, '2025-11-24 19:35:17'),
(9, 24, 'Tekken 8', 'Fighting', 'PC', NULL, 'Completed', 7, 0.0, NULL, '2025-11-26 18:35:08'),
(11, 25, 'Tekken 8', 'Fighting', 'PC', NULL, 'Completed', 7, 0.0, NULL, '2025-11-27 17:35:41'),
(14, 26, 'Tekken 8', 'Fighting', 'PS5, Xbox Series X, PC', 2024, 'Backlog', NULL, 0.0, NULL, '2025-12-01 18:47:56'),
(15, 26, 'Elden Ring', 'Action RPG', 'PC', 2022, 'Backlog', NULL, 0.0, NULL, '2025-12-01 18:48:07'),
(16, 26, 'Cyberpunk 2077', 'RPG', 'PC', 2020, 'Backlog', NULL, 0.0, NULL, '2025-12-01 19:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'testuser', 'test@example.com', '$2y$10$YeYI7twXp5ca74hEvbgPX.hmwRS0xDYXwJrKkRDz.uBfXWibqKOB6', '2025-11-05 12:50:32'),
(3, 'testusers', 'tests@example.com', '$2y$10$zEWzruvSekmqOvFl/8k4WOUmAyEXi..Vq7kKAf.TiHics8EgQJdXq', '2025-11-05 13:01:27'),
(6, 'Simone', 'simonepisani71@gmail.com', '$2y$10$WIWj6ATBT7FhyfF8Aycy5.4ig3KIXZRnJrPW/bzM3DjLRjumhAC06', '2025-11-07 12:52:26'),
(7, 'Nikki', 'nikkidegiorgio26@gmail.com', '$2y$10$R68Me881IJHFOv73yKJMi.Pev0mRoSVyA6ccZBoD1orMNB60T40dW', '2025-11-07 18:52:50'),
(9, 'Ethanos', 'ethanpisani711@gmail.com', '$2y$10$peQ60MSGQan.RZhT1QM4Y.dsAk7nOxrx7XIioJR82sRyD7qkCfglu', '2025-11-10 17:18:43'),
(11, 'Ethan', 'ethanpisani72@gmail.com', '$2y$10$UtaGFy0nz0CkN1uyRk5yle8JYy0EBtsrUuTod7xVHXa1zWvYfroGO', '2025-11-18 10:08:33'),
(12, 'testuser123', 'ethanpisani71234@gmail.com', '$2y$10$LX70ZOhQhH5MNEUIMpc9suNg9ez47xnH8h8U83tGIYdcM6P1L0qN6', '2025-11-24 13:04:31'),
(23, 'testuser1234', 'ethanpisani7343@gmail.com', '$2y$10$5uIobaiC/2yEbqceqfY5JudwMYfBfMXdHadB1B4Ny33wPaOAdAQAG', '2025-11-25 12:26:01'),
(24, 'John', 'johnjuniormalta@gmail.com', '$2y$10$ICxRZylwf8pNygFto1hhvONhV2dHTrxE84Z1irnpLmQQLdfLuZ786', '2025-11-26 18:33:15'),
(25, 'testuser12345', 'testuser1@gmail.com', '$2y$10$hDGp/sC2E9CoixzfpM5Anekf0iihuiq8hv5JINNMrf/p.uRY4F6Ya', '2025-11-27 17:28:47'),
(26, 'bob', 'ethanpisani7222@gmail.com', '$2y$10$UsLkhFBgLuBM2P8BcZnKXucaL4/XzFUcod6I6AqVubQM4c6qqINjy', '2025-11-29 10:27:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
