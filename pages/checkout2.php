<?php
session_start();
include('../admin/pages/db_connect.php');

// Nhận dữ liệu giỏ hàng từ cart.php
$cartItemsRaw = isset($_POST['cart_items']) ? $_POST['cart_items'] : null;
$cartItems = json_decode($cartItemsRaw, true);

// Kiểm tra và ghi log
error_log("Dữ liệu nhận được từ POST cart_items: " . $cartItemsRaw);
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("Lỗi JSON: " . json_last_error_msg());
}

if (empty($cartItems)) {
    error_log("Giỏ hàng trống hoặc không có sản phẩm nào được chọn để thanh toán.", 0);
    $_SESSION['order_error'] = 'Giỏ hàng trống hoặc không có sản phẩm nào được chọn để thanh toán.';
    header("Location: cart.php");
    exit();
}

// Tính tổng giá tiền chính xác dựa trên số lượng sản phẩm
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

$userInfo = null;
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userQuery = "SELECT * FROM nguoi_dung WHERE id = $userId";
    $userResult = $conn->query($userQuery);
    if ($userResult && $userResult->num_rows > 0) {
        $userInfo = $userResult->fetch_assoc();
    }
}

// Xử lý sau khi người dùng xác nhận thanh toán
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
    $conn->begin_transaction();

    try {
        $orderQuery = "INSERT INTO don_hang (nguoi_dung_id, tong_tien, trang_thai)
                       VALUES ($userId, '$totalPrice', 'cho_xu_ly')";

        if (!$conn->query($orderQuery)) {
            throw new Exception("Lỗi khi chèn vào bảng don_hang: " . $conn->error);
        }

        $orderId = $conn->insert_id;

        foreach ($cartItems as $item) {
            $detailQuery = "INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia_ban)
                            VALUES ('$orderId', '{$item['id']}', '{$item['quantity']}', '{$item['price']}')";
            if (!$conn->query($detailQuery)) {
                throw new Exception("Lỗi khi chèn vào bảng chi_tiet_don_hang: " . $conn->error);
            }

            $updateProductQuery = "UPDATE san_pham SET so_luong_ton = so_luong_ton - {$item['quantity']} WHERE id = {$item['id']}";
            if (!$conn->query($updateProductQuery)) {
                throw new Exception("Lỗi khi cập nhật số lượng sản phẩm: " . $conn->error);
            }
        }

        // Xóa các sản phẩm đã được thanh toán khỏi giỏ hàng
        $selectedProductIds = implode(',', array_column($cartItems, 'id'));
        $clearCartQuery = "DELETE FROM gio_hang WHERE nguoi_dung_id = $userId AND san_pham_id IN ($selectedProductIds)";
        if (!$conn->query($clearCartQuery)) {
            throw new Exception("Lỗi khi xóa giỏ hàng: " . $conn->error);
        }

        $conn->commit();
        $_SESSION['order_success'] = 'Đặt hàng thành công!';
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
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
    <title>Thông tin thanh toán</title>
    <link rel="stylesheet" href="../assets/css/checkout.css">
    <link rel="stylesheet" href="../assets/css/sanpham.css">
</head>

<body>

    <?php include("header.php"); ?>

    <div class="checkout-container">
        <h1 class="checkout-title">Thanh toán</h1>

        <div class="checkout-wrapper">
            <div class="checkout-left">
                <div class="checkout-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="checkout-cart-item">
                            <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="checkout-cart-item-img">
                            <div class="checkout-cart-item-details">
                                <p class="checkout-cart-item-title"><?= $item['name'] ?></p>
                                <p class="checkout-cart-item-price">Giá: <?= number_format($item['price'], 0, ',', '.') ?> ₫</p>
                                <p class="checkout-cart-item-quantity">Số lượng: <?= $item['quantity'] ?></p>
                                <p class="checkout-cart-item-total">Tổng: <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> ₫</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="checkout-total">
                    Tổng cộng:
                    <span id="totalAmount">
                        <?= number_format($totalPrice, 0, ',', '.') ?> ₫
                    </span>
                </div>
            </div>

            <div class="checkout-right">
                <form id="checkoutForm" method="POST" action="">
                    <div class="checkout-form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="name" name="name" value="<?= $userInfo['ho_ten'] ?? '' ?>" required>
                        <div id="nameError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= $userInfo['email'] ?? '' ?>" required>
                        <div id="emailError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address" name="address" value="<?= $userInfo['dia_chi'] ?? '' ?>" required>
                        <div id="addressError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" id="phone" name="phone" value="<?= $userInfo['so_dien_thoai'] ?? '' ?>" required>
                        <div id="phoneError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="paymentMethod">Phương thức thanh toán:</label>
                        <select id="paymentMethod" name="paymentMethod" required>
                            <option value="cod">Thanh toán khi nhận hàng</option>
                            <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                        </select>
                    </div>
                    <button class="checkout-btn" type="submit" name="confirm_payment">Xác nhận thanh toán</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="../assets/js/checkout2.js"></script>
</body>

</html>