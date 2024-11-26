-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 11:15 AM
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
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `category` varchar(50) DEFAULT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`product_id`, `product_name`, `product_description`, `price`, `discount`, `quantity`, `category`, `product_image`) VALUES
(20241100, 'One Piece Boa Hancock Fabric Cloth Banner', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.', 1700, 2500, 1, 'arrival', 'shopProducts/boa hancock.jpg'),
(20241101, 'Franky Banner Fabric Cloth', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.', 1900, 2700, 1, 'arrival', 'shopProducts/franky banner cloth fabric.jpg'),
(20241102, 'Germa Sanji Fabric Cloth', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.', 2000, 2900, 1, 'arrival', 'shopProducts/germasanji.jpg'),
(20241103, 'Luffy Gear 5th Fabric Cloth Banner', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.', 2000, 2500, 1, 'arrival', 'shopProducts/luffy gear5th.jpg'),
(20241104, 'Trafalgar Law Fabric Cloth Banner', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.', 2000, 2900, 1, 'arrival', 'shopProducts/trafalgar law.jpg'),
(20241105, 'Zoro Asura Fabric Cloth Banner', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.', 2000, 2900, 1, 'arrival', 'shopProducts/zoroasura.jpg'),
(20241106, 'One Piece Ace Printed T-Shirt', 'A High Quality Printed T-Shirt One Piece Ace', 300, 400, 1, 'limited', 'shopProducts/ace printed t shirt.jpg'),
(20241107, 'Attack on Titan Eren Yeager Printed T-Shirt', 'A High Quality Printed T-Shirt Attack on Titan Eren Yeager', 350, 480, 1, 'limited', 'shopProducts/eren printed.jpg'),
(20241108, 'Jujutsu Kaisen Gojo Hooded Neck', 'Quality Cotton Fleece Material, Smooth and soft adem material, Comfortable adem wear, Anime Model', 610, 800, 1, 'limited', 'shopProducts/Gojo Hooded Neck.jpg'),
(20241109, 'Hori San To Miyamura T-shirt - Kawaii Japanese Anime Horimiya Printed T- shirt', 'Our merchandise will deliver you satisfaction with a clear, vivid, correct shade for excellent completed clothes.', 420, 500, 1, 'limited', 'shopProducts/horimiya.jpg'),
(20241110, 'Jujutsu Kaisen Key Chains', 'High Quality: Made from durable PVC. Versatile: Great for backpacks, purses, or even as a decorative piece. Perfect Gift: A great gift for friends and family who love anime.', 200, 400, 1, 'limited', 'shopProducts/jjkkeychain.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20241111;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
