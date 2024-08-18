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
        <link rel="icon" href="../assets/image/z5660085257637_83416c363e7c8c6fd43750ccf58d9015.jpg">
        <title>Tinh Chất Yến Sào</title>
        <link  rel="icon" href="../assets/image/index/logohdeader.webp"/>
        <link rel="stylesheet" href="../assets/css/sanpham.css" />
        <link rel="stylesheet" href="../assets/css/header.css">
        <link rel="stylesheet" href="../assets/css/footer.css">

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
        <!-- Content -->
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
                    <h2>Sản phẩm nổi bật</h4>
                    <ul>
                        <a href="detail.php?id=1" style="text-decoration:none;color:black ;" > <li>
                            <img src="../assets/image/product/yensaonguyento/yskh_024.jpg" >
                            <p>
                                Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024
                            </p>
                            <span>37,800,000đ</span>
                        </li></a>
                        <a href="detail.php?id=3" style="text-decoration:none;color:black ;" ><li>
                           <img src="../assets/image/product/yensaonguyento/_024s.jpg" /> 
                                 
                                
                            
                            <p>Yến huyết đảo thiên nhiên Khánh Hòa mẫu hộp quà tặng - 024S</p>
                            <span>19,170,000₫</span>
                        </li></a>
                        <a href="detail.php?id=2" style="text-decoration:none;color:black ;" ><li>
                           <img src="../assets/image/product/yensaonguyento/yskh_026.jpg" />
                                
                               
                            
                            <p>Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026</p>
                            <span>23,760,000₫</span>
                        </li></a>
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <div class="product-list">
                    <div class="header-product-list">
                        <h2 class="product-title">Tinh chất yến sào</h2>
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
                        <a href="detail.php"> </a>
                    </div>

                    <ul class="listPage"></ul>
                    <script src="../assets/js/tinhchat.js"></script>
                </div>

                <div id="productDetails" class="modal1">
                    <div class="modal-content1">
                        <div class="modal-content5">
                            <img id="productImage" src="" alt="Product Image" />
                            <div class="product-info">
                                <p id="productName" class="product-name"></p>
                                <p
                                    id="description"
                                    class="product-description"
                                ></p>
                                <p id="productPrice" class="product-price"></p>
                            </div>
                            <span class="close" onclick="closeProductDetails()"
                                >&times;</span
                            >
                        </div>
                        <div class="add">
                            <button onclick="addToCart()">
                                Thêm vào giỏ hàng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       <footer>
            <div class="footer-container">
                <div class="footer-section">
                    <h4>LIÊN HỆ</h4>
                    <p>Thông tin sinh viên</p>
                    <p>2251120246 - Nguyễn Võ Thành</p>
                    <p>2251120259 - Nguyễn Quốc Tùng</p>
                    <p>GV hướng dẫn : Mai Thanh Thảo</p>
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
        <script src="../assets/js/header.js"></script>
        <script src="../assets/js/sort.js"></script>
    </body>
</html>
