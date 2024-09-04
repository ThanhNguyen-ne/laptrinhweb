<?php
session_start();
include('../admin/pages/db_connect.php');

$productInfo = null;
$message = "";

// Kiểm tra thông tin sản phẩm từ form giỏ hàng
if (isset($_POST['cart_items'])) {
    $selectedProducts = json_decode($_POST['cart_items'], true);
    $selectedItemIds = json_decode($_POST['selected_item_ids'], true);
} elseif (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $query = "SELECT * FROM san_pham WHERE id = $productId";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $productInfo = $result->fetch_assoc();
        $selectedProducts = [
            [
                'id' => $productInfo['id'],
                'name' => $productInfo['ten_san_pham'],
                'price' => $productInfo['gia'],
                'quantity' => 1,
                'image' => $productInfo['hinh_anh'],
            ]
        ];
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

// Xử lý khi người dùng xác nhận thanh toán
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['address'], $_POST['phone'], $_POST['paymentMethod'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $paymentMethod = $_POST['paymentMethod'];
    $totalAmount = array_sum(array_map(function ($product) {
        return $product['price'] * $product['quantity'];
    }, $selectedProducts));

    // Thêm vào bảng don_hang
    $orderQuery = "INSERT INTO don_hang (nguoi_dung_id, tong_tien, trang_thai) VALUES (?, ?, 'cho_xu_ly')";
    $stmt = $conn->prepare($orderQuery);
    $stmt->bind_param('id', $userId, $totalAmount);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    // Thêm vào bảng chi_tiet_don_hang và cập nhật số lượng sản phẩm còn lại
    foreach ($selectedProducts as $product) {
        $detailQuery = "INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia_ban) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($detailQuery);
        $stmt->bind_param('iiid', $orderId, $product['id'], $product['quantity'], $product['price']);
        $stmt->execute();

        // Cập nhật số lượng sản phẩm còn lại
        $updateProductQuery = "UPDATE san_pham SET so_luong_ton = so_luong_ton - ? WHERE id = ?";
        $stmt = $conn->prepare($updateProductQuery);
        $stmt->bind_param('ii', $product['quantity'], $product['id']);
        $stmt->execute();
    }

    // Xóa các sản phẩm đã được thanh toán khỏi giỏ hàng
    if (!empty($selectedItemIds)) {
        $itemIdsStr = implode(',', array_map('intval', $selectedItemIds));
        $deleteCartItemsQuery = "DELETE FROM gio_hang WHERE nguoi_dung_id = ? AND id IN ($itemIdsStr)";
        $stmt = $conn->prepare($deleteCartItemsQuery);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
    }

    // Hiển thị thông báo thành công và chuyển về trang chủ
    $_SESSION['success_message'] = "Thanh toán thành công! Cảm ơn bạn đã mua hàng.";
    header("Location: index.php");
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
                <?php if ($selectedProducts): ?>
                    <?php foreach ($selectedProducts as $product): ?>
                        <div class="checkout-cart-item">
                            <img src="../<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="checkout-cart-item-img">
                            <div class="checkout-cart-item-details">
                                <p class="checkout-cart-item-title"><?= htmlspecialchars($product['name']) ?></p>
                                <p class="checkout-cart-item-price">Giá: <?= number_format($product['price'], 0, ',', '.') ?> ₫</p>
                                <p class="checkout-cart-item-quantity">Số lượng: <?= $product['quantity'] ?></p>
                                <p class="checkout-cart-item-total">Tổng: <?= number_format($product['price'] * $product['quantity'], 0, ',', '.') ?> ₫</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="checkout-total">
                        Tổng cộng:
                        <span id="totalAmount">
                            <?= number_format(array_sum(array_map(function($product) {
                                return $product['price'] * $product['quantity'];
                            }, $selectedProducts)), 0, ',', '.') . ' ₫' ?>
                        </span>
                    </div>

                <?php else: ?>
                    <p>Không tìm thấy sản phẩm.</p>
                <?php endif; ?>
            </div>

            <div class="checkout-right">
                <?php if ($message): ?>
                    <div class="checkout-success-message">
                        <?= $message ?>
                    </div>
                <?php else: ?>
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
                        <input type="hidden" name="cart_items" value="<?= htmlspecialchars(json_encode($selectedProducts)) ?>">
                        <input type="hidden" name="selected_item_ids" value="<?= htmlspecialchars(json_encode($selectedItemIds)) ?>">
                        <button class="checkout-btn" type="submit">Xác nhận thanh toán</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="../assets/js/checkout.js"></script>
</body>
</html>
