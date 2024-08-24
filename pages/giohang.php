<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yến Sào Khánh Hòa</title>
    <link rel="icon" href="../assets/image/index/logohdeader.webp" />
    <link rel="stylesheet" href="../assets/css/header.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <link rel="stylesheet" href="../assets/css/sanpham.css" />
    <link rel="stylesheet" href="../assets/css/cart.css" />
</head>

<body>
    <?php include("header.php"); ?>

    <script src="../assets/js/dangnhap.js"></script>

    <main>
        <div class="container">
            <div class="cart-container">
                <div class="cart-header">
                    <div class="header-select">Chọn</div>
                    <div class="header-img">Hình ảnh</div>
                    <div class="header-desc">Tên sản phẩm</div>
                    <div class="header-quantity">Số lượng</div>
                    <div class="header-price">Giá</div>
                    <div class="header-total">Tổng</div>
                    <div class="header-remove">Xóa</div>
                </div>
                <div class="cart-content">
                    <!-- Các sản phẩm trong giỏ hàng sẽ được thêm tại đây -->
                </div>
            </div>
            <div class="cart-summary">
                <div class="product-total">
                    <h2>Tổng giá tiền: <span id="total"></span></h2>
                </div>
                <div class="product-checkout">
                    <a href="checkout.php" class="checkout">Thanh toán</a>
                </div>
                <button class="removeAll" onclick="clearCart()">Xóa giỏ hàng</button>
            </div>
        </div>
    </main>

    <?php include("footer.php"); ?>

    <script src="../assets/js/dangnhap.js"></script>
    <script src="../assets/js/cart.js"></script>
</body>

</html>
