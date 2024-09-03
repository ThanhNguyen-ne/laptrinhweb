<?php
include("../admin/pages/db_connect.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$notification_message = '';

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

if (isset($_SESSION['notification_message'])) {
    $notification_message = $_SESSION['notification_message'];
    unset($_SESSION['notification_message']); // Xóa thông báo sau khi hiển thị
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
    <?php if (!empty($notification_message)): ?>
    <div id="notification-bar" class="notification">
        <p id="notification-message"><?= htmlspecialchars($notification_message) ?></p>
    </div>
    <?php endif; ?>

    <header>
        <div id="main">
            <div class="header_tren">
                <div class="info">
                    <span><i class="fa-solid fa-phone"></i> Hotline: 0123456789</span>
                    <span><i class="fa-solid fa-location-dot"></i> Địa chỉ: 70 Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh</span>
                </div>
                <div class="auth-buttons">
                    <?php if (isset($user)) : ?>
                        <div class="dropdown">
                            <button class="dropbtn">
                                <i class="fa-solid fa-user"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="profile.php">Tài khoản</a>
                                <a href="donhang.php">Đơn hàng</a>
                                <?php if ($user_role === 'admin'): ?>
                                    <a href="../admin/pages/store.php">Trang quản trị</a>
                                <?php endif; ?>
                                <a href="dangxuat.php" class="dropdown-logout">Đăng xuất</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <button id="loginBtn" class="btn-primary">Đăng nhập</button>
                        <button id="signupBtn" class="btn-secondary">Đăng kí</button>
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
                            <li><a href="cart.php" id="cartBtn" class="cart"><i class="fa-solid fa-cart-shopping"></i> Giỏ Hàng</a></li>
                        </ul>
                        <form action="search.php" method="get" class="search" onsubmit="return validateSearch()">
                            <input type="text" name="q" class="search-text" placeholder="Tìm kiếm sản phẩm" id="searchInput">
                            <button type="submit" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
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

    <div id="quenPassModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeQuenPassModal">&times;</span>
            <div id="quenPassModalBody">
                <!-- Nội dung form quên mật khẩu sẽ được tải động tại đây -->
            </div>
        </div>
    </div>

    <script>
        var isLoggedIn = <?= isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;
    </script>

    <script src="../assets/js/dangnhap.js"></script>
    <script src="../assets/js/header.js"></script>
    <script>
        function validateSearch() {
            var searchInput = document.getElementById("searchInput").value.trim();
            if (searchInput === "") {
                showNotification("Vui lòng nhập thông tin tìm kiếm.");
                return false; // Ngăn form gửi đi nếu không có thông tin tìm kiếm
            }
            return true;
        }

        function showNotification(message) {
            var notificationBar = document.getElementById("notification-bar");
            var notificationMessage = document.getElementById("notification-message");
            notificationMessage.textContent = message;
            notificationBar.classList.add("show");

            setTimeout(function() {
                notificationBar.classList.remove("show");
            }, 3000); // Ẩn thông báo sau 3 giây
        }

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

        document.getElementById("closeQuenPassModal").onclick = function() {
            closeModal("quenPassModal");
        };

        // Kiểm tra đăng nhập trước khi vào giỏ hàng
        document.getElementById("cartBtn").onclick = function(event) {
            var isLoggedIn = <?php echo isset($user) ? 'true' : 'false'; ?>;
            if (!isLoggedIn) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định
                showLoginModal(); // Hiển thị modal đăng nhập
            } else {
                window.location.href = "cart.php";
            }
        };
    </script>

</body>

</html>
