<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Giỏ hàng của bạn đang trống.";
    exit;
}

$cartItems = $_SESSION['cart'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($cartItems)) {
        // Xử lý đơn hàng ở đây
        // Ví dụ: Lưu thông tin đơn hàng vào cơ sở dữ liệu

        // Sau khi xử lý đơn hàng, bạn có thể xóa giỏ hàng
        unset($_SESSION['cart']);
        echo "Đơn hàng đã được xử lý thành công!";
    } else {
        echo "Giỏ hàng của bạn đang trống.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận thanh toán</title>
    <!-- Bao gồm các thẻ meta và link CSS -->
</head>
<body>
    <h1>Xác nhận thanh toán</h1>

    <form id="checkoutForm" action="checkout2.php" method="POST">
        <!-- Các trường thông tin người dùng -->
        <div>
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name">
            <span id="nameError" class="checkout-error-message"></span>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <span id="emailError" class="checkout-error-message"></span>
        </div>
        <div>
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address">
            <span id="addressError" class="checkout-error-message"></span>
        </div>
        <div>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone">
            <span id="phoneError" class="checkout-error-message"></span>
        </div>
        <div>
            <label for="paymentMethod">Phương thức thanh toán:</label>
            <select id="paymentMethod" name="paymentMethod">
                <option value="cash">Tiền mặt</option>
                <option value="bank">Chuyển khoản ngân hàng</option>
            </select>
        </div>
        
        <button type="submit">Xác nhận thanh toán</button>
    </form>

    <script src="checkout2.js"></script>
</body>
</html>
