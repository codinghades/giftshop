-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 10:07 AM
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
-- Database: `gift_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `discount`, `product_image`) VALUES
(30, 'Hori San To Miyamura T-shirt - Kawaii Japanese Anime Horimiya Printed T- shirt', 420, 1200, 'limitedProduct/horimiya.jpg'),
(31, 'Jujutsu Kaisen Doll Keychain', 87, 178, 'limitedProduct/jjkkeychain.jpg'),
(32, 'Gojo Hooded Neck', 850, 1700, 'limitedProduct/Gojo Hooded Neck.jpg'),
(33, 'Kaiju No.8 Printed Black T-Shirt', 400, 800, 'limitedProduct/kaiju8.jpg'),
(34, 'My Hero Academia Trio Figure Limited Edition', 2100, 3000, 'limitedProduct/mha.jpg'),
(35, 'One Piece Phone Case Anniversary Edition', 310, 500, 'limitedProduct/one piece phone case.jpg'),
(36, 'Jujutsu Kaisen Sukuna Design Hoodie Oversized', 870, 1500, 'limitedProduct/sukuna hoodie.jpg'),
(37, 'Demon Slayer Tanjiro Water Breathing Sneakers', 1700, 2300, 'limitedProduct/tanjiro sneakers.jpg'),
(38, 'One Piece Anime T-Shirt Ace Printed', 280, 400, 'limitedProduct/ace printed t shirt.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
