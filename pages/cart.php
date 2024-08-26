<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../assets/css/cart.css" />
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
                    <?php
                    include('../admin/pages/db_connect.php');

                    $total_price = 0;
                    $cart_query = "SELECT gh.id, sp.ten_san_pham, sp.hinh_anh, sp.gia, gh.so_luong 
                                   FROM gio_hang gh
                                   JOIN san_pham sp ON gh.san_pham_id = sp.id
                                   WHERE gh.nguoi_dung_id = ?";  // chỉ lấy dữ liệu của user_id hiện tại
                    $stmt = $conn->prepare($cart_query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $cart_result = $stmt->get_result();

                    if ($cart_result->num_rows > 0) {
                        $stt = 1;
                        while ($row = $cart_result->fetch_assoc()) {
                            $item_total = $row['gia'] * $row['so_luong'];
                            $total_price += $item_total;
                            echo "<div class='cart-item' data-item-id='" . $row['id'] . "'>";
                            echo "<div class='item-stt'>$stt</div>";
                            echo "<div class='item-img'><img src='../" . $row['hinh_anh'] . "' alt='" . $row['ten_san_pham'] . "' /></div>";
                            echo "<div class='item-desc'>" . $row['ten_san_pham'] . "</div>";
                            echo "<div class='item-quantity'>
                                    <button class='quantity-btn' onclick='updateQuantity(" . $row['id'] . ", -1)'>-</button>
                                    <span class='quantity-number'>" . $row['so_luong'] . "</span>
                                    <button class='quantity-btn' onclick='updateQuantity(" . $row['id'] . ", 1)'>+</button>
                                  </div>";
                            echo "<div class='item-price'>" . number_format($row['gia'], 0, ',', '.') . " VND</div>";
                            echo "<div class='item-total'>" . number_format($item_total, 0, ',', '.') . " VND</div>";
                            echo "<div class='item-remove'><button onclick='removeItem(" . $row['id'] . ")'><i class='fa fa-trash'></i></button></div>";
                            echo "</div>";
                            $stt++;
                        }
                    } else {
                        echo "<div class='cart-empty'>
                                <h2>Giỏ hàng của bạn đang trống</h2>
                                <button class='homeBtn' onclick='window.location.href=\"index.php\"'>Về trang chủ</button>
                              </div>";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
            </div>
            <?php if ($cart_result->num_rows > 0) { ?>
            <div class="cart-summary">
                <div class="product-total">
                    <h2>Tổng giá tiền: <span id="total"><?= number_format($total_price, 0, ',', '.') ?> VND</span></h2>
                </div>
                <div class="product-checkout">
                    <a href="checkout.php" class="checkout">Thanh toán</a>
                </div>
                <button class="removeAll" onclick="clearCart()">Xóa giỏ hàng</button>
            </div>
            <?php } ?>
        </div>
    </main>

    <?php include("footer.php"); ?>

    <script src="../assets/js/cart.js"></script>
</body>

</html>
