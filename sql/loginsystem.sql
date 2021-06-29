-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2021 at 12:33 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `uname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pwd` varchar(256) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uname`, `email`, `pwd`, `role`) VALUES
(1, 'dibya', 'dibyadarshanip@gmail.com', '$2y$10$2mo5tgXrXyW08kzTtLgUQ.i/tauGew0sQBJZmG4MT62TlOZyKEu2.', 'customer'),
(2, 'manufacturer1', 'samplemanufacturer@gmail.com', '$2y$10$YtYfn87h0t8vlLPfBrSpkOK1.nxQjHzOSZ9bfQb99lXaFU6rHJEFi', 'manufacturer'),
(3, 'pharmacist1', 'samplepharmacist@gmail.com', '$2y$10$SO0sieWgsSMNq6QMp/hy7uPIGC0L/tzgM4Dz5i3RRziNZbNzsifrq', 'pharmacist'),
(4, 'distributor1', 'sampledistributor@gmail.com', '$2y$10$Kg.5JFDvAlM3UU4y26pTDO15x2y/U6S6XVCtrGH7oqvEE.GOqxloi', 'distributor'),
(5, 'dd', 'dibyaddp@gmail.com', '$2y$10$PI.zzlMPctYeI6kBTNsjGuLlQRTHU9Ft8eRUi6X2pFtbQiMlvbyZy', 'customer'),
(6, 'customer1', 'samplecustomer@gmail.com', '$2y$10$B4E47x1HYiEGh4.Bq9kdX.gUMaJppvdoLQKni8/O8YDKQQ/iw76zS', 'customer');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
