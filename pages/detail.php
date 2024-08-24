<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <title>Chi tiết sản phẩm</title>
    <link rel="icon" href="../assets/image/index/logohdeader.webp" />
    <link rel="stylesheet" href="../assets/css/header.css" />
    <link rel="stylesheet" href="../assets/css/footer.css" />
    <link rel="stylesheet" href="../assets/css/detail.css" />
    <link rel="stylesheet" href="../assets/css/sanpham.css" />
</head>

<body>
    <div class="breadcrumb">
        <h3><a href="index.php">Trang chủ</a> > </h3>
        <h3><a href="sanpham.php">Tất cả sản phẩm</a> > </h3>
        <h3><a href="#">Chi tiết sản phẩm</a></h3>
    </div>
    <?php include("header.php"); ?>

    <div class="detail9-container">
        <div class="detail9">
            <div class="detail9-image">
                <img src="" alt="Product Image" />
            </div>
            <div class="detail9-info">
                <div class="detail9-name"></div>
                <div class="detail9-price"></div>
                <div class="detail9-description"></div>
                <div class="detail9-actions">
                    <button class="btn-add">Thêm vào giỏ hàng</button>
                    <button class="btn-buy">Mua ngay</button>
                </div>
            </div>
        </div>
    </div>



    <?php include("footer.php"); ?>

    <script src="../assets/js/detail.js"></script>
</body>

</html>