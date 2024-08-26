<?php
// Kết nối đến cơ sở dữ liệu
include('../admin/pages/db_connect.php');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Logic phân trang
$limit = 12;
$thisPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($thisPage - 1) * $limit;

// Logic sắp xếp
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$order_by = "id ASC";
if ($sort == 'price_asc') {
    $order_by = "gia ASC";
} elseif ($sort == 'price_desc') {
    $order_by = "gia DESC";
}

// Truy vấn sản phẩm
$query = "SELECT * FROM san_pham ORDER BY $order_by LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

// Kiểm tra kết quả truy vấn
if ($result->num_rows > 0) {
    $productList = [];
    while ($row = $result->fetch_assoc()) {
        $productList[] = $row;
    }
} else {
    echo "Không có sản phẩm nào.";
}

// Truy vấn sản phẩm nổi bật
$featured_query = "SELECT * FROM san_pham LIMIT 6";
$featured_result = $conn->query($featured_query);

// Kiểm tra kết quả truy vấn sản phẩm nổi bật
if ($featured_result->num_rows > 0) {
    $featuredProducts = [];
    while ($row = $featured_result->fetch_assoc()) {
        $featuredProducts[] = $row;
    }
}

// Đóng kết nối
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../assets/image/z5660085257637_83416c363e7c8c6fd43750ccf58d9015.jpg" />
    <title>Sản Phẩm</title>
    <link rel="stylesheet" href="../assets/css/sanpham.css" />
</head>

<body>
    <?php include("header.php"); ?>

    <div class="breadcrumb">
        <h3>
            <a href="index.php">Trang chủ</a> >
        </h3>
        <h3>
            <a href="sanpham.php">Tất cả sản phẩm</a>
        </h3>
    </div>

    <div class="content">
        <div class="sidebar">
            <div class="featured-products">
                <h2>Sản phẩm nổi bật</h2>
                <ul id="featuredProducts">
                    <?php foreach ($featuredProducts as $featured): ?>
                        <a href="detail.php?id=<?= $featured['id'] ?>" style="text-decoration:none;color:black;">
                            <li>
                                <img src="../<?= $featured['hinh_anh'] ?>" alt="<?= $featured['ten_san_pham'] ?>" />
                                <p><?= $featured['ten_san_pham'] ?></p>
                                <span><?= number_format($featured['gia'], 0, ',', '.') ?> VND</span>
                            </li>
                        </a>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="product-list">
                <div class="header-product-list">
                    <h2 class="product-title">Tất cả sản phẩm</h2>
                    <div class="sort-container">
                        <label for="sort" class="sort-label">Sắp xếp:</label>
                        <select id="sort" class="sort-select" onchange="location = this.value;">
                            <option value="sanpham.php?sort=default" <?= $sort == 'default' ? 'selected' : '' ?>>Mặc định</option> <option value="sanpham.php?sort=price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option> <option value="sanpham.php?sort=price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option> </select> </div> </div>
                            <div class="products">
                <?php if (!empty($productList)): ?>
                    <?php foreach ($productList as $product): ?>
                        <div class="productCard" id="<?= $product['id'] ?>" onclick="redirectToDetail(<?= $product['id'] ?>)">
                            <img src="../<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>" />
                            <p class="name"><?= $product['ten_san_pham'] ?></p>
                            <p class="price"><?= number_format($product['gia'], 0, ',', '.') ?> VND</p>
                            <div class="product-buttons">
                                <button class="btn-cart" onclick="addToCart(event, <?= $product['id'] ?>)"><i class="fa-solid fa-cart-shopping"></i></button>
                                <button class="btn-buy" onclick="redirectToCheckout(event, <?= $product['id'] ?>)">Mua ngay</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có sản phẩm nào.</p>
                <?php endif; ?>
            </div>

            <ul class="listPage">
                <?php
                // Pagination controls
                $count_query = "SELECT COUNT(*) as total FROM san_pham";
                $count_result = $conn->query($count_query);
                $total_products = $count_result->fetch_assoc()['total'];
                $total_pages = ceil($total_products / $limit);

                if ($thisPage > 1) {
                    echo '<li onclick="changePage(' . ($thisPage - 1) . ')">TRƯỚC</li>';
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = $i == $thisPage ? 'class="active"' : '';
                    echo '<li ' . $active . ' onclick="changePage(' . $i . ')">' . $i . '</li>';
                }

                if ($thisPage < $total_pages) {
                    echo '<li onclick="changePage(' . ($thisPage + 1) . ')">SAU</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>

<script src="../assets/js/header.js"></script>

<script>
    function redirectToDetail(productId) {
        window.location.href = 'detail.php?id=' + productId;
    }

    function changePage(page) {
        window.location.href = 'sanpham.php?page=' + page + '&sort=<?= $sort ?>';
    }

    function addToCart(event, productId) {
        event.stopPropagation();
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const product = <?= json_encode($productList) ?>.find((p) => p.id == productId);

        const existingProductIndex = cart.findIndex(
            (item) => item.id === productId
        );
        if (existingProductIndex !== -1) {
            cart[existingProductIndex].count += 1;
        } else {
            cart.push({ ...product, count: 1 });
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        showNotification("Sản phẩm đã được thêm vào giỏ hàng!");
        renderCartItem(); // Thêm dòng này để đảm bảo giỏ hàng được cập nhật sau khi thêm sản phẩm
    }

    function redirectToCheckout(event, productId) {
        event.stopPropagation();
        addToCart(event, productId);
        window.location.href = 'checkout.php';
    }

    function showNotification(message) {
        const notification = document.createElement("div");
        notification.className = "notification";
        notification.innerText = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>
</body>
 </html>
