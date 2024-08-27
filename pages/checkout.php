<?php
session_start();
include('../admin/pages/db_connect.php');

$productId = isset($_GET['id']) ? (int)$_GET['id'] : null;
$productInfo = null;

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/checkout.css">
    <link rel="stylesheet" href="../assets/css/sanpham.css">
</head>

<body>

    <?php include("header.php"); ?>

    <script src="../assets/js/header.js"></script>

    <div class="checkout-container">
        <h1 class="checkout-title">Thanh toán</h1>

        <div class="checkout-wrapper">
            <div class="checkout-left">
                <?php if ($productInfo): ?>
                    <div class="checkout-cart-item">
                        <img src="../<?= $productInfo['hinh_anh'] ?>" alt="<?= $productInfo['ten_san_pham'] ?>" class="checkout-cart-item-img">
                        <div class="checkout-cart-item-details">
                            <p class="checkout-cart-item-title"><?= $productInfo['ten_san_pham'] ?></p>
                            <p class="checkout-cart-item-quantity">Số lượng: 1</p>
                            <p class="checkout-cart-item-price"><?= number_format($productInfo['gia'], 0, ',', '.') ?> ₫</p>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Không tìm thấy sản phẩm.</p>
                <?php endif; ?>
                
                <div class="checkout-total">
                    Tổng cộng: 
                    <span id="totalAmount">
                        <?= $productInfo ? number_format($productInfo['gia'], 0, ',', '.') . '₫' : '0₫' ?>
                    </span>
                </div>
            </div>

            <div class="checkout-right">
                <form id="checkoutForm">
                    <div class="checkout-form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="name" value="<?= $userInfo['ho_ten'] ?? '' ?>">
                        <div id="nameError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" value="<?= $userInfo['email'] ?? '' ?>">
                        <div id="emailError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address" value="<?= $userInfo['dia_chi'] ?? '' ?>">
                        <div id="addressError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" id="phone" value="<?= $userInfo['so_dien_thoai'] ?? '' ?>">
                        <div id="phoneError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="paymentMethod">Phương thức thanh toán:</label>
                        <select id="paymentMethod">
                            <option value="creditCard">Thẻ tín dụng</option>
                            <option value="cod">Thanh toán khi nhận hàng</option>
                        </select>
                    </div>
                    <button class="checkout-btn" type="submit">Xác nhận thanh toán</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="../assets/js/checkout.js"></script>
</body>

</html>
