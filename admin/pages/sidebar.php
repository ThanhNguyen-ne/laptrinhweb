<div class="sidebar">
    <a href="#" class="logo">
        <i class="bx bxl-twitter"></i>
        <div class="logo-name"><span>Yến sào</span>TT</div>
    </a>
    <ul class="side-menu">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']); // Lấy tên file hiện tại

        // Tạo các mục sidebar với class 'active' nếu trùng với trang hiện tại
        $menu_items = [
            "store.php" => '<i class="bx bx-store-alt"></i>Cửa hàng',
            "analytics.php" => '<i class="bx bx-analyse"></i>Phân tích',
            "feedback.php" => '<i class="bx bx-message-square-dots"></i>Phản hồi',
            "users.php" => '<i class="bx bx-group"></i>Người dùng',
            "settings.php" => '<i class="bx bx-cog"></i>Cài đặt',
        ];

        foreach ($menu_items as $page => $label) {
            $active_class = $current_page === $page ? 'active' : '';
            echo "<li class='$active_class'><a href='$page'>$label</a></li>";
        }
        ?>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="#" class="logout">
                <i class="bx bx-log-out-circle"></i>
                Đăng xuất
            </a>
        </li>
    </ul>
</div>
