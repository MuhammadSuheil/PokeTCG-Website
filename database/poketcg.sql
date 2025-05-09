-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2025 at 12:30 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poketcg`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `original_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `card_desc` text COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `original_image`, `name`, `card_desc`, `price`) VALUES
(18, '20c0db616d9b0d34870a299e280dbe21747b42fb7366993f1b57d136dcf0b4e2.jpg', NULL, 'Umbreon ex - 161/131 - SV: Prismatic Evolutions (PRE)', 'Card Number / Rarity:161/131 / Special Illustration Rare', 1425),
(19, '896da14cec75d89919d6ae170725656e09ba712fbf966516cbc3f9397b0671cf.jpg', NULL, 'Sylveon ex - 156/131 - SV: Prismatic Evolutions (PRE)', 'Card Number / Rarity:156/131 / Special Illustration Rare', 475),
(21, '1d43c6c847626ecd7492a3bf1854815f113129f3d149885955923e23682cf32f.jpg', NULL, 'Charizard ex - 199/165 - SV: Scarlet &amp; Violet 151 (MEW)', 'Card Number / Rarity:199/165 / Special Illustration Rare', 250),
(24, '60e164a32013ff001cec3bd9e923c929089b6ca4831f64f33af7ffd01625d89d.jpg', NULL, 'Deoxys VSTAR - Crown Zenith: Galarian Gallery (CRZ:GG)', 'Card Number / Rarity:GG46/GG70 / Ultra Rare', 35),
(25, 'f68dbf05fbeb799ac4b727a5a218c87b32b04e508666e388215430b7f6416d1c.jpg', NULL, 'Gardevoir ex - 245/198 - SV01: Scarlet & Violet Base Set (SV1)', 'Card Number / Rarity:245/198 / Special Illustration Rare', 64),
(26, '99516cb5b37f32d31e3d37069fd470043a2cddeb0845a70deee6fd1402304cb5.jpg', NULL, 'N\'s Reshiram - 167/159 (Journey Together Stamped) - SV09: Journey Together', 'Card Number / Rarity:167/159 / Illustration Rare', 60),
(27, '0242522015972d7790382c36d2cda5d3a0c34158c5580cea34fad55b31f4462a.jpg', NULL, 'Milotic ex - 237/191 - SV08: Surging Sparks (SV08)', 'Card Number / Rarity:237/191 / Special Illustration Rare', 174),
(28, 'c4c809c7fe18c129f9dd9ab3f640fd5033642a008967a7271c5690d81a461767.jpg', NULL, 'Greninja ex - 214/167 - SV06: Twilight Masquerade (TWM)', 'Card Number / Rarity:214/167 / Special Illustration Rare', 382),
(29, '22e08c471c82e979374d7ff5513ec91709e5127b1f5a0d9abe370e2a0b482c42.jpg', NULL, 'Mewtwo VSTAR - Crown Zenith: Galarian Gallery (CRZ:GG)', 'Card Number / Rarity:GG44/GG70 / Ultra Rare', 148);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'Sumhel', '$2y$10$.FFNJpKjnWPeqDYVSdyl2OhT.vzd3Bpa9/kvyEdG.G9xcswxwGe5e', 'suheilputra@gmail.com', '2025-05-09 11:16:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
