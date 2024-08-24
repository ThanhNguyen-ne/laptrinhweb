<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assets/image/z5660085257637_83416c363e7c8c6fd43750ccf58d9015.jpg">
    <title>Yến Sào Sanest Khánh Hòa</title>
    <link rel="icon" href="../assets/image/index/logohdeader.webp" />
    <link rel="stylesheet" href="../assets/css/sanpham.css" />
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
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
            <a href="yensaosanestkhanhhoa.php">Yến sào Sanest Khánh Hòa</a>
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
                    <h2 class="product-title">Yến sào Sanest Khánh Hoà</h2>
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
                <script src="../assets/js/sanest.js"></script>
            </div>

            <div id="productDetails" class="modal1">
                <div class="modal-content1">
                    <div class="modal-content5">
                        <img id="productImage" src="" alt="Product Image" />
                        <div class="product-info">
                            <p id="productName" class="product-name"></p>
                            <p id="description" class="product-description"></p>
                            <p id="productPrice" class="product-price"></p>
                        </div>
                        <span class="close" onclick="closeProductDetails()">&times;</span>
                    </div>
                    <div class="add">
                        <button onclick="addToCart()">Thêm vào giỏ hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="../assets/js/header.js"></script>
    <script src="../assets/js/sort.js"></script>
</body>

</html>
