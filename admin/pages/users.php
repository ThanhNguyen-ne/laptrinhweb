<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/users.css" />
        <title>Người dùng</title>
    </head>

    <body>
        <!-- Sidebar -->
        <?php include("sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Main Content -->
        <div class="content">
            <!-- Navbar -->
            <nav>
                <i class="bx bx-menu"></i>
                <form id="SearchForm" method="GET">
                    <div class="form-input">
                        <input
                            type="search"
                            name="search"
                            placeholder="Tìm kiếm người dùng..."
                        />
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
                        <h1>NGƯỜI DÙNG</h1>
                    </div>
                    <a href="#" class="btn add-user-btn">
                        <i class="bx bx-plus"></i>
                        <span>Thêm Người dùng</span>
                    </a>
                </div>

                <!-- User Table -->
                <div class="user-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên người dùng</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Mật khẩu</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu người dùng sẽ được hiển thị ở đây qua JavaScript -->
                        </tbody>
                    </table>
                </div>
            </main>
        </div>

        <!-- Add/Edit User Modal -->
        <div class="modal" id="userModal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>THÊM NGƯỜI DÙNG</h2>
                <form id="userForm">
                    <div class="input-group">
                        <label for="userFullName">Họ và Tên</label>
                        <input type="text" id="userFullName" name="userFullName" required />
                    </div>
                    <div class="input-group">
                        <label for="userPhone">Số Điện Thoại</label>
                        <input type="text" id="userPhone" name="userPhone" required />
                    </div>
                    <div class="input-group">
                        <label for="userEmail">Email</label>
                        <input type="email" id="userEmail" name="userEmail" required />
                    </div>
                    <div class="input-group">
                        <label for="userAddress">Địa Chỉ</label>
                        <input type="text" id="userAddress" name="userAddress" required />
                    </div>
                    <div class="input-group">
                        <label for="userPassword">Mật khẩu</label>
                        <input type="password" id="userPassword" name="userPassword" required />
                    </div>
                    <div class="input-group">
                        <label for="userRole">Vai trò</label>
                        <select id="userRole" name="userRole" required>
                            <option value="Admin">Admin</option>
                            <option value="khach_hang">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn submit-btn">Lưu</button>
                </form>
            </div>
        </div>

        <!-- PIN Verification Modal -->
        <div class="modal" id="pinModal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Xác thực Mã PIN</h2>
                <form id="pinForm">
                    <div class="input-group">
                        <label for="pinInput">Nhập Mã PIN</label>
                        <input type="password" id="pinInput" name="pinInput" required maxlength="4" />
                    </div>
                    <button type="submit" class="btn submit-btn">Xác nhận</button>
                </form>
                <p id="pinError" class="error"></p>
            </div>
        </div>

        <script src="../assets/js/users.js"></script>
    </body>
</html>
