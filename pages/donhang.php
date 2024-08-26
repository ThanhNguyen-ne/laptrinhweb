<?php
include("../admin/pages/db_connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin đơn hàng
$sql_orders = "
    SELECT dh.id, dh.ngay_dat, dh.tong_tien, dh.trang_thai, GROUP_CONCAT(sp.ten_san_pham SEPARATOR ', ') AS san_pham
    FROM don_hang dh
    JOIN chi_tiet_don_hang ctdh ON dh.id = ctdh.don_hang_id
    JOIN san_pham sp ON ctdh.san_pham_id = sp.id
    WHERE dh.nguoi_dung_id = ?
    GROUP BY dh.id";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/donhang.css">
    <title>Đơn hàng của bạn</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <h2>Đơn hàng đã đặt</h2>
        <div class="order-info">
            <table>
                <tr>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Sản phẩm</th>
                    <th>Trạng thái</th>
                </tr>
                <?php while ($order = $result_orders->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['ngay_dat']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($order['tong_tien'], 2)); ?> VND</td>
                        <td><?php echo htmlspecialchars($order['san_pham']); ?></td>
                        <td><?php echo htmlspecialchars($order['trang_thai']); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>

<?php
$conn->close();
?>
