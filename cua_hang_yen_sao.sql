-- Tạo cơ sở dữ liệu
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
    gia FLOAT NOT NULL,
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
    danh_gia INT CHECK (danh_gia BETWEEN 1 AND 5),
    ngay_gui DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(id) ON DELETE CASCADE
);

-- Tạo bảng don_hang
CREATE TABLE don_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id INT,
    tong_tien INT,
    ngay_dat DATETIME DEFAULT CURRENT_TIMESTAMP,
    trang_thai ENUM('cho_xu_ly', 'dang_xu_ly', 'hoan_thanh', 'da_huy') DEFAULT 'cho_xu_ly',
    ly_do_huy TEXT,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE
);

-- Tạo bảng chi_tiet_don_hang
CREATE TABLE chi_tiet_don_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    don_hang_id INT,
    san_pham_id INT,
    so_luong INT NOT NULL,
    gia_ban INT NOT NULL,
    FOREIGN KEY (don_hang_id) REFERENCES don_hang(id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(id) ON DELETE CASCADE
);

-- Tạo bảng san_pham_loai
CREATE TABLE san_pham_loai (
    san_pham_id INT,
    loai_san_pham_id INT,
    PRIMARY KEY (san_pham_id, loai_san_pham_id),
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(id) ON DELETE CASCADE,
    FOREIGN KEY (loai_san_pham_id) REFERENCES loai_san_pham(id) ON DELETE CASCADE
);

-- Tạo bảng gio_hang
CREATE TABLE gio_hang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nguoi_dung_id INT NOT NULL,
    san_pham_id INT NOT NULL,
    so_luong INT NOT NULL DEFAULT 1,
    FOREIGN KEY (nguoi_dung_id) REFERENCES nguoi_dung(id) ON DELETE CASCADE,
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Chèn dữ liệu vào bảng loai_san_pham
INSERT INTO loai_san_pham (ten_loai, mo_ta)
VALUES (
        'Yến sào đảo yến thiên nhiên',
        'Sản phẩm yến từ đảo yến thiên nhiên Khánh Hòa.'
    ),
    (
        'Yến sào Sanvinest',
        'Sản phẩm yến của thương hiệu Sanvinest Khánh Hòa.'
    ),
    (
        'Yến sào Sanest',
        'Sản phẩm yến của thương hiệu Sanest Khánh Hòa.'
    ),
    (
        'Tinh chất yến sào',
        'Các sản phẩm tinh chất yến sào thiên nhiên Khánh Hòa.'
    ),
    (
        'Thực phẩm Sanest Food',
        'Các sản phẩm thực phẩm chế biến từ yến sào và hạt điều.'
    ),
    (
        'Khác',
        'Khác.'
    );
-- Chèn dữ liệu vào bảng san_pham
INSERT INTO san_pham (
        id,
        ten_san_pham,
        mo_ta,
        hinh_anh,
        gia,
        so_luong_ton
    )
VALUES (
        1,
        'Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024',
        'Yến huyết đảo yến thiên nhiên nguyên tổ là tổ yến có màu đỏ tự nhiên...',
        '/assets/image/product/yensaonguyento/yskh_024.jpg',
        37800000,
        50
    ),
    (
        2,
        'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        'Sản phẩm Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100g...',
        '/assets/image/product/yensaonguyento/yskh_026.jpg',
        23760000,
        30
    ),
    (
        3,
        'Yến huyết đảo thiên nhiên Khánh Hòa mẫu hộp quà tặng - 024S',
        'Yến huyết đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng...',
        '/assets/image/product/yensaonguyento/_024s.jpg',
        19170000,
        100
    ),
    (
        4,
        'Yến sao đảo yến thiên nhiên Khánh Hòa hộp 100G -TP1',
        'Yến sào đảo yến thiên nhiên Khánh Hòa (nguyên tổ) hộp TP1-100g...',
        '/assets/image/product/yensaonguyento/tp1_9547ae75719143bea6c155e98e1fc816.jpg',
        13500000,
        50
    ),
    (
        5,
        'Yến hồng đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng - 026S',
        'Yến sào đảo yến thiên nhiên Khánh Hòa nguyên tổ hồng...',
        '/assets/image/product/yensaonguyento/yskh_026s.webp',
        12150000,
        50
    ),
    (
        6,
        'Yến sào đảo thiên nhiên tinh chế hộp 100G - 014',
        'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 100g...',
        '/assets/image/product/yensaonguyento/014_b790244e32e145c8a21efdee64b8d456.webp',
        7128000,
        50
    ),
    (
        7,
        'Yến sào đảo thiên nhiên tinh chế hộp 3G - 011',
        'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 3g...',
        '/assets/image/product/yensaonguyento/011_ebce11cb07a744fa8d61dbe83c2f130c.webp',
        232200,
        50
    ),
    (
        8,
        'Yến sào đảo thiên nhiên tinh chế hộp 50G - 015',
        'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp 50g...',
        '/assets/image/product/yensaonguyento/014_b790244e32e145c8a21efdee64b8d456.webp',
        3564000,
        50
    ),
    (
        9,
        'Yến sào đảo thiên nhiên tinh chế hộp 5G - 012',
        'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế làm sạch hộp 5g...',
        '/assets/image/product/yensaonguyento/011_ebce11cb07a744fa8d61dbe83c2f130c.webp',
        378000,
        50
    ),
    (
        10,
        'Yến sào đảo thiên nhiên tinh chế hộp quà tặng 2 hộp 3G - 011G2',
        'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp quà tặng(2 hộp x 3g)...',
        '/assets/image/product/yensaonguyento/yskh_012g2_op_97485178226440bba20791aeecf4a837.webp',
        507600,
        50
    ),
    (
        11,
        'Yến sào đảo thiên nhiên tinh chế hộp quà tặng 2 hộp 5G - 012G2',
        'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế hộp quà tặng (2 hộp x 5g)...',
        '/assets/image/product/yensaonguyento/yskh_012g2_op_97485178226440bba20791aeecf4a837.webp',
        799200,
        50
    ),
    (
        12,
        'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 100G - 014G',
        'Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng với trọng lượng yến 100g...',
        '/assets/image/product/yensaonguyento/yskh_014g.webp',
        7516800,
        50
    ),
    (
        13,
        'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 100G - 014GS',
        'Sản phẩm yến sào nguyên chất từ đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 100g...',
        '/assets/image/product/yensaonguyento/yskh_014g.webp',
        7916400,
        50
    ),
    (
        14,
        'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 3G - 011G',
        'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 3g...',
        '/assets/image/product/yensaonguyento/yskh_011g_op.webp',
        1220400,
        50
    ),
    (
        15,
        'Yến sào đảo thiên nhiên tinh chế mẫu hộp quà tặng 50G - 015G',
        'Sản phẩm Yến sào đảo yến thiên nhiên tinh chế mẫu hộp quà tặng 50g...',
        '/assets/image/product/yensaonguyento/yskh_014g.webp',
        3931200,
        50
    ),
    (
        16,
        'Hộp quà tặng Yến sào Nguyên tổ 50g Sanvinest Khánh Hòa Chính hiệu - Q150',
        'Yến sào Sanvinest Khánh Hòa - Hộp quà tặng 50g...',
        '/assets/image/product/yensaonguyento/q150_42b932ad40724f34a9230042878f5122.jpg',
        2308500,
        50
    ),
    (
        17,
        'Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 100g - Q610',
        'Yến sào Sanvinest Khánh Hòa - Hộp quà tặng 100g...',
        '/assets/image/product/sanviest/q160_7e71defed4054c8da70240dada86b807.jpg',
        6796900,
        50
    ),
    (
        18,
        'Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 50g - Q650',
        'Yến sào từ lâu đã được biết đến là nguồn thực phẩm bổ dưỡng diệu kỳ...',
        '/assets/image/product/sanviest/q650_fefa4292fffd46a5988f035460f1f458.jpg',
        3103650,
        50
    ),
    (
        19,
        'Nước yến sào Khánh Hòa Sanvinest trẻ em lọ 62ml, hộp 1 lọ - 2011',
        'Nước Yến sào Sanvinest Khánh Hòa dành cho trẻ em...',
        '/assets/image/product/sanviest/2011_c5841feb5c404b46ba9976eb7b039439.jpg',
        34400,
        50
    ),
    (
        20,
        'Nước yến sào Khánh Hòa Sanvinest Đông Trùng Hạ Thảo lọ 70ml - 208',
        'Nước Yến sào Khánh Hòa Sanvinest Đông trùng hạ thảo...',
        '/assets/image/product/sanviest/untitled_0e6fde7e18f14b2b8254a91fc6a4645e.webp',
        42300,
        50
    ),
    (
        21,
        'Nước yến sào Khánh Hòa Sanvinest Đông Trùng Hạ Thảo lọ 70ml hộp 6 lọ - 208H6',
        'Nước Yến sào Khánh Hòa Sanvinest Đông trùng hạ thảo - Hộp 6 lọ...',
        '/assets/image/product/sanviest/untitled_f80e0c02aa534b6cb7f02f43c1bdbd21.webp',
        263200,
        50
    ),
    (
        22,
        'Nước yến sào Khánh Hòa Sanvinest không đường lọ 70ml, hộp 6 lọ - 102H6',
        'Nước Yến sào Sanvinest Khánh Hòa không đường - Hộp 6 lọ...',
        '/assets/image/product/sanviest/hop_6_lo_102_fd7dbb1807c0459288946f908705f6b9.webp',
        220000,
        50
    ),
    (
        23,
        'Nước yến sào Khánh Hòa Sanvinest lọ 70ml, hộp 1 lọ - 101',
        'Nước Yến sào Sanvinest Khánh Hòa lọ 70ml...',
        '/assets/image/product/sanviest/101_678512918f8343ff96395b3e653a0bfe.webp',
        35400,
        50
    ),
    (
        24,
        'Nước yến sào Khánh Hòa Sanvinest lon 190ML - 121',
        'Nước Yến sào Sanvinest Khánh Hòa - Lon 190ml...',
        '/assets/image/product/sanviest/121_f2553d9e10d745c2b0dba5f324cc7213.webp',
        8900,
        50
    ),
    (
        25,
        'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp 10 túi 20ml - TC503H10',
        'Tinh chất Yến sào Khánh Hòa Sanvinest - Hộp 10 túi...',
        '/assets/image/product/sanviest/10_66b27067e1674475ae4d6035b5c15274.webp',
        380000,
        50
    ),
    (
        26,
        'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp 20 túi 20ml - TC503H20',
        'Tinh chất Yến sào Khánh Hòa Sanvinest - Hộp 20 túi...',
        '/assets/image/product/sanviest/10_66b27067e1674475ae4d6035b5c15274.webp',
        754000,
        50
    ),
    (
        27,
        'Nước Yến sào Sanvinest không đường lon 190ml, hay 30 lon - 125K30',
        'Nước Yến sào Sanvinest không đường - Lon 190ml, Hộp 30 lon...',
        '/assets/image/product/sanviest/9_35b9d820ac674d38b3a3b83a96bb2ba8.webp',
        604000,
        50
    ),
    (
        28,
        'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho mọi lứa tuổi hộp quà tặng 20 túi 20ml - QTC503H20',
        'Tinh chất Yến sào Khánh Hòa Sanvinest - Hộp quà tặng 20 túi...',
        '/assets/image/product/sanviest/9_35b9d820ac674d38b3a3b83a96bb2ba8.webp',
        792000,
        50
    ),
    (
        29,
        'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi Hộp quà tặng 15 túi 20ml - QTC502H15',
        'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi - Hộp quà tặng 15 túi...',
        '/assets/image/product/sanviest/5_af4d4860cdc14da4b99ea6df1761b00c.webp',
        604000,
        50
    ),
    (
        30,
        'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi hộp 20 túi 20ml - TC502H20',
        'Tinh chất Yến sào Khánh Hòa Sanvinest dành cho người cao tuổi - Hộp 20 túi...',
        '/assets/image/product/sanviest/6_2eab4c94d1a046edb89711e94a015ad7.webp',
        754000,
        50
    ),
    (
        31,
        'Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml, Hộp 6 Lọ - 700H6',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Fucoidan Nhân sâm Khánh Hòa Sanest là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/sanest_hop6lo_700_d5d0df7e74c34ad3ae33205677052db9.jpg',
        280800,
        100
    ),
    (
        32,
        'Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml, lọ(New) - 700',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Fucoidan Nhân sâm Khánh Hòa Sanest là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/sanest_lo700.jpg',
        44200,
        200
    ),
    (
        33,
        'Nước Yến Sào Khánh Hòa Sanest Collagen 70ml 1 lọ - 770',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Collagen là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/sanest_lo770.jpg',
        35400,
        150
    ),
    (
        34,
        'Nước Yến Sào Khánh Hòa Sanest Collagen 70ml hộp 6 lọ - 770H6',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Collagen là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/sanest_770hop6lo.jpg',
        218000,
        100
    ),
    (
        35,
        'Nước yến sào Khánh Hòa Sanest dành cho trẻ em đóng lon 190 ml, hộp 6 lon - 0162H6',
        'THÔNG TIN NỔI BẬT: Thành phần sản phẩm: Nước, Yến sào 1,6%, đường tinh luyện, Taurine, 2’-fucosyllactose (2’-FL), chất ổn định (406, 327, 415, 401, 466), hương liệu tổng hợp dùng cho thực phẩm...',
        '/assets/image/product/sanest/a_fca85d54924b477b9977ab92f02b8d08.webp',
        53100,
        120
    ),
    (
        36,
        'Nước yến sào Sanest đông trùng hạ thảo 70ml, hộp 6 lọ - 005H6',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest Đông Trùng Hạ Thảo được sản xuất từ nguồn Yến sào thiên nhiên do Công ty Yến sào Khánh Hòa trực tiếp khai thác tại các đảo Yến Khánh Hòa kết hợp với Đông Trùng Hạ Thảo...',
        '/assets/image/product/sanest/005h6_832cc1018d3846d4a219f0077c04ff11.webp',
        263200,
        100
    ),
    (
        37,
        'Nước yến sào Khánh Hòa Sanest kid lon 190ML, khay 30 lon - 0162K30',
        'THÔNG TIN NỔI BẬT: Thành phần sản phẩm: Nước, Yến sào 1,6%, đường tinh luyện, Taurine, 2’-fucosyllactose (2’-FL), chất ổn định (406, 327, 415, 401, 466), hương liệu tổng hợp dùng cho thực phẩm...',
        '/assets/image/product/sanest/12_3b4c3aff6fdf4b27b91ffff28b021376.webp',
        257300,
        80
    ),
    (
        38,
        'Nước yến sào Khánh Hòa Sanest kid lon 190ML, thùng 30 lon - 0162T30',
        'THÔNG TIN NỔI BẬT: Thành phần sản phẩm: Nước, Yến sào 1,6%, đường tinh luyện, Taurine, 2’-fucosyllactose (2’-FL), chất ổn định (406, 327, 415, 401, 466), hương liệu tổng hợp dùng cho thực phẩm...',
        '/assets/image/product/sanest/thung_30_-_0162_-_24-8-2020_5dbb0e1af4794d57acc4940ef4bddfb7_large_51745978569c4a68afb1fb08b5f4a5d3.webp',
        259200,
        70
    ),
    (
        39,
        'Nước Yến Sào Khánh Hòa Sanest không đường dành cho người cao tuổi 70ml - Hộp 6 Lọ - 096H6',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest không đường dành cho người cao tuổi là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/caotuoikhongduong_e980982f3b734934b3bdfd77010a27f8.webp',
        220000,
        100
    ),
    (
        40,
        'Nước Yến Sào Khánh Hòa Sanest dành cho người cao tuổi 70ml - Hộp 6 Lọ - 095H6',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest dành cho người cao tuổi là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/caotuoikhongduong_e980982f3b734934b3bdfd77010a27f8.webp',
        218000,
        120
    ),
    (
        41,
        'Nước Yến sào Khánh Hòa Sanest không đường dành cho người cao tuổi 70 ml - Hộp 1 lọ 096',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest không đường dành cho người cao tuổi là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/096_1c8798c49a1c4bd7955ecbc0734aa0ad.webp',
        35400,
        150
    ),
    (
        42,
        'Nước Yến sào Khánh Hòa Sanest dành cho người cao tuổi 70ml - Hộp 1 lọ 095',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest dành cho người cao tuổi là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/095_09fc5d0d843944d7a16cac2692485d34.webp',
        35400,
        180
    ),
    (
        43,
        'Nước Yến sào Sanvinest không đường lon 190ml, thùng 30 lon - 125T30',
        'THÔNG TIN NỔI BẬT: Nước Yến sào Sanvinest Khánh Hòa không đường đóng lon là sản phẩm giải khát bổ dưỡng, thích hợp cho mọi độ tuổi...',
        '/assets/image/product/sanest/122t30_6c42efa35e5e472295552b34da77d0b4_large_fccf3a6883444d65b8f3cf517fbf5abe.jpg',
        259200,
        150
    ),
    (
        44,
        'Nước yến sào Khánh Hòa Sanest lon 190ML, hộp 12 lon - 001H12',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest (đóng lon) là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/001h12_800_538_4c80337caf954dc7af4a45bb9cfa1d9e.webp',
        106100,
        150
    ),
    (
        45,
        'Nước yến sào Khánh Hòa Sanest lon 190ml, khay 30 lon - 001K30',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest (đóng lon) là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/sanest/001k30.webp',
        257300,
        150
    ),
    (
        46,
        'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 2 HỘP 20 GÓI 5 GRAM - 031G',
        'THÔNG TIN NỔI BẬT: Sản phẩm Nước Yến sào Khánh Hòa Sanest (đóng lon) là sản phẩm được chế biến từ nguồn Yến sào đảo thiên nhiên và giữ nguyên tính năng của Yến sào đảo thiên nhiên...',
        '/assets/image/product/yensaonguyento/z3955337968029_9af6618a530ffe63f805b9cc1efcb158_858ceaf95ca24c6aabfa774bb1c68873.webp',
        1512000,
        200
    ),
    (
        47,
        'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 20 GÓI 5 GRAM - 028',
        'THÔNG TIN NỔI BẬT: Yến sào là sản vật thiên nhiên quý giá của xứ sở rừng trầm biển yến Khánh Hòa với quần thể đàn chim yến hàng Acrodramus Fuciphagus Germani lớn nhất thế giới hiện nay...',
        '/assets/image/product/yensaonguyento/z3955337939918_bd2220b255837b6cde7fa2db4593a165_3e70a906e7ba46829547df28efd6a184.webp',
        702000,
        300
    ),
    (
        48,
        'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 30 GÓI 5 GRAM - 029G',
        'THÔNG TIN NỔI BẬT: Yến sào là sản vật thiên nhiên quý giá của xứ sở rừng trầm biển yến Khánh Hòa với quần thể đàn chim yến hàng Acrodramus Fuciphagus Germani lớn nhất thế giới hiện nay...',
        '/assets/image/product/yensaonguyento/z3955337934951_9f822651ca86197d6389648ea6675180_d6e16733552440dfb769ceee93c911ad.webp',
        1026000,
        150
    ),
    (
        49,
        'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 5 GÓI 5 GRAM - 027',
        'THÔNG TIN NỔI BẬT: Yến sào là sản vật thiên nhiên quý giá của xứ sở rừng trầm biển yến Khánh Hòa với quần thể đàn chim yến hàng Acrodramus Fuciphagus Germani lớn nhất thế giới hiện nay...',
        '/assets/image/product/yensaonguyento/027_46377142da3b4f4b9d60189e2e338950.webp',
        162000,
        400
    ),
    (
        50,
        'TINH CHẤT YẾN SÀO THIÊN NHIÊN KHÁNH HÒA - HỘP 6 HỘP 5 GÓI 5 GRAM - 030G',
        'THÔNG TIN NỔI BẬT: Yến sào là sản vật thiên nhiên quý giá của xứ sở rừng trầm biển yến Khánh Hòa với quần thể đàn chim yến hàng Acrodramus Fuciphagus Germani lớn nhất thế giới hiện nay...',
        '/assets/image/product/yensaonguyento/z3955337968029_9af6618a530ffe63f805b9cc1efcb158_858ceaf95ca24c6aabfa774bb1c68873.webp',
        1080000,
        150
    ),
    (
        51,
        'Hạt điều lạt hộp 1KG',
        'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện. Hướng dẫn sử dụng: Ăn liền...',
        '/assets/image/product/thucpham/hl1k.jpg',
        395700,
        100
    ),
    (
        52,
        'Hạt điều chiên Sanest Foods (muối) hộp 1KG',
        'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện. Hướng dẫn sử dụng: Ăn liền...',
        '/assets/image/product/thucpham/hop_dieu_muoi_1000g.jpg',
        392800,
        150
    ),
    (
        53,
        'Hạt điều chiên Sanest Foods (muối) hộp 454G - MH454',
        'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện. Hướng dẫn sử dụng: Ăn liền...',
        '/assets/image/product/thucpham/hop_dieu_muoi_454g.jpg',
        184600,
        200
    ),
    (
        54,
        'Hạt điều muối lụa hộp 400G - LM400',
        'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện. Hướng dẫn sử dụng: Ăn liền...',
        '/assets/image/product/thucpham/1_52144ef2d79b4fffa2a5d06e8b90d833.jpg',
        159100,
        150
    ),
    (
        55,
        'Nhân điều muối hộp 300G - MH300',
        'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện. Hướng dẫn sử dụng: Ăn liền...',
        '/assets/image/product/thucpham/hop_dieu_muoi_300g_mat_dung.webp',
        119800,
        100
    ),
    (
        56,
        'Hạt điều chiên muối Sanest Foods hộp 100G - MH100',
        'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện. Hướng dẫn sử dụng: Ăn liền...',
        '/assets/image/product/thucpham/hop_dieu_muoi_100g_1.webp',
        51100,
        200
    ),
    (
        57,
        'Hạt điều chiên muối Sanest Foods túi 100G - MT100',
        'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện. Hướng dẫn sử dụng: Ăn liền...',
        '/assets/image/product/thucpham/dieu_muoi_100g.webp',
        47200,
        180
    ),
    (
        58,
        'Hạt điều chiên muối Sanest Foods túi 50G - MT50',
        'THÔNG TIN NỔI BẬT: Thành phần cấu tạo: Nhân điều, dầu thực vật tinh luyện. Hướng dẫn sử dụng: Ăn liền...',
        '/assets/image/product/thucpham/dieu_muoi_50g.webp',
        26600,
        250
    ),
    (
        59,
        'Bánh yến sào đường ăn kiêng hộp 12 cái - H12K',
        'THÔNG TIN NỔI BẬT: Thành phần: Bột mì, Yến sào (2%), Chocolate, Đạm Whey, Chất xơ, Bột năng, Bột bắp, Dầu thực vật tinh luyện, Shortening...',
        '/assets/image/product/thucpham/z3979830090602_8046aa557673e17f4f59258894a3aaf0_2955ab05371740aa93923b150fb29871.webp',
        90000,
        150
    ),
    (
        60,
        'Bánh Yến sào Sanest Cake hộp 20 cái - H20',
        'THÔNG TIN NỔI BẬT: Thành phần: Bột mì, Yến sào (2%), Chocolate, Đạm Whey, Chất xơ, Bột năng, Bột bắp, Dầu thực vật tinh luyện, Shortening...',
        '/assets/image/product/thucpham//z3979830080738_aecad8ceca3494d7ea7fab5d612de71d_fb6c3306867449c7978d3035861b7581.webp',
        132600,
        150
    );
-- Liên kết sản phẩm với loại sản phẩm
INSERT INTO san_pham_loai (san_pham_id, loai_san_pham_id)
VALUES (1, 1),
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
        'Nguyen Quoc Tung',
        'tung@gmail.com',
        'password123',
        '0123456789',
        '70 Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh',
        'khach_hang'
    ),
    (
        'Nguyễn Võ Thành',
        'thanh@gmail.com',
        'password123',
        '0987654321',
        '70 Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh',
        'khach_hang'
    ),
    (
        'Admin',
        'admin@gmail.com',
        'adminpassword',
        '',
        '',
        'admin'
    );
