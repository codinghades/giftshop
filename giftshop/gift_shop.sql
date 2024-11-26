-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 03:48 AM
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
-- Table structure for table `arrival`
--

CREATE TABLE `arrival` (
  `arrival_id` int(11) NOT NULL,
  `arrival_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `arrival_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `arrival`
--

INSERT INTO `arrival` (`arrival_id`, `arrival_name`, `price`, `discount`, `arrival_image`) VALUES
(20241101, 'One Piece Boa Hancock Fabric Cloth Banner', 1700, 2500, 'newArrival/boa hancock.jpg'),
(20241102, 'Franky Banner Fabric Cloth', 1700, 2500, 'newArrival/franky banner cloth fabric.jpg'),
(20241103, 'Germa Sanji Fabric Cloth', 1900, 2700, 'newArrival/germasanji.jpg'),
(20241104, 'Luffy Gear 5th Fabric Cloth Banner', 2000, 2900, 'newArrival/luffy gear5th.jpg'),
(20241105, 'Trafalgar Law Fabric Cloth Banner', 1900, 2700, 'newArrival/trafalgar law.jpg'),
(20241106, 'Zoro Asura Fabric Cloth Banner', 2000, 2900, 'newArrival/zoroasura.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `product_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `image`, `quantity`, `product_type`) VALUES
(40, 4, 'Zoro Asura Fabric Cloth Banner', 2000, 'newArrival/zoroasura.jpg', 1, 'arrival'),
(42, 4, 'Germa Sanji Fabric Cloth', 1900, 'newArrival/germasanji.jpg', 1, 'arrival'),
(44, 5, 'One Piece Boa Hancock Fabric Cloth Banner', 1700, 'newArrival/boa hancock.jpg', 1, 'arrival'),
(45, 5, 'Kaiju No.8 Printed Black T-Shirt', 400, 'limitedProduct/kaiju8.jpg', 1, 'limited'),
(46, 5, 'Zoro Asura Fabric Cloth Banner', 2000, 'newArrival/zoroasura.jpg', 1, 'arrival'),
(47, 5, 'Gojo Hooded Neck', 850, 'limitedProduct/Gojo Hooded Neck.jpg', 1, 'limited'),
(48, 5, 'One Piece Phone Case Anniversary Edition', 310, 'limitedProduct/one piece phone case.jpg', 1, 'limited'),
(49, 5, 'Demon Slayer Tanjiro Water Breathing Sneakers', 1700, 'limitedProduct/tanjiro sneakers.jpg', 1, 'limited');

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
(38, 'One Piece Anime T-Shirt Ace Printed', 280, 400, 'limitedProduct/ace printed t shirt.jpg'),
(39, 'Attack on Titan Eren Jeager Printed Shirt', 350, 1200, 'limitedProduct/eren printed.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(4, 'user123', 'user123@gmail.com', '$2y$10$SMtsKUAdbvyPXxG5ef/riuQIwZ7gj76TL.1FZaQHELimLFySJDulu'),
(5, 'hades', 'hades123@gmail.com', '$2y$10$F2takpoSAmT/UIWq.UF7/.K2grP8v9HHTiNJjUehGFrnNFV47zvey');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arrival`
--
ALTER TABLE `arrival`
  ADD PRIMARY KEY (`arrival_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arrival`
--
ALTER TABLE `arrival`
  MODIFY `arrival_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20241107;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
