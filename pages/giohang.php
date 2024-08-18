<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Yến Sào Khánh Hòa</title>
        <link  rel="icon" href="../assets/image/index/logohdeader.webp"/>
        <link rel="stylesheet" href="../assets/css/header.css" />
        <link rel="stylesheet" href="../assets/css/footer.css" />
        <link rel="stylesheet" href="../assets/css/sanpham.css" />
        <link rel="stylesheet" href="../assets/css/cart.css" />
    </head>

    <body>
        <header>
            <div id="main">
                <div class="header_tren">
                    <div class="info">
                        <span><i class="fa-solid fa-phone"></i> Hotline: 0123456789</span>
                        <span><i class="fa-solid fa-location-dot"></i> Địa chỉ: 70 Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh</span>
                    </div>
                    <div class="auth-buttons">
                        <button id="loginBtn" onclick="showLoginModal()">Đăng nhập</button>
                        <button id="signupBtn" onclick="showSignupModal()">Đăng kí</button>
                    </div>

                    <!-- The Modals -->
                    <div id="loginModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('loginModal')">&times;</span>
                            <div id="loginModalBody"></div>
                        </div>
                    </div>

                    <div id="signupModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal('signupModal')">&times;</span>
                            <div id="signupModalBody"></div>
                        </div>
                    </div>
                </div>
                <nav>
                    <div class="header_duoi">
                        <div class="content-header">
                            <a href="index.php">
                                <img src="../assets/image/index/logohdeader.webp" alt="Logo" class="logo" />
                            </a>
                            <ul id="nav">
                                <li><a href="index.php">Trang chủ</a></li>
                                <li>
                                    <a href="sanpham.php"> Sản phẩm</a>
                                    <ul class="subnav">
                                        <li><a href="yensaothiennhiennguyento.php">Yến sào đảo yến thiên nhiên</a></li>
                                        <li><a href="thucphamsanestfood.php">Thực phẩm Sanest Food</a></li>
                                        <li><a href="yensaosanviestkhanhhoa.php">Yến sào Sanvinest Khánh Hoà</a></li>
                                        <li><a href="yensaosanestkhanhhoa.php">Yến sào Sanest</a></li>
                                        <li><a href="tinhchatyensao.php">Tinh chất yến sào</a></li>
                                    </ul>
                                </li>
                                <li><a href="thongtin.php">Thông tin</a></li>
                                <li><a class="cart" href="giohang.php"><i class="fa-solid fa-cart-shopping"></i> Giỏ Hàng</a></li>
                            </ul>
                            <form action="" class="search">
                                <input type="text" class="search-text" placeholder="Tìm kiếm sản phẩm " required />
                                <button class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <script src="../assets/js/dangnhap.js"></script>

        <main>
            <div class="container">
                <div class="cart-container">
                    <div class="cart-header">
                        <div class="header-img">Hình ảnh</div>
                        <div class="header-desc">Tên sản phẩm</div>
                        <div class="header-quantity">Số lượng</div>
                        <div class="header-price">Giá</div>
                        <div class="header-total">Tổng</div>
                        <div class="header-remove">Xóa</div>
                    </div>
                    <div class="cart-content">
                        <!-- Các sản phẩm trong giỏ hàng sẽ được thêm tại đây -->
                    </div>
                </div>
                <div class="cart-summary">
                    <div class="product-total">
                        <h2>Tổng giá tiền: <span id="total"></span></h2>
                    </div>
                    <div class="product-checkout">
                        <a href="#" class="checkout">Thanh toán</a>
                    </div>
                    <button class="removeAll">Xóa giỏ hàng</button>
                </div>
            </div>
        </main>

        <footer>
            <div class="footer-container">
                <div class="footer-section">
                    <h4>LIÊN HỆ</h4>
                    <p>Thông tin sinh viên</p>
                    <p>2251120246 - Nguyễn Võ Thành</p>
                    <p>2251120259 - Nguyễn Quốc Tùng</p>
                    <p>GV hướng dẫn: Mai Thanh Thảo</p>
                </div>
                <div class="footer-section">
                    <h4>DANH MỤC</h4>
                    <ul>
                        <li><a href="index.php">Trang chủ</a></li>
                        <li><a href="sanpham.php">Sản phẩm</a></li>
                        <li>
                            <a href="hotrokhachhang.php">Hỗ trợ khách hàng</a>
                        </li>
                        <li><a href="giohang.php">Kiểm tra đơn hàng</a></li>
                    </ul>
                    <img
                        src="../assets/image/logoSaleNoti.png"
                        alt=""
                        width="150px"
                    />
                </div>

                <div class="footer-section">
                    <h4>KẾT NỐI VỚI YẾN SÀO KHÁNH HÒA</h4>
                    <div class="social-media">
                        <img
                            src="../assets/image/index/yensaokhanhhoa.jpg"
                            alt="Yến sào Khánh Hòa"
                            width="150px"
                        />
                        <a href="#">facebook.com</a>
                    </div>
                </div>
            </div>
        </footer>
        <script src="../assets/js/dangnhap.js"></script>
        <script src="../assets/js/cart.js"></script>
    </body>
</html>
