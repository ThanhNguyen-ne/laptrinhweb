<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="icon" href="../assets/image/index/logohdeader.webp">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <title>Thông tin cá nhân</title>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <div class="profile-section">
            <h2>Thông tin tài khoản</h2>
            <div class="profile-info">
                <form method="POST" action="">
                    <label for="ho_ten">Họ tên:</label>
                    <input type="text" name="ho_ten" value="<?php echo htmlspecialchars($user['ho_ten']); ?>" required><br>
                    
                    <label for="email">Email:</label>
                    <input type="text" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled><br>

                    <label for="so_dien_thoai">Số điện thoại:</label>
                    <input type="text" name="so_dien_thoai" value="<?php echo htmlspecialchars($user['so_dien_thoai']); ?>"><br>

                    <label for="dia_chi">Địa chỉ:</label>
                    <textarea name="dia_chi" required><?php echo htmlspecialchars($user['dia_chi']); ?></textarea><br>

                    <button type="submit" name="update_profile" class="btn-save">Lưu</button>
                </form>
            </div>
        </div>

        <div class="password-section">
            <h2>Đổi mật khẩu</h2>
            <button id="change-password-btn" class="btn-change-password">Đổi mật khẩu</button>

            <div id="changePasswordModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeChangePasswordModal">&times;</span>
                    <div id="changePasswordBody">
                        <!-- Nội dung form đổi mật khẩu sẽ được tải động tại đây -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>

    <script src="../assets/js/doimatkhau.js"></script>
</body>

</html>
