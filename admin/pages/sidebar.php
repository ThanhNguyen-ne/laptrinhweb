<div class="sidebar">
    <a href="#" class="logo">
        <i class="bx bxl-twitter"></i>
        <div class="logo-name"><span>Yến sào</span>TT</div>
    </a>
    <ul class="side-menu">
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);

        $menu_items = [
            "store.php" => '<i class="bx bx-store-alt"></i>Cửa hàng',
            "orders.php" => '<i class="bx bx-cart"></i>Đơn hàng',
            "users.php" => '<i class="bx bx-group"></i>Người dùng',
            "/pages/index.php" => '<i class="bx bx-home"></i>Trang chủ',
        ];

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
