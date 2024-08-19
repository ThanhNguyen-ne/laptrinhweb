<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link
            href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
            rel="stylesheet"
        />
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
                <form action="#">
                    <div class="form-input">
                        <input
                            type="search"
                            placeholder="Tìm kiếm người dùng..."
                        />
                        <button class="search-btn" type="submit">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                </form>
                <input type="checkbox" id="theme-toggle" hidden />
                <label for="theme-toggle" class="theme-toggle"></label>
                <a href="#" class="notif">
                    <i class="bx bx-bell"></i>
                    <span class="count">2</span>
                </a>
                <a href="#" class="profile">
                    <img src="../assets/images/logohdeader.webp" />
                </a>
            </nav>
            <!-- End of Navbar -->

            <main>
                <div class="header">
                    <div class="left">
                        <h1>Quản lí Người dùng</h1>
                        <ul class="breadcrumb">2
                            <li><a href="#">Người dùng</a></li>
                            /
                            <li><a href="#" class="active">Danh sách</a></li>
                        </ul>
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
                                <th>Tên người dùng</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic rows will be inserted here by JS -->
                        </tbody>
                    </table>
                </div>
            </main>
        </div>

        <!-- Add/Edit User Modal -->
        <div class="modal" id="userModal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Thêm Người dùng</h2>
                <form id="userForm">
                    <div class="input-group">
                        <label for="userName">Tên người dùng</label>
                        <input type="text" id="userName" required />
                    </div>
                    <div class="input-group">
                        <label for="userEmail">Email</label>
                        <input type="email" id="userEmail" required />
                    </div>
                    <div class="input-group">
                        <label for="userRole">Chỉnh sửa</label>
                        <select id="userRole" required>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn submit-btn">Lưu</button>
                </form>
            </div>
        </div>

        <script src="../assets/js/users.js"></script>
    </body>
</html>
