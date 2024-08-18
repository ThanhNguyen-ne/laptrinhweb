<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/store.css" />
    <title>Cửa hàng</title>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class="bx bxl-twitter"></i>
            <div class="logo-name"><span>Yến sào</span>TT</div>
        </a>
        <ul class="side-menu">

            <li class="active">
                <a href="#"><i class="bx bx-store-alt"></i>Cửa hàng</a>
            </li>
            <li>
                <a href="analytics.php"><i class="bx bx-analyse"></i>Phân tích</a>
            </li>
            <li>
                <a href="feedback.php"><i class="bx bx-message-square-dots"></i>Phản hồi</a>
            </li>
            <li>
                <a href="users.php"><i class="bx bx-group"></i>Người dùng</a>
            </li>
            <li>
                <a href="settings.php"><i class="bx bx-cog"></i>Cài đặt</a>
            </li>
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
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class="bx bx-menu"></i>
            <form action="#">
                <div class="form-input">
                    <input
                        type="search"
                        placeholder="Tìm kiếm sản phẩm..." />
                    <button class="search-btn" type="submit">
                        <i class="bx bx-search"></i>
                    </button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden />
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="#" class="notif">
                <i class="bx bx-bell"></i>
                <span class="count">3</span>
            </a>
            <a href="#" class="profile">
                <img src="../assets/images/logohdeader.webp" />
            </a>
        </nav>
        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Quản lí Cửa hàng</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Cửa hàng</a></li>
                        /
                        <li><a href="#" class="active">Sản phẩm</a></li>
                    </ul>
                </div>
                <a href="#" class="btn add-product-btn">
                    <i class="bx bx-plus"></i>
                    <span>Thêm Sản phẩm</span>
                </a>
            </div>

            <!-- Product Table -->
            <div class="product-table">
                <table>
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic rows will be inserted here by JS -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Thêm sản phẩm</h2>
            <form id="productForm">
                <div class="input-group">
                    <label for="productName">Tên sản phẩm</label>
                    <input type="text" id="productName" required />
                </div>
                <div class="input-group">
                    <label for="productPrice">Giá</label>
                    <input type="number" id="productPrice" required />
                </div>
                <div class="input-group">
                    <label for="productStatus">Trạng thái</label>
                    <select id="productStatus" required>
                        <option value="Còn hàng">Còn hàng</option>
                        <option value="Hết hàng">Hết hàng</option>
                    </select>
                </div>
                <button type="submit" class="btn submit-btn">Lưu</button>
            </form>
        </div>
    </div>

    <script src="../assets/js/store.js"></script>
</body>

</html>