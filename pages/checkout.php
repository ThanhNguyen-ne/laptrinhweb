<?php
session_start();
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
                <div id="cartItems"></div>
                <div class="checkout-total">
                    Tổng cộng: <span id="totalAmount">0₫</span>
                </div>
            </div>

            <div class="checkout-right">
                <form id="checkoutForm">
                    <div class="checkout-form-group">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="name">
                        <div id="nameError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email">
                        <div id="emailError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" id="address">
                        <div id="addressError" class="checkout-error-message"></div>
                    </div>
                    <div class="checkout-form-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="text" id="phone">
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
