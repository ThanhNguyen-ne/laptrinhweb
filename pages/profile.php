<?php
include("../admin/pages/db_connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Xử lý cập nhật thông tin
$update_success = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ho_ten'], $_POST['so_dien_thoai'], $_POST['dia_chi'])) {
        $ho_ten = $_POST['ho_ten'];
        $so_dien_thoai = $_POST['so_dien_thoai'];
        $dia_chi = $_POST['dia_chi'];

        // Kiểm tra xem mật khẩu có được gửi hay không
        if (!empty($_POST['mat_khau'])) {
            $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
            $sql_update = "UPDATE nguoi_dung SET ho_ten = ?, so_dien_thoai = ?, dia_chi = ?, mat_khau = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("ssssi", $ho_ten, $so_dien_thoai, $dia_chi, $mat_khau, $user_id);
        } else {
            $sql_update = "UPDATE nguoi_dung SET ho_ten = ?, so_dien_thoai = ?, dia_chi = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sssi", $ho_ten, $so_dien_thoai, $dia_chi, $user_id);
        }

        if ($stmt_update->execute()) {
            $update_success = true;
        } else {
            $update_success = false;
        }
    } elseif (isset($_POST['logout'])) {
        session_destroy();
        header("Location: dangnhap.php");
        exit();
    }
}

// Lấy thông tin người dùng
$sql = "SELECT ho_ten, email, so_dien_thoai, dia_chi,mat_khau FROM nguoi_dung WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

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
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <title>Thông tin cá nhân </title>
    <link rel="icon" href="../assets/image/index/logohdeader.webp" />
    <link rel="stylesheet" href="../assets/css/profile.css" />
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container">
        <h2>Thông tin tài khoản</h2>
        <div class="profile-info">
    <p>Họ tên: <?php echo htmlspecialchars($user['ho_ten']); ?></p>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    <p>Số điện thoại: <?php echo htmlspecialchars($user['so_dien_thoai']); ?></p>
    <p>Địa chỉ: <?php echo htmlspecialchars($user['dia_chi']); ?></p>
  
</div>

        <h2>Cập nhật thông tin cá nhân</h2>
<div class="update-form">
    <form method="POST" action="">
        <label for="ho_ten">Họ tên:</label>
        <input type="text" name="ho_ten" value="<?php echo htmlspecialchars($user['ho_ten']); ?>" required><br>

        <label for="so_dien_thoai">Số điện thoại:</label>
        <input type="text" name="so_dien_thoai" value="<?php echo htmlspecialchars($user['so_dien_thoai']); ?>"><br>

        <label for="dia_chi">Địa chỉ:</label>
        <textarea name="dia_chi" required><?php echo htmlspecialchars($user['dia_chi']); ?></textarea><br>

        <label for="mat_khau">Mật khẩu:</label>
        <input type="password" name="mat_khau" placeholder="Nhập mật khẩu mới"><br>

        <button type="submit">Cập nhật</button>
    </form>
</div>

        <h2>Đơn hàng đã đặt</h2>
        <div class="order-info">
            <table>
                <tr>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Sản phẩm</th>
                    <th>Trạng thái</th>
                </tr>
                <?php while($order = $result_orders->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['ngay_dat']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($order['tong_tien'], 2)); ?> VND</td>
                    <td><?php echo htmlspecialchars($order['san_pham']); ?></td>
                    <td><?php echo htmlspecialchars($order['trang_thai']); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <div class="logout-form">
            <form method="POST" action="">
                <button type="submit" name="logout">Đăng xuất</button>
            </form>
        </div>
    </div>
    <?php include('footer.php'); ?>

    <script>
        function showNotification(message) {
            const notification = document.createElement("div");
            notification.className = "notification";
            notification.innerText = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($update_success !== null): ?>
                <?php if ($update_success): ?>
                    showNotification("Cập nhật thông tin thành công!");
                <?php else: ?>
                    showNotification("Có lỗi xảy ra. Vui lòng thử lại.");
                <?php endif; ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
