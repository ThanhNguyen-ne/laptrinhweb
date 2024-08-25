-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 25, 2024 lúc 04:01 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `cua_hang_yen_sao`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_don_hang`
--

CREATE TABLE `chi_tiet_don_hang` (
  `id` int(11) NOT NULL,
  `don_hang_id` int(11) DEFAULT NULL,
  `san_pham_id` int(11) DEFAULT NULL,
  `so_luong` int(11) NOT NULL,
  `gia_ban` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chi_tiet_don_hang`
--

INSERT INTO `chi_tiet_don_hang` (`id`, `don_hang_id`, `san_pham_id`, `so_luong`, `gia_ban`) VALUES
(1, 1, 1, 1, 37800000.00),
(2, 2, 2, 1, 23760000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_hang`
--

CREATE TABLE `don_hang` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `tong_tien` decimal(10,2) DEFAULT NULL,
  `ngay_dat` datetime DEFAULT current_timestamp(),
  `trang_thai` enum('cho_xu_ly','dang_xu_ly','hoan_thanh','da_huy') DEFAULT 'cho_xu_ly'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `don_hang`
--

INSERT INTO `don_hang` (`id`, `nguoi_dung_id`, `tong_tien`, `ngay_dat`, `trang_thai`) VALUES
(1, 1, 37800000.00, '2024-08-25 13:32:09', 'hoan_thanh'),
(2, 2, 23760000.00, '2024-08-25 13:32:09', 'cho_xu_ly');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gio_hang`
--

CREATE TABLE `gio_hang` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `san_pham_id` int(11) DEFAULT NULL,
  `so_luong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_san_pham`
--

CREATE TABLE `loai_san_pham` (
  `id` int(11) NOT NULL,
  `ten_loai` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_san_pham`
--

INSERT INTO `loai_san_pham` (`id`, `ten_loai`, `mo_ta`) VALUES
(1, 'Yến sào đảo yến thiên nhiên', 'Sản phẩm yến từ đảo yến thiên nhiên Khánh Hòa.'),
(2, 'Yến sào Sanvinest', 'Sản phẩm yến của thương hiệu Sanvinest Khánh Hòa.'),
(3, 'Yến sào Sanest', 'Sản phẩm yến của thương hiệu Sanest Khánh Hòa.'),
(4, 'Tinh chất yến sào', 'Các sản phẩm tinh chất yến sào thiên nhiên Khánh Hòa.'),
(5, 'Thực phẩm Sanest Food', 'Các sản phẩm thực phẩm chế biến từ yến sào và hạt điều.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `vai_tro` enum('admin','khach_hang') DEFAULT 'khach_hang',
  `ngay_dang_ky` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `dia_chi`, `vai_tro`, `ngay_dang_ky`) VALUES
(1, 'Nguyen Quoc Tung', 'tung@gmail.com', 'password123', '0123456789', '70 Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh', 'khach_hang', '2024-08-25 13:32:09'),
(2, 'Nguyễn Võ Thành', 'thanh@gmail.com', 'password123', '0987654321', '70 Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh', 'khach_hang', '2024-08-25 13:32:09'),
(3, 'Admin', 'admin@gmail.com', '$2y$10$nYdCVCboNqIhpX8TbzeRResoXeQJtJ8hrxj3AnwIiwCUe1xuRr3vq', '', '', 'admin', '2024-08-25 13:32:09'),
(4, 'Nguyễn Võ Thành', 'nguyenvothanh2004@gmail.com', '$2y$10$81vVM8rcLC2xYIJQHI56ye5NCnMcLZCyeUdr.hSIug68CuBXcsPDm', '0929352067', 'Tuy Hòa', 'khach_hang', '2024-08-25 16:02:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phan_hoi`
--

CREATE TABLE `phan_hoi` (
  `id` int(11) NOT NULL,
  `nguoi_dung_id` int(11) DEFAULT NULL,
  `san_pham_id` int(11) DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `danh_gia` int(11) DEFAULT NULL CHECK (`danh_gia` between 1 and 5),
  `ngay_gui` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phan_hoi`
--

INSERT INTO `phan_hoi` (`id`, `nguoi_dung_id`, `san_pham_id`, `noi_dung`, `danh_gia`, `ngay_gui`) VALUES
(1, 1, 1, 'Sản phẩm rất tốt, tôi rất hài lòng.', 5, '2024-08-25 13:32:09'),
(2, 2, 2, 'Yến thô chưa sạch lắm, cần cải thiện.', 3, '2024-08-25 13:32:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `id` int(11) NOT NULL,
  `ten_san_pham` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `gia` int(11) NOT NULL,
  `so_luong_ton` int(11) NOT NULL,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `ngay_cap_nhat` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`id`, `ten_san_pham`, `mo_ta`, `hinh_anh`, `gia`, `so_luong_ton`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024', 'THÔNG TIN NỔI BẬT: Yến huyết đảo yến thiên nhiên nguyên tổ là tổ yến có màu đỏ tự nhiên. Sản phẩm Yến huyết đảo yến thiên nhiên nguyên tổ hộp 100g - MS 024 có giá trị dinh dưỡng rất cao. Nhờ vào nguồn gốc địa hóa, thành phần hóa học và khoáng vật phong phú tại những vách đá cheo leo hiểm trở, hang động dưới chân sóng vỗ quanh năm là nền tảng làm phong phú nguyên tố đa vi lượng trong tổ yến, tạo nên giá trị dinh dưỡng đặc biệt cao và mùi vị đặc trưng của tổ yến đảo thiên nhiên. Đặc biệt, chỉ có một số hang đảo thiên nhiên tại các đảo yến Khánh Hòa mới có tổ yến huyết.', '/assets/image/product/yensaonguyento/yskh_024.jpg', 37800000, 50, '2024-08-25 13:32:09', '2024-08-25 20:36:56'),
(2, 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026', 'THÔNG TIN NỔI BẬT: Sản phẩm Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100g (mã số: 026), bao gồm những tổ yến hồng còn nguyên tổ, màu hồng nhạt có giá trị dinh dưỡng cao. Đặc biệt, chỉ có một số hang đảo thiên nhiên tại các đảo yến Khánh Hòa có tổ yến hồng.', '/assets/image/product/yensaonguyento/yskh_026.jpg', 23760000, 30, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(3, 'Yến huyết đảo thiên nhiên Khánh Hòa mẫu hộp quà tặng - 024S', 'THÔNG TIN NỔI BẬT: Yến huyết đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng là tổ yến có màu sắc đỏ, màu đỏ tự nhiên của tổ yến đảo thiên nhiên. Sản phẩm Yến huyết đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng 50g (mã số: 024S) có giá trị dinh dưỡng rất cao. Nhờ vào nguồn gốc địa hóa, thành phần hóa học và khoáng vật phong phú tại những vách đá cheo leo hiểm trở, hang động dưới chân sóng vỗ quanh năm là nền tảng làm phong phú nguyên tố đa vi lượng trong tổ yến tạo nên giá trị dinh dưỡng đặc biệt cao và mùi vị đặc trưng của tổ yến đảo thiên nhiên. Đặc biệt, chỉ có một số hang đảo thiên nhiên tại các đảo yến Khánh Hòa mới có tổ yến huyết.', '/assets/image/product/yensaonguyento/_024s.jpg', 19170000, 100, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(4, 'Yến sao đảo yến thiên nhiên Khánh Hòa hộp 100G -TP1', 'THÔNG TIN NỔI BẬT: Yến sào đảo yến thiên nhiên Khánh Hòa (nguyên tổ) hộp TP1-100g còn gọi là Yến Thiên: là tổ yến còn nguyên, khoảng từ 17 đến 18 tổ yến/100g. Tổ yến có màu trắng theo thuộc tính tổ yến đảo thiên nhiên.', '/assets/image/product/yensaonguyento/tp1_9547ae75719143bea6c155e98e1fc816.jpg', 13500000, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(5, 'Yến hồng đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng - 026S', 'THÔNG TIN NỔI BẬT: Yến sào đảo yến thiên nhiên Khánh Hòa nguyên tổ hồng là tổ yến có màu sắc hồng nhạt trên bề mặt của tổ yến, màu sắc hồng tự nhiên của tổ yến đảo thiên nhiên. Nhờ vào nguồn gốc địa hóa, thành phần hóa học và khoáng vật phong phú tại những vách đá, hang động làm phong phú nguyên tố đa vi lượng trong tổ yến, tạo nên giá trị dinh dưỡng đặc biệt cao và mùi vị đặc trưng của tổ yến đảo thiên nhiên. Đặc biệt, chỉ có một số hang đảo thiên nhiên tại các đảo yến Khánh Hòa có tổ yến hồng. Sản phẩm Yến sào đảo yến thiên nhiên Khánh Hòa (Yến hồng hộp quà tặng 50g - 026S) được đóng gói bao bì theo kiểu dáng quà tặng trang trọng, thích hợp làm quà biếu tặng trong những dịp lễ, Tết.', '/assets/image/product/yensaonguyento/yskh_026s.webp', 12150000, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(6, 'Yến sào đảo thiên nhiên tinh chế hộp 100G - 014', 'THÔNG TIN NỔI BẬT:Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 100g có mã sản phẩm 014 với trọng lượng yến 100g.Yến sào đảo yến thiên nhiên tinh chế là sản phẩm đã được làm sạch hoàn toàn từ yến đảo thiên nhiên Khánh Hòa, do Công ty Yến sào Khánh Hoà trực tiếp quản lý, khai thác, chế biến. Khi sử dụng, khách hàng đưa ngay vào chế biến, không cần phải làm sạch lại.', '/assets/image/product/yensaonguyento/014_b790244e32e145c8a21efdee64b8d456.webp', 7128000, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(7, 'Yến sào đảo thiên nhiên tinh chế hộp 3G - 011', 'THÔNG TIN NỔI BẬT: Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 3g -  MS 011, mẫu hộp 3g yến. Nhằm tạo thuận lợi cho người tiêu dùng khi sử dụng, Công ty giới thiệu với khách hàng dạng hộp 3g cho 1 người sử dụng/lần, kèm theo một lượng đường phèn tinh khiết tương ứng với trọng lượng yến sào trong hộp, có hướng dẫn sử dụng được ghi rõ ràng, cụ thể và đúng cách pha chế truyền thống.\r\n', '/assets/image/product/yensaonguyento/011_ebce11cb07a744fa8d61dbe83c2f130c.webp', 232200, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(8, 'Yến sào đảo thiên nhiên tinh chế hộp 50G - 015', 'THÔNG TIN NỔI BẬT: Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 50g có mã sản phẩm 015 với trọng lượng yến 50g. Yến sào đảo yến thiên nhiên tinh chế là sản phẩm đã được làm sạch hoàn toàn từ yến đảo thiên nhiên Khánh Hòa, do Công ty Yến sào Khánh Hoà trực tiếp quản lý, khai thác, chế biến. Khi sử dụng, khách hàng đưa ngay vào chế biến, không cần phải làm sạch lại.\r\n', '/assets/image/product/yensaonguyento/014_b790244e32e145c8a21efdee64b8d456.webp', 3564000, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(9, 'Yến sào đảo thiên nhiên tinh chế hộp 5G - 012', 'THÔNG TIN NỔI BẬT: Sản phẩm Yến sào đảo yến thiên nhiên tinh chế  làm sạch hộp 5g- MS 012, mẫu hộp 5g yến. Nhằm tạo thuận lợi cho người tiêu dùng khi sử dụng, Công ty giới thiệu với khách hàng dạng hộp 5g cho 2 người sử dụng/lần, kèm theo một lượng đường phèn tinh khiết tương ứng với trọng lượng yến sào trong hộp, có hướng dẫn sử dụng được ghi rõ ràng, cụ thể và đúng cách pha chế truyền thống.\r\n', '/assets/image/product/yensaonguyento/011_ebce11cb07a744fa8d61dbe83c2f130c.webp', 378000, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(10, 'Yến sào đảo thiên nhiên tinh chế hộp quà tặng 2 hộp 3G - 011G2', 'THÔNG TIN NỔI BẬT: Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp quà tặng( 2hộp x3g) 011G2, mẫu hộp gồm 2 hộp nhỏ, mỗi hộp nhỏ 3g, được đóng gói bao bì theo kiểu dáng quà tặng trang trọng, thích hợp làm quà biếu tặng trong những dịp lễ, Tết. Yến sào đảo yến thiên nhiên tinh chế là sản phẩm đã được làm sạch hoàn toàn từ yến đảo thiên nhiên Khánh Hòa, do Công ty Yến sào Khánh Hoà trực tiếp quản lý, khai thác, chế biến. Khi sử dụng, khách hàng đưa ngay vào chế biến, không cần phải làm sạch lại.\r\n', '/assets/image/product/yensaonguyento/yskh_012g2_op_97485178226440bba20791aeecf4a837.webp', 507600, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(11, 'Yến sào đảo thiên nhiên tinh chế hộp quà tặng 2 hộp 5G - 012G2', 'THÔNG TIN NỔI BẬT: Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp quà tặng (2hộp  x 5g ) 012G2, mẫu hộp gồm 2 hộp nhỏ, mỗi hộp nhỏ 5g, có mã sản phẩm là 012G2, được đóng gói bao bì theo kiểu dáng quà tặng trang trọng, thích hợp làm quà biếu tặng trong những dịp lễ, Tết.\r\n', '/assets/image/product/yensaonguyento/yskh_012g2_op_97485178226440bba20791aeecf4a837.webp', 799200, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(12, 'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 100G - 014G', 'THÔNG TIN NỔI BẬT: Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng với trọng lượng yến100g - MS 014G, tặng kèm 1 thố chưng yến, được đóng gói với mẫu mã thiết kế sang trọng theo kiểu dáng hộp quà tặng, thích hợp làm quà biếu tặng trong những dịp lễ, Tết. Yến sào đảo yến thiên nhiên tinh chế là sản phẩm đã được làm sạch hoàn toàn từ yến đảo thiên nhiên Khánh Hòa, do Công ty Yến sào Khánh Hoà trực tiếp quản lý, khai thác từ các đảo yến thiên nhiên trên vùng biển Khánh Hòa. Sản phẩm không sử dụng hóa chất, hương liệu và chất bảo quản. Vì vậy sản phẩm yến đảo tinh chế của Công ty luôn giữ được giá trị bổ dưỡng với hương vị đặc trưng tự nhiên của yến sào đảo thiên nhiên.\r\n', '/assets/image/product/yensaonguyento/yskh_014g.webp', 7516800, 50, '2024-08-25 13:32:09', '2024-08-25 20:50:45'),
(13, 'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 100G - 014GS', 'THÔNG TIN NỔI BẬT: Sản phẩm yến sào nguyên chất từ đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 100g - MS 014GS, gồm có 100g yến tinh chế, tặng kèm 1 thố chưng yến, 1 tổ yến đảo nguyên tổ, được đóng gói với mẫu mã thiết kế sang trọng theo kiểu dáng hộp quà tặng, thích hợp làm quà biếu tặng trong những dịp lễ, Tết.\r\n', '/assets/image/product/yensaonguyento/yskh_014g.webp', 7916400, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(14, 'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 3G - 011G', 'THÔNG TIN NỔI BẬT: Sản phẩm Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 3g - MS 011G, mẫu hộp gồm 5 hộp nhỏ, mỗi hộp nhỏ 3g, được đóng gói bao bì theo kiểu dáng quà tặng sang trọng, thích hợp làm quà biếu tặng trong những dịp lễ, Tết.Yến sào đảo yến thiên nhiên tinh chế là sản phẩm đã được làm sạch hoàn toàn từ yến đảo thiên nhiên Khánh Hòa, do Công ty Yến sào Khánh Hoà trực tiếp quản lý, khai thác từ các đảo yến thiên nhiên trên vùng biển Khánh Hòa. Sản phẩm không sử dụng hóa chất, hương liệu và chất bảo quản. Vì vậy sản phẩm yến đảo tinh chế của Công ty luôn giữ được giá trị bổ dưỡng với hương vị đặc trưng tự nhiên của yến sào đảo thiên nhiên.\r\n', '/assets/image/product/yensaonguyento/yskh_011g_op.webp', 1220400, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(15, 'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 50G - 015G', 'THÔNG TIN NỔI BẬT: Sản phẩm Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 50g - 015G với trọng lượng yến 50g, có mã sản phẩm là 015G, tặng kèm 1 thố chưng yến, được đóng gói bao bì theo kiểu dáng quà tặng trang trọng, thích hợp làm quà biếu tặng trong những dịp lễ, Tết.\r\n', '/assets/image/product/yensaonguyento/yskh_014g.webp', 3931200, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(16, 'Hộp quà tặng Yến sào Nguyên tổ 50g Sanvinest Khánh Hòa Chính hiệu - Q150', 'THÔNG TIN NỔI BẬT: Yến sào Sanvinest Khánh Hòa.Xuất xứ:Khánh Hòa - Việt Nam.Phân loại:Tổ yến nguyên chất còn lôngTrọng lượng: 50gĐặc trưng;Màu trắng nguyên thủyHình võng tròn đều, đầy dáng.Tanh nhẹ đặc trưng (mùi biển).\r\n', '/assets/image/product/yensaonguyento/q150_42b932ad40724f34a9230042878f5122.jpg', 2308500, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(17, 'Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 100g - Q610', 'THÔNG TIN NỔI BẬT: Yến sào Sanvinest Khánh Hòa.Xuất xứ:Khánh Hòa - Việt Nam.Phân loại:Yến sào nguyên chất đã được làm sạch - Dạng tổTrọng lượng: 100gĐặc trưng;- Màu nguyên thủy- Chế biến ngay, Không cần sơ chế lại.\r\n', '/assets/image/product/sanviest/q160_7e71defed4054c8da70240dada86b807.jpg', 6796900, 50, '2024-08-25 13:32:09', '2024-08-25 20:43:23'),
(18, 'Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 50g - Q650\r\n', 'THÔNG TIN NỔI BẬT: Yến sào từ lâu đã được biết đến là nguồn thực phẩm bổ dưỡng diệu kỳ để tăng cường sức khỏe, tăng cường hệ miễn dịch cho cơ thể. Yến sào có tác dụng làm sạch phổi và các cơ quan hô hấp cùng các triệu chứng dị ứng, giúp tăng thể lực, làm tăng số lượng hồng cầu, huyết sắc tố, giảm thời gian đông máu, tăng cường các kích thích sinh trưởng cho các tế bào, chống lão hóa, bảo vệ da, giúp làn da sáng mịn, hồi xuân, tăng tuổi thọ.\r\n', '/assets/image/product/sanviest/q650_fefa4292fffd46a5988f035460f1f458.jpg', 3103650, 50, '2024-08-25 13:32:09', '2024-08-25 20:47:13'),
(19, 'Nước yến sào Khánh Hòa Sanvinest trẻ em lọ 62ml, hộp 1 lọ - 2011', 'THÔNG TIN NỔI BẬT: Nước Yến sào Sanvinest Khánh Hòa dành cho trẻ em là sản phẩm được chế biến từ Yến sào kết hợp với các dưỡng chất như Taurine, L-Lysine, Palatinose, Orafti GR:Giúp tăng cường sức đề kháng cho cơ thể, cải thiện hệ miễn dịch, kích thích tiêu hóa, tăng cường trí nhớ và bổ sung một số khoáng chất cần thiết cho cơ thể như canxi, sắt, kẽm…; Hỗ trợ sự phát triển thị giác; Giúp nhuận tràng, cân bằng hệ vi sinh vật đường ruột; Giúp ăn ngon, hấp thu dinh dưỡng và canxi, hỗ trợ phát triển chiều cao; Cung cấp năng lượng ổn định cho hoạt động thể chất, trí não.\r\n', '/assets/image/product/sanviest/2011_c5841feb5c404b46ba9976eb7b039439.jpg', 34400, 50, '2024-08-25 13:32:09', '2024-08-25 20:51:17'),
(20, 'Nước yến sào Khánh Hòa Sanvinest Đông Trùng Hạ Thảo lọ 70ml - 208', 'THÔNG TIN NỔI BẬT: Nước Yến sào Khánh Hòa Sanvinest Đông trùng hạ thảo là sản phẩm có hàm lượng dinh dưỡng cao được chế biến từ nguồn nguyên liệu Yến sào thiên nhiên Khánh Hòa kết hợp với đông trùng hạ thảo là dược liệu quý mang lại nhiều lợi ích cho sức khỏe của người sử dụng.\r\n', '/assets/image/product/sanviest/untitled_0e6fde7e18f14b2b8254a91fc6a4645e.webp', 42300, 50, '2024-08-25 13:32:09', '2024-08-25 20:51:38'),
(21, 'Nước yến sào Khánh Hòa Sanvinest Đông Trùng Hạ Thảo lọ 70ml hộp 6 lọ - 208H6', 'THÔNG TIN NỔI BẬT: Nước Yến sào Khánh Hòa Sanvinest Đông trùng hạ thảo là sản phẩm có hàm lượng dinh dưỡng cao được chế biến từ nguồn nguyên liệu Yến sào thiên nhiên Khánh Hòa kết hợp với đông trùng hạ thảo là dược liệu quý mang lại nhiều lợi ích cho sức khỏe của người sử dụng.\r\n', '/assets/image/product/sanviest/untitled_f80e0c02aa534b6cb7f02f43c1bdbd21.webp', 263200, 50, '2024-08-25 13:32:09', '2024-08-25 20:52:35'),
(22, 'Nước yến sào Khánh Hòa Sanvinest không đường lọ 70ml, hộp 6 lọ - 102H6', 'THÔNG TIN NỔI BẬT: Công dụng của Yến sào là bổ huyết, tăng sức đề kháng cho cơ thể, đẹp da, chống lão hóa, ổn định thần kinh, trí nhớ, kích thích tiêu hóa, phục hồi sức khỏe trong thời gian dưỡng bệnh.Nước Yến sào Sanvinest Khánh Hòa không đường đóng lọ là sản phẩm có giá trị bổ dưỡng, thích hợp cho mọi độ tuổi, phù hợp với người cần được bồi bổ.\r\n', '/assets/image/product/sanviest/hop_6_lo_102_fd7dbb1807c0459288946f908705f6b9.webp', 220000, 50, '2024-08-25 13:32:09', '2024-08-25 20:52:35'),
(23, 'Nước yến sào Khánh Hòa Sanvinest lọ 70ml, hộp 1 lọ - 101', 'THÔNG TIN NỔI BẬT: Công dụng của Yến sào là bổ huyết, tăng sức đề kháng cho cơ thể, đẹp da, chống lão hóa, ổn định thần kinh, trí nhớ, kích thích tiêu hóa, phục hồi sức khỏe trong thời gian dưỡng bệnh. Nước Yến sào Sanvinest Khánh Hòa đóng lọ là sản phẩm có giá trị bổ dưỡng, thích hợp cho mọi độ tuổi, phù hợp với người cần được bồi bổ.\r\n', '/assets/image/product/sanviest/101_678512918f8343ff96395b3e653a0bfe.webp', 35400, 50, '2024-08-25 13:32:09', '2024-08-25 20:52:35'),
(24, 'Nước yến sào Khánh Hòa Sanvinest lon 190ML - 121', 'THÔNG TIN NỔI BẬT: Nước Yến sào Sanvinest Khánh Hòa đóng lon là sản phẩm giải khát bổ dưỡng, thích hợp cho mọi độ tuổi.Nước Yến sào Sanvinest Khánh Hòa được sản xuất từ nguồn Yến sào thiên nhiên do Công ty Yến sào Khánh Hòa trực tiếp khai thác.Nước Yến sào Sanvinest Khánh Hòa được chế biến theo phương pháp cổ truyền kết hợp với khoa học công nghệ hiện đại trên dây chuyền thiết bị kỹ thuật tiên tiến của Châu Âu.\r\n', '/assets/image/product/sanviest/121_f2553d9e10d745c2b0dba5f324cc7213.webp', 8900, 50, '2024-08-25 13:32:09', '2024-08-25 20:52:35'),
(25, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp 10 túi 20ml - TC503H10', 'THÔNG TIN NỔI BẬT: Tinh chất Yến sào Khánh Hòa Sanvinest từ tổ yến sào nguyên chất được chế biến theo bí quyết cổ truyền kết hợp với công nghệ hiện đại, hỗ trợ hấp thu dưỡng chất nhanh chóng và dễ dàng.Tinh chất Yến sào Khánh Hòa Sanvinest giúp bồi bổ sức khỏe, tăng cường sức đề kháng, giảm căng thẳng thần kinh, giải tỏa stress, cân bằng quá trình trao đổi chất, ngăn ngừa quá trình lão hóa, làm đẹp da và duy trì hoạt động thể lực.\r\n', '/assets/image/product/sanviest/10_66b27067e1674475ae4d6035b5c15274.webp', 380000, 50, '2024-08-25 13:32:09', '2024-08-25 20:52:35'),
(26, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp 20 túi 20ml - TC503H20', 'THÔNG TIN NỔI BẬT: Tinh chất Yến sào Khánh Hòa Sanvinest từ tổ yến sào nguyên chất được chế biến theo bí quyết cổ truyền kết hợp với công nghệ hiện đại, hỗ trợ hấp thu dưỡng chất nhanh chóng và dễ dàng.Tinh chất Yến sào Khánh Hòa Sanvinest giúp bồi bổ sức khỏe, tăng cường sức đề kháng, giảm căng thẳng thần kinh, giải tỏa stress, cân bằng quá trình trao đổi chất, ngăn ngừa quá trình lão hóa, làm đẹp da và duy trì hoạt động thể lực.\r\n', '/assets/image/product/sanviest/10_66b27067e1674475ae4d6035b5c15274.webp', 754000, 50, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(27, 'Nước Yến sào Sanvinest không đường lon 190ml, hay 30 lon - 125K30', 'THÔNG TIN NỔI BẬT:  Nước, Yến sào 1,6%, đường tinh luyện, Taurine, 2’-fucosyllactose (2’-FL), chất ổn định (406, 327, 415, 401, 466), hương liệu tổng hợp dùng cho thực phẩm.Yến sào: Yến sào giúp tăng cường sức đề kháng cho cơ thể [1], kích thích tiêu hóa [2] , tăng cường trí nhớ [3,4] và bổ sung một số khoáng chất cần thiết cho cơ thể như canxi, sắt, kẽm ...[5]\r\n', '/assets/image/product/sanviest/9_35b9d820ac674d38b3a3b83a96bb2ba8.webp', 604000, 50, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(28, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp quà tặng 20 túi 20ml - QTC503H20', 'THÔNG TIN NỔI BẬT: Tinh chất Yến sào Khánh Hòa Sanvinest từ tổ yến sào nguyên chất được chế biến theo bí quyết cổ truyền kết hợp với công nghệ hiện đại, hỗ trợ hấp thu dưỡng chất nhanh chóng và dễ dàng.Tinh chất Yến sào Khánh Hòa Sanvinest giúp bồi bổ sức khỏe, tăng cường sức đề kháng, giảm căng thẳng thần kinh, giải tỏa stress, cân bằng quá trình trao đổi chất, ngăn ngừa quá trình lão hóa, làm đẹp da và duy trì hoạt động thể lực.\r\n', '/assets/image/product/sanviest/9_35b9d820ac674d38b3a3b83a96bb2ba8.webp', 792000, 50, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(29, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi Hộp quà tặng 15 túi 20ml - QTC502H15', 'THÔNG TIN NỔI BẬT: Tinh chất Yến sào Khánh Hòa Sanvinest từ tổ yến sào nguyên chất được chế biến theo bí quyết cổ truyền kết hợp với công nghệ hiện đại, hỗ trợ hấp thu dưỡng chất nhanh chóng và dễ dàng.Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi giúp bồi bổ sức khỏe, tăng cường sức đề kháng, tăng cường hệ miễn dịch tự nhiên, tăng cường tuần hoàn máu não, giúp ngủ ngon, giảm mệt mỏi lo âu và hỗ trợ hệ xương khớp. Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi được sản xuất từ nguồn Yến sào thiên nhiên Khánh Hòa kết hợp với Glucosamine, Chamomile và Ginkgo Biloba.\r\n', '/assets/image/product/sanviest/5_af4d4860cdc14da4b99ea6df1761b00c.webp', 604000, 50, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(30, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi hộp 20 túi 20ml - TC502H20', 'THÔNG TIN NỔI BẬT: Tinh chất Yến sào Khánh Hòa Sanvinest từ tổ yến sào nguyên chất được chế biến theo bí quyết cổ truyền kết hợp với công nghệ hiện đại, hỗ trợ hấp thu dưỡng chất nhanh chóng và dễ dàng.Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi giúp bồi bổ sức khỏe, tăng cường sức đề kháng, tăng cường hệ miễn dịch tự nhiên, tăng cường tuần hoàn máu não, giúp ngủ ngon, giảm mệt mỏi lo âu và hỗ trợ hệ xương khớp. \r\n', '/assets/image/product/sanviest/6_2eab4c94d1a046edb89711e94a015ad7.webp', 754000, 50, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(31, 'Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml, Hộp 6 Lọ - 700H6', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Fucoidan Nhân sâm Khánh Hòa Sanest là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Yến sào là nguồn tài nguyên thiên nhiên quý hiếm, từng dùng trong các buổi Yến tiệc thời phong kiến. Thưởng thức Nước Yến sào Fucoidan Nhân sâm Khánh Hòa Sanest là đã thưởng thức một trong những tinh hoa của trời đất, tạo vật.', '/assets/image/product/sanest/sanest_hop6lo_700_d5d0df7e74c34ad3ae33205677052db9.jpg', 280800, 100, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(32, 'Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml, lọ(New) - 700', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Fucoidan Nhân sâm Khánh Hòa Sanest là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Yến sào là nguồn tài nguyên thiên nhiên quý hiếm, từng dùng trong các buổi Yến tiệc thời phong kiến. Thưởng thức Nước Yến sào Fucoidan Nhân sâm Khánh Hòa Sanest là đã thưởng thức một trong những tinh hoa của trời đất, tạo vật.\r\n', '/assets/image/product/sanest/sanest_lo700.jpg', 44200, 200, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(33, 'Nước Yến Sào Khánh Hòa Sanest Collagen 70ml 1 lọ - 770', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Collagen là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Yến sào nguồn tài nguyên thiên nhiên quý hiếm, từng dùng trong các buổi Yến tiệc thời phong kiến. Thưởng thức Nước Yến sào Khánh Hòa Collagen là đã thưởng thức một trong những tinh hoa của trời đất, tạo vật.\r\n', '/assets/image/product/sanest/sanest_lo770.jpg', 35400, 150, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(34, 'Nước Yến Sào Khánh Hòa Sanest Collagen 70ml hộp 6 lọ - 770H6', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Collagen là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Yến sào nguồn tài nguyên thiên nhiên quý hiếm, từng dùng trong các buổi Yến tiệc thời phong kiến. Thưởng thức Nước Yến sào Khánh Hòa Collagen là đã thưởng thức một trong những tinh hoa của trời đất, tạo vật.\r\n', '/assets/image/product/sanest/sanest_770hop6lo.jpg', 218000, 100, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(35, 'Nước yến sào Khánh Hòa Sanest dành cho trẻ em đóng lon 190 ml, hộp 6 lon - 0162H6', 'THÔNG TIN NỔI BẬT: Thành phần sản phẩm: Nước, Yến sào 1,6%, đường tinh luyện, Taurine, 2’-fucosyllactose (2’-FL), chất ổn định (406, 327, 415, 401, 466), hương liệu tổng hợp dùng cho thực phẩm.Yến sào giúp tăng cường sức đề kháng cho cơ thể [1], kích thích tiêu hóa [2] , tăng cường trí nhớ [3,4] và bổ sung một số khoáng chất cần thiết cho cơ thể như canxi, sắt, kẽm ...[5].Taurine: Hỗ trợ cho sự tăng trưởng, phát triển thị giác, trí não [6,7]\r\n', '/assets/image/product/sanest/a_fca85d54924b477b9977ab92f02b8d08.webp', 53100, 120, '2024-08-25 13:32:09', '2024-08-25 20:54:26'),
(36, 'Nước yến sào Sanest đông trùng hạ thảo 70ml, hộp 6 lọ - 005H6', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest Đông Trùng Hạ Thảo được sản xuất từ nguồn Yến sào thiên nhiên do Công ty Yến sào Khánh Hòa trực tiếp khai thác tại các đảo Yến Khánh Hòa kết hợp với Đông Trùng Hạ Thảo, đem đến cho người tiêu dùng sản phẩm bổ dưỡng cao cấp.Nước Yến sào Khánh Hòa Sanest Đông Trùng Hạ Thảo là sự hòa quyện tuyệt vời của Yến sào mang hương vị của biển và Đông Trùng Hạ Thảo đậm đà thơm ngon, ngọt thanh, hấp dẫn.\r\n', '/assets/image/product/sanest/005h6_832cc1018d3846d4a219f0077c04ff11.webp', 263200, 100, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(37, 'Nước yến sào Khánh Hòa Sanest kid lon 190ML, khay 30 lon - 0162K30', 'THÔNG TIN NỔI BẬT: Thành phần sản phẩm: Nước, Yến sào 1,6%, đường tinh luyện, Taurine, 2’-fucosyllactose (2’-FL), chất ổn định (406, 327, 415, 401, 466), hương liệu tổng hợp dùng cho thực phẩm.Yến sào giúp tăng cường sức đề kháng cho cơ thể [1], kích thích tiêu hóa [2] , tăng cường trí nhớ [3,4] và bổ sung một số khoáng chất cần thiết cho cơ thể như canxi, sắt, kẽm ...[5].Hỗ trợ cho sự tăng trưởng, phát triển thị giác, trí não [6,7]\r\n', '/assets/image/product/sanest/12_3b4c3aff6fdf4b27b91ffff28b021376.webp', 257300, 80, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(38, 'Nước yến sào Khánh Hòa Sanest kid lon 190ML, thùng 30 lon - 0162T30', 'THÔNG TIN NỔI BẬT: Thành phần sản phẩm: Nước, Yến sào 1,6%, đường tinh luyện, Taurine, 2’-fucosyllactose (2’-FL), chất ổn định (406, 327, 415, 401, 466), hương liệu tổng hợp dùng cho thực phẩm.Yến sào giúp tăng cường sức đề kháng cho cơ thể [1], kích thích tiêu hóa [2] , tăng cường trí nhớ [3,4] và bổ sung một số khoáng chất cần thiết cho cơ thể như canxi, sắt, kẽm ...[5].Hỗ trợ cho sự tăng trưởng, phát triển thị giác, trí não [6,7]\r\n', '/assets/image/product/sanest/thung_30_-_0162_-_24-8-2020_5dbb0e1af4794d57acc4940ef4bddfb7_large_51745978569c4a68afb1fb08b5f4a5d3.webp', 259200, 70, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(39, 'Nước Yến Sào Khánh Hòa Sanest không đường dành cho người cao tuổi 70ml - Hộp 6 Lọ - 096H6', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest không đường dành cho người cao tuổi là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Yến sào nguồn tài nguyên thiên nhiên quý hiếm, từng dùng trong các buổi Yến tiệc thời phong kiến. Thưởng thức Nước Yến sào Khánh Hòa Sanest không đường dành cho người cao tuổi là đã thưởng thức một trong những tinh hoa của trời đất, tạo vật.\r\n', '/assets/image/product/sanest/caotuoikhongduong_e980982f3b734934b3bdfd77010a27f8.webp', 220000, 100, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(40, 'Nước Yến Sào Khánh Hòa Sanest dành cho người cao tuổi 70ml - Hộp 6 Lọ - 095H6', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest dành cho người cao tuổi là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Yến sào nguồn tài nguyên thiên nhiên quý hiếm, từng dùng trong các buổi Yến tiệc thời phong kiến. Thưởng thức Nước Yến sào Khánh Hòa Sanest dành cho người cao tuổi là đã thưởng thức một trong những tinh hoa của trời đất, tạo vật.\r\n', '/assets/image/product/sanest/caotuoikhongduong_e980982f3b734934b3bdfd77010a27f8.webp', 218000, 120, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(41, 'Nước Yến sào Khánh Hòa Sanest không đường dành cho người cao tuổi 70 ml - Hộp 1 lọ 096', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest không đường dành cho người cao tuổi là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Yến sào nguồn tài nguyên thiên nhiên quý hiếm, từng dùng trong các buổi Yến tiệc thời phong kiến. Thưởng thức Nước Yến sào Khánh Hòa Sanest không đường dành cho người cao tuổi là đã thưởng thức một trong những tinh hoa của trời đất, tạo vật.\r\n', '/assets/image/product/sanest/096_1c8798c49a1c4bd7955ecbc0734aa0ad.webp', 35400, 150, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(42, 'Nước Yến sào Khánh Hòa Sanest dành cho người cao tuổi 70ml - Hộp 1 lọ 095', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest dành cho người cao tuổi là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Yến sào nguồn tài nguyên thiên nhiên quý hiếm, từng dùng trong các buổi Yến tiệc thời phong kiến. Thưởng thức Nước Yến sào Khánh Hòa Sanest dành cho người cao tuổi là đã thưởng thức một trong những tinh hoa của trời đất, tạo vật.\r\n', '/assets/image/product/sanest/095_09fc5d0d843944d7a16cac2692485d34.webp', 35400, 180, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(43, 'Nước Yến sào Sanvinest không đường lon 190ml, thùng 30 lon - 125T30', 'THÔNG TIN NỔI BẬT: Nước Yến sào Sanvinest Khánh Hòa không đường đóng lon là sản phẩm giải khát bổ dưỡng, thích hợp cho mọi độ tuổi.Nước Yến sào Sanvinest Khánh Hòa không đường được sản xuất từ nguồn Yến sào thiên nhiên do Công ty Yến sào Khánh Hòa trực tiếp khai thác.Nước Yến sào Sanvinest Khánh Hòa không đường được chế biến theo phương pháp cổ truyền kết hợp với khoa học công nghệ hiện đại trên dây chuyền thiết bị kỹ thuật tiên tiến của Châu Âu.\r\n', '/assets/image/product/sanest/122t30_6c42efa35e5e472295552b34da77d0b4_large_fccf3a6883444d65b8f3cf517fbf5abe.jpg', 259200, 150, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(44, 'Nước yến sào Khánh Hòa Sanest lon 190ML, hộp 12 lon - 001H12', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest (đóng lon) là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Những tính năng này đã được chứng minh qua nhiều đề tài nghiên cứu khoa học, trong đó có đề tài “Nghiên cứu chất hoạt tính sinh học trong tổ Yến Khánh Hòa” do PTS Ngô Thị Kim thuộc Viện Công nghệ sinh học - Trung tâm khoa học tự nhiên và công nghệ quốc gia làm chủ nhiệm đề tài.\r\n', '/assets/image/product/sanest/001h12_800_538_4c80337caf954dc7af4a45bb9cfa1d9e.webp', 106100, 150, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(45, 'Nước yến sào Khánh Hòa Sanest lon 190ml, khay 30 lon - 001K30', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest (đóng lon) là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Những tính năng này đã được chứng minh qua nhiều đề tài nghiên cứu khoa học, trong đó có đề tài “Nghiên cứu chất hoạt tính sinh học trong tổ Yến Khánh Hòa” do PTS Ngô Thị Kim thuộc Viện Công nghệ sinh học - Trung tâm khoa học tự nhiên và công nghệ quốc gia làm chủ nhiệm đề tài.\r\n', '/assets/image/product/sanest/001k30.webp', 257300, 150, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(46, 'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 2 HỘP 20 GÓI 5 GRAM - 031G', 'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest (đóng lon) là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên.Những tính năng này đã được chứng minh qua nhiều đề tài nghiên cứu khoa học, trong đó có đề tài “Nghiên cứu chất hoạt tính sinh học trong tổ Yến Khánh Hòa” do PTS Ngô Thị Kim thuộc Viện Công nghệ sinh học - Trung tâm khoa học tự nhiên và công nghệ quốc gia làm chủ nhiệm đề tài.\r\n', '/assets/image/product/yensaonguyento/z3955337968029_9af6618a530ffe63f805b9cc1efcb158_858ceaf95ca24c6aabfa774bb1c68873.webp', 1512000, 200, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(47, 'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 20 GÓI 5 GRAM - 028', 'THÔNG TIN NỔI BẬT: Yến sào là sản vật thiên nhiên quý giá của xứ sở rừng trầm biển yến Khánh Hòa với quần thể đàn chim yến hàng Acrodramus Fuciphagus Germani lớn nhất thế giới hiện nay. Yến sào chứa protein và các axit amin không thay thế với hàm lượng cao, rất cần thiết cho phát triển cơ thể và phục hồi sức khỏe con người; Yến sào thúc đẩy cơ thể hấp thụ mạnh các dưỡng chất, tăng cường miễn dịch, chống lão hóa; Các khoáng chất: canxi, magiê, sắt… trong tổ yến rất có lợi cho thần kinh, trí nhớ, hệ tiêu hóa.\r\n', '/assets/image/product/yensaonguyento/z3955337939918_bd2220b255837b6cde7fa2db4593a165_3e70a906e7ba46829547df28efd6a184.webp', 702000, 300, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(48, 'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 30 GÓI 5 GRAM - 029G', 'THÔNG TIN NỔI BẬT: Yến sào là sản vật thiên nhiên quý giá của xứ sở rừng trầm biển yến Khánh Hòa với quần thể đàn chim yến hàng Acrodramus Fuciphagus Germani lớn nhất thế giới hiện nay. Yến sào chứa protein và các axit amin không thay thế với hàm lượng cao, rất cần thiết cho phát triển cơ thể và phục hồi sức khỏe con người; Yến sào thúc đẩy cơ thể hấp thụ mạnh các dưỡng chất, tăng cường miễn dịch, chống lão hóa; Các khoáng chất: canxi, magiê, sắt… trong tổ yến rất có lợi cho thần kinh, trí nhớ, hệ tiêu hóa\r\n', '/assets/image/product/yensaonguyento/z3955337934951_9f822651ca86197d6389648ea6675180_d6e16733552440dfb769ceee93c911ad.webp', 1026000, 150, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(49, 'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 5 GÓI 5 GRAM - 027', 'THÔNG TIN NỔI BẬT: Yến sào là sản vật thiên nhiên quý giá của xứ sở rừng trầm biển yến Khánh Hòa với quần thể đàn chim yến hàng Acrodramus Fuciphagus Germani lớn nhất thế giới hiện nay. Yến sào chứa protein và các axit amin không thay thế với hàm lượng cao, rất cần thiết cho phát triển cơ thể và phục hồi sức khỏe con người; Yến sào thúc đẩy cơ thể hấp thụ mạnh các dưỡng chất, tăng cường miễn dịch, chống lão hóa; Các khoáng chất: canxi, magiê, sắt… trong tổ yến rất có lợi cho thần kinh, trí nhớ, hệ tiêu hóa,…\r\n', '/assets/image/product/yensaonguyento/027_46377142da3b4f4b9d60189e2e338950.webp', 162000, 400, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(50, 'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 6 HỘP 5 GÓI 5 GRAM - 030G', 'THÔNG TIN NỔI BẬT: Yến sào là sản vật thiên nhiên quý giá của xứ sở rừng trầm biển yến Khánh Hòa với quần thể đàn chim yến hàng Acrodramus Fuciphagus Germani lớn nhất thế giới hiện nay. Yến sào chứa protein và các axit amin không thay thế với hàm lượng cao, rất cần thiết cho phát triển cơ thể và phục hồi sức khỏe con người; Yến sào thúc đẩy cơ thể hấp thụ mạnh các dưỡng chất, tăng cường miễn dịch, chống lão hóa; Các khoáng chất: canxi, magiê, sắt… trong tổ yến rất có lợi cho thần kinh, trí nhớ, hệ tiêu hóa,…\r\n', '/assets/image/product/yensaonguyento/z3955337968029_9af6618a530ffe63f805b9cc1efcb158_858ceaf95ca24c6aabfa774bb1c68873.webp', 1080000, 150, '2024-08-25 13:32:09', '2024-08-25 20:57:13'),
(51, 'Hạt điều lạt hộp 1KG', 'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện.Hướng dẫn sử dụng: Ăn liền. Đậy kín bao bì sau khi sử dụng.Để nơi khô ráo thoáng mát.\r\n', '/assets/image/product/thucpham/hl1k.jpg', 395700, 100, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(52, 'Hạt điều chiên Sanest Foods (muối) hộp 1KG', 'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện.Hướng dẫn sử dụng: Ăn liền. Đậy kín bao bì sau khi sử dụng.Để nơi khô ráo thoáng mát.\r\n', '/assets/image/product/thucpham/hop_dieu_muoi_1000g.jpg', 392800, 150, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(53, 'Hạt điều chiên Sanest Foods (muối) hộp 454G - MH454', 'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện.Hướng dẫn sử dụng: Ăn liền. Đậy kín bao bì sau khi sử dụng.Để nơi khô ráo thoáng mát.\r\n', '/assets/image/product/thucpham/hop_dieu_muoi_454g.jpg', 184600, 200, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(54, 'Hạt điều muối lụa hộp 400G - LM400', 'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện.Hướng dẫn sử dụng: Ăn liền. Đậy kín bao bì sau khi sử dụng.Để nơi khô ráo thoáng mát.\r\n', '/assets/image/product/thucpham/1_52144ef2d79b4fffa2a5d06e8b90d833.jpg', 159100, 150, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(55, 'Nhân điều muối hộp 300G - MH300', 'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện.Hướng dẫn sử dụng: Ăn liền. Đậy kín bao bì sau khi sử dụng.Để nơi khô ráo thoáng mát.\r\n', '/assets/image/product/thucpham/hop_dieu_muoi_300g_mat_dung.webp', 119800, 100, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(56, 'Hạt điều chiên muối Sanest Foods hộp 100G - MH100', 'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện.Hướng dẫn sử dụng: Ăn liền. Đậy kín bao bì sau khi sử dụng.Để nơi khô ráo thoáng mát.\r\n', '/assets/image/product/thucpham/hop_dieu_muoi_100g_1.webp', 51100, 200, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(57, 'Hạt điều chiên muối Sanest Foods túi 100G - MT100', 'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện.Hướng dẫn sử dụng: Ăn liền. Đậy kín bao bì sau khi sử dụng.Để nơi khô ráo thoáng mát.\r\n', '/assets/image/product/thucpham/dieu_muoi_100g.webp', 47200, 180, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(58, 'Hạt điều chiên muối Sanest Foods túi 50G - MT50', 'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện.Hướng dẫn sử dụng: Ăn liền. Đậy kín bao bì sau khi sử dụng.Để nơi khô ráo thoáng mát.\r\n', '/assets/image/product/thucpham/dieu_muoi_50g.webp', 26600, 250, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(59, 'Bánh yến sào đường ăn kiêng hộp 12 cái - H12K', 'THÔNG TIN NỔI BẬT: Thành phần: Bột mì, Yến sào (2%), Chocolate, Đạm Whey, Chất xơ, Bột năng, Bột bắp, Dầu thực vật tinh luyện, Shortening, Dextrose, Bơ đậu phộng, Chất nhũ hóa Lecithin (322), Chất bảo quản Natri benzoat (211), Chất chống oxy hóa Acid citric (330), Enzym Protease (1101i).\r\n', '/assets/image/product/thucpham/z3979830090602_8046aa557673e17f4f59258894a3aaf0_2955ab05371740aa93923b150fb29871.webp', 90000, 150, '2024-08-25 13:32:09', '2024-08-25 20:58:27'),
(60, 'Bánh Yến sào Sanest Cake hộp 20 cái - H20', 'THÔNG TIN NỔI BẬT: Thành phần: Bột mì, Yến sào (2%), Chocolate, Đạm Whey, Chất xơ, Bột năng, Bột bắp, Dầu thực vật tinh luyện, Shortening, Dextrose, Bơ đậu phộng, Chất nhũ hóa Lecithin (322), Chất bảo quản Natri benzoat (211), Chất chống oxy hóa Acid citric (330), Enzym Protease (1101i).\r\n', '/assets/image/product/thucpham//z3979830080738_aecad8ceca3494d7ea7fab5d612de71d_fb6c3306867449c7978d3035861b7581.webp', 132600, 150, '2024-08-25 13:32:09', '2024-08-25 20:58:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham_loai`
--

CREATE TABLE `san_pham_loai` (
  `san_pham_id` int(11) NOT NULL,
  `loai_san_pham_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham_loai`
--

INSERT INTO `san_pham_loai` (`san_pham_id`, `loai_san_pham_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(45, 3),
(46, 4),
(47, 4),
(48, 4),
(49, 4),
(50, 4),
(51, 5),
(52, 5),
(53, 5),
(54, 5),
(55, 5),
(56, 5),
(57, 5),
(58, 5),
(59, 5),
(60, 5);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `don_hang_id` (`don_hang_id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Chỉ mục cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`);

--
-- Chỉ mục cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Chỉ mục cho bảng `loai_san_pham`
--
ALTER TABLE `loai_san_pham`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `phan_hoi`
--
ALTER TABLE `phan_hoi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoi_dung_id` (`nguoi_dung_id`),
  ADD KEY `san_pham_id` (`san_pham_id`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `san_pham_loai`
--
ALTER TABLE `san_pham_loai`
  ADD PRIMARY KEY (`san_pham_id`,`loai_san_pham_id`),
  ADD KEY `loai_san_pham_id` (`loai_san_pham_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `loai_san_pham`
--
ALTER TABLE `loai_san_pham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `phan_hoi`
--
ALTER TABLE `phan_hoi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chi_tiet_don_hang`
--
ALTER TABLE `chi_tiet_don_hang`
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_1` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hang` (`id`),
  ADD CONSTRAINT `chi_tiet_don_hang_ibfk_2` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`);

--
-- Các ràng buộc cho bảng `don_hang`
--
ALTER TABLE `don_hang`
  ADD CONSTRAINT `don_hang_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`);

--
-- Các ràng buộc cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `gio_hang_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `gio_hang_ibfk_2` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`);

--
-- Các ràng buộc cho bảng `phan_hoi`
--
ALTER TABLE `phan_hoi`
  ADD CONSTRAINT `phan_hoi_ibfk_1` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `phan_hoi_ibfk_2` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`);

--
-- Các ràng buộc cho bảng `san_pham_loai`
--
ALTER TABLE `san_pham_loai`
  ADD CONSTRAINT `san_pham_loai_ibfk_1` FOREIGN KEY (`san_pham_id`) REFERENCES `san_pham` (`id`),
  ADD CONSTRAINT `san_pham_loai_ibfk_2` FOREIGN KEY (`loai_san_pham_id`) REFERENCES `loai_san_pham` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
