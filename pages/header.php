<?php
include("../admin/pages/db_connect.php");
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];

    $query = "SELECT * FROM nguoi_dung WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

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
                    <span style="font-family: Arial, sans-serif; font-size: 18px; color: #333; background-color: #f0f0f0; padding: 8px 12px; border-radius: 5px; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2); display: inline-block; top:2px">
                        Xin chào, <?php echo htmlspecialchars($user['ho_ten']); ?>!
                    </span>
                    <form method="post" action="">
                        <button type="submit" name="dangxuat">Đăng xuất</button>
                    </form>
                <?php else : ?>
                    <button id="loginBtn">Đăng nhập</button>
                    <button id="signupBtn">Đăng kí</button>
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

<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeLoginModal">&times;</span>
        <div id="loginModalBody">
            <!-- Nội dung form đăng nhập sẽ được tải động tại đây -->
        </div>
    </div>
</div>

<div id="signupModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeSignupModal">&times;</span>
        <div id="signupModalBody">
            <!-- Nội dung form đăng ký sẽ được tải động tại đây -->
        </div>
    </div>
</div>

<script src="../assets/js/dangnhap.js"></script>
<script>
    document.getElementById("loginBtn").onclick = function() {
        showLoginModal();
    };
    document.getElementById("signupBtn").onclick = function() {
        showSignupModal();
    };

    document.getElementById("closeLoginModal").onclick = function() {
        closeModal("loginModal");
    };
    document.getElementById("closeSignupModal").onclick = function() {
        closeModal("signupModal");
    };
</script>
</body>
</html>
