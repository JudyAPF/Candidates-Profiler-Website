-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2024 at 09:51 AM
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
-- Database: `candidates_profiler`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `idno` int(11) NOT NULL,
  `firstname` varchar(55) NOT NULL,
  `lastname` varchar(55) NOT NULL,
  `mi` varchar(55) NOT NULL,
  `sex` varchar(55) NOT NULL,
  `address` varchar(255) NOT NULL,
  `party` varchar(55) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`idno`, `firstname`, `lastname`, `mi`, `sex`, `address`, `party`, `picture`) VALUES
(11, 'Hann', 'Solace', 'P.', 'Female', 'Urdaneta City, Pangasinan', '4PS', 'Uploaded_Image/365462149_262576279858526_7177448936465090024_n.jpg'),
(12, 'Kate', 'Lei', 'M.', 'Female', 'Dagupan City, Pangasinan', '1-RIDER PARTYLIST', 'Uploaded_Image/359495176_828778615437190_571760413338612381_n.jpg'),
(13, 'Kieszer', 'Harred', 'H.', 'Male', 'Baguio City, Benguet', 'ACT TEACHERS', 'Uploaded_Image/375574514_321830730260409_8673552187699924281_n.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`idno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `idno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
