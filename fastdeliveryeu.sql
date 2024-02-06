-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 06, 2024 at 09:43 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fastdeliveryeu`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_wachtwoorden`
--

CREATE TABLE `admin_wachtwoorden` (
  `id` int(11) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  `admin_wachtwoord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_wachtwoorden`
--

INSERT INTO `admin_wachtwoorden` (`id`, `wachtwoord`, `admin_wachtwoord`) VALUES
(1, '$2y$10$jG0wk.SIF35H2c21xPiDWOkmhxCYfNGG1GAmBJKCcoDhZZogALd5q', '$2a$12$nezq97n8ZYpdAMoBlKbydewWFafqQ51J0f5SLezeyN5Mo/64IMFJ6');

-- --------------------------------------------------------

--
-- Table structure for table `registraties`
--

CREATE TABLE `registraties` (
  `datum` date NOT NULL,
  `tijd` time NOT NULL,
  `sleutelnummer` int(11) NOT NULL,
  `gebruiker` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `registraties`
--

INSERT INTO `registraties` (`datum`, `tijd`, `sleutelnummer`, `gebruiker`) VALUES
('2024-02-05', '19:30:44', 2, 'eee'),
('2024-02-05', '19:31:06', 2, 'fff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_wachtwoorden`
--
ALTER TABLE `admin_wachtwoorden`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_wachtwoorden`
--
ALTER TABLE `admin_wachtwoorden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
