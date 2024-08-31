<?php
// Kết nối đến cơ sở dữ liệu
include('../admin/pages/db_connect.php');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Xử lý yêu cầu thêm sản phẩm vào giỏ hàng
if (isset($_GET['add_to_cart'])) {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng."]);
        exit();
    }

    $productId = (int)$_GET['add_to_cart'];
    $userId = $_SESSION['user_id'];

    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    $check_query = "SELECT * FROM gio_hang WHERE san_pham_id = ? AND nguoi_dung_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $productId, $userId);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        // Cập nhật số lượng nếu sản phẩm đã tồn tại trong giỏ hàng
        $update_query = "UPDATE gio_hang SET so_luong = so_luong + 1 WHERE san_pham_id = ? AND nguoi_dung_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $productId, $userId);
        $stmt->execute();
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        $insert_query = "INSERT INTO gio_hang (nguoi_dung_id, san_pham_id, so_luong) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
    }

    echo json_encode(["status" => "success", "message" => "Sản phẩm đã được thêm vào giỏ hàng."]);
    exit();
}

// Lấy từ khóa tìm kiếm
$search_query = isset($_GET['q']) ? $_GET['q'] : '';

// Logic phân trang
$limit = 12;
$thisPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($thisPage - 1) * $limit;

// Logic sắp xếp
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'price_asc';  // Thay đổi thành 'price_asc' để mặc định sắp xếp theo giá tăng dần
$order_by = "gia ASC";
if ($sort == 'price_asc') {
    $order_by = "gia ASC";
} elseif ($sort == 'price_desc') {
    $order_by = "gia DESC";
}

// Lọc giá
$min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : PHP_INT_MAX;

// Truy vấn sản phẩm
$query = "SELECT * FROM san_pham WHERE ten_san_pham LIKE ? AND gia BETWEEN ? AND ? ORDER BY $order_by LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($query);
$search_param = '%' . $search_query . '%';
$stmt->bind_param("sdd", $search_param, $min_price, $max_price);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra kết quả truy vấn
$productList = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productList[] = $row;
    }
}

// Tính tổng số sản phẩm cho phân trang
$count_query = "SELECT COUNT(*) as total FROM san_pham WHERE ten_san_pham LIKE ? AND gia BETWEEN ? AND ?";
$stmt = $conn->prepare($count_query);
$stmt->bind_param("sdd", $search_param, $min_price, $max_price);
$stmt->execute();
$count_result = $stmt->get_result();
$total_products = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_products / $limit);

// Truy vấn giá sản phẩm cao nhất sau khi lọc
$max_price_query = "SELECT MAX(gia) as max_price FROM san_pham WHERE ten_san_pham LIKE ? AND gia BETWEEN ? AND ?";
$stmt = $conn->prepare($max_price_query);
$stmt->bind_param("sdd", $search_param, $min_price, $max_price);
$stmt->execute();
$max_price_result = $stmt->get_result();
$highest_price = $max_price_result->fetch_assoc()['max_price'];

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/search.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.css">
    <title>Kết quả tìm kiếm</title>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="breadcrumb">
        <h3><a href="index.php">Trang chủ</a> > Kết quả tìm kiếm</h3>
    </div>

    <div class="content">
        <div class="sidebar">
            <h2>Sắp xếp</h2>
            <div class="sort-by-price">
                <form action="search.php" method="get">
                    <input type="hidden" name="q" value="<?= htmlspecialchars($search_query) ?>">
                    <input type="hidden" id="min_price_input" name="min_price" value="<?= $min_price ?>">
                    <input type="hidden" id="max_price_input" name="max_price" value="<?= $max_price ?>">
                    <div class="sort-container">
                        <button type="submit" name="sort" value="price_asc" class="btn-sort <?= $sort == 'price_asc' ? 'active' : ''; ?>">Từ thấp đến cao</button>
                        <button type="submit" name="sort" value="price_desc" class="btn-sort <?= $sort == 'price_desc' ? 'active' : ''; ?>">Từ cao đến thấp</button>
                    </div>
                </form>
            </div>

            <h2>Lọc giá</h2>
            <div class="price-filter">
                <div id="price-slider"></div>
                <div class="price-values">
                    <span id="min_price_display"><?= number_format($min_price, 0, ',', '.'); ?> ₫</span>
                    <span id="max_price_display"><?= number_format($max_price, 0, ',', '.'); ?> ₫</span>
                </div>
                <button id="filterPriceBtn" onclick="filterByPrice()">Áp dụng</button>
            </div>
        </div>

        <div class="main-content">
            <h2 class="product-title">Kết quả tìm kiếm cho: "<?= htmlspecialchars($search_query) ?>"</h2>
            <div class="products">
                <?php if (!empty($productList)): ?>
                    <?php foreach ($productList as $product): ?>
                        <div class="productCard" id="<?= $product['id'] ?>">
                            <img src="../<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>" />
                            <p class="name"><?= $product['ten_san_pham'] ?></p>
                            <p class="price"><?= number_format($product['gia'], 0, ',', '.') ?> ₫</p>
                            <div class="product-buttons">
                                <a href="search.php?add_to_cart=<?= $product['id'] ?>" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i></a>
                                <button class="btn-buy" onclick="window.location.href = 'checkout.php?id=<?= $product['id'] ?>'">Mua ngay</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không tìm thấy sản phẩm nào.</p>
                <?php endif; ?>
            </div>

            <ul class="listPage">
                <?php
                // Liên kết trang trước đó
                if ($thisPage > 1) {
                    echo '<li><a href="search.php?page=' . ($thisPage - 1) . '&q=' . urlencode($search_query) . '&sort=' . $sort . '&min_price=' . $min_price . '&max_price=' . $max_price . '">TRƯỚC</a></li>';
                }

                // Liên kết số trang
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = $i == $thisPage ? 'class="active"' : '';
                    echo '<li ' . $active . '><a href="search.php?page=' . $i . '&q=' . urlencode($search_query) . '&sort=' . $sort . '&min_price=' . $min_price . '&max_price=' . $max_price . '">' . $i . '</a></li>';
                }

                // Liên kết trang tiếp theo
                if ($thisPage < $total_pages) {
                    echo '<li><a href="search.php?page=' . ($thisPage + 1) . '&q=' . urlencode($search_query) . '&sort=' . $sort . '&min_price=' . $min_price . '&max_price=' . $max_price . '">SAU</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <?php include("footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>
    <script src="../assets/js/sanpham.js"></script>
    <script>
        const priceSlider = document.getElementById('price-slider');
        noUiSlider.create(priceSlider, {
            start: [<?= $min_price ?>, <?= $highest_price ?>],
            connect: true,
            range: {
                'min': 0,
                'max': <?= $highest_price ?>
            },
            step: 1000,
            format: {
                to: function(value) {
                    return Math.round(value);
                },
                from: function(value) {
                    return Number(value);
                }
            }
        });

        const minPriceInput = document.getElementById('min_price_input');
        const maxPriceInput = document.getElementById('max_price_input');
        const minPriceDisplay = document.getElementById('min_price_display');
        const maxPriceDisplay = document.getElementById('max_price_display');

        priceSlider.noUiSlider.on('update', function(values, handle) {
            const minPrice = Math.round(values[0]);
            const maxPrice = Math.round(values[1]);

            minPriceInput.value = minPrice;
            maxPriceInput.value = maxPrice;

            minPriceDisplay.textContent = new Intl.NumberFormat('vi-VN').format(minPrice) + ' ₫';
            maxPriceDisplay.textContent = new Intl.NumberFormat('vi-VN').format(maxPrice) + ' ₫';
        });

        function filterByPrice() {
            const minPrice = priceSlider.noUiSlider.get()[0];
            const maxPrice = priceSlider.noUiSlider.get()[1];
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('min_price', minPrice);
            urlParams.set('max_price', maxPrice);
            window.location.search = urlParams.toString();
        }
    </script>
</body>

</html>
