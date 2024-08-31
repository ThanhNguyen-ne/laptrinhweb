<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/store.css" />
    <title>Cửa hàng</title>
</head>

<body>
    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar">
            <i class="bx bx-menu"></i>
            <form id="searchForm">
    <div class="form-input">
        <input type="search" id="searchInput" placeholder="Tìm kiếm sản phẩm..." />
        <button class="search-btn" type="submit">
            <i class="bx bx-search"></i>
        </button>
    </div>
</form>
            <input type="checkbox" id="theme-toggle" hidden />
            <label for="theme-toggle" class="theme-toggle"></label>
           
            <a href="#" class="profile">
                <img src="/assets/image/index/logohdeader.webp" />
            </a>
        </nav>
        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Quản lí Cửa hàng</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Cửa hàng</a></li>
                        /
                        <li><a href="#" class="active">Sản phẩm</a></li>
                    </ul>
                </div>
                <a href="#" class="btn add-product-btn">
                    <i class="bx bx-plus"></i>
                    <span>Thêm Sản phẩm</span>
                </a>
            </div>

            <!-- Product Table -->
            <div class="product-table">
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Loại sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Chỉnh sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu sản phẩm sẽ được hiển thị ở đây qua JavaScript -->
                    </tbody>
                </table>
            </div>
        </main>
        <!-- Add this inside the body, after the main content -->
        <div id="confirmDeleteModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">Xác nhận xóa sản phẩm</div>
                <p>Bạn có chắc chắn muốn xóa sản phẩm này không?</p>
                <div class="modal-actions">
                    <button id="confirmDeleteBtn" class="btn">Xóa</button>
                    <button id="cancelDeleteBtn" class="btn">Không</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Thêm sản phẩm</h2>
            <form id="productForm" enctype="multipart/form-data">
                <div class="input-group">
                    <label for="productImage">Hình ảnh</label>
                    <input type="file" id="productImage" accept="image/*" name="productImage" />
                </div>
                <div class="input-group">
                    <label for="productName">Tên sản phẩm</label>
                    <input type="text" id="productName" name="productName" required />
                </div>
                <div class="input-group">
                    <label for="productDescription">Mô tả</label>
                    <textarea id="productDescription" name="productDescription" required></textarea>
                </div>
                <div class="input-group">
                    <label for="productType">Loại sản phẩm</label>
                    <select id="productType" name="productType" required>
                        <!-- Loại sản phẩm sẽ được nạp vào từ JavaScript -->
                    </select>
                </div>
                <div class="input-group">
                    <label for="productPrice">Giá</label>
                    <input type="number" id="productPrice" name="productPrice" required />
                </div>
                <div class="input-group">
                    <label for="productQuantity">Số lượng</label>
                    <input type="number" id="productQuantity" name="productQuantity" required />
                </div>

                <button type="submit" class="btn submit-btn">Lưu</button>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

    <script src="../assets/js/store.js"></script>
</body>

</html>