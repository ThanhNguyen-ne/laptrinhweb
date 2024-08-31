<?php
session_start();
include('../admin/pages/db_connect.php');

$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$productInfo = null;
$message = "";

if ($productId) {
    $query = "SELECT * FROM san_pham WHERE id = $productId";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $productInfo = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy sản phẩm với ID: $productId";
        exit();
    }
} else {
    echo "ID sản phẩm không được cung cấp.";
    exit();
}

// Lấy thông tin người dùng nếu đã đăng nhập
$userInfo = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userQuery = "SELECT * FROM nguoi_dung WHERE id = $userId";
    $userResult = $conn->query($userQuery);
    if ($userResult && $userResult->num_rows > 0) {
        $userInfo = $userResult->fetch_assoc();
    }
}

// Xử lý sau khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $paymentMethod = $_POST['paymentMethod'];
    $quantity = 1; // Số lượng cố định ở đây là 1, bạn có thể cập nhật nếu cần

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Chèn thông tin vào bảng don_hang, người dùng có thể là khách không đăng nhập
        $userIdOrNull = isset($userId) ? $userId : 'NULL';
        $orderQuery = "INSERT INTO don_hang (nguoi_dung_id, tong_tien, trang_thai)
                    VALUES ($userIdOrNull, '{$productInfo['gia']}', 'cho_xu_ly')";
        if ($conn->query($orderQuery) === TRUE) {
            // Lấy ID của đơn hàng vừa tạo
            $orderId = $conn->insert_id;

            // Chèn thông tin vào bảng chi_tiet_don_hang
            $detailQuery = "INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia_ban)
                            VALUES ('$orderId', '$productId', '$quantity', '{$productInfo['gia']}')";
            if ($conn->query($detailQuery) === TRUE) {
                // Nếu thành công, cam kết giao dịch
                $conn->commit();
                
                // Lưu thông báo vào session
                $_SESSION['order_message'] = "Đơn hàng đã được xác nhận";

                // Chuyển hướng về index.php
                header('Location: index.php');
                exit();
            } else {
                // Nếu lỗi, hủy giao dịch
                $conn->rollback();
                echo "Lỗi: " . $detailQuery . "<br>" . $conn->error;
            }
        } else {
            // Nếu lỗi, hủy giao dịch
            $conn->rollback();
            echo "Lỗi: " . $orderQuery . "<br>" . $conn->error;
        }
    } catch (Exception $e) {
        // Nếu có ngoại lệ, hủy giao dịch
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Thanh toán</title>
    <link rel="stylesheet" href="../assets/css/checkout.css">
    <link rel="stylesheet" href="../assets/css/sanpham.css">
</head>

<body>

    <?php include("header.php"); ?>

    <div class="checkout-container">
        <h1 class="checkout-title">Thanh toán</h1>

        <div class="checkout-wrapper">
            <div class="checkout-left">
                <?php if ($productInfo): ?>
                    <div class="checkout-cart-item">
                        <img src="../<?= $productInfo['hinh_anh'] ?>" alt="<?= $productInfo['ten_san_pham'] ?>" class="checkout-cart-item-img">
                        <div class="checkout-cart-item-details">
                            <p class="checkout-cart-item-title"><?= $productInfo['ten_san_pham'] ?></p>
                            <p class="checkout-cart-item-price">Giá: <?= number_format($productInfo['gia'], 0, ',', '.') ?> ₫</p>
                            <p class="checkout-cart-item-quantity">Số lượng: 1</p>
                            <p class="checkout-cart-item-total">Tổng: <?= number_format($productInfo['gia'], 0, ',', '.') ?> ₫</p>
                        </div>
                    </div>
                    <div class="checkout-total">
                        Tổng cộng:
                        <span id="totalAmount">
                            <?= number_format($productInfo['gia'], 0, ',', '.') . ' ₫' ?>
                        </span>
                    </div>
                <?php else: ?>
                    <p>Không tìm thấy sản phẩm.</p>
                <?php endif; ?>
            </div>

            <div class="checkout-right">
                <form id="checkoutForm" method="POST" action="">
                    <div class="checkout-form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="name" name="name" value="<?= $userInfo['ho_ten'] ?? '' ?>">
                        <div id="nameError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= $userInfo['email'] ?? '' ?>">
                        <div id="emailError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address" name="address" value="<?= $userInfo['dia_chi'] ?? '' ?>">
                        <div id="addressError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" id="phone" name="phone" value="<?= $userInfo['so_dien_thoai'] ?? '' ?>">
                        <div id="phoneError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="paymentMethod">Phương thức thanh toán:</label>
                        <select id="paymentMethod" name="paymentMethod">
                            <option value="cod">Thanh toán khi nhận hàng</option>
                            <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                        </select>
                    </div>
                    <button class="checkout-btn" type="submit">Xác nhận thanh toán</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="../assets/js/checkout.js"></script>
    <script>
        function showNotification(message) {
            const notificationBar = document.createElement("div");
            notificationBar.className = "notification-bar";
            notificationBar.innerText = message;

            document.body.prepend(notificationBar);

            setTimeout(() => {
                notificationBar.remove();
                window.location.href = 'index.php';
            }, 3000);
        }

    </script>
</body>

</html>