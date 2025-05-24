-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Server: 127.0.0.1
-- Generation Time: May 24, 2025 at 14:42:26
-- Server Version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamming_01`
--

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `name`, `picture`) VALUES
(4, 'League of Legends', 'picture1.jpeg'),
(5, 'Dota 2', 'picture2.png'),
(6, 'Counter-Strike: Global Offensive', 'picture3.png'),
(7, 'Fortnite', 'picture4.png'),
(8, 'Valorant', 'picture5.png'),
(9, 'Apex Legends', 'picture6.jpeg'),
(10, 'Rainbow Six Siege', 'picture7.png'),
(11, 'Overwatch', 'picture8.png'),
(12, 'Call of Duty: Warzone', 'picture9.png'),
(13, 'Rocket League', 'picture10.png'),
(14, 'PUBG: Battlegrounds', 'picture11.png'),
(15, 'Hearthstone', 'picture12.png'),
(16, 'Street Fighter V', 'picture13.png'),
(17, 'Brawlhalla', 'picture14.png'),
(18, 'Clash of Clans', 'picture15.jpeg'),
(19, 'FIFA 25', 'picture16.png'),
(20, 'Magic: The Gathering Arena', 'picture17.jpeg'),
(21, 'StarCraft II', 'picture18.png'),
(22, 'Garena Free Fire', 'picture19.png'),
(23, 'Teamfight Tactics', 'picture20.jpeg'),
(24, 'Team Fortress 2', 'picture21.png'),
(25, 'World of Tanks', 'picture22.png'),
(26, 'Marvel Rivals', 'picture23.jpeg'),
(27, 'Brawl Stars', 'picture24.jpeg'),
(28, 'Smite', 'picture25.png'),
(29, 'Paladins', 'picture26.png'),
(30, 'War Thunder', 'picture27.png'),
(31, 'Clash Royale', 'picture28.png'),
(32, 'Tekken 7', 'picture29.png'),
(33, 'Dead by Daylight', 'picture30.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pref_game` int(11) DEFAULT NULL,
  `highest_rank` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Dumping data for table `users`
--
--
-- Indexes for dumped tables
--
--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `picture` (`picture`);
--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_pref_game` (`pref_game`),
  ADD KEY `fk_highest_rank` (`highest_rank`);
--
-- AUTO_INCREMENT values for dumped tables
--
--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Foreign key constraints for dumped tables
--
--
-- Foreign key constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_highest_rank` FOREIGN KEY (`highest_rank`) REFERENCES `games` (`id`),
  ADD CONSTRAINT `fk_pref_game` FOREIGN KEY (`pref_game`) REFERENCES `games` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
