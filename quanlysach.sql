-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2024 at 04:04 PM
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
-- Database: `quanlysach`
--

-- --------------------------------------------------------

--
-- Table structure for table `loai`
--

CREATE TABLE `loai` (
  `maloai` int(100) NOT NULL,
  `tenloai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loai`
--

INSERT INTO `loai` (`maloai`, `tenloai`) VALUES
(1, 'Tiểu thuyết'),
(2, 'Hồi ký'),
(3, 'Giáo dục');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidungs`
--

CREATE TABLE `nguoidungs` (
  `mand` int(100) NOT NULL,
  `hoten` varchar(100) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sodt` varchar(50) NOT NULL,
  `tendangnhap` varchar(100) NOT NULL,
  `matkhau` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoidungs`
--

INSERT INTO `nguoidungs` (`mand`, `hoten`, `diachi`, `email`, `sodt`, `tendangnhap`, `matkhau`, `admin`) VALUES
(1, 'Nguyễn Thanh Hiếu', 'Huế', 'hieu123@gmail.com', '091201910', 'hieuvip', '$2y$10$AutLNQxo/L7X.7tvpJ5dT.1NZCdB8WlFi38LcgT9lGH6GCNhWd1q.', 1),
(2, 'Nguyễn Đức Tuệ', 'Huế', 'tue123@gmail.com', '09281481', 'tuecook', '$2y$10$jFdrHPCl2JDdkmpf8Go9Au1iZ9kGrL1TznVXHNbO7Gu9hpGPZb6EG', 0),
(3, 'Hoàng Ngọc Thành', 'Huế', 'thanh12@gmail.com', '8401984019', 'thanhh', '$2y$10$0UmE3vtmLUaL1t4HInTyJ.R67H4GTEQBENi07GdyYhm.bMKK.nmsa', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sach`
--

CREATE TABLE `sach` (
  `masach` int(100) NOT NULL,
  `tensach` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `gia` int(50) NOT NULL,
  `soluong` int(50) NOT NULL,
  `tacgia` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `maloai` int(100) NOT NULL,
  `anh` varchar(50) NOT NULL,
  `ngayxuatban` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sach`
--

INSERT INTO `sach` (`masach`, `tensach`, `gia`, `soluong`, `tacgia`, `maloai`, `anh`, `ngayxuatban`) VALUES
(1, 'Kinh tế chính trị', 25000, 30, 'Bộ Giáo dục và Đào tạo', 3, 'image_anh/kinhtechinhtri.jpg', '2015-12-17'),
(2, 'Tuổi thơ dữ dội', 75000, 50, 'Phùng Quán', 1, 'image_anh/tuoithodudoi.jpg', '2014-12-16'),
(3, 'Chuyện lính Tây Nam', 50000, 100, 'Trung Sỹ', 2, 'image_anh/chuyenlinhtaynam.jpg', '2020-12-15'),
(4, 'Running With Scissors', 60000, 40, 'Augusten Burroghs', 2, 'image_anh/runningwithscissors.jpg', '2024-12-09'),
(5, 'Just Kids', 35000, 10, 'Patti Smith', 2, 'image_anh/justkids.jpg', '2018-09-10'),
(6, 'Một Cơn Gió Bụi', 50000, 36, 'Trần Trọng Kim', 2, 'image_anh/motcongiobui.jpg', '2016-03-16'),
(7, 'Giáo trình Chủ nghĩa xã hội khoa học', 25000, 500, 'Bộ Giáo dục và Đào tạo', 3, 'image_anh/CNXHKH.jpg', '2018-05-10'),
(8, 'Pháp luật đại cương', 25000, 120, 'Bộ Giáo dục và Đào tạo', 3, 'image_anh/phapluatdaicuong.jpg', '2017-09-12'),
(9, 'Số đỏ', 70000, 200, 'Vũ Trọng Phụng', 1, 'image_anh/sodo.jpg', '2015-02-10'),
(10, 'Không gia đình', 60000, 50, 'Hector Malot', 1, 'image_anh/khong-gia-dinh.jpg', '2014-05-21'),
(11, 'Vượt Côn Đảo', 60000, 50, 'Phùng Quán', 1, 'image_anh/vuot-con-dao.jpg', '2015-12-10'),
(12, 'Trăng Hoàng Cung', 90000, 20, 'Phùng Quán', 1, 'image_anh/trang-hoang-cung.jpg', '2019-07-15'),
(25, 'Overlord', 200000, 23, 'Kugane Maruyama', 1, 'image_anh/thumb-1920-975264.jpg', '2024-12-13');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_thongke`
-- (See below for the actual view)
--
CREATE TABLE `view_thongke` (
`loai` varchar(50)
,`so_sach` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `view_thongke`
--
DROP TABLE IF EXISTS `view_thongke`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_thongke`  AS SELECT `loai`.`tenloai` AS `loai`, count(`sach`.`masach`) AS `so_sach` FROM (`loai` left join `sach` on(`loai`.`maloai` = `sach`.`maloai`)) GROUP BY `loai`.`tenloai` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loai`
--
ALTER TABLE `loai`
  ADD PRIMARY KEY (`maloai`);

--
-- Indexes for table `nguoidungs`
--
ALTER TABLE `nguoidungs`
  ADD PRIMARY KEY (`mand`);

--
-- Indexes for table `sach`
--
ALTER TABLE `sach`
  ADD PRIMARY KEY (`masach`),
  ADD KEY `maloai` (`maloai`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `loai`
--
ALTER TABLE `loai`
  MODIFY `maloai` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nguoidungs`
--
ALTER TABLE `nguoidungs`
  MODIFY `mand` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sach`
--
ALTER TABLE `sach`
  MODIFY `masach` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sach`
--
ALTER TABLE `sach`
  ADD CONSTRAINT `sach_ibfk_1` FOREIGN KEY (`maloai`) REFERENCES `loai` (`maloai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
