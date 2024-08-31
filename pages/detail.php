<?php
session_start();
include('../admin/pages/db_connect.php');

// Lấy ID sản phẩm từ URL
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Truy vấn thông tin sản phẩm
    $product_query = "SELECT sp.id, sp.ten_san_pham, sp.mo_ta, sp.hinh_anh, sp.gia, sp.so_luong_ton, lsp.ten_loai 
                      FROM san_pham sp 
                      JOIN san_pham_loai spl ON sp.id = spl.san_pham_id 
                      JOIN loai_san_pham lsp ON spl.loai_san_pham_id = lsp.id 
                      WHERE sp.id = ?";
    $stmt = $conn->prepare($product_query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();
    $product = $product_result->fetch_assoc();

    if (!$product) {
        echo "<h2>Sản phẩm không tồn tại</h2>";
        exit();
    }

    // Lấy các sản phẩm tương tự cùng loại
    $related_products_query = "SELECT sp.id, sp.ten_san_pham, sp.hinh_anh, sp.gia 
                               FROM san_pham sp 
                               JOIN san_pham_loai spl ON sp.id = spl.san_pham_id 
                               WHERE spl.loai_san_pham_id = (SELECT loai_san_pham_id FROM san_pham_loai WHERE san_pham_id = ?) 
                               AND sp.id != ? LIMIT 8";
    $stmt_related = $conn->prepare($related_products_query);
    $stmt_related->bind_param("ii", $product_id, $product_id);
    $stmt_related->execute();
    $related_products_result = $stmt_related->get_result();
} else {
    echo "<h2>ID sản phẩm không hợp lệ</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?= htmlspecialchars($product['ten_san_pham']) ?></title>
    <link rel="stylesheet" href="../assets/css/detail.css">
</head>

<body>
    <?php include("header.php"); ?>

    <main>
        <div class="detail-container">
            <!-- Phần trên: Chi tiết sản phẩm -->
            <div class="detail">
                <div class="detail-image">
                    <img src="../<?= $product['hinh_anh'] ?>" alt="<?= htmlspecialchars($product['ten_san_pham']) ?>">
                </div>
                <div class="detail-info">
                    <h2 class="detail-name"><?= htmlspecialchars($product['ten_san_pham']) ?></h2>
                    <div class="detail-price">
                        <span><?= number_format($product['gia'], 0, ',', '.') ?> ₫</span>
                    </div>
                    <p class="detail-description"><?= nl2br(htmlspecialchars($product['mo_ta'])) ?></p>
                    <div class="detail-actions">
                        <button class="btn-add" id="addToCart" data-product-id="<?= $product['id'] ?>">Thêm vào giỏ hàng</button>
                        <button class="btn-buy" id="buyNow" onclick="window.location.href = 'checkout.php?id=<?= $product['id'] ?>'">Mua</button>
                    </div>
                </div>
            </div>
            <!-- Phần dưới: Sản phẩm tương tự -->
            <div class="similar-products-container">
                <h3>Sản phẩm khác</h3>
                <div class="similar-products-navigation">
                    <button id="prevBtn" class="nav-btn">&#10094;</button>
                    <div class="similar-products" id="similarProducts">
                        <?php while ($related = $related_products_result->fetch_assoc()) { ?>
                            <div class="product-card">
                                <img src="../<?= $related['hinh_anh'] ?>" alt="<?= htmlspecialchars($related['ten_san_pham']) ?>">
                                <h4><?= htmlspecialchars($related['ten_san_pham']) ?></h4>
                                <p><?= number_format($related['gia'], 0, ',', '.') ?> ₫</p>
                                <a href="detail.php?id=<?= $related['id'] ?>" class="btn-detail">Xem chi tiết</a>
                            </div>
                        <?php } ?>
                    </div>
                    <button id="nextBtn" class="nav-btn">&#10095;</button>
                </div>
            </div>
        </div>
    </main>

    <?php include("footer.php"); ?>

    <div id="notification" class="notification" style="display:none;"></div>

    <script src="../assets/js/detail.js"></script>
</body>

</html>