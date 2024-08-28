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
                    <div class="header-select"><input type="checkbox" id="selectAll"></div>
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
                                   WHERE gh.nguoi_dung_id = ?
                                   ORDER BY gh.id DESC";
                    $stmt = $conn->prepare($cart_query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $cart_result = $stmt->get_result();

                    if ($cart_result->num_rows > 0) {
                        $stt = 1;
                        while ($row = $cart_result->fetch_assoc()) {
                            $item_total = $row['gia'] * $row['so_luong'];
                            echo "<div class='cart-item' data-item-id='" . $row['id'] . "'>";
                            echo "<div class='item-select'><input type='checkbox' class='select-item' data-price='$item_total'></div>";
                            echo "<div class='item-stt'>$stt</div>";
                            echo "<div class='item-img'><img src='../" . $row['hinh_anh'] . "' alt='" . $row['ten_san_pham'] . "' /></div>";
                            echo "<div class='item-desc'>" . $row['ten_san_pham'] . "</div>";
                            echo "<div class='item-quantity'>
                                    <button class='quantity-btn' onclick='updateQuantity(" . $row['id'] . ", -1)'>-</button>
                                    <span class='quantity-number'>" . $row['so_luong'] . "</span>
                                    <button class='quantity-btn' onclick='updateQuantity(" . $row['id'] . ", 1)'>+</button>
                                  </div>";
                            echo "<div class='item-price'>" . number_format($row['gia'], 0, ',', '.') . " ₫</div>";
                            echo "<div class='item-total'>" . number_format($item_total, 0, ',', '.') . " ₫</div>";
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
            <div class="cart-summary" style="display:none;">
                <div class="product-total">
                    <h2>Tổng giá tiền: <span id="total">0 ₫</span></h2>
                </div>
                <!-- Form gửi dữ liệu giỏ hàng đến checkout.php -->
                <form id="cartForm" method="POST" action="checkout2.php">
                    <input type="hidden" name="cart_items" id="cartItemsInput">
                    <!-- Nút thanh toán -->
                    <div class="product-checkout">
                        <button type="submit" class="checkout">Thanh toán</button>
                        <button class="removeAll" type="button" onclick="clearCart()">Xóa giỏ hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include("footer.php"); ?>

    <script src="../assets/js/cart.js"></script>
    <script>
document.querySelector(".checkout").addEventListener("click", function() {
    const selectedItems = [];
    document.querySelectorAll('.select-item:checked').forEach(item => {
        const cartItem = item.closest('.cart-item');
        const itemId = cartItem.getAttribute('data-item-id');
        const quantity = cartItem.querySelector('.quantity-number').textContent.trim();
        const price = cartItem.querySelector('.item-price').textContent.trim().replace(/[₫,.]/g, '');
        const productName = cartItem.querySelector('.item-desc').textContent.trim();
        const productImage = cartItem.querySelector('.item-img img').getAttribute('src');

        selectedItems.push({
            id: itemId,
            quantity: parseInt(quantity),
            price: parseInt(price),
            name: productName,
            image: productImage
        });
    });

    if (selectedItems.length > 0) {
        document.getElementById('cartItemsInput').value = JSON.stringify(selectedItems);
    } else {
        alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
        return false;
    }
});
</script>
</body>

</html>
