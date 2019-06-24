-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 11, 2016 at 04:49 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `metodeElectre`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `namaAlternatif` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `kualitas` int(11) NOT NULL,
  `fitur` int(11) NOT NULL,
  `populer` int(11) NOT NULL,
  `keawetan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`namaAlternatif`, `harga`, `kualitas`, `fitur`, `populer`, `keawetan`) VALUES
('BlackBerry', 5, 4, 2, 2, 2),
('Galaxy', 4, 4, 5, 3, 3),
('htc', 3, 4, 2, 3, 1),
('Iphone', 3, 3, 4, 2, 3),
('noki', 3, 4, 5, 2, 1),
('oppo', 3, 5, 4, 3, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`namaAlternatif`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
