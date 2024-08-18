<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trạng Thái Đơn Hàng</title>
    <link rel="icon" href="../assets/image/index/logohdeader.webp" />
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/sanpham.css" />
    <link rel="stylesheet" href="../assets/css/trangthai.css" />
</head>

<body>
    <?php include("header.php"); ?>


    <main class="content">
        <section class="order-status">
            <h2>Kiểm Tra Trạng Thái Đơn Hàng</h2>
            <form id="orderStatusForm">
                <label for="orderID">Mã Đơn Hàng:</label>
                <input type="text" id="orderID" name="orderID" placeholder="Nhập mã đơn hàng" required />

                <button type="submit">Kiểm Tra</button>
            </form>

            <div id="orderResult" class="order-result">
                <!-- Kết quả kiểm tra trạng thái đơn hàng sẽ hiển thị ở đây -->
            </div>
        </section>
    </main>

    <?php include("footer.php"); ?>

    <script src="../assets/js/dangnhap.js"></script>
    <script src="../assets/js/orderStatus.js"></script>
</body>

</html>