<?php
// Kết nối cơ sở dữ liệu
include("../admin/pages/db_connect.php");

// Lấy userId từ session
session_start();
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!$userId) {
    echo "Bạn cần đăng nhập để xem giỏ hàng.";
    exit();
}

// Hàm để lấy giỏ hàng của người dùng
function getCart($conn, $userId) {
    $sql = "SELECT c.id, p.ten_san_pham, p.gia, p.hinh_anh, c.quantity 
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Lỗi truy vấn: " . $conn->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $cart;
}

// Hàm để thêm sản phẩm vào giỏ hàng
function addToCart($conn, $userId, $productId, $quantity) {
    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    $sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Lỗi truy vấn: " . $conn->error);
    }
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Nếu sản phẩm đã có, cập nhật số lượng
        $row = $result->fetch_assoc();
        $newQuantity = $row['quantity'] + $quantity;
        $updateSql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        if ($updateStmt === false) {
            die("Lỗi truy vấn: " . $conn->error);
        }
        $updateStmt->bind_param("ii", $newQuantity, $row['id']);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Nếu sản phẩm chưa có, thêm mới
        $insertSql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        if ($insertStmt === false) {
            die("Lỗi truy vấn: " . $conn->error);
        }
        $insertStmt->bind_param("iii", $userId, $productId, $quantity);
        $insertStmt->execute();
        $insertStmt->close();
    }
    $stmt->close();
}

// Hàm để xóa sản phẩm khỏi giỏ hàng
function removeFromCart($conn, $userId, $productId) {
    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Lỗi truy vấn: " . $conn->error);
    }
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $stmt->close();
}

// Kiểm tra các hành động từ người dùng (thêm, xóa)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        addToCart($conn, $userId, $productId, $quantity);
    } elseif (isset($_POST['action']) && $_POST['action'] === 'remove_from_cart') {
        $productId = $_POST['product_id'];
        removeFromCart($conn, $userId, $productId);
    }
}

// Lấy giỏ hàng của người dùng
$cart = getCart($conn, $userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yến Sào Khánh Hòa</title>
    <link rel="icon" href="../assets/image/index/logohdeader.webp">
    <link rel="stylesheet" href="../assets/css/sanpham.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
</head>
<body>
    <?php include("header.php"); ?>
    <main>
        <div class="container">
            <div class="cart-container">
                <div class="cart-header">
                    <div class="header-stt">STT</div>
                    <div class="header-img">Hình ảnh</div>
                    <div class="header-desc">Tên sản phẩm</div>
                    <div class="header-quantity">Số lượng</div>
                    <div class="header-price">Giá</div>
                    <div class="header-total">Tổng</div>
                    <div class="header-remove">Xóa</div>
                </div>
                <div class="cart-content">
                    <?php if (count($cart) > 0): ?>
                        <?php 
                        $totalAmount = 0;
                        foreach ($cart as $index => $item): 
                            $totalPrice = $item['gia'] * $item['quantity'];
                            $totalAmount += $totalPrice;
                        ?>
                        <hr>
                        <div class="cart-part">
                            <div class="cart-serial"><?= $index + 1 ?></div>
                            <div class="cart-img">
                                <img src="../<?= $item['hinh_anh'] ?>" alt="<?= $item['ten_san_pham'] ?>" />
                            </div>
                            <div class="cart-desc">
                                <p><?= $item['ten_san_pham'] ?></p>
                            </div>
                            <div class="cart-quantity">
                                <span><?= $item['quantity'] ?></span>
                            </div>
                            <div class="cart-price">
                                <h4><?= number_format($item['gia'], 0, ',', '.') ?> ₫</h4>
                            </div>
                            <div class="cart-total"><h4><?= number_format($totalPrice, 0, ',', '.') ?> ₫</h4></div>
                            <div class="cart-remove">
                                <form method="post">
                                    <input type="hidden" name="action" value="remove_from_cart">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    <button type="submit"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="cart-empty">
                            <h2>Giỏ hàng trống</h2>
                            <a href="index.php">
                                <button class="homeBtn">Trở về trang chủ</button>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="cart-summary">
                <div class="product-total">
                    <h2>Tổng giá tiền: <span id="total"><?= number_format($totalAmount, 0, ',', '.') ?> ₫</span></h2>
                </div>
                <div class="product-checkout">
                    <a href="checkout.php" class="checkout">Thanh toán</a>
                </div>
                <form method="post">
                    <button type="submit" name="action" value="clear_cart" class="removeAll">Xóa giỏ hàng</button>
                </form>
            </div>
        </div>
    </main>
    <?php include("footer.php"); ?>
</body>
</html>
