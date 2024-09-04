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
$query = "SELECT * FROM san_pham 
          INNER JOIN san_pham_loai ON san_pham.id = san_pham_loai.san_pham_id 
          WHERE san_pham_loai.loai_san_pham_id = 2 AND san_pham.so_luong_ton > 0 
          ORDER BY $order_by 
          LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

// Kiểm tra kết quả truy vấn
$productList = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productList[] = $row;
    }
}

// Truy vấn sản phẩm nổi bật
$featured_query = "SELECT * FROM san_pham WHERE so_luong_ton > 0 LIMIT 6";
$featured_result = $conn->query($featured_query);

// Kiểm tra kết quả truy vấn sản phẩm nổi bật
$featuredProducts = [];
if ($featured_result->num_rows > 0) {
    while ($row = $featured_result->fetch_assoc()) {
        $featuredProducts[] = $row;
    }
}

// Hàm thêm sản phẩm vào giỏ hàng trong cơ sở dữ liệu
function addToCart($productId, $userId, $conn) {
    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    $check_query = "SELECT * FROM gio_hang WHERE san_pham_id = ? AND nguoi_dung_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $productId, $userId);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Nếu đã tồn tại, cập nhật số lượng
        $update_query = "UPDATE gio_hang SET so_luong = so_luong + 1 WHERE san_pham_id = ? AND nguoi_dung_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $productId, $userId);
        $stmt->execute();
    } else {
        // Nếu chưa tồn tại, thêm sản phẩm mới vào giỏ hàng
        $insert_query = "INSERT INTO gio_hang (nguoi_dung_id, san_pham_id, so_luong) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
    }
    $stmt->close();
}

// Kiểm tra yêu cầu thêm sản phẩm vào giỏ hàng
if (isset($_GET['add_to_cart'])) {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng."]);
        exit();
    }

    $productId = (int)$_GET['add_to_cart'];
    $userId = $_SESSION['user_id'];
    addToCart($productId, $userId, $conn);

    echo json_encode(["status" => "success", "message" => "Sản phẩm đã được thêm vào giỏ hàng."]);
    exit();
}

// Đóng kết nối
$conn->close();
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon"
        href="../assets/image/z5660085257637_83416c363e7c8c6fd43750ccf58d9015.jpg">
    <title>Yến Sào Sanvinest Khánh Hòa</title>
    <link rel="stylesheet" href="../assets/css/sanpham.css" />
</head>

<body>
    <?php include("header.php"); ?>

    <div class="breadcrumb">
        <h3>
            <a href="index.php">Trang chủ</a> >
        </h3>
        <h3>
            <a href="sanpham.php">Tất cả sản phẩm</a> >
        </h3>
        <h3>
            <a href="yensaosanestkhanhhoa.php">Yến sào Sanvinest Khánh Hòa</a>
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
                                <span><?= number_format($featured['gia'], 0, ',', '.') ?> ₫</span>
                            </li>
                        </a>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="main-content">
            <div class="product-list">
                <div class="header-product-list">
                    <h2 class="product-title">Yến sào Sanvinest Khánh Hoà</h2>
                    <div class="sort-container">
                        <label for="sort" class="sort-label">Sắp xếp:</label>
                        <select id="sort" class="sort-select" onchange="location = this.value;">
                            <option value="yensaosanestkhanhhoa.php?sort=default" <?= $sort == 'default' ? 'selected' : '' ?>>Mặc định</option>
                            <option value="yensaosanestkhanhhoa.php?sort=price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                            <option value="yensaosanestkhanhhoa.php?sort=price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                        </select>
                    </div>
                </div>

                <div class="products">
                    <?php if (!empty($productList)): ?>
                        <?php foreach ($productList as $product): ?>
                            <div class="productCard" id="<?= $product['id'] ?>" onclick="redirectToDetail(<?= $product['id'] ?>)">
                                <img src="../<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>" />
                                <p class="name"><?= $product['ten_san_pham'] ?></p>
                                <p class="price"><?= number_format($product['gia'], 0, ',', '.') ?> ₫</p>
                                <div class="product-buttons">
                                    <a href="yensaosanviestkhanhhoa.php?add_to_cart=<?= $product['id'] ?>" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i></a>
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
                    $total_products_query = "SELECT COUNT(*) AS total FROM san_pham_loai WHERE loai_san_pham_id = 2";
                    $total_products_result = $conn->query($total_products_query);
                    $total_products = $total_products_result->fetch_assoc()['total'];
                    $total_pages = ceil($total_products / $limit);

                    if ($thisPage > 1) {
                        echo '<li><a href="yensaosanviestkhanhhoa.php?page=' . ($thisPage - 1) . '&sort=' . $sort . '">TRƯỚC</a></li>';
                    }

                    // Page number links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = $i == $thisPage ? 'class="active"' : '';
                        echo '<li ' . $active . '><a href="yensaosanviestkhanhhoa.php?page=' . $i . '&sort=' . $sort . '">' . $i . '</a></li>';
                    }

                    // Next page link
                    if ($thisPage < $total_pages) {
                        echo '<li><a href="yensaosanviestkhanhhoa.php?page=' . ($thisPage + 1) . '&sort=' . $sort . '">SAU</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <script src="../assets/js/header.js"></script>
    <script src="../assets/js/sanpham.js"></script>

    
</body>

</html>
