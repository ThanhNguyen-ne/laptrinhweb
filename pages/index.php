<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang Chủ Yến Sào TT</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="icon" href="../assets/image/index/logohdeader.webp" />
</head>

<body>
    <?php include("header.php"); ?>

    <script src="../assets/js/dangnhap.js"></script>
    <div class="container1">
        <div class="sidebar">
            <h2>DANH MỤC</h2>
            <ul>
                <li>
                    <i class="fa-solid fa-arrow-right"></i><a href="yensaothiennhiennguyento.php">Yến đảo nguyên tổ</a>
                </li>
                <li>
                    <i class="fa-solid fa-arrow-right"></i><a href="tinhchatyensao.php">Yến đảo tinh chế</a>
                </li>
                <li>
                    <i class="fa-solid fa-arrow-right"></i><a href="tinhchatyensao.php">Tinh chất yến sào</a>
                </li>
                <li>
                    <i class="fa-solid fa-arrow-right"></i><a href="yensaosanestkhanhhoa.php">Yến sào Sanest</a>
                </li>
                <li>
                    <i class="fa-solid fa-arrow-right"></i><a href="yensaosanviestkhanhhoa.php">Yến sào Sanvinest</a>
                </li>
                <li>
                    <i class="fa-solid fa-arrow-right"></i><a href="tinhchatyensao.php">Tinh chất Yến sào Sanvinest</a>
                </li>
                <li>
                    <i class="fa-solid fa-arrow-right"></i><a href="thucphamsanestfood.php">Thực phẩm Sanest Foods</a>
                </li>
            </ul>
        </div>
        <div class="slider">
            <div class="slides">
                <div class="slide">
                    <a href="yensaothiennhiennguyento.php"><img src="../assets/image/index/slider_2.jng.jpg" /></a>

                </div>
                <div class="slide">
                    <a href="yensaosanviestkhanhhoa.php"><img src="../assets/image/index/slider2_3.jpg" alt="Slide 2" /></a>
                </div>
                <div class="slide">
                    <a href="thucphamsanestfood.php"><img src="../assets/image/index/slider_3.webp" alt="Slide 2" /></a>
                </div>
            </div>
            <button class="prev" onclick="prevSlide()">&#10094;</button>
            <button class="next" onclick="nextSlide()">&#10095;</button>
        </div>
        <script src="../assets/js/scripts.js"></script>
    </div>

    <div class="sanPhamBanChay">
        <div class="title">
            <h3>SẢN PHẨM BÁN CHẠY</h3>
        </div>
        <div class="san-pham-item">
            <div class="product">
                <a href="detail.php?id=31"><img src="../assets/image/product/yensaonguyento/banner1.jpg" alt="Sản phẩm 1" /></a>
            </div>
            <div class="product">
                <a href="detail.php?id=13">
                    <img src="../assets/image/product/yensaonguyento/banner2.jpg" alt="Sản phẩm 2" /></a>
            </div>
            <div class="product">
                <a href="detail.php?id=6">
                    <img src="../assets/image/product/yensaonguyento/banner3.jpg" alt="Sản phẩm 3" /></a>
            </div>
        </div>
    </div>

    <div class="yennaothiennhien">
        <div class="title-bar">
            <h2 class="tieude">YẾN SÀO THIÊN NHIÊN NGUYÊN TỔ</h2>
        </div>
        <div class="header1">
            <a href="yensaothiennhiennguyento.php">
                <img src="../assets/image/index/owl_col1_subtitle_img.jpg" alt="Yến Sào Khánh Hòa" />
            </a>
        </div>

        <div class="products1">
            <?php
            // Kết nối đến cơ sở dữ liệu
            include("../admin/pages/db_connect.php");

            // Truy vấn lấy các sản phẩm có id từ 1 đến 4
            $sql = "SELECT * FROM san_pham WHERE id BETWEEN 1 AND 4";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='productCard' id='" . $row["id"] . "'>";
                    echo "<img src='../" . $row["hinh_anh"] . "' alt='" . $row["ten_san_pham"] . "' />";
                    echo "<p class='name'>" . $row["ten_san_pham"] . "</p>";
                    echo "<p class='price'>" . number_format($row["gia"], 0, ',', '.') . " ₫</p>";
                    echo "<div class='product-buttons'>";
                    echo "<a href='sanpham.php?add_to_cart=" . $row["id"] . "' class='btn-cart'><i class='fa-solid fa-cart-shopping'></i></a>";
                    echo "<button class='btn-buy' onclick=\"window.location.href = 'checkout.php?id=" . $row["id"] . "'\">Mua ngay</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Không có sản phẩm nào.";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </div>
    </div>

    <div class="thucpham">
        <div class="title-bar">
            <h2 class="tieude">THỰC PHẨM SANEST FOODS</h2>
        </div>
        <div class="header1">
            <a href="thucphamsanestfood.php">
                <img src="../assets/image/index/owl_col3_subtitle_img.jpg" alt="Thực phẩm Sanest Foods" />
            </a>
        </div>
        <div class="products1">
            <?php
            // Kết nối đến cơ sở dữ liệu
            include("../admin/pages/db_connect.php");

            // Truy vấn lấy các sản phẩm có id từ 1 đến 4
            $sql = "SELECT * FROM san_pham WHERE id BETWEEN 51 AND 54";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='productCard' id='" . $row["id"] . "'>";
                    echo "<img src='../" . $row["hinh_anh"] . "' alt='" . $row["ten_san_pham"] . "' />";
                    echo "<p class='name'>" . $row["ten_san_pham"] . "</p>";
                    echo "<p class='price'>" . number_format($row["gia"], 0, ',', '.') . " ₫</p>";
                    echo "<div class='product-buttons'>";
                    echo "<a href='sanpham.php?add_to_cart=" . $row["id"] . "' class='btn-cart'><i class='fa-solid fa-cart-shopping'></i></a>";
                    echo "<button class='btn-buy' onclick=\"window.location.href = 'checkout.php?id=" . $row["id"] . "'\">Mua ngay</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Không có sản phẩm nào.";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </div>
    </div>

    <div class="yensaosanviest">
        <div class="title-bar">
            <h2 class="tieude">YẾN SÀO SANVIEST KHÁNH HÒA</h2>
        </div>
        <div class="header1">
            <a href="yensaosanviestkhanhhoa.php">
                <img src="../assets/image/index/owl_col4_subtitle_img.webp" alt="Yến Sào Sanviest" />
            </a>
        </div>
        <div class="products1">
            <?php
            // Kết nối đến cơ sở dữ liệu
            include("../admin/pages/db_connect.php");

            // Truy vấn lấy các sản phẩm có id từ 1 đến 4
            $sql = "SELECT * FROM san_pham WHERE id BETWEEN 16 AND 19";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='productCard' id='" . $row["id"] . "'>";
                    echo "<img src='../" . $row["hinh_anh"] . "' alt='" . $row["ten_san_pham"] . "' />";
                    echo "<p class='name'>" . $row["ten_san_pham"] . "</p>";
                    echo "<p class='price'>" . number_format($row["gia"], 0, ',', '.') . " ₫</p>";
                    echo "<div class='product-buttons'>";
                    echo "<a href='sanpham.php?add_to_cart=" . $row["id"] . "' class='btn-cart'><i class='fa-solid fa-cart-shopping'></i></a>";
                    echo "<button class='btn-buy' onclick=\"window.location.href = 'checkout.php?id=" . $row["id"] . "'\">Mua ngay</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Không có sản phẩm nào.";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </div>
    </div>

    <div class="yensaosanest">
        <div class="title-bar">
            <h2 class="tieude">YẾN SÀO SANEST KHÁNH HÒA</h2>
        </div>
        <div class="header1">
            <a href="yensaosanestkhanhhoa.php">
                <img src="../assets/image/index/owl_col3_subtitle_img.jpg" alt="Yến Sào Sanest" />
            </a>
        </div>
        <div class="products1">
            <?php
            // Kết nối đến cơ sở dữ liệu
            include("../admin/pages/db_connect.php");

            // Truy vấn lấy các sản phẩm có id từ 1 đến 4
            $sql = "SELECT * FROM san_pham WHERE id BETWEEN 31 AND 34";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='productCard' id='" . $row["id"] . "'>";
                    echo "<img src='../" . $row["hinh_anh"] . "' alt='" . $row["ten_san_pham"] . "' />";
                    echo "<p class='name'>" . $row["ten_san_pham"] . "</p>";
                    echo "<p class='price'>" . number_format($row["gia"], 0, ',', '.') . " ₫</p>";
                    echo "<div class='product-buttons'>";
                    echo "<a href='sanpham.php?add_to_cart=" . $row["id"] . "' class='btn-cart'><i class='fa-solid fa-cart-shopping'></i></a>";
                    echo "<button class='btn-buy' onclick=\"window.location.href = 'checkout.php?id=" . $row["id"] . "'\">Mua ngay</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Không có sản phẩm nào.";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </div>
    </div>

    <div class="tinhchatyensao">
        <div class="title-bar">
            <h2 class="tieude">TINH CHẤT YẾN SÀO</h2>
        </div>
        <div class="header1">
            <a href="tinhchatyensao.php">
                <img src="../assets/image/index/owl_col5_subtitle_img.webp" alt="Yến Sào Sanest" />
            </a>
        </div>
        <div class="products1">
            <?php
            // Kết nối đến cơ sở dữ liệu
            include("../admin/pages/db_connect.php");

            // Truy vấn lấy các sản phẩm có id từ 1 đến 4
            $sql = "SELECT * FROM san_pham WHERE id BETWEEN 46 AND 49";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='productCard' id='" . $row["id"] . "'>";
                    echo "<img src='../" . $row["hinh_anh"] . "' alt='" . $row["ten_san_pham"] . "' />";
                    echo "<p class='name'>" . $row["ten_san_pham"] . "</p>";
                    echo "<p class='price'>" . number_format($row["gia"], 0, ',', '.') . " ₫</p>";
                    echo "<div class='product-buttons'>";
                    echo "<a href='sanpham.php?add_to_cart=" . $row["id"] . "' class='btn-cart'><i class='fa-solid fa-cart-shopping'></i></a>";
                    echo "<button class='btn-buy' onclick=\"window.location.href = 'checkout.php?id=" . $row["id"] . "'\">Mua ngay</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Không có sản phẩm nào.";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </div>
    </div>



    <?php include("footer.php"); ?>

    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-Fo8sP+v+j7U4eG3Bw0n6eH7a3FjU9T2pG2h9RHNO9K4hU+e/Ec1TkM0Kx2BJ2yZq2F9hPZT/r4BlZHt8IzHoHQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
    <script src="../assets/js/header.js"></script>
    <script src="../assets/js/sanpham.js"></script>

    <div id="notificationBar" class="notification-bar"></div>

    <?php
    if (isset($_SESSION['order_message'])) {
        $message = $_SESSION['order_message'];
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var notificationBar = document.getElementById('notificationBar');
                notificationBar.textContent = '$message';
                notificationBar.style.display = 'block';
                setTimeout(function() {
                    notificationBar.style.display = 'none';
                }, 5000); // Ẩn sau 5 giây
            });
          </script>";
        unset($_SESSION['order_message']);
    }
    ?>
</body>

</html>