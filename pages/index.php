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
            <div class="product1" id="1" onclick="redirectToDetail(1)">
                <img src="../assets/image/product/yensaonguyento/yskh_024.jpg"
                    alt="Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024" />
                <p class="product-name1">Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024</p>
                <p class="product-price1">37,800,000₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 1)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 1)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="2" onclick="redirectToDetail(2)">
                <img src="../assets/image/product/yensaonguyento/yskh_026.jpg"
                    alt="Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026" />
                <p class="product-name1">Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026</p>
                <p class="product-price1">23,760,000₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 2)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 2)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="3" onclick="redirectToDetail(3)">
                <img src="../assets/image/product/yensaonguyento/_024s.jpg"
                    alt="Yến huyết đảo thiên nhiên Khánh Hòa mẫu hộp quà tặng - 024S" />
                <p class="product-name1">Yến huyết đảo thiên nhiên Khánh Hòa mẫu hộp quà tặng - 024S</p>
                <p class="product-price1">19,170,000₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 3)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 3)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="4" onclick="redirectToDetail(4)">
                <img src="../assets/image/product/yensaonguyento/tp1_9547ae75719143bea6c155e98e1fc816.jpg"
                    alt="Yến sao đảo yến thiên nhiên Khánh Hòa hộp 100G - TP1" />
                <p class="product-name1">Yến sao đảo yến thiên nhiên Khánh Hòa hộp 100G - TP1</p>
                <p class="product-price1">13,500,000₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 4)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 4)">Mua ngay</button>
                </div>
            </div>
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
            <div class="product1" id="51" onclick="redirectToDetail(51)">
                <img src="../assets/image/product/thucpham/hl1k.jpg" alt="Hạt điều lạt hộp 1KG" />
                <p class="product-name1">Hạt điều lạt hộp 1KG</p>
                <p class="product-price1">395,700₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 51)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 51)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="52" onclick="redirectToDetail(52)">
                <img src="../assets/image/product/thucpham/hop_dieu_muoi_1000g.jpg" alt="Hạt điều chiên Sanest Foods (muối) hộp 1KG" />
                <p class="product-name1">Hạt điều chiên Sanest Foods (muối) hộp 1KG</p>
                <p class="product-price1">392,800₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 52)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 52)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="53" onclick="redirectToDetail(53)">
                <img src="../assets/image/product/thucpham/hop_dieu_muoi_454g.jpg" alt="Hạt điều chiên Sanest Foods (muối) hộp 454G - MH454" />
                <p class="product-name1">Hạt điều chiên Sanest Foods (muối) hộp 454G - MH454</p>
                <p class="product-price1">184,600₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 53)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 53)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="54" onclick="redirectToDetail(54)">
                <img src="../assets/image/product/thucpham/1_52144ef2d79b4fffa2a5d06e8b90d833.jpg" alt="Hạt điều muối lụa hộp 400G - LM400" />
                <p class="product-name1">Hạt điều muối lụa hộp 400G - LM400</p>
                <p class="product-price1">159,100₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 54)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 54)">Mua ngay</button>
                </div>
            </div>
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
            <div class="product1" id="16" onclick="redirectToDetail(16)">
                <img src="../assets/image/product/yensaonguyento/q150_42b932ad40724f34a9230042878f5122.jpg"
                    alt="Hộp quà tặng Yến sào Nguyên tổ 50g Sanvinest Khánh Hòa Chính hiệu - Q150" />
                <p class="product-name1">Hộp quà tặng Yến sào Nguyên tổ 50g Sanvinest Khánh Hòa Chính hiệu - Q150</p>
                <p class="product-price1">2,308,500₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 16)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 16)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="17" onclick="redirectToDetail(17)">
                <img src="../assets/image/product/sanviest/q160_7e71defed4054c8da70240dada86b807.jpg"
                    alt="Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 100g - Q610" />
                <p class="product-name1">Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 100g - Q610</p>
                <p class="product-price1">6,796,900₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 17)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 17)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="18" onclick="redirectToDetail(18)">
                <img src="../assets/image/product/sanviest/q650_fefa4292fffd46a5988f035460f1f458.jpg"
                    alt="Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 50g - Q650" />
                <p class="product-name1">Hộp quà tặng Yến sào Sanvinest Khánh Hòa Chính hiệu. Tổ Yến sào Tinh chế 50g - Q650</p>
                <p class="product-price1">3,103,650₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 18)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 18)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="19" onclick="redirectToDetail(19)">
                <img src="../assets/image/product/sanviest/2011_c5841feb5c404b46ba9976eb7b039439.jpg"
                    alt="Nước yến sào Khánh Hòa Sanvinest trẻ em lọ 62ml, hộp 1 lọ - 2011" />
                <p class="product-name1">Nước yến sào Khánh Hòa Sanvinest trẻ em lọ 62ml, hộp 1 lọ - 2011</p>
                <p class="product-price1">34,400₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 19)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 19)">Mua ngay</button>
                </div>
            </div>
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
            <div class="product1" id="31" onclick="redirectToDetail(31)">
                <img src="../assets/image/product/sanest/sanest_hop6lo_700_d5d0df7e74c34ad3ae33205677052db9.jpg"
                    alt="Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml, Hộp 6 Lọ - 700H6" />
                <p class="product-name1">Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml, Hộp 6 Lọ - 700H6</p>
                <p class="product-price1">280,800₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 31)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 31)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="32" onclick="redirectToDetail(32)">
                <img src="../assets/image/product/sanest/sanest_lo700.jpg"
                    alt="Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml,lọ(New) - 700" />
                <p class="product-name1">Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml,lọ(New) - 700</p>
                <p class="product-price1">44,200₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 32)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 32)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="33" onclick="redirectToDetail(33)">
                <img src="../assets/image/product/sanest/sanest_lo770.jpg"
                    alt="Nước Yến Sào Khánh Hòa Sanest Collagen 70ml 1 lọ - 770" />
                <p class="product-name1">Nước Yến Sào Khánh Hòa Sanest Collagen 70ml 1 lọ - 770</p>
                <p class="product-price1">35,400₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 33)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 33)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="34" onclick="redirectToDetail(34)">
                <img src="../assets/image/product/sanest/sanest_770hop6lo.jpg"
                    alt="Nước Yến Sào Khánh Hòa Sanest Collagen 70ml hộp 6 lọ - 770H6" />
                <p class="product-name1">Nước Yến Sào Khánh Hòa Sanest Collagen 70ml hộp 6 lọ - 770H6</p>
                <p class="product-price1">218,000₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 34)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 34)">Mua ngay</button>
                </div>
            </div>
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
            <div class="product1" id="31" onclick="redirectToDetail(31)">
                <img src="../assets/image/product/sanest/sanest_hop6lo_700_d5d0df7e74c34ad3ae33205677052db9.jpg"
                    alt="Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml, Hộp 6 Lọ - 700H6" />
                <p class="product-name1">Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml, Hộp 6 Lọ - 700H6</p>
                <p class="product-price1">280,800₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 31)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 31)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="32" onclick="redirectToDetail(32)">
                <img src="../assets/image/product/sanest/sanest_lo700.jpg"
                    alt="Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml,lọ(New) - 700" />
                <p class="product-name1">Nước Yến Sào Khánh Hòa Nhân Sâm Fucoidan 70ml,lọ(New) - 700</p>
                <p class="product-price1">44,200₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 32)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 32)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="33" onclick="redirectToDetail(33)">
                <img src="../assets/image/product/sanest/sanest_lo770.jpg"
                    alt="Nước Yến Sào Khánh Hòa Sanest Collagen 70ml 1 lọ - 770" />
                <p class="product-name1">Nước Yến Sào Khánh Hòa Sanest Collagen 70ml 1 lọ - 770</p>
                <p class="product-price1">35,400₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 33)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 33)">Mua ngay</button>
                </div>
            </div>
            <div class="product1" id="34" onclick="redirectToDetail(34)">
                <img src="../assets/image/product/sanest/sanest_770hop6lo.jpg"
                    alt="Nước Yến Sào Khánh Hòa Sanest Collagen 70ml hộp 6 lọ - 770H6" />
                <p class="product-name1">Nước Yến Sào Khánh Hòa Sanest Collagen 70ml hộp 6 lọ - 770H6</p>
                <p class="product-price1">218,000₫</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(event, 34)">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(event, 34)">Mua ngay</button>
                </div>
            </div>
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
</body>

</html>