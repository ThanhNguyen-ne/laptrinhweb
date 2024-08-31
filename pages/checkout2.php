<?php
session_start();
include('../admin/pages/db_connect.php');

// Nhận dữ liệu giỏ hàng từ cart.php
$cartItems = isset($_POST['cart_items']) ? json_decode($_POST['cart_items'], true) : [];
if (empty($cartItems)) {
    echo "Giỏ hàng trống.";
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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $paymentMethod = $_POST['paymentMethod'];

    // Bắt đầu giao dịch
    $conn->begin_transaction();

    try {
        // Chèn thông tin vào bảng don_hang
        $userIdOrNull = isset($userId) ? $userId : 'NULL';
        $orderQuery = "INSERT INTO don_hang (nguoi_dung_id, tong_tien, trang_thai, ho_ten, email, dia_chi, so_dien_thoai, phuong_thuc_thanh_toan)
                    VALUES ($userIdOrNull, '$totalPrice', 'cho_xu_ly', ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($orderQuery);
        $stmt->bind_param("sssss", $name, $email, $address, $phone, $paymentMethod);

        if ($stmt->execute()) {
            $orderId = $stmt->insert_id;

            // Chèn thông tin vào bảng chi_tiet_don_hang
            foreach ($cartItems as $item) {
                $detailQuery = "INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia_ban)
                                VALUES (?, ?, ?, ?)";
                $stmtDetail = $conn->prepare($detailQuery);
                $stmtDetail->bind_param("iiii", $orderId, $item['id'], $item['quantity'], $item['price']);
                if (!$stmtDetail->execute()) {
                    throw new Exception("Lỗi: " . $stmtDetail->error);
                }
            }

            // Xóa các sản phẩm đã thanh toán khỏi giỏ hàng
            foreach ($cartItems as $item) {
                $deleteQuery = "DELETE FROM gio_hang WHERE nguoi_dung_id = $userId AND san_pham_id = ?";
                $stmtDelete = $conn->prepare($deleteQuery);
                $stmtDelete->bind_param("i", $item['id']);
                $stmtDelete->execute();
            }

            // Cam kết giao dịch
            $conn->commit();
            echo "<script>alert('Đơn hàng của bạn đã được xác nhận!'); window.location.href = 'index.php';</script>";
        } else {
            throw new Exception("Lỗi: " . $stmt->error);
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "Lỗi: " . $e->getMessage();
    }

    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                <p class="checkout-cart-item-quantity">Số lượng: <?= $item['quantity'] ?></p>
                                <p class="checkout-cart-item-price"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> ₫</p>
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
                            <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                            <option value="bank_transfer">Chuyển khoản ngân hàng</option>
                        </select>
                    </div>
                    <button class="checkout-btn" type="submit" name="confirm_payment">Xác nhận thanh toán</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
    <script src="../assets/js/checkout.js"></script>
</body>
</html>
