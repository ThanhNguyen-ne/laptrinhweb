<?php
// Kết nối tới cơ sở dữ liệu và bắt đầu phiên
include("../admin/pages/db_connect.php");
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    // Truy vấn thông tin người dùng
    $query = "SELECT * FROM nguoi_dung WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// Xử lý khi người dùng nhấn nút đăng xuất
if (isset($_POST['dangxuat'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yến Sào Khánh Hòa</title>
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<header>
    <div id="main">
        <div class="header_tren">
            <div class="info">
                <span><i class="fa-solid fa-phone"></i> Hotline: 0123456789</span>
                <span><i class="fa-solid fa-location-dot"></i> Địa chỉ: 70 Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh</span>
            </div>
            <div class="auth-buttons">
                <?php if (isset($user)) : ?>
                    <span style="
    font-family: Arial, sans-serif;
    font-size: 18px;
    color: #333;
    background-color: #f0f0f0;
    padding: 8px 12px;
    border-radius: 5px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    
    display: inline-block;
    top:2px">
    Xin chào, <?php echo htmlspecialchars($user['ho_ten']); ?>!
</span>
                    <form method="post" action="logout.php">
                        <button type="submit" name="dangxuat">Đăng xuất</button>
                    </form>
                <?php else : ?>
                    <button id="loginBtn" onclick="location.href='dangnhap.php'">Đăng nhập</button>
                    <button id="signupBtn" onclick="location.href='dangki.php'">Đăng kí</button>
                    <!-- <button id="loginBtn" onclick="showLoginModal()">Đăng nhập</button>
                    <button id="signupBtn" onclick="showSignupModal()">Đăng kí</button> -->
                <?php endif; ?>
            </div>
        </div>
        <nav>
            <div class="header_duoi">
                <div class="content-header">
                    <a href="index.php">
                        <img src="../assets/image/index/logohdeader.webp" alt="Logo" class="logo">
                    </a>
                    <ul id="nav">
                        <li><a href="index.php">Trang chủ</a></li>
                        <li>
                            <a href="sanpham.php"> Sản phẩm</a>
                            <ul class="subnav">
                                <li><a href="yensaothiennhiennguyento.php">Yến sào đảo yến thiên nhiên</a></li>
                                <li><a href="thucphamsanestfood.php">Thực phẩm Sanest Food</a></li>
                                <li><a href="yensaosanviestkhanhhoa.php">Yến sào Sanvinest Khánh Hoà</a></li>
                                <li><a href="yensaosanestkhanhhoa.php">Yến sào Sanest</a></li>
                                <li><a href="tinhchatyensao.php">Tinh chất yến sào</a></li>
                            </ul>
                        </li>
                        <li><a href="thongtin.php">Thông tin</a></li>
                        <li><a class="cart" href="giohang.php"><i class="fa-solid fa-cart-shopping"></i> Giỏ Hàng</a></li>
                    </ul>
                    <form action="" class="search">
                        <input type="text" class="search-text" placeholder="Tìm kiếm sản phẩm " required>
                        <button class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header>
