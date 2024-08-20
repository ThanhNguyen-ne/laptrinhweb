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
VALUES (
    'Yến Tinh Chế',
    'Yến đã được làm sạch và tinh chế.'
  ),
  ('Yến Thô', 'Yến nguyên chất chưa qua xử lý.'),
  (
    'Yến Nấu Sẵn',
    'Yến đã được nấu chín, sẵn sàng để sử dụng.'
  );
-- Chèn dữ liệu vào bảng san_pham
INSERT INTO san_pham (ten_san_pham, mo_ta, gia, so_luong_ton)
VALUES (
    'Yến Tinh Chế Loại 1',
    'Yến đã được làm sạch loại 1.',
    2000000,
    50
  ),
  (
    'Yến Thô Loại 2',
    'Yến nguyên chất loại 2.',
    1500000,
    30
  ),
  (
    'Yến Nấu Sẵn Vị Đường Phèn',
    'Yến đã nấu chín với đường phèn.',
    500000,
    100
  );
-- Liên kết sản phẩm với loại sản phẩm
INSERT INTO san_pham_loai (san_pham_id, loai_san_pham_id)
VALUES (1, 1),
  (2, 2),
  (3, 3);
-- Chèn dữ liệu vào bảng nguoi_dung
INSERT INTO nguoi_dung (
    ho_ten,
    email,
    mat_khau,
    so_dien_thoai,
    dia_chi,
    vai_tro
  )
VALUES (
    'Nguyen Van A',
    'nguyenvana@example.com',
    'password123',
    '0909123456',
    '123 Đường ABC, Quận 1, TP.HCM',
    'khach_hang'
  ),
  (
    'Tran Thi B',
    'tranthib@example.com',
    'password123',
    '0909876543',
    '456 Đường DEF, Quận 2, TP.HCM',
    'khach_hang'
  ),
  (
    'Admin',
    'admin@example.com',
    'adminpassword',
    '0909123456',
    '789 Đường XYZ, Quận 3, TP.HCM',
    'admin'
  );
-- Chèn dữ liệu vào bảng phan_hoi
INSERT INTO phan_hoi (nguoi_dung_id, san_pham_id, noi_dung, danh_gia)
VALUES (1, 1, 'Sản phẩm rất tốt, tôi rất hài lòng.', 5),
  (2, 2, 'Yến thô chưa sạch lắm, cần cải thiện.', 3);
-- Chèn dữ liệu vào bảng don_hang
INSERT INTO don_hang (nguoi_dung_id, tong_tien, trang_thai)
VALUES (1, 2000000, 'hoan_thanh'),
  (2, 3000000, 'cho_xu_ly');
-- Chèn dữ liệu vào bảng chi_tiet_don_hang
INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia_ban)
VALUES (1, 1, 1, 2000000),
  (2, 2, 2, 1500000);