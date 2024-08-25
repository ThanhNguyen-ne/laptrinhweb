<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="icon"
        href="../assets/image/z5660085257637_83416c363e7c8c6fd43750ccf58d9015.jpg" />
    <title>Thực Phẩm Sanest Foods</title>
    <link rel="icon" href="../assets/image/index/logohdeader.webp" />
    <link rel="stylesheet" href="../assets/css/sanpham.css" />
</head>

<body>
    <?php include("header.php"); ?>

    <script src="../assets/js/dangnhap.js"></script>
    <!-- Content -->
    <div class="breadcrumb">
        <h3>
            <a href="index.php">Trang chủ</a> >
        </h3>
        <h3>
            <a href="sanpham.php">Tất cả sản phẩm</a> >
        </h3>
        <h3>
            <a href="thucphamsanestfood.php">Thực phẩm Sanest Foods</a>
        </h3>
    </div>

    <div class="content">
        <div class="sidebar">
            <div class="featured-products">
                <h2>Sản phẩm nổi bật</h2>
                <ul id="featuredProducts"></ul> <!-- Dùng để load sản phẩm nổi bật từ JavaScript -->
            </div>
        </div>

        <div class="main-content">
            <div class="product-list">
                <div class="header-product-list">
                    <h2 class="product-title">Thực phẩm Sanest Food</h2>
                    <div class="sort-container">
                        <label for="sort" class="sort-label">Sắp xếp:</label>
                        <select id="sort" class="sort-select">
                            <option value="default">Mặc định</option>
                            <option value="price_asc">Giá tăng dần</option>
                            <option value="price_desc">Giá giảm dần</option>
                        </select>
                    </div>
                </div>

                <div class="products">
                    <!-- Danh sách sản phẩm sẽ được hiển thị ở đây -->
                </div>

                <ul class="listPage"></ul>
                <script src="../assets/js/thucpham.js"></script>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-Fo8sP+v+j7U4eG3Bw0n6eH7a3FjU9T2pG2h9RHNO9K4hU+e/Ec1TkM0Kx2BJ2yZq2F9hPZT/r4BlZHt8IzHoHQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../assets/js/header.js"></script>
    <script src="../assets/js/sort.js"></script>
</body>

</html>
