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
$query = "SELECT * FROM san_pham WHERE so_luong_ton > 0 ORDER BY $order_by LIMIT $limit OFFSET $offset";
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
$featured_query = "SELECT * FROM san_pham WHERE so_luong_ton > 0 LIMIT 6";
$featured_result = $conn->query($featured_query);

// Kiểm tra kết quả truy vấn sản phẩm nổi bật
if ($featured_result->num_rows > 0) {
    $featuredProducts = [];
    while ($row = $featured_result->fetch_assoc()) {
        $featuredProducts[] = $row;
    }
}

// Hàm thêm sản phẩm vào giỏ hàng trong cơ sở dữ liệu
function addToCart($productId, $userId, $conn)
{
    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    $check_query = "SELECT * FROM gio_hang WHERE san_pham_id = $productId AND nguoi_dung_id = $userId";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Nếu đã tồn tại, cập nhật số lượng
        $update_query = "UPDATE gio_hang SET so_luong = so_luong + 1 WHERE san_pham_id = $productId AND nguoi_dung_id = $userId";
        if ($conn->query($update_query) === TRUE) {
            error_log("Cập nhật giỏ hàng thành công: sản phẩm ID $productId, người dùng ID $userId");
        } else {
            error_log("Lỗi cập nhật giỏ hàng: " . $conn->error);
        }
    } else {
        // Nếu chưa tồn tại, thêm sản phẩm mới vào giỏ hàng
        $insert_query = "INSERT INTO gio_hang (nguoi_dung_id, san_pham_id, so_luong) VALUES ($userId, $productId, 1)";
        if ($conn->query($insert_query) === TRUE) {
            error_log("Thêm sản phẩm vào giỏ hàng thành công: sản phẩm ID $productId, người dùng ID $userId");
        } else {
            error_log("Lỗi thêm sản phẩm vào giỏ hàng: " . $conn->error);
        }
    }
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
                    <h2 class="product-title">Tất cả sản phẩm</h2>
                    <div class="sort-container">
                        <label for="sort" class="sort-label">Sắp xếp:</label>
                        <select id="sort" class="sort-select" onchange="location = this.value;">
                            <option value="sanpham.php?sort=default" <?= $sort == 'default' ? 'selected' : '' ?>>Mặc định</option>
                            <option value="sanpham.php?sort=price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                            <option value="sanpham.php?sort=price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                        </select>
                    </div>
                </div>
                <div class="products">
                    <?php if (!empty($productList)): ?>
                        <?php foreach ($productList as $product): ?>
                            <div class="productCard" id="<?= $product['id'] ?>">
                                <img src="../<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>" />
                                <p class="name"><?= $product['ten_san_pham'] ?></p>
                                <p class="price"><?= number_format($product['gia'], 0, ',', '.') ?> ₫</p>
                                <div class="product-buttons">
                                    <a href="sanpham.php?add_to_cart=<?= $product['id'] ?>" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i></a>
                                    <!-- Nút Mua Ngay sẽ chuyển hướng tới checkout.php với ID sản phẩm -->
                                    <button class="btn-buy" onclick="window.location.href = 'checkout.php?product_id=<?= $product['id'] ?>'">Mua ngay</button>
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
                    $count_query = "SELECT COUNT(*) as total FROM san_pham WHERE so_luong_ton > 0";
                    $count_result = $conn->query($count_query);
                    $total_products = $count_result->fetch_assoc()['total'];
                    $total_pages = ceil($total_products / $limit);

                    // Previous
                    if ($thisPage > 1) {
                        echo '<li><a href="sanpham.php?page=' . ($thisPage - 1) . '&sort=' . $sort . '">TRƯỚC</a></li>';
                    }

                    // Page number links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = $i == $thisPage ? 'class="active"' : '';
                        echo '<li ' . $active . '><a href="sanpham.php?page=' . $i . '&sort=' . $sort . '">' . $i . '</a></li>';
                    }

                    // Next page link
                    if ($thisPage < $total_pages) {
                        echo '<li><a href="sanpham.php?page=' . ($thisPage + 1) . '&sort=' . $sort . '">SAU</a></li>';
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
