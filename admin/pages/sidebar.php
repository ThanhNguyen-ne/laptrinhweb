<div class="sidebar">
    <a href="#" class="logo">
        <i class="bx bxl-twitter"></i>
        <div class="logo-name"><span>Yến sào</span>TT</div>
    </a>
    <ul class="side-menu">
        <?php
        session_start();  // Bắt đầu session để truy cập thông tin user
        
        $current_page = basename($_SERVER['PHP_SELF']);

        // Kiểm tra vai trò của người dùng đã đăng nhập
        $user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : '';

        // Nếu là admin, hiển thị menu đầy đủ
        if ($user_role == 'admin') {
            $menu_items = [
                "store.php" => '<i class="bx bx-store-alt"></i>Cửa hàng',
                "orders.php" => '<i class="bx bx-cart"></i>Đơn hàng',
                "users.php" => '<i class="bx bx-group"></i>Người dùng',
                "delivery.php" => '<i class="bx bxs-truck"></i>Nhân viên',
                "/pages/index.php" => '<i class="bx bx-home"></i>Trang chủ',
            ];
        } 
        // Nếu là nhân viên, hiển thị menu rút gọn
        elseif ($user_role == 'nhan_vien') {
            $menu_items = [
                "delivery.php" => '<i class="bx bxs-truck"></i>Nhân viên',
            ];
        } else {
            // Nếu không xác định vai trò, có thể xử lý thêm tùy theo yêu cầu (ví dụ: ẩn toàn bộ menu)
            $menu_items = [];
        }

        // Hiển thị các mục menu tương ứng
        foreach ($menu_items as $page => $label) {
            $active_class = $current_page === $page ? 'active' : '';
            echo "<li class='$active_class'><a href='$page'>$label</a></li>";
        }
        ?>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="dangxuat.php" class="logout">
                <i class="bx bx-log-out-circle"></i>
                Đăng xuất
            </a>
        </li>
    </ul>
</div>
