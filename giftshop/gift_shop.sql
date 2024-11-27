-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 01:49 PM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `product_type` varchar(50) DEFAULT NULL,
  `product_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `image`, `quantity`, `product_type`, `product_description`) VALUES
(110, 5, 'One Piece Boa Hancock Fabric Cloth Banner', 1700, 'shopProducts/boa hancock.jpg', 1, 'arrival', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.'),
(111, 5, 'One Piece Ace Printed T-Shirt', 300, 'shopProducts/ace printed t shirt.jpg', 1, 'limited', 'A High Quality Printed T-Shirt One Piece Ace'),
(112, 5, 'Yuki Tsukumo T-shirt Jujutsu Kaisen', 640, 'shopProducts/yuki tshirt.jpg', 1, 'limited', 'Yuki Tsukumo T-shirt kenjaku Choso jujutsu kaisen Horror Anime Shirt All Size The 100% cotton men\'s classic tee will help you land a more structured look'),
(113, 5, 'Franky Banner Fabric Cloth', 1900, 'shopProducts/franky banner cloth fabric.jpg', 1, 'limited', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.'),
(117, 4, 'Yuki Tsukumo T-shirt Jujutsu Kaisen', 640, 'shopProducts/yuki tshirt.jpg', 2, 'limited', 'Yuki Tsukumo T-shirt kenjaku Choso jujutsu kaisen Horror Anime Shirt All Size The 100% cotton men\'s classic tee will help you land a more structured look'),
(118, 4, 'Darling in the Franxx Anime Accessories Bracelet', 780, 'shopProducts/Darling in the Franxx.jpg', 1, 'limited', 'From the anime Darling in the Franxx Anime Accessories Bracelet'),
(119, 4, 'Germa Sanji Fabric Cloth', 2000, 'shopProducts/germasanji.jpg', 1, 'limited', 'It’s a perfect on-display merch for gamers and anime lovers to express their passion.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `grand_total` varchar(50) NOT NULL,
  `pmode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `name`, `email`, `address`, `country`, `city`, `postal_code`, `phone_number`, `grand_total`, `pmode`) VALUES
(20241125, 'Anthony', 'user123@gmail.com', '123', 'iyfg', 'phil', '1832', '09739472141', '4060', 'Cash On Delivery');

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
(20241110, 'Jujutsu Kaisen Key Chains', 'High Quality: Made from durable PVC. Versatile: Great for backpacks, purses, or even as a decorative piece. Perfect Gift: A great gift for friends and family who love anime.', 200, 400, 1, 'limited', 'shopProducts/jjkkeychain.jpg'),
(20241111, '5 Pack Demon Slayer Anime Figures', 'Inspired by popular animation. With unique design and perfect details, it is very suitable for any fan of this anime.', 2794, 3000, 1, 'figures', 'shopProducts/5 Pack Demon Slayer Action Figures.webp'),
(20241112, 'Darling in the Franxx Anime Accessories Bracelet', 'From the anime Darling in the Franxx Anime Accessories Bracelet', 780, 1200, 1, 'accessories', 'shopProducts/Darling in the Franxx.jpg'),
(20241113, 'Nezuko Plushie Toy Demon Slayer', 'Anime Plush Toys, best gift for any Anime fan. It can be used as decoration, collectibles, hug pillows, etc. Filled with 100% cotton, made of soft plush and high-quality PP cotton.', 1175, 1800, 1, 'plush', 'shopProducts/Nezuko Plushie Demon Slayer.jpg'),
(20241114, 'Yuki Tsukumo T-shirt Jujutsu Kaisen', 'Yuki Tsukumo T-shirt kenjaku Choso jujutsu kaisen Horror Anime Shirt All Size The 100% cotton men\'s classic tee will help you land a more structured look', 640, 1000, 1, 'shirt', 'shopProducts/yuki tshirt.jpg'),
(20241115, 'Unisex Oversize Naruto Uchiha Sasuke, Itachi, Obito Anime Hoodie', 'Top Quality Naruto Hoodie', 900, 1200, 1, 'hoodie', 'shopProducts/Uchiha Sasuke.jpg'),
(20241116, '3D Illusion Night Lamp Jujutsu Kaisen', 'Anime Jujutsu Kaisen Satoru Gojo lamp, 3D illusion night lamp made of plane acrylic glass', 2080, 3100, 1, 'decor', 'shopProducts/3D Illusion Night Lamp Jujutsu Kaisen Gojo.jpg');

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
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20241126;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20241117;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202400;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
