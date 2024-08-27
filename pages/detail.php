<?php
include('../admin/pages/db_connect.php');

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$loai_san_pham_id = 0;

if ($product_id > 0) {
    $query = "SELECT sp.*, lsp.ten_loai FROM san_pham sp
              JOIN san_pham_loai spl ON sp.id = spl.san_pham_id
              JOIN loai_san_pham lsp ON spl.loai_san_pham_id = lsp.id
              WHERE sp.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $loai_san_pham_id = $product['id'];
    } else {
        echo "Sản phẩm không tồn tại.";
        exit();
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
    exit();
}

// Lấy danh sách các sản phẩm cùng loại
$query_similar = "SELECT sp.* FROM san_pham sp
                  JOIN san_pham_loai spl ON sp.id = spl.san_pham_id
                  WHERE spl.loai_san_pham_id = ? AND sp.id != ?";
$stmt_similar = $conn->prepare($query_similar);
$stmt_similar->bind_param("ii", $loai_san_pham_id, $product_id);
$stmt_similar->execute();
$result_similar = $stmt_similar->get_result();
$similar_products = $result_similar->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$stmt_similar->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="../assets/css/detail.css" />
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
                <img src="<?= $product['hinh_anh'] ?>" alt="<?= $product['ten_san_pham'] ?>" />
            </div>
            <div class="detail9-info">
                <div class="detail9-name"><?= $product['ten_san_pham'] ?></div>
                <div class="detail9-price"><?= number_format($product['gia'], 0, ',', '.') ?> ₫</div>
                <div class="detail9-description"><?= $product['mo_ta'] ?></div>
                <div class="detail9-actions">
                    <button class="btn-add" onclick="addToCart(<?= $product_id ?>)">Thêm vào giỏ hàng</button>
                    <button class="btn-buy" onclick="redirectToCheckout()">Mua ngay</button>
                </div>
            </div>
        </div>
    </div>

    <div class="similar-products-container">
        <h3>Sản phẩm cùng loại</h3>
        <div class="similar-products-navigation">
            <button class="nav-btn" id="prev-btn">← Trước</button>
            <button class="nav-btn" id="next-btn">Tiếp →</button>
        </div>
        <div class="similar-products" id="carousel">
            <?php foreach ($similar_products as $similar): ?>
                <div class="product-card">
                    <img src="<?= $similar['hinh_anh'] ?>" alt="<?= $similar['ten_san_pham'] ?>" />
                    <h4><?= $similar['ten_san_pham'] ?></h4>
                    <p><?= number_format($similar['gia'], 0, ',', '.') ?> ₫</p>
                    <a href="detail.php?id=<?= $similar['id'] ?>" class="btn-detail">Chi tiết</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include("footer.php"); ?>
    <script src="../assets/js/detail.js"></script>
</body>
</html>
