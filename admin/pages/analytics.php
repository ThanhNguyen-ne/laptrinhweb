<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/analytics.css" />
        <title>Phân tích</title>
    </head>

    <body>
        <!-- Sidebar -->
        <?php include("sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Main Content -->
        <div class="content">
            <!-- Navbar -->
            <nav>
                <i class="bx bx-menu"></i>
                <form action="#">
                    <div class="form-input">
                        <input type="search" placeholder="Tìm kiếm..." />
                        <button class="search-btn" type="submit">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                </form>
                <input type="checkbox" id="theme-toggle" hidden />
                <label for="theme-toggle" class="theme-toggle"></label>
                <a href="#" class="notif">
                    <i class="bx bx-bell"></i>
                    <span class="count">12</span>
                </a>
                <a href="#" class="profile">
                    <img src="../assets/images/logohdeader.webp" />
                </a>
            </nav>
            <!-- End of Navbar -->

            <main>
                <div class="header">
                    <div class="left">
                        <h1>Bảng điều khiển</h1>
                        <ul class="breadcrumb">
                            <li><a href="#">Phân tích</a></li>
                            /
                            <li><a href="#" class="active">Cửa hàng</a></li>
                        </ul>
                    </div>
                </div>

                <?php
                include('db_connect.php');

                // Lấy dữ liệu từ cơ sở dữ liệu
                $orders_result = $conn->query("SELECT COUNT(order_id) AS total_orders FROM orders WHERE pay_status = 1");
                $orders_paid = $orders_result->fetch_assoc()['total_orders'];

                $views_result = $conn->query("SELECT SUM(views) AS total_views FROM site_statistics");
                $total_views = $views_result->fetch_assoc()['total_views'];

                $searches_result = $conn->query("SELECT SUM(searches) AS total_searches FROM site_statistics");
                $total_searches = $searches_result->fetch_assoc()['total_searches'];

                $revenue_result = $conn->query("SELECT SUM(amount) AS total_revenue FROM orders WHERE pay_status = 1");
                $total_revenue = $revenue_result->fetch_assoc()['total_revenue'];

                $conn->close();
                ?>

                <!-- Insights -->
                <ul class="insights">
                    <li>
                        <i class="bx bx-calendar-check"></i>
                        <span class="info">
                            <h3><?php echo number_format($orders_paid); ?></h3>
                            <p>Đơn hàng đã thanh toán</p>
                        </span>
                    </li>
                    <li>
                        <i class="bx bx-show-alt"></i>
                        <span class="info">
                            <h3><?php echo number_format($total_views); ?></h3>
                            <p>Lượt truy cập</p>
                        </span>
                    </li>
                    <li>
                        <i class="bx bx-line-chart"></i>
                        <span class="info">
                            <h3><?php echo number_format($total_searches); ?></h3>
                            <p>Tìm kiếm</p>
                        </span>
                    </li>
                    <li>
                        <i class="bx bx-dollar-circle"></i>
                        <span class="info">
                            <h3>$<?php echo number_format($total_revenue); ?></h3>
                            <p>Tổng doanh thu</p>
                        </span>
                    </li>
                </ul>
                <!-- End of Insights -->

                <div class="bottom-data">
                    <div class="orders">
                        <div class="header">
                            <i class="bx bx-receipt"></i>
                            <h3>Đơn hàng gần đây</h3>
                            <i class="bx bx-filter"></i>
                            <i class="bx bx-search"></i>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Người dùng</th>
                                    <th>Ngày đặt hàng</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('db_connect.php');
                                $recent_orders_result = $conn->query("SELECT orders.order_id, users.first_name, users.last_name, orders.order_date, orders.order_status FROM orders JOIN users ON orders.user_id = users.user_id ORDER BY orders.order_date DESC LIMIT 3");

                                while ($order = $recent_orders_result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><img src='../assets/images/logohdeader.webp' /><p>" . $order['first_name'] . " " . $order['last_name'] . "</p></td>";
                                    echo "<td>" . date("d-m-Y", strtotime($order['order_date'])) . "</td>";
                                    echo "<td><span class='status " . ($order['order_status'] == 1 ? 'completed' : ($order['order_status'] == 0 ? 'pending' : 'process')) . "'>" . ($order['order_status'] == 1 ? 'Hoàn thành' : ($order['order_status'] == 0 ? 'Chờ xử lý' : 'Đang xử lý')) . "</span></td>";
                                    echo "</tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

        <script src="../assets/js/analytics.js"></script>
    </body>
</html>
