<?php
session_start(); // Bắt đầu một session để có thể truy cập hoặc khởi tạo session cho người dùng hiện tại.

include('../admin/pages/db_connect.php'); // Kết nối đến cơ sở dữ liệu bằng cách bao gồm tập tin `db_connect.php`.

$productInfo = null; // Khởi tạo biến `$productInfo` với giá trị null để lưu trữ thông tin sản phẩm sau này.
$message = ""; // Khởi tạo biến `$message` với một chuỗi rỗng để lưu trữ thông báo.

if (isset($_POST['cart_items'])) { // Kiểm tra nếu dữ liệu giỏ hàng đã được gửi thông qua POST.
    $selectedProducts = json_decode($_POST['cart_items'], true); // Giải mã JSON thành mảng PHP chứa thông tin sản phẩm đã chọn.
    $selectedItemIds = json_decode($_POST['selected_item_ids'], true); // Giải mã JSON thành mảng PHP chứa các ID sản phẩm đã chọn.
} elseif (isset($_GET['id'])) { // Nếu không có dữ liệu giỏ hàng, kiểm tra xem có ID sản phẩm trong URL không.
    $productId = intval($_GET['id']); // Chuyển ID sản phẩm sang kiểu số nguyên để tránh lỗi SQL injection.
    $query = "SELECT * FROM san_pham WHERE id = $productId"; // Truy vấn để lấy thông tin sản phẩm từ cơ sở dữ liệu.
    $result = $conn->query($query); // Thực hiện truy vấn và lưu kết quả vào biến `$result`.
    if ($result && $result->num_rows > 0) { // Kiểm tra nếu kết quả không rỗng và có ít nhất một dòng dữ liệu.
        $productInfo = $result->fetch_assoc(); // Lấy thông tin sản phẩm dưới dạng mảng kết hợp (associative array).
        $selectedProducts = [ // Tạo mảng chứa sản phẩm đã chọn.
            [
                'id' => $productInfo['id'], // ID của sản phẩm.
                'name' => $productInfo['ten_san_pham'], // Tên của sản phẩm.
                'price' => $productInfo['gia'], // Giá của sản phẩm.
                'quantity' => 1, // Số lượng sản phẩm mặc định là 1.
                'image' => $productInfo['hinh_anh'], // Hình ảnh của sản phẩm.
            ]
        ];
    } else { // Nếu không tìm thấy sản phẩm.
        echo "Không tìm thấy sản phẩm với ID: $productId"; // Thông báo lỗi.
        exit(); // Dừng thực thi kịch bản.
    }
} else { // Nếu không có ID sản phẩm trong URL.
    echo "ID sản phẩm không được cung cấp."; // Thông báo lỗi.
    exit(); // Dừng thực thi kịch bản.
}

$userInfo = null; // Khởi tạo biến `$userInfo` với giá trị null để lưu trữ thông tin người dùng sau này.
if (isset($_SESSION['user_id'])) { // Kiểm tra nếu người dùng đã đăng nhập.
    $userId = $_SESSION['user_id']; // Lấy ID người dùng từ session.
    $userQuery = "SELECT * FROM nguoi_dung WHERE id = $userId"; // Truy vấn để lấy thông tin người dùng từ cơ sở dữ liệu.
    $userResult = $conn->query($userQuery); // Thực hiện truy vấn và lưu kết quả vào biến `$userResult`.
    if ($userResult && $userResult->num_rows > 0) { // Kiểm tra nếu kết quả không rỗng và có ít nhất một dòng dữ liệu.
        $userInfo = $userResult->fetch_assoc(); // Lấy thông tin người dùng dưới dạng mảng kết hợp.
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['address'], $_POST['phone'], $_POST['paymentMethod'])) {
    // Xử lý đơn hàng khi người dùng nhấn nút thanh toán và POST form.
    $name = $_POST['name']; // Lấy tên người dùng từ form.
    $email = $_POST['email']; // Lấy email từ form.
    $address = $_POST['address']; // Lấy địa chỉ từ form.
    $phone = $_POST['phone']; // Lấy số điện thoại từ form.
    $paymentMethod = $_POST['paymentMethod']; // Lấy phương thức thanh toán từ form.
    $totalAmount = array_sum(array_map(function ($product) { // Tính tổng số tiền của đơn hàng.
        return $product['price'] * $product['quantity']; // Giá * số lượng cho mỗi sản phẩm.
    }, $selectedProducts));

    $orderQuery = "INSERT INTO don_hang (nguoi_dung_id, tong_tien, trang_thai) VALUES (?, ?, 'cho_xu_ly')";
    // Truy vấn để thêm thông tin đơn hàng vào bảng `don_hang` với trạng thái "chờ xử lý".
    $stmt = $conn->prepare($orderQuery); // Chuẩn bị truy vấn SQL để tránh lỗi SQL injection.
    $stmt->bind_param('id', $userId, $totalAmount); // Gắn giá trị cho các tham số của truy vấn.
    $stmt->execute(); // Thực thi truy vấn.
    $orderId = $stmt->insert_id; // Lấy ID của đơn hàng vừa tạo.

    foreach ($selectedProducts as $product) { // Duyệt qua từng sản phẩm đã chọn.
        $detailQuery = "INSERT INTO chi_tiet_don_hang (don_hang_id, san_pham_id, so_luong, gia_ban) VALUES (?, ?, ?, ?)";
        // Truy vấn để thêm chi tiết đơn hàng vào bảng `chi_tiet_don_hang`.
        $stmt = $conn->prepare($detailQuery); // Chuẩn bị truy vấn SQL.
        $stmt->bind_param('iiid', $orderId, $product['id'], $product['quantity'], $product['price']); // Gắn giá trị cho các tham số.
        $stmt->execute(); // Thực thi truy vấn.

        $updateProductQuery = "UPDATE san_pham SET so_luong_ton = so_luong_ton - ? WHERE id = ?";
        // Truy vấn để cập nhật số lượng sản phẩm còn lại trong kho.
        $stmt = $conn->prepare($updateProductQuery); // Chuẩn bị truy vấn SQL.
        $stmt->bind_param('ii', $product['quantity'], $product['id']); // Gắn giá trị cho các tham số.
        $stmt->execute(); // Thực thi truy vấn.
    }

    if (!empty($selectedItemIds)) { // Kiểm tra nếu có sản phẩm trong giỏ hàng cần xóa.
        $itemIdsStr = implode(',', array_map('intval', $selectedItemIds)); // Tạo chuỗi các ID sản phẩm đã chọn.
        $deleteCartItemsQuery = "DELETE FROM gio_hang WHERE nguoi_dung_id = ? AND id IN ($itemIdsStr)";
        // Truy vấn để xóa các sản phẩm đã thanh toán khỏi giỏ hàng.
        $stmt = $conn->prepare($deleteCartItemsQuery); // Chuẩn bị truy vấn SQL.
        $stmt->bind_param('i', $userId); // Gắn giá trị cho tham số.
        $stmt->execute(); // Thực thi truy vấn.
    }

    $_SESSION['success_message'] = "Thanh toán thành công! Cảm ơn bạn đã mua hàng."; // Đặt thông báo thành công vào session.
    header("Location: index.php"); // Chuyển hướng người dùng về trang chủ.
    exit(); // Dừng thực thi kịch bản.
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
