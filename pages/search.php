<?php
include("../admin/pages/db_connect.php");

$keyword = '';
$sort_order = 'asc';
$min_price = 0;
$max_price = 10000000;
$result = null;

if (isset($_GET['q'])) {
    $keyword = trim($_GET['q']);
    $sort_order = $_GET['sortOrder'] ?? 'asc';
    $min_price = $_GET['min_price'] ?? 0;
    $max_price = $_GET['max_price'] ?? 10000000;

    $query = "SELECT * FROM san_pham WHERE LOWER(ten_san_pham) LIKE LOWER(?) AND gia BETWEEN ? AND ? ORDER BY gia $sort_order";
    $stmt = $conn->prepare($query);
    $searchTerm = '%' . $keyword . '%';
    $stmt->bind_param("sii", $searchTerm, $min_price, $max_price);
    $stmt->execute();
    $result = $stmt->get_result();

    $query_max_price = "SELECT MAX(gia) as max_price FROM san_pham WHERE LOWER(ten_san_pham) LIKE LOWER(?)";
    $stmt_max_price = $conn->prepare($query_max_price);
    $stmt_max_price->bind_param("s", $searchTerm);
    $stmt_max_price->execute();
    $result_max_price = $stmt_max_price->get_result();
    $row_max_price = $result_max_price->fetch_assoc();
    $max_price = $row_max_price['max_price'];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm cho "<?php echo htmlspecialchars($keyword); ?>"</title>
    <link rel="stylesheet" href="../assets/css/search.css">
    <link rel="stylesheet" href="../assets/css/sanpham.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.css">
    <style>
        .noUi-tooltip {
            display: none;
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>
    <main class="search-page">
        <h1 class="search-title">Kết quả tìm kiếm cho "<?php echo htmlspecialchars($keyword); ?>"</h1>
        <div class="search-container">
            <div class="search-filters">
                <form action="search.php" method="get">
                    <input type="hidden" name="q" value="<?php echo htmlspecialchars($keyword); ?>">
                    <input type="hidden" id="min_price_input" name="min_price" value="<?= $min_price ?>">
                    <input type="hidden" id="max_price_input" name="max_price" value="<?= $max_price ?>">

                    <div class="sort-by-price">
                        <label for="sortOrder">Sắp xếp giá:</label>
                        <div>
                            <button type="submit" name="sortOrder" value="asc" class="btn-sort <?= $sort_order == 'asc' ? 'active' : ''; ?>">Từ thấp đến cao</button>
                            <button type="submit" name="sortOrder" value="desc" class="btn-sort <?= $sort_order == 'desc' ? 'active' : ''; ?>">Từ cao đến thấp</button>
                        </div>
                    </div>

                    <div class="price-range">
                        <label for="priceRange">Khoảng giá:</label>
                        <div id="price-slider"></div>
                        <div class="price-values">
                            <span id="min_price_display"><?= number_format($min_price, 0, ',', '.'); ?> ₫</span>
                            <span id="max_price_display"><?= number_format($max_price, 0, ',', '.'); ?> ₫</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-filter">Áp dụng</button>
                </form>
            </div>

            <div class="search-results">
                <?php if ($result && $result->num_rows > 0) : ?>
                    <div class="products">
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <div class="productCard" id="<?= $row['id'] ?>">
                                <img src="../<?= $row['hinh_anh'] ?>" alt="<?= htmlspecialchars($row['ten_san_pham']); ?>" />
                                <p class="name"><?= htmlspecialchars($row['ten_san_pham']); ?></p>
                                <p class="price"><?= number_format($row['gia'], 0, ',', '.'); ?> ₫</p>
                                <div class="product-buttons">
                                    <a href="sanpham.php?add_to_cart=<?= $row['id'] ?>" class="btn-cart"><i class="fa-solid fa-cart-shopping"></i></a>
                                    <button class="btn-buy" onclick="window.location.href = 'checkout.php?id=<?= $row['id'] ?>'">Mua ngay</button>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else : ?>
                    <p class="no-results">Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?php echo htmlspecialchars($keyword); ?>"</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
    
    <?php include("footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.6.0/nouislider.min.js"></script>
    <script>
        const priceSlider = document.getElementById('price-slider');
        noUiSlider.create(priceSlider, {
            start: [<?= $min_price ?>, <?= $max_price ?>],
            connect: true,
            range: {
                'min': 0,
                'max': <?= $max_price ?>
            },
            step: 1000,
            tooltips: [true, true],
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
    </script>
</body>
</html>
