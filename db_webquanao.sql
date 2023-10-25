-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 25, 2023 at 02:52 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_webquanao`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `id_banner` int(11) NOT NULL,
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diachianh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `trang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vitri` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'danhmuc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_banner`
--

INSERT INTO `tbl_banner` (`id_banner`, `ten`, `diachianh`, `mota`, `trang`, `vitri`, `value`, `name`) VALUES
(9, 'Bottom Banner', 'public/images/banners/botbanner1.jpg', 'Hình ảnh hiển thị phần phía dưới của trang chủ', 'trang chu', 'bot', '0', 'loai'),
(10, 'Slider image', 'public/images/banners/1644555770ceb15b5fc83181b0af27d96433baf9b8.gif', 'Hình ảnh của slider trong trang chủ', 'trang chu', 'slider', '0', 'loai'),
(11, 'Slider image 1', 'public/images/banners/6339836.jpg', 'Hình ảnh của slider trong trang chủ', 'trang chu', 'slider', '1', 'loai'),
(12, 'Slider image', 'public/images/banners/images.jpg', 'Hình ảnh của slider trong trang chủ', 'trang chu', 'slider', '2', 'loai'),
(13, 'Bot Banner', 'public/images/banners/botbanner1.jpg', 'Banner trong slider nằm phía dưới phần hiển thị tìm kiếm', 'tim kiem', 'bot', '0', 'loai');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chitiethoadon`
--

CREATE TABLE `tbl_chitiethoadon` (
  `id_hoadon` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `size` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soluong` int(11) NOT NULL,
  `thanhtien` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_chitiethoadon`
--

INSERT INTO `tbl_chitiethoadon` (`id_hoadon`, `id_sanpham`, `size`, `soluong`, `thanhtien`) VALUES
(1, 4, '', 1, 350000),
(1, 5, 'XL', 3, 2550000),
(1, 6, 'L', 2, 1000000),
(159, 6, 'L', 1, 500000),
(159, 8, 'XL', 1, 990000),
(160, 5, 'XL', 1, 850000),
(161, 3, 'L', 1, 600000),
(161, 3, 'M', 1, 600000),
(162, 13, 'L', 1, 250000),
(163, 8, 'XL', 1, 990000),
(163, 25, 'XL', 1, 600000),
(164, 8, 'XL', 1, 990000),
(164, 25, 'XL', 1, 600000),
(165, 2, 'XL', 2, 640000),
(165, 11, 'L', 1, 450000),
(165, 19, 'L', 2, 980000),
(165, 25, 'XL', 1, 600000),
(166, 1, 'M', 2, 2400000),
(166, 25, 'XL', 2, 1200000),
(167, 1, 'M', 1, 1200000),
(168, 1, 'M', 1, 1200000),
(169, 1, 'M', 1, 1200000),
(169, 2, 'L', 1, 320000),
(170, 1, 'M', 5, 6000000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_danhmuc`
--

CREATE TABLE `tbl_danhmuc` (
  `id_danhmuc` int(11) NOT NULL,
  `tendanhmuc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_danhmuc`
--

INSERT INTO `tbl_danhmuc` (`id_danhmuc`, `tendanhmuc`) VALUES
(0, 'Áo Thun'),
(1, 'Áo Sơ Mi'),
(2, 'Áo Khoác'),
(3, 'Quần Jean'),
(4, 'Quần Tây'),
(5, 'Quần Short'),
(6, 'Khác');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_giamgia`
--

CREATE TABLE `tbl_giamgia` (
  `id_sanpham` int(11) NOT NULL,
  `giagiam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_giamgia`
--

INSERT INTO `tbl_giamgia` (`id_sanpham`, `giagiam`) VALUES
(5, 850000),
(8, 990000),
(1, 1200000),
(2, 320000),
(13, 250000),
(18, 300000),
(24, 490000),
(11, 450000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_giohang`
--

CREATE TABLE `tbl_giohang` (
  `id_taikhoan` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `size` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soluong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_giohang`
--

INSERT INTO `tbl_giohang` (`id_taikhoan`, `id_sanpham`, `size`, `soluong`) VALUES
(1, 25, 'XL', 1),
(63, 2, 'XL', 2),
(63, 11, 'L', 1),
(63, 19, 'L', 2),
(63, 25, 'XL', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hoadon`
--

CREATE TABLE `tbl_hoadon` (
  `id_hoadon` int(11) NOT NULL,
  `id_khachhang` int(11) NOT NULL,
  `hoten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sodienthoai` int(10) NOT NULL,
  `diachi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhthucvanchuyen` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hinhthucthanhtoan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tamtinh` double NOT NULL,
  `phivanchuyen` double NOT NULL,
  `giamgia` double NOT NULL,
  `ngaylap` date NOT NULL,
  `tongtien` float NOT NULL,
  `trangthai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_hoadon`
--

INSERT INTO `tbl_hoadon` (`id_hoadon`, `id_khachhang`, `hoten`, `email`, `sodienthoai`, `diachi`, `hinhthucvanchuyen`, `hinhthucthanhtoan`, `tamtinh`, `phivanchuyen`, `giamgia`, `ngaylap`, `tongtien`, `trangthai`) VALUES
(1, 1, 'Nguyễn Công Đạt', 'admin@baeshop.com', 123456789, '231 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 6750000, 50000, 2850000, '2023-10-12', 3950000, 'Đã hoàn thành'),
(159, 2, 'nguyen  b', 'vhaus@gmail.com', 2147483647, '23111 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 2000000, 50000, 510000, '2023-10-14', 1540000, 'Đã hoàn thành'),
(160, 2, 'nguyen  b', 'vhaus@gmail.com', 2147483647, '23111 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng tiêu chuẩn', 'Chuyển khoản', 1800000, 25000, 950000, '2023-10-14', 900000, 'Đã hoàn thành'),
(161, 2, 'nguyen  b', 'vhaus@gmail.com', 2147483647, '23111 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 1200000, 50000, 0, '2023-10-14', 1250000, 'Đã hoàn thành'),
(162, 2, 'Nguyễn Cấm', 'aasffafas@gmail.com', 961781700, '23111 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 350000, 50000, 100000, '2023-10-14', 300000, 'Đã hoàn thành'),
(163, 1, 'Nguyễn Công Đạt', 'admin@baeshop.com', 123456789, '231 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'Chuyển khoản', 2100000, 50000, 510000, '2023-10-17', 1640000, 'Đã hoàn thành'),
(164, 1, 'Nguyễn Công Đạt', 'admin@baeshop.com', 123456789, '231 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 2100000, 50000, 510000, '2023-10-17', 1640000, 'Đã xác nhận'),
(165, 63, 'Nguyen Cong Dat', 'coda@yahoo.com', 961781700, '279 Nguyễn Tri Phương, phường 5, Quận 10, TPHCM', 'Giao hàng nhanh', 'COD', 2880000, 50000, 210000, '2023-10-18', 2720000, 'Chờ xác nhận'),
(166, 2, 'nguyen  b', 'vhaus@gmail.com', 2147483647, '23111 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 4200000, 50000, 600000, '2023-10-19', 3650000, 'Chờ xác nhận'),
(167, 1, 'Nguyễn Công Đạt', 'admin@baeshop.com', 123456789, '231 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 1500000, 50000, 300000, '2023-10-20', 1250000, 'Chờ xác nhận'),
(168, 1, 'Nguyễn Công Đạt', 'admin@baeshop.com', 123456789, '231 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 1500000, 50000, 300000, '2023-10-20', 1250000, 'Chờ xác nhận'),
(169, 1, 'Nguyễn Công Đạt', 'admin@baeshop.com', 123456789, '231 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 1900000, 50000, 380000, '2023-10-20', 1570000, 'Chờ xác nhận'),
(170, 1, 'Nguyễn Công Đạt', 'admin@baeshop.com', 123456789, '231 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM', 'Giao hàng nhanh', 'COD', 7500000, 50000, 1500000, '2023-10-23', 6050000, 'Chờ xác nhận');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sanpham`
--

CREATE TABLE `tbl_sanpham` (
  `id_sanpham` int(11) NOT NULL,
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gia` int(11) NOT NULL,
  `ngaynhap` date NOT NULL,
  `gioithieu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `anhchinh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anhphu1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anhphu2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anhphu3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anhphu4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_sanpham`
--

INSERT INTO `tbl_sanpham` (`id_sanpham`, `ten`, `gia`, `ngaynhap`, `gioithieu`, `anhchinh`, `anhphu1`, `anhphu2`, `anhphu3`, `anhphu4`) VALUES
(1, 'Sweater Nike x Stussy', 1500000, '2023-10-05', '- Material : Wool Yarn 100% ACRYLIC |- Hand Distressed detail |- Model : 1m75 - 62kg wear size M', 'public/images/products/sweater_nike_main.jpg', 'public/images/products/sweater_nike_1.png', 'public/images/products/sweater_nike_2.jpg', 'public/images/products/sweater_nike_3.jpg', 'public/images/products/sweater_nike_4.png'),
(2, 'Basic White T-Shirt', 400000, '2023-10-02', '- Material :  100% COTTON |- Hand Distressed detail |- Model : 1m75 - 62kg wear size M', 'public/images/products/basicTshirt_main.jpg', 'public/images/products/basicTshirt_1.jpg', 'public/images/products/basicTshirt_2.jpg', 'public/images/products/basicTshirt_3.jpg', 'public/images/products/basicTshirt_4.jpg'),
(3, 'Straight Washed Blue Jeans', 600000, '2023-10-03', '- 3D Washed |\r\n- Straight Fit |\r\n- 100% Cotton / 12oz', 'public/images/products/stjeans_main.jpg', 'public/images/products/stjeans_1.jpg', 'public/images/products/stjeans_2.jpg', 'public/images/products/stjeans_3.jpg', 'public/images/products/stjeans_4.jpg'),
(4, 'Gray Vintage Hat', 350000, '2023-10-11', '- Free size |\r\n- 3D washed |\r\n- Adjustable Strap', 'public/images/products/gray_hat_main.jpg', 'public/images/products/gray_hat_1.jpg', 'public/images/products/gray_hat_2.jpg', 'public/images/products/gray_hat_3.jpg', 'public/images/products/gray_hat_4.jpg'),
(5, 'Leather Black Jacket', 1800000, '2023-10-03', '- Boxy Fit |\r\n- Kaki 100% Cotton |\r\n- Mix Faux Leather Pocket ', 'public/images/products/leather_jacket_main.jpg', 'public/images/products/leather_jacket_1.jpg', 'public/images/products/leather_jacket_2.jpg', 'public/images/products/leather_jacket_3.jpg', 'public/images/products/leather_jacket_4.jpg'),
(6, 'Graphic Tee - Faded Girl', 500000, '2023-10-04', '- 100% Cotton\r\n|- Form Boxy\r\n|- Model: 1m8 70kg size L', 'public/images/products/graptee_main.jpg', 'public/images/products/graptee_1.jpg', 'public/images/products/graptee_2.jpg', 'public/images/products/graptee_3.jpg', 'public/images/products/graptee_4.jpg'),
(8, 'Heavy Brushed Wool Shirt Jacket', 1500000, '2023-10-02', '- Body : 20% Acrylic - 30% Polyester - 50% Wool |\n- Lining : 100% Polyester |\n- Model : 1m80 70kg  - Wearing size L ', 'public/images/products/shirtjacket_heavy_main.jpg', 'public/images/products/shirtjacket_heavy_1.jpg', 'public/images/products/shirtjacket_heavy_2.jpg', 'public/images/products/shirtjacket_heavy_3.jpg', 'public/images/products/shirtjacket_heavy_4.jpg'),
(9, 'Wool Jacket ( Beige )', 1290000, '2023-10-04', '- BODY : 80% WOOL - 20% POLYESTER ; LINING : 100% POLYESTER |\r\n- BOXY FIT - ELONGATED SLEEVES |\r\n- MODEL : 1m87 - 70 kg Wear L ', 'public/images/products/whitejacket_main.jpg', 'public/images/products/whitejacket_1.jpg', 'public/images/products/whitejacket_2.jpg', 'public/images/products/whitejacket_3.jpg', 'public/images/products/whitejacket_4.jpg'),
(10, 'Wool Polo with Pocket', 400000, '2023-10-03', '- Material :  10% COTTON, 90% Wool |- Hand Distressed detail |- Boxy Form', 'public/images/products/polo_len_main.jpg', 'public/images/products/polo_len_1.jpg', 'public/images/products/polo_len_2.jpg', 'public/images/products/polo_len_3.jpg', 'public/images/products/polo_len_4.jpg'),
(11, 'Basic Graphic Black Hoodie ', 500000, '2023-10-03', '- 100% cotton|\r\n- Form Crop|\r\n- Model: 1m8 70kg size L', 'public/images/products/bhoodie_main.jpg', 'public/images/products/bhoodie_1.jpg', 'public/images/products/bhoodie_2.jpg', 'public/images/products/bhoodie_3.jpg', 'public/images/products/bhoodie_4.jpg'),
(12, 'Basic Trouser (Black)', 650000, '2023-10-03', '- Chất Liệu : Kate : 95% Cotton - 5% Polyester |\r\n- Form Straight Fit |\r\n- Model : 1m80 - 70kg wear sz L ', 'public/images/products/trouser_pants__main.jpg', 'public/images/products/trouser_pants__3.jpg', 'public/images/products/trouser_pants__1.jpg', 'public/images/products/trouser_pants__2.jpg', 'public/images/products/trouser_pants__4.jpg'),
(13, 'SLIM FIT TEE (WHITE)', 350000, '2023-10-04', '- 95% cotton 5% spandex ( thun co dãn 4 chiều)|\r\n- Slim Fit Form|\r\n- Model: 1m8 70kg size L', 'public/images/products/fit_tee_main.jpg', 'public/images/products/fit_tee_1.jpg', 'public/images/products/fit_tee_2.jpg', 'public/images/products/fit_tee_3.jpg', 'public/images/products/fit_tee_4.jpg'),
(14, 'Leather Backpack (Beige)', 600000, '2023-10-14', '- Outer material: high quality PU leather|\r\n- Lining material: poly fabric|\r\n- The inside of the backpack can fit a 15.6\' laptop', 'public/images/products/bag01_main.jpg', 'public/images/products/bag01_1.jpg', 'public/images/products/bag01_2.jpg', 'public/images/products/bag01_3.jpg', 'public/images/products/bag01_4.jpg'),
(16, 'Leather Belt ', 400000, '2023-10-03', '- Strap material: cowhide; Pendant: alloy|\r\n- Comes with a drawstring bag and box|\r\n- Size: 110 CM', 'public/images/products/belt_main.jpg', 'public/images/products/belt_1.jpg', 'public/images/products/belt_2.jpg', 'public/images/products/belt_3.jpg', 'public/images/products/belt_4.jpg'),
(17, 'Leather Folding Card Holder', 300000, '2023-10-11', '- Surface material: Genuine leather; Lining material: Polyester|\r\n- 5 card slots|\r\n- Dimensions: 11 x 8.5 x 1.5 (cm)', 'public/images/products/cardholder_main.jpg', 'public/images/products/cardholder_1.jpg', 'public/images/products/cardholder_2.jpg', 'public/images/products/cardholder_3.jpg', 'public/images/products/cardholder_4.jpg'),
(18, 'Folding Long Wallet', 550000, '2023-10-01', '- Surface material: Genuine leather; Lining material: Polyester|\r\n- 12 card slots|\r\n- Dimensions: 18 x 9.5 x 2 (cm)', 'public/images/products/longwallet_main.jpg', 'public/images/products/longwallet_1.jpg', 'public/images/products/longwallet_2.jpg', 'public/images/products/longwallet_3.jpg', 'public/images/products/longwallet_4.jpg'),
(19, 'Corduroy Shirt Jacket ̣(Brown)', 490000, '2023-10-06', '- Material: Velvet|\r\n- Relaxed Fit|\r\n- Heart-shaped pocket detail on the left chest', 'public/images/products/shirt_main.jpg', 'public/images/products/shirt_1.jpg', 'public/images/products/shirt_2.jpg', 'public/images/products/shirt_3.jpg', 'public/images/products/shirt_4.jpg'),
(20, 'Cuban Shirt (Cream White)', 410000, '2023-10-11', '- Material: Cotton Khaki|\r\n- Boxy Fit|\r\n- Heart-shaped pocket detail on the left chest', 'public/images/products/shirt1_main.jpg', 'public/images/products/shirt1_1.jpg', 'public/images/products/shirt1_2.jpg', 'public/images/products/shirt1_3.jpg', 'public/images/products/shirt1_4.jpg'),
(21, 'Linen Cuban Shirt (White)', 490000, '2023-10-04', '- Material: Linen|\r\n- Regular Fit|\r\n- Metallic tag sewn onto the chest.\r\n', 'public/images/products/shirtwhite_main.jpg', 'public/images/products/shirtwhite_1.jpg', 'public/images/products/shirtwhite_2.jpg', 'public/images/products/shirtwhite_3.jpg', 'public/images/products/shirtwhite_4.jpg'),
(22, 'Logo Shorts (White)', 350000, '2023-09-20', '- Material: cotton canvas.|\n- Has pockets on both sides|\n- Model is 1m71 tall, weighs 57kg - wearing size L', 'public/images/products/short_main.jpg', 'public/images/products/short_1.jpg', 'public/images/products/short_2.jpg', 'public/images/products/short_3.jpg', 'public/images/products/short_4.jpg'),
(23, 'Logo Shorts (Black)', 350000, '2023-09-17', '- Material: cotton canvas.|\r\n- Has pockets on both sides|\r\n- Model is 1m71 tall, weighs 57kg - wearing size L', 'public/images/products/shortb_main.jpg', 'public/images/products/shortb_1.jpg', 'public/images/products/shortb_2.jpg', 'public/images/products/shortb_3.jpg', 'public/images/products/shortb_4.jpg'),
(24, 'Caro Shirt (Black)', 700000, '2023-10-15', '- Material: synthetic fiber|\r\n- Relaxed Fit|\r\n- Embroidery on both sides of the bag.', 'public/images/products/ashirt_main.jpg', 'public/images/products/ashirt_1.jpg', 'public/images/products/ashirt_2.jpg', 'public/images/products/ashirt_3.jpg', 'public/images/products/ashirt_4.jpg'),
(25, 'Slim Fit Jeans (Blue)', 600000, '2023-10-12', '- Material: Cotton Denim|\r\n- Slim Fit|\r\n- Fabric surface is lightly washed', 'public/images/products/slinjeans_main.jpg', 'public/images/products/slinjeans_1.jpg', 'public/images/products/slinjeans_2.jpg', 'public/images/products/slinjeans_3.jpg', 'public/images/products/slinjeans_4.jpg'),
(26, 'Canvas Cross Bag', 250000, '2023-10-04', '- Exterior material: Polyester Canvas; Lining material: Polyester|\r\n- The bag can fit a phone and wallet|\r\n- The lid of the bag is closed with a plastic lock', 'public/images/products/crossbag_main.jpg', 'public/images/products/crossbag_1.jpg', 'public/images/products/crossbag_2.jpg', 'public/images/products/crossbag_3.jpg', 'public/images/products/crossbag_4.jpg'),
(27, 'Kittens Tote Bag', 100000, '2023-09-07', '- Material: non-woven fabric|\r\n- Stand-up bag with sturdy seams|\r\n- Size: 29 x 40.5 (cm)', 'public/images/products/totebag_main.jpg', 'public/images/products/totebag_1.jpg', 'public/images/products/totebag_2.jpg', 'public/images/products/totebag_3.jpg', 'public/images/products/totebag_4.jpg'),
(28, 'Leather Crossbody Bag', 390000, '2023-10-03', '- External material: Synthetic leather; Lining material: Polyester|\r\n- Main bag size: 13 x 19.5 x 6.5 (cm)|\r\n - Small bag size: 11.5 x 7 x 2.5 (cm)', 'public/images/products/crbodybag_main.jpg', 'public/images/products/crbodybag_1.jpg', 'public/images/products/crbodybag_2.jpg', 'public/images/products/crbodybag_3.jpg', 'public/images/products/crbodybag_4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sanphamdm`
--

CREATE TABLE `tbl_sanphamdm` (
  `id_sanpham` int(11) NOT NULL,
  `id_danhmuc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_sanphamdm`
--

INSERT INTO `tbl_sanphamdm` (`id_sanpham`, `id_danhmuc`) VALUES
(1, 2),
(2, 0),
(3, 3),
(4, 6),
(5, 2),
(6, 0),
(8, 2),
(9, 2),
(10, 0),
(11, 2),
(12, 4),
(13, 0),
(14, 6),
(16, 6),
(17, 6),
(18, 6),
(19, 2),
(20, 1),
(21, 1),
(22, 5),
(23, 5),
(24, 1),
(25, 3),
(26, 6),
(27, 6),
(28, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_size`
--

CREATE TABLE `tbl_size` (
  `id_sanpham` int(11) NOT NULL,
  `size` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tonkho` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_size`
--

INSERT INTO `tbl_size` (`id_sanpham`, `size`, `tonkho`) VALUES
(1, 'L', 12),
(1, 'M', 5),
(1, 'S', 12),
(2, 'L', 11),
(2, 'M', 12),
(2, 'S', 32),
(2, 'XL', 15),
(2, 'XS', 15),
(3, 'L', 15),
(3, 'M', 15),
(3, 'S', 14),
(4, 'PK', 51),
(5, 'L', 15),
(5, 'M', 34),
(5, 'S', 3),
(5, 'XL', 24),
(6, 'L', 14),
(6, 'M', 2),
(6, 'S', 41),
(8, 'L', 12),
(8, 'M', 125),
(8, 'S', 123),
(8, 'XL', 144),
(8, 'XS', 12),
(9, 'L', 142),
(9, 'M', 42),
(9, 'S', 12),
(10, 'L', 42),
(10, 'M', 13),
(10, 'S', 42),
(10, 'XL', 123),
(10, 'XS', 123),
(11, 'L', 213),
(11, 'M', 32),
(11, 'S', 41),
(12, 'L', 124),
(12, 'M', 52),
(12, 'S', 15),
(12, 'XL', 142),
(13, 'L', 121),
(13, 'M', 67),
(13, 'S', 67),
(14, 'PK', 87),
(16, 'PK', 98),
(17, 'PK', 23),
(18, 'PK', 12),
(19, 'L', 123),
(19, 'M', 12),
(19, 'S', 13),
(20, 'L', 42),
(20, 'M', 24),
(20, 'S', 32),
(21, 'L', 12),
(21, 'M', 42),
(21, 'S', 14),
(22, 'M', 233),
(22, 'S', 123),
(23, 'L', 41),
(23, 'M', 44),
(24, 'L', 34),
(24, 'M', 43),
(24, 'S', 34),
(24, 'XL', 53),
(24, 'XS', 43),
(25, 'L', 23),
(25, 'M', 42),
(25, 'S', 123),
(25, 'XL', 124),
(25, 'XS', 33),
(26, 'PK', 44),
(27, 'PK', 23),
(28, 'PK', 23);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_taikhoan`
--

CREATE TABLE `tbl_taikhoan` (
  `id_taikhoan` int(11) NOT NULL,
  `tendangnhap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matkhau` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phanquyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_taikhoan`
--

INSERT INTO `tbl_taikhoan` (`id_taikhoan`, `tendangnhap`, `matkhau`, `phanquyen`) VALUES
(1, 'admin', '123', 0),
(2, 'ab160', '123', 1),
(3, 'vy123', '123', 1),
(4, 'tien1', '123', 1),
(63, 'coda1601', 'asd', 1),
(64, 'ad123', '123', 1),
(65, 'a123', '123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_taikhoankh`
--

CREATE TABLE `tbl_taikhoankh` (
  `id_taikhoan` int(11) NOT NULL,
  `id_khachhang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_taikhoankh`
--

INSERT INTO `tbl_taikhoankh` (`id_taikhoan`, `id_khachhang`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(63, 63),
(64, 64),
(65, 65);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_thongtinkhachhang`
--

CREATE TABLE `tbl_thongtinkhachhang` (
  `id_khachhang` int(11) NOT NULL,
  `ho` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `diachi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_thongtinkhachhang`
--

INSERT INTO `tbl_thongtinkhachhang` (`id_khachhang`, `ho`, `ten`, `sdt`, `email`, `diachi`) VALUES
(1, 'Nguyễn', 'Công Đạt', '0123456789', 'admin@baeshop.com', '231 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM'),
(2, 'nguyen ', 'b', '09219291221', 'vhaus@gmail.com', '23111 Nguyễn Công Đạt, phường 1, quận 12, TP.HCM'),
(3, 'Tran', 'Vy', '091231554', 'vy@gmail.coom', ''),
(4, 'Trần ', 'Thủy Tiên', '023456178', 'tien@gmail.com', ''),
(63, 'Nguyen', 'Cong Dat', '0961781700', 'coda@yahoo.com', '279 Nguyễn Tri Phương, phường 5, Quận 10, TPHCM'),
(64, 'Tran', 'dat', '01545612312', 'renaeandgaryrichardson@hotmail.com', ''),
(65, 'Nguyen', 'A', '0483321112', 'coda@yahoo.com', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`id_banner`);

--
-- Indexes for table `tbl_chitiethoadon`
--
ALTER TABLE `tbl_chitiethoadon`
  ADD PRIMARY KEY (`id_hoadon`,`id_sanpham`,`size`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Indexes for table `tbl_danhmuc`
--
ALTER TABLE `tbl_danhmuc`
  ADD PRIMARY KEY (`id_danhmuc`);

--
-- Indexes for table `tbl_giamgia`
--
ALTER TABLE `tbl_giamgia`
  ADD KEY `tbl_giamgia_ibfk_1` (`id_sanpham`);

--
-- Indexes for table `tbl_giohang`
--
ALTER TABLE `tbl_giohang`
  ADD PRIMARY KEY (`id_taikhoan`,`id_sanpham`,`size`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Indexes for table `tbl_hoadon`
--
ALTER TABLE `tbl_hoadon`
  ADD PRIMARY KEY (`id_hoadon`),
  ADD KEY `id_khachhang` (`id_khachhang`);

--
-- Indexes for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  ADD PRIMARY KEY (`id_sanpham`);

--
-- Indexes for table `tbl_sanphamdm`
--
ALTER TABLE `tbl_sanphamdm`
  ADD PRIMARY KEY (`id_sanpham`,`id_danhmuc`),
  ADD KEY `id_danhmuc` (`id_danhmuc`);

--
-- Indexes for table `tbl_size`
--
ALTER TABLE `tbl_size`
  ADD PRIMARY KEY (`id_sanpham`,`size`);

--
-- Indexes for table `tbl_taikhoan`
--
ALTER TABLE `tbl_taikhoan`
  ADD PRIMARY KEY (`id_taikhoan`),
  ADD UNIQUE KEY `tendangnhap` (`tendangnhap`);

--
-- Indexes for table `tbl_taikhoankh`
--
ALTER TABLE `tbl_taikhoankh`
  ADD KEY `tbl_taikhoankh_ibfk_1` (`id_taikhoan`),
  ADD KEY `tbl_taikhoankh_ibfk_2` (`id_khachhang`);

--
-- Indexes for table `tbl_thongtinkhachhang`
--
ALTER TABLE `tbl_thongtinkhachhang`
  ADD PRIMARY KEY (`id_khachhang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `id_banner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_danhmuc`
--
ALTER TABLE `tbl_danhmuc`
  MODIFY `id_danhmuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_hoadon`
--
ALTER TABLE `tbl_hoadon`
  MODIFY `id_hoadon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  MODIFY `id_sanpham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_taikhoan`
--
ALTER TABLE `tbl_taikhoan`
  MODIFY `id_taikhoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_thongtinkhachhang`
--
ALTER TABLE `tbl_thongtinkhachhang`
  MODIFY `id_khachhang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_chitiethoadon`
--
ALTER TABLE `tbl_chitiethoadon`
  ADD CONSTRAINT `tbl_chitiethoadon_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `tbl_sanpham` (`id_sanpham`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_chitiethoadon_ibfk_2` FOREIGN KEY (`id_hoadon`) REFERENCES `tbl_hoadon` (`id_hoadon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_giamgia`
--
ALTER TABLE `tbl_giamgia`
  ADD CONSTRAINT `tbl_giamgia_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `tbl_sanpham` (`id_sanpham`);

--
-- Constraints for table `tbl_giohang`
--
ALTER TABLE `tbl_giohang`
  ADD CONSTRAINT `tbl_giohang_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `tbl_sanpham` (`id_sanpham`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_giohang_ibfk_2` FOREIGN KEY (`id_taikhoan`) REFERENCES `tbl_taikhoan` (`id_taikhoan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_hoadon`
--
ALTER TABLE `tbl_hoadon`
  ADD CONSTRAINT `tbl_hoadon_ibfk_1` FOREIGN KEY (`id_khachhang`) REFERENCES `tbl_thongtinkhachhang` (`id_khachhang`);

--
-- Constraints for table `tbl_sanphamdm`
--
ALTER TABLE `tbl_sanphamdm`
  ADD CONSTRAINT `tbl_sanphamdm_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `tbl_sanpham` (`id_sanpham`),
  ADD CONSTRAINT `tbl_sanphamdm_ibfk_2` FOREIGN KEY (`id_danhmuc`) REFERENCES `tbl_danhmuc` (`id_danhmuc`);

--
-- Constraints for table `tbl_size`
--
ALTER TABLE `tbl_size`
  ADD CONSTRAINT `tbl_size_ibfk_1` FOREIGN KEY (`id_sanpham`) REFERENCES `tbl_sanpham` (`id_sanpham`);

--
-- Constraints for table `tbl_taikhoankh`
--
ALTER TABLE `tbl_taikhoankh`
  ADD CONSTRAINT `tbl_taikhoankh_ibfk_1` FOREIGN KEY (`id_taikhoan`) REFERENCES `tbl_taikhoan` (`id_taikhoan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_taikhoankh_ibfk_2` FOREIGN KEY (`id_khachhang`) REFERENCES `tbl_thongtinkhachhang` (`id_khachhang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
