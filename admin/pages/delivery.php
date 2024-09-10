<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/delivery.css" />
    <title>Giao hàng</title>
</head>

<body>
    <?php include("sidebar.php"); ?>
    <div class="content">
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

        <main>
            <div class="header">
                <div class="left">
                    <h1>ĐƠN HÀNG CẦN GIAO</h1>
                </div>
                <div class="notifications">
                    <h2>Thông báo</h2>
                    <ul id="notificationList">
                        <!-- Thông báo sẽ được hiển thị ở đây -->
                    </ul>
                </div>
            </div>

            <div class="order-table">
                <table>
                    <thead>
                        <tr>
                            <th>Mã Đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Địa chỉ</th>
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

    <!-- Modal Chi tiết đơn hàng -->
    <div class="modal" id="orderModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Chi tiết đơn hàng</h2>
            <div id="orderDetails"></div>
        </div>
    </div>

    <script src="../assets/js/delivery.js"></script>
</body>

</html>
