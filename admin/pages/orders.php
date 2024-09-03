<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/orders.css" />
    <title>Đơn hàng</title>
</head>

<body>
    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar">
            <i class="bx bx-menu"></i>
            <form id="ordersSearchForm">
                <div class="form-input">
                    <input type="search" id="ordersSearchInput" placeholder="Tìm kiếm đơn hàng theo mã..." />
                    <button class="search-btn" type="submit">
                        <i class="bx bx-search"></i>
                    </button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden />
            <label for="theme-toggle" class="theme-toggle"></label>

            <a href="#" class="profile">
                <img src="/assets/image/index/logohdeader.webp" />
            </a>
        </nav>
        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>ĐƠN HÀNG</h1>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="order-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã Đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu đơn hàng sẽ được hiển thị ở đây qua JavaScript -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Modal hiển thị chi tiết đơn hàng -->
    <div class="modal" id="orderModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Chi tiết đơn hàng</h2>
            <div id="orderDetails"></div> <!-- Nơi hiển thị chi tiết đơn hàng -->
        </div>
    </div>

    <script src="../assets/js/orders.js"></script>
</body>

</html>
