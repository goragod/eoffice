-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 02, 2021 at 01:57 PM
-- Server version: 10.1.44-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_category`
--

CREATE TABLE `{prefix}_category` (
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT 0,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `{prefix}_category`
--

INSERT INTO `{prefix}_category` (`type`, `category_id`, `topic`, `color`, `published`) VALUES
('repairstatus', 1, 'แจ้งซ่อม', '#660000', 1),
('repairstatus', 2, 'กำลังดำเนินการ', '#120eeb', 1),
('repairstatus', 3, 'รออะไหล่', '#d940ff', 1),
('repairstatus', 4, 'ซ่อมสำเร็จ', '#06d628', 1),
('repairstatus', 5, 'ซ่อมไม่สำเร็จ', '#FF0000', 1),
('repairstatus', 6, 'ยกเลิกการซ่อม', '#FF6F00', 1),
('repairstatus', 7, 'ส่งมอบเรียบร้อย', '#000000', 1),
('type_id', 4, '{\"en\":\"Projector\",\"la\":\"ໂປເຈັກເຕີ\",\"th\":\"โปรเจ็คเตอร์\"}', '', 1),
('model_id', 4, '{\"en\":\"ACER\",\"la\":\"ACER\",\"th\":\"ACER\"}', '', 1),
('accessories', 3, '{\"en\":\"Overhead projector\",\"la\":\"ເຄື່ອງສາຍພາບ\",\"th\":\"เครื่องฉายแผ่นใส\"}', '', 1),
('accessories', 4, '{\"en\":\"Snack\",\"la\":\"ອາຫານຫວ່າງ\",\"th\":\"อาหารว่าง\"}', '', 1),
('position', 2, '{\"en\":\"Vice-Director\",\"la\":\"ຮອງຜູ້ອໍານວຍການ\",\"th\":\"รองผู้อำนวยการ\"}', '', 1),
('position', 3, '{\"en\":\"Senior\",\"la\":\"ຫົວຫນ້າ\",\"th\":\"หัวหน้า\"}', '', 1),
('position', 4, '{\"en\":\"Employees\",\"la\":\"ເຈົ້າພະນັກງານ\",\"th\":\"เจ้าหน้าที่\"}', '', 1),
('position', 1, '{\"en\":\"Director\",\"la\":\"ຜູ້ອໍານວຍການ\",\"th\":\"ผู้อำนวยการ\"}', '', 1),
('department', 3, '{\"en\":\"Finance\",\"la\":\"ການເງິນ\",\"th\":\"การเงิน\"}', '', 1),
('department', 1, '{\"en\":\"Management\",\"la\":\"ການບໍລິຫານ\",\"th\":\"บริหาร\"}', '', 1),
('department', 2, '{\"en\":\"Supplies\",\"la\":\"ພັສດຸ\",\"th\":\"พัสดุ\"}', '', 1),
('accessories', 2, '{\"en\":\"Projector Screen\",\"la\":\"ຈໍໂປເຈກເຕີ\",\"th\":\"จอโปรเจ็คเตอร์\"}', '', 1),
('accessories', 1, '{\"en\":\"Computer\",\"la\":\"ເຄື່ອງຄອມພິວເຕີ\",\"th\":\"เครื่องคอมพิวเตอร์\"}', '', 1),
('use', 3, '{\"en\":\"Party\",\"la\":\"ງານຮື່ນເຮີງ\",\"th\":\"จัดเลี้ยง\"}', '', 1),
('use', 1, '{\"en\":\"Meeting\",\"la\":\"ການປະຊົມ\",\"th\":\"ประชุม\"}', '', 1),
('use', 2, '{\"en\":\"Seminar\",\"la\":\"ການສໍາມະນາ\",\"th\":\"สัมนา\"}', '', 1),
('model_id', 5, '{\"en\":\"Samsung\",\"la\":\"Samsung\",\"th\":\"Samsung\"}', '', 1),
('model_id', 1, '{\"en\":\"Unknown\",\"la\":\"ບໍ່ລະບຸ\",\"th\":\"ไม่ระบุ\"}', '', 1),
('model_id', 2, '{\"en\":\"Asus\",\"la\":\"Asus\",\"th\":\"Asus\"}', '', 1),
('category_id', 3, '{\"en\":\"Office material\",\"la\":\"ອຸປະກອນສໍານັກງານ\",\"th\":\"วัสดุสำนักงาน\"}', '', 1),
('type_id', 2, '{\"en\":\"Computer\",\"la\":\"ຄອມພິວເຕີ\",\"th\":\"เครื่องคอมพิวเตอร์\"}', '', 1),
('type_id', 3, '{\"en\":\"Printer\",\"la\":\"ເຄື່ອງພິມ\",\"th\":\"เครื่องพิมพ์\"}', '', 1),
('type_id', 5, '{\"en\":\"Monitor\",\"la\":\"ຫນ້າຈໍຄອມພິວເຕີ\",\"th\":\"จอมอนิเตอร์\"}', '', 1),
('category_id', 1, '{\"en\":\"Hardware\",\"la\":\"ອຸປະກອນ\",\"th\":\"อุปกรณ์\"}', '', 1),
('category_id', 2, '{\"en\":\"์Network\",\"la\":\"ອຸປະກອນເຄືອຂ່າຍ\",\"th\":\"อุปกรณ์เครือข่าย\"}', '', 1),
('model_id', 3, '{\"en\":\"Cannon\",\"la\":\"Cannon\",\"th\":\"Cannon\"}', '', 1),
('type_id', 1, '{\"en\":\"Other\",\"la\":\"ອື່ນໆ\",\"th\":\"อื่นๆ\"}', '', 1),
('unit', 1, '{\"en\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\",\"la\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\",\"th\":\"\\u0e40\\u0e04\\u0e23\\u0e37\\u0e48\\u0e2d\\u0e07\"}', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_edocument`
--

CREATE TABLE `{prefix}_edocument` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) UNSIGNED NOT NULL,
  `department` text COLLATE utf8_unicode_ci NOT NULL,
  `urgency` tinyint(1) NOT NULL DEFAULT 2,
  `last_update` int(11) UNSIGNED NOT NULL,
  `document_no` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `detail` text COLLATE utf8_unicode_ci NOT NULL,
  `topic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ext` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `size` double UNSIGNED NOT NULL,
  `file` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `{prefix}_edocument`
--

INSERT INTO `{prefix}_edocument` (`id`, `sender_id`, `department`, `urgency`, `last_update`, `document_no`, `detail`, `topic`, `ext`, `size`, `file`, `ip`) VALUES
(1, 2, ',,', 2, 1545666283, 'DOC-0009', 'ส่งให้แอดมิน', 'คำศัพท์ชื่อป้ายห้องในโรงเรียนเป็นภาษาอังกฤษแนบ', 'pdf', 457639, '1545666283.pdf', '110.168.79.37'),
(2, 1, ',1,2,3,', 2, 1545664264, 'DOC-0008', 'ทดสอบ', 'CanonPixmaMP280-MP287-PrinterDriver', 'jpg', 18795, '1545662500.jpg', '110.168.79.37');

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_edocument_download`
--

CREATE TABLE `{prefix}_edocument_download` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `downloads` int(11) NOT NULL,
  `last_update` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `{prefix}_edocument_download`
--

INSERT INTO `{prefix}_edocument_download` (`id`, `member_id`, `downloads`, `last_update`) VALUES
(1, 2, 1, 1545665178),
(2, 1, 0, 1545667460);

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_inventory`
--

CREATE TABLE `{prefix}_inventory` (
  `id` int(11) NOT NULL,
  `topic` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `detail` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `unit` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `{prefix}_inventory`
--

INSERT INTO `{prefix}_inventory` (`id`, `topic`, `detail`, `unit`, `status`) VALUES
(1, 'จอมอนิเตอร์ ACER S220HQLEBD', '', 1, 1),
(2, 'Notebook Samsung RV418', 'Windows 10 HOME\r\nMicrosoft Office', 1, 1),
(4, 'Printer Cannon MP287', '', 1, 1),
(5, 'กระดาษ A4', '', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_inventory_meta`
--

CREATE TABLE `{prefix}_inventory_meta` (
  `inventory_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `value` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `{prefix}_inventory_meta`
--

INSERT INTO `{prefix}_inventory_meta` (`inventory_id`, `name`, `value`) VALUES
(4, 'model_id', '3'),
(2, 'model_id', '5'),
(1, 'model_id', '4'),
(2, 'type_id', '1'),
(1, 'type_id', '4'),
(3, 'model_id', '2'),
(2, 'category_id', '1'),
(1, 'category_id', '1'),
(3, 'type_id', '1'),
(4, 'type_id', '2'),
(4, 'category_id', '1'),
(3, 'category_id', '1'),
(5, 'type_id', '5'),
(5, 'category_id', '3'),
(5, 'model_id', '1');

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_inventory_stock`
--

CREATE TABLE `{prefix}_inventory_stock` (
  `id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `product_no` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock` float NOT NULL DEFAULT 0,
  `create_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `{prefix}_inventory_stock`
--

INSERT INTO `{prefix}_inventory_stock` (`id`, `inventory_id`, `product_no`, `stock`, `create_date`) VALUES
(1, 5, '0001', 1, '2021-01-23'),
(2, 4, '0002', 1, '2021-01-23'),
(3, 2, '0003', 1, '2021-01-23'),
(4, 1, '0004', 1, '2021-01-23');

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_inventory_user`
--

CREATE TABLE `{prefix}_inventory_user` (
  `id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `create_date` date DEFAULT NULL,
  `return_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `{prefix}_inventory_user`
--

INSERT INTO `{prefix}_inventory_user` (`id`, `stock_id`, `member_id`, `create_date`, `return_date`) VALUES
(1, 4, 1, '2021-01-23', NULL),
(2, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_language`
--

CREATE TABLE `{prefix}_language` (
  `id` int(11) NOT NULL,
  `key` text COLLATE utf8_unicode_ci NOT NULL,
  `la` text COLLATE utf8_unicode_ci,
  `type` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `owner` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `js` tinyint(1) NOT NULL,
  `th` text COLLATE utf8_unicode_ci,
  `en` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_line`
--

CREATE TABLE `{prefix}_line` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_repair`
--

CREATE TABLE `{prefix}_repair` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `job_description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_repair_status`
--

CREATE TABLE `{prefix}_repair_status` (
  `id` int(11) NOT NULL,
  `repair_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `operator_id` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `member_id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_reservation`
--

CREATE TABLE `{prefix}_reservation` (
  `id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `create_date` datetime DEFAULT NULL,
  `topic` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `attendees` int(11) NOT NULL,
  `begin` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `department` int(11) NOT NULL,
  `reason` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_reservation_data`
--

CREATE TABLE `{prefix}_reservation_data` (
  `reservation_id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_rooms`
--

CREATE TABLE `{prefix}_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `detail` text COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `published` int(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `{prefix}_rooms`
--

INSERT INTO `{prefix}_rooms` (`id`, `name`, `detail`, `color`, `published`) VALUES
(1, 'ห้องประชุม 2', 'ห้องประชุมพร้อมระบบ Video conference\r\nที่นั่งผู้เข้าร่วมประชุม รูปตัว U 2 แถว', '#01579B', 1),
(2, 'ห้องประชุม 1', 'ห้องประชุมขนาดใหญ่\r\nพร้อมสิ่งอำนวยความสะดวกครบครัน', '#1A237E', 1),
(3, 'ห้องประชุมส่วนเทคโนโลยีสารสนเทศ', 'ห้องประชุมขนาดใหญ่ (Hall)\r\nเหมาะสำรับการสัมนาเป็นหมู่คณะ และ จัดเลี้ยง', '#B71C1C', 1);

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_rooms_meta`
--

CREATE TABLE `{prefix}_rooms_meta` (
  `room_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `value` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `{prefix}_rooms_meta`
--

INSERT INTO `{prefix}_rooms_meta` (`room_id`, `name`, `value`) VALUES
(2, 'seats', '20 ที่นั่ง'),
(2, 'number', 'R-0001'),
(2, 'building', 'อาคาร 1'),
(1, 'number', 'R-0002'),
(1, 'seats', '50 ที่นั่ง รูปตัว U'),
(1, 'building', 'อาคาร 2'),
(3, 'building', 'โรงอาหาร'),
(3, 'seats', '100 คน');

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_user`
--

CREATE TABLE `{prefix}_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `permission` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_card` varchar(13) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` int(11) DEFAULT 0,
  `position` int(11) DEFAULT 0,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `address` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provinceID` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8_unicode_ci DEFAULT 'TH',
  `visited` int(11) DEFAULT 0,
  `lastvisited` int(11) DEFAULT 0,
  `session_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `social` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{prefix}_user_category`
--

CREATE TABLE `{prefix}_user_category` (
  `member_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `value` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `{prefix}_user_category`
--

INSERT INTO `{prefix}_user_category` (`member_id`, `name`, `value`) VALUES
(2, 'job', 'นักศึกษาฝึกงาน');

--
-- Indexes for table `{prefix}_category`
--
ALTER TABLE `{prefix}_category`
  ADD KEY `type` (`type`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `{prefix}_edocument`
--
ALTER TABLE `{prefix}_edocument`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{prefix}_edocument_download`
--
ALTER TABLE `{prefix}_edocument_download`
  ADD PRIMARY KEY (`id`,`member_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `{prefix}_inventory`
--
ALTER TABLE `{prefix}_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{prefix}_inventory_meta`
--
ALTER TABLE `{prefix}_inventory_meta`
  ADD KEY `inventory_id` (`inventory_id`);

--
-- Indexes for table `{prefix}_inventory_stock`
--
ALTER TABLE `{prefix}_inventory_stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_id` (`inventory_id`),
  ADD UNIQUE KEY `product_no` (`product_no`);

--
-- Indexes for table `{prefix}_inventory_user`
--
ALTER TABLE `{prefix}_inventory_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `stock_id` (`stock_id`);

--
-- Indexes for table `{prefix}_language`
--
ALTER TABLE `{prefix}_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{prefix}_line`
--
ALTER TABLE `{prefix}_line`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{prefix}_repair`
--
ALTER TABLE `{prefix}_repair`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{prefix}_repair_status`
--
ALTER TABLE `{prefix}_repair_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_id` (`repair_id`);

--
-- Indexes for table `{prefix}_reservation`
--
ALTER TABLE `{prefix}_reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{prefix}_reservation_data`
--
ALTER TABLE `{prefix}_reservation_data`
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `{prefix}_rooms`
--
ALTER TABLE `{prefix}_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{prefix}_rooms_meta`
--
ALTER TABLE `{prefix}_rooms_meta`
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `{prefix}_user`
--
ALTER TABLE `{prefix}_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `token` (`token`),
  ADD KEY `phone` (`phone`);

--
-- Indexes for table `{prefix}_user_category`
--
ALTER TABLE `{prefix}_user_category`
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for table `{prefix}_edocument`
--
ALTER TABLE `{prefix}_edocument`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_edocument_download`
--
ALTER TABLE `{prefix}_edocument_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_inventory`
--
ALTER TABLE `{prefix}_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_inventory_stock`
--
ALTER TABLE `{prefix}_inventory_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_inventory_user`
--
ALTER TABLE `{prefix}_inventory_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_language`
--
ALTER TABLE `{prefix}_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_line`
--
ALTER TABLE `{prefix}_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_repair`
--
ALTER TABLE `{prefix}_repair`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_repair_status`
--
ALTER TABLE `{prefix}_repair_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_reservation`
--
ALTER TABLE `{prefix}_reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_rooms`
--
ALTER TABLE `{prefix}_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `{prefix}_user`
--
ALTER TABLE `{prefix}_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
