-- Tạo cơ sở dữ liệu
CREATE DATABASE IF NOT EXISTS cua_hang_yen_sao;
USE cua_hang_yen_sao;

-- Tạo bảng loai_san_pham
CREATE TABLE loai_san_pham (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ten_loai VARCHAR(255) NOT NULL,
  mo_ta TEXT
);

-- Tạo bảng san_pham
CREATE TABLE san_pham (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ten_san_pham VARCHAR(255) NOT NULL,
  mo_ta TEXT,
  hinh_anh VARCHAR(255),
  gia DECIMAL(10, 2) NOT NULL,
  so_luong_ton INT NOT NULL,
  ngay_tao DATETIME DEFAULT CURRENT_TIMESTAMP,
  ngay_cap_nhat DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tạo bảng nguoi_dung
CREATE TABLE nguoi_dung (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ho_ten VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  mat_khau VARCHAR(255) NOT NULL,
  so_dien_thoai VARCHAR(20),
  dia_chi TEXT,
  vai_tro ENUM('admin', 'khach_hang') DEFAULT 'khach_hang',
  ngay_dang_ky DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng phan_hoi
CREATE TABLE phan_hoi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nguoi_dung_id INT,
  san_pham_id INT,
  noi_dung TEXT,
  danh_gia INT CHECK (
    danh_gia BETWEEN 1 AND 5
  ),
  ngay_gui DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id),
  FOREIGN KEY (san_pham_id) REFERENCES san_pham(id)
);

-- Tạo bảng don_hang
CREATE TABLE don_hang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nguoi_dung_id INT,
  tong_tien DECIMAL(10, 2),
  ngay_dat DATETIME DEFAULT CURRENT_TIMESTAMP,
  trang_thai ENUM(
    'cho_xu_ly',
    'dang_xu_ly',
    'hoan_thanh',
    'da_huy'
  ) DEFAULT 'cho_xu_ly',
  FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id)
);

-- Tạo bảng chi_tiet_don_hang
CREATE TABLE chi_tiet_don_hang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  don_hang_id INT,
  san_pham_id INT,
  so_luong INT NOT NULL,
  gia_ban DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (don_hang_id) REFERENCES don_hang(id),
  FOREIGN KEY (san_pham_id) REFERENCES san_pham(id)
);

-- Tạo bảng san_pham_loai
CREATE TABLE san_pham_loai (
  san_pham_id INT,
  loai_san_pham_id INT,
  PRIMARY KEY (san_pham_id, loai_san_pham_id),
  FOREIGN KEY (san_pham_id) REFERENCES san_pham(id),
  FOREIGN KEY (loai_san_pham_id) REFERENCES loai_san_pham(id)
);

-- Chèn dữ liệu vào bảng loai_san_pham
INSERT INTO loai_san_pham (ten_loai, mo_ta)
VALUES 
('Yến sào đảo yến thiên nhiên', 'Sản phẩm yến từ đảo yến thiên nhiên Khánh Hòa.'),
('Yến sào Sanvinest', 'Sản phẩm yến của thương hiệu Sanvinest Khánh Hòa.');

-- Chèn dữ liệu vào bảng san_pham
INSERT INTO san_pham (id, ten_san_pham, mo_ta, hinh_anh, gia, so_luong_ton)
VALUES 
(1, 'Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024', 
    'Yến huyết đảo yến thiên nhiên nguyên tổ là tổ yến có màu đỏ tự nhiên...', 
    '/assets/image/product/yensaonguyento/yskh_024.jpg', 37800000, 50),
(2, 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026', 
    'Sản phẩm Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100g...', 
    '/assets/image/product/yensaonguyento/yskh_026.jpg', 23760000, 30),
(3, 'Yến huyết đảo thiên nhiên Khánh Hòa mẫu hộp quà tặng - 024S', 
    'Yến huyết đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng...', 
    '/assets/image/product/yensaonguyento/_024s.jpg', 19170000, 100),
(4, 'Yến sao đảo yến thiên nhiên Khánh Hòa hộp 100G -TP1', 
    'Yến sào đảo yến thiên nhiên Khánh Hòa (nguyên tổ) hộp TP1-100g...', 
    '/assets/image/product/yensaonguyento/tp1_9547ae75719143bea6c155e98e1fc816.jpg', 13500000, 50),
(5, 'Yến hồng đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng - 026S', 
    'Yến sào đảo yến thiên nhiên Khánh Hòa nguyên tổ hồng...', 
    '/assets/image/product/yensaonguyento/yskh_026s.webp', 12150000, 50),
(6, 'Yến sào đảo thiên nhiên tinh chế hộp 100G - 014', 
    'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 100g...', 
    '/assets/image/product/yensaonguyento/014_b790244e32e145c8a21efdee64b8d456.webp', 7128000, 50),
(7, 'Yến sào đảo thiên nhiên tinh chế hộp 3G - 011', 
    'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 3g...', 
    '/assets/image/product/yensaonguyento/011_ebce11cb07a744fa8d61dbe83c2f130c.webp', 232200, 50),
(8, 'Yến sào đảo thiên nhiên tinh chế hộp 50G - 015', 
    'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 50g...', 
    '/assets/image/product/yensaonguyento/014_b790244e32e145c8a21efdee64b8d456.webp', 3564000, 50),
(9, 'Yến sào đảo thiên nhiên tinh chế hộp 5G - 012', 
    'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế làm sạch hộp 5g...', 
    '/assets/image/product/yensaonguyento/011_ebce11cb07a744fa8d61dbe83c2f130c.webp', 378000, 50),
(10, 'Yến sào đảo thiên nhiên tinh chế hộp quà tặng 2 hộp 3G - 011G2', 
    'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp quà tặng(2 hộp x 3g)...', 
    '/assets/image/product/yensaonguyento/yskh_012g2_op_97485178226440bba20791aeecf4a837.webp', 507600, 50),
(11, 'Yến sào đảo thiên nhiên tinh chế hộp quà tặng 2 hộp 5G - 012G2', 
    'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp quà tặng (2 hộp x 5g)...', 
    '/assets/image/product/yensaonguyento/yskh_012g2_op_97485178226440bba20791aeecf4a837.webp', 799200, 50),
(12, 'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 100G - 014G', 
    'Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng với trọng lượng yến 100g...', 
    '/assets/image/product/yensaonguyento/yskh_014g.webp', 7516800, 50),
(13, 'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 100G - 014GS', 
    'Sản phẩm yến sào nguyên chất từ đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 100g...', 
    '/assets/image/product/yensaonguyento/yskh_014g.webp', 7916400, 50),
(14, 'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 3G - 011G', 
    'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 3g...', 
    '/assets/image/product/yensaonguyento/yskh_011g_op.webp', 1220400, 50),
(15, 'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 50G - 015G', 
    'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 50g...', 
    '/assets/image/product/yensaonguyento/yskh_014g.webp', 3931200, 50),
(16, 'Hộp quà tặng Yến sào Nguyên tổ 50g Sanvinest Khánh Hòa Chính hiệu - Q150', 
    'Yến sào Sanvinest Khánh Hòa - Hộp quà tặng 50g...', 
    '/assets/image/product/yensaonguyento/q150_42b932ad40724f34a9230042878f5122.jpg', 2308500, 50),
(17, 'Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 100g - Q610', 
    'Yến sào Sanvinest Khánh Hòa - Hộp quà tặng 100g...', 
    '/assets/image/product/sanviest/q160_7e71defed4054c8da70240dada86b807.jpg', 6796900, 50),
(18, 'Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 50g - Q650', 
    'Yến sào từ lâu đã được biết đến là nguồn thực phẩm bổ dưỡng diệu kỳ...', 
    '/assets/image/product/sanviest/q650_fefa4292fffd46a5988f035460f1f458.jpg', 3103650, 50),
(19, 'Nước yến sào Khánh Hòa Sanvinest trẻ em lọ 62ml, hộp 1 lọ - 2011', 
    'Nước Yến sào Sanvinest Khánh Hòa dành cho trẻ em...', 
    '/assets/image/product/sanviest/2011_c5841feb5c404b46ba9976eb7b039439.jpg', 34400, 50),
(20, 'Nước yến sào Khánh Hòa Sanvinest Đông Trùng Hạ Thảo lọ 70ml - 208', 
    'Nước Yến sào Khánh Hòa Sanvinest Đông trùng hạ thảo...', 
    '/assets/image/product/sanviest/untitled_0e6fde7e18f14b2b8254a91fc6a4645e.webp', 42300, 50),
(21, 'Nước yến sào Khánh Hòa Sanvinest Đông Trùng Hạ Thảo lọ 70ml hộp 6 lọ - 208H6', 
    'Nước Yến sào Khánh Hòa Sanvinest Đông trùng hạ thảo - Hộp 6 lọ...', 
    '/assets/image/product/sanviest/untitled_f80e0c02aa534b6cb7f02f43c1bdbd21.webp', 263200, 50),
(22, 'Nước yến sào Khánh Hòa Sanvinest không đường lọ 70ml, hộp 6 lọ - 102H6', 
    'Nước Yến sào Sanvinest Khánh Hòa không đường - Hộp 6 lọ...', 
    '/assets/image/product/sanviest/hop_6_lo_102_fd7dbb1807c0459288946f908705f6b9.webp', 220000, 50),
(23, 'Nước yến sào Khánh Hòa Sanvinest lọ 70ml, hộp 1 lọ - 101', 
    'Nước Yến sào Sanvinest Khánh Hòa lọ 70ml...', 
    '/assets/image/product/sanviest/101_678512918f8343ff96395b3e653a0bfe.webp', 35400, 50),
(24, 'Nước yến sào Khánh Hòa Sanvinest lon 190ML - 121', 
    'Nước Yến sào Sanvinest Khánh Hòa - Lon 190ml...', 
    '/assets/image/product/sanviest/121_f2553d9e10d745c2b0dba5f324cc7213.webp', 8900, 50),
(25, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp 10 túi 20ml - TC503H10', 
    'Tinh chất Yến sào Khánh Hòa Sanvinest - Hộp 10 túi...', 
    '/assets/image/product/sanviest/10_66b27067e1674475ae4d6035b5c15274.webp', 380000, 50),
(26, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp 20 túi 20ml - TC503H20', 
    'Tinh chất Yến sào Khánh Hòa Sanvinest - Hộp 20 túi...', 
    '/assets/image/product/sanviest/10_66b27067e1674475ae4d6035b5c15274.webp', 754000, 50),
(27, 'Nước Yến sào Sanvinest không đường lon 190ml, hay 30 lon - 125K30', 
    'Nước Yến sào Sanvinest không đường - Lon 190ml, Hộp 30 lon...', 
    '/assets/image/product/sanviest/9_35b9d820ac674d38b3a3b83a96bb2ba8.webp', 604000, 50),
(28, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp quà tặng 20 túi 20ml - QTC503H20', 
    'Tinh chất Yến sào Khánh Hòa Sanvinest - Hộp quà tặng 20 túi...', 
    '/assets/image/product/sanviest/9_35b9d820ac674d38b3a3b83a96bb2ba8.webp', 792000, 50),
(29, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi Hộp quà tặng 15 túi 20ml - QTC502H15', 
    'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi - Hộp quà tặng 15 túi...', 
    '/assets/image/product/sanviest/5_af4d4860cdc14da4b99ea6df1761b00c.webp', 604000, 50),
(30, 'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi hộp 20 túi 20ml - TC502H20', 
    'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi - Hộp 20 túi...', 
    '/assets/image/product/sanviest/6_2eab4c94d1a046edb89711e94a015ad7.webp', 754000, 50);

-- Liên kết sản phẩm với loại sản phẩm
INSERT INTO san_pham_loai (san_pham_id, loai_san_pham_id)
VALUES 
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), 
(6, 1), (7, 1), (8, 1), (9, 1), (10, 1), 
(11, 1), (12, 1), (13, 1), (14, 1), (15, 1),
(16, 2), (17, 2), (18, 2), (19, 2), (20, 2), 
(21, 2), (22, 2), (23, 2), (24, 2), (25, 2),
(26, 2), (27, 2), (28, 2), (29, 2), (30, 2);

-- Chèn dữ liệu vào bảng nguoi_dung
INSERT INTO nguoi_dung (ho_ten, email, mat_khau, so_dien_thoai, dia_chi, vai_tro)
VALUES 
('Nguyen Van A', 'nguyenvana@example.com', 'password123', '0909123456', '123 Đường ABC, Quận 1, TP.HCM', 'khach_hang'),
('Tran Thi B', 'tranthib@example.com', 'password123', '0909876543', '456 Đường DEF, Quận 2, TP.HCM', 'khach_hang'),
('Admin', 'admin@example.com', 'adminpassword', '0909123456', '789 Đường XYZ, Quận 3, TP.HCM', 'admin');

-- Chèn dữ liệu vào bảng phan_hoi
INSERT INTO phan_hoi (nguoi_dung_id, san_pham_id, noi_dung, danh_gia)
VALUES 
(1, 1, 'Sản phẩm rất tốt, tôi rất hài lòng.', 5),
(2, 2, 'Yến thô chưa sạch lắm, cần cải thiện.', 3);

-- Chèn dữ liệu vào bảng don_hang
INSERT INTO don_hang (nguoi_dung_id, tong_tien, trang_thai)
VALUES 
(1, 37800000, 'hoan_thanh'),
(2, 23760000, 'cho_xu_ly');

-- Chèn dữ liệu vào bảng chi_tiet_don_hang
INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia_ban)
VALUES 
(1, 1, 1, 37800000),
(2, 2, 1, 23760000);
