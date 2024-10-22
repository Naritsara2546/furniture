-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2024 at 09:38 AM
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
-- Database: `furnitureshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `oid` int(7) UNSIGNED ZEROFILL NOT NULL,
  `ototal` int(7) NOT NULL,
  `odate` datetime NOT NULL,
  `u_id` int(7) NOT NULL,
  `username` varchar(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`oid`, `ototal`, `odate`, `u_id`, `username`, `address`) VALUES
(0000022, 6780, '2024-10-21 02:40:31', 1, 'artty', '14/7 สารคาม'),
(0000023, 35940, '2024-10-21 03:23:18', 1, 'artty', '12/4 ดินแดง');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `od_id` int(6) NOT NULL,
  `oid` int(7) UNSIGNED ZEROFILL NOT NULL,
  `p_id` int(7) NOT NULL,
  `item` int(7) NOT NULL,
  `u_id` varchar(255) NOT NULL,
  `p_price` int(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`od_id`, `oid`, `p_id`, `item`, `u_id`, `p_price`, `address`) VALUES
(30, 0000022, 28, 1, '1', 3990, '14/7 สารคาม'),
(31, 0000022, 30, 1, '1', 2790, '14/7 สารคาม'),
(32, 0000023, 32, 1, '1', 9180, '12/4 ดินแดง'),
(33, 0000023, 33, 1, '1', 26760, '12/4 ดินแดง');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(200) NOT NULL,
  `p_detail` text NOT NULL,
  `p_price` int(6) NOT NULL,
  `p_picture` varchar(200) NOT NULL,
  `pt_id` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_detail`, `p_price`, `p_picture`, `pt_id`) VALUES
(32, 'POÄNG ', 'เบาะอาร์มแชร์ POÄNG/พัวแอง ทำด้วยหนังกลูเซแท้นิ่มสบายที่ทั้งทนทาน และสวยงามเมื่อกาลเวลาผ่านไปด้วยลุคที่ดูเป็นธรรมชาติ หรือก็คือ เบาะคุณภาพสูงที่ทนต่อการใช้งานได้อย่างดีเยี่ยม', 9180, '32.jpg', 1),
(33, 'PAX', 'เริ่มต้นเรียบง่าย เพื่อให้ต่อเติมได้เต็มที่ เริ่มต้นการออกแบบด้วยชุดเฟอร์นิเจอร์พื้นฐานที่มีพื้นที่ให้คุณต่อเติมฟังก์ชั่นเพิ่มเติมได้หากต้องการ', 26760, '33.jpg', 4),
(31, 'POÄNG', 'อาร์มแชร์ POÄNG/พัวแอง มีทรวดทรงที่สวยงามจากไม้เบนท์วูด ซึ่งจะรองรับคออย่างดีและมอบความยืดหยุ่นที่แสนสบาย เป็นสินค้าที่เราจำหน่ายมาหลาย 10 ปีแล้ว และก็ยังเป็นที่นิยมอยู่ อยากจะลองหน่อยไหม', 4990, '31.jpg', 1),
(28, 'UTESPELARE ', 'เราควรรู้สึกสบายตัวขณะเล่นเกม โดยเฉพาะอย่างยิ่งเมื่อการแข่งขันลากยาวออกไป นี่เป็นสาเหตุที่ท็อปโต๊ะถูกออกแบบมาให้ลึก เพื่อให้คุณสามารถตั้งหน้าจอไว้ในระยะที่พอเหมาะกับสายตา', 3990, '28.jpg', 3),
(29, 'LAGKAPTEN', 'การมีพื้นที่จำกัดไม่ได้เป็นอุปสรรคในการเรียนหรือทำงานที่บ้านเลย โต๊ะตัวนี้ใช้พื้นที่เพียงเล็กน้อย แต่มาพร้อมกับลิ้นชักให้คุณได้เก็บเอกสารและของสำคัญอื่นๆ', 4040, '29.jpg', 3),
(30, 'POÄNG', 'อาร์มแชร์ POÄNG/พัวแอง มีทรวดทรงที่สวยงามจากไม้เบนท์วูด ซึ่งจะรองรับคออย่างดีและมอบความยืดหยุ่นที่แสนสบาย เป็นสินค้าที่เราจำหน่ายมาหลาย 10 ปีแล้ว และก็ยังเป็นที่นิยมอยู่ อยากจะลองหน่อยไหม', 2790, '30.jpg', 1),
(27, 'UTESPELARE ', 'สามารถปรับระดับโต๊ะเล่นเกมที่ใหญ่และแข็งแรงรุ่น UTESPELARE/อูเตสเปียลาเร่ นี้เพื่อให้มีความสูงเหมาะกับคุณมากที่สุด ตะแกรงเหล็กด้านหลังของท็อปโต๊ะช่วยให้อากาศถ่ายเทได้ดีและระบายความร้อนให้กับ PC', 3990, '27.jpg', 3),
(26, 'FRIHETEN', 'เปลี่ยนเป็นเตียงนอนสำหรับแขก หรือเปลี่ยนกลับเป็นโซฟาห้องนั่งเล่นก็ทำได้ง่าย ๆ มาพร้อมที่เก็บของขนาดใหญ่ใต้เบาะ สำหรับเก็บของใช้ต่าง ๆ เช่น เครื่องนอน หนังสือ หรือชุดนอน', 17990, '26.jpg', 2),
(25, 'FRIHETEN', 'เปลี่ยนเป็นเตียงนอนสำหรับแขก หรือเปลี่ยนกลับเป็นโซฟาห้องนั่งเล่นก็ทำได้ง่าย ๆ มาพร้อมที่เก็บของขนาดใหญ่ใต้เบาะ สำหรับเก็บของใช้ต่าง ๆ เช่น เครื่องนอน หนังสือ หรือชุดนอน', 15900, '25.jpg', 1),
(34, 'FORSAND', 'ตู้เสื้อผ้าสำหรับใครก็ตามที่ชอบเก็บผ้าด้วยการพับ! เพราะมีชั้นวางของมากมายไว้รองรับเสื้อผ้าประเภทต่างๆ ที่พับหรือม้วนเก็บได้ รวมถึงเสื้อผ้าอื่นๆ ที่ขนาดใหญ่เกินกว่าจะเก็บไว้ในลิ้นชัก', 27650, '34.jpg', 4),
(35, 'BRUKSVARA', 'ตู้เสื้อผ้านี้มีทุกสิ่งที่จำเป็นพร้อมใช้งาน ไม่ว่าจะเป็นบานตู้ ราวแขวนผ้า ลิ้นชัก ชั้นวาง และตะขอเกี่ยว โซลูชั่นยืดหยุ่น ให้คุณจัดการเสื้อผ้าได้ง่าย หยิบใช้สะดวก', 3990, '35.jpg', 4),
(36, 'BRUKSVARA', 'ที่เก็บของสารพัดฟังก์ชั่นที่เก็บได้ทั้งเสื้อผ้า และของใช้ทั่วไปในชีวิตประจำวัน', 1990, '36.jpg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `pt_id` int(3) NOT NULL,
  `pt_name` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`pt_id`, `pt_name`) VALUES
(1, 'Chair'),
(2, 'Sofa'),
(3, 'Table'),
(4, 'Wardrobes');

-- --------------------------------------------------------

--
-- Table structure for table `userdb`
--

CREATE TABLE `userdb` (
  `u_id` int(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `userdb`
--

INSERT INTO `userdb` (`u_id`, `username`, `Email`, `Age`, `password`, `user_type`) VALUES
(1, 'artty', 'a@a', 64, '1234', 'user'),
(2, 'arm', 's@s', 21, '1234', 'admin'),
(3, 'meaw', 'q@q', 60, '1234', 'admin'),
(5, 'arm', 'z@z', 21, '1234', 'user'),
(6, 'a', 'a', 1, '$2y$10$h/lOMW1aaQz/GiHlLQD5qunT81z96y5obL5HVhNxlunkaGZfvq24G', 'user'),
(7, 'minnie', 'poliypokky55@msu.ac.th', 21, '1234', 'user'),
(8, 'aee', 'a@s', 20, '1334', 'user'),
(9, '', 'arm@q', 20, '$2y$10$HqSRRsXW1pKpkISlDIPJcuxtYvCuE6vF1leeLEIt30AA0V04Prcvy', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`od_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`pt_id`);

--
-- Indexes for table `userdb`
--
ALTER TABLE `userdb`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `oid` int(7) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `od_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `userdb`
--
ALTER TABLE `userdb`
  MODIFY `u_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
