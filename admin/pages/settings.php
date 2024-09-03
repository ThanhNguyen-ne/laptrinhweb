<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/settings.css" />
    <title>Cài đặt</title>
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
                        placeholder="Tìm kiếm cài đặt..." />
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
                    <h1>CÀI ĐẶT</h1>
                </div>
            </div>

            <!-- Settings Form -->
            <div class="settings-container">
                <!-- Account Settings -->
                <div class="settings-section">
                    <h2>Tài khoản</h2>
                    <form id="accountSettingsForm">
                        <div class="input-group">
                            <label for="username">Tên người dùng</label>
                            <input
                                type="text"
                                id="username"
                                value="admin"
                                required />
                        </div>
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                value="admin@gmail.com"
                                required />
                        </div>
                        <div class="input-group">
                            <label for="password">Mật khẩu mới</label>
                            <input type="password" id="password" />
                        </div>
                        <button type="submit" class="btn save-btn">
                            Lưu thay đổi
                        </button>
                    </form>
                </div>

                <!-- Notification Settings -->
                <div class="settings-section">
                    <h2>Thông báo</h2>
                    <form id="notificationSettingsForm">
                        <div class="input-group">
                            <label for="emailNotif">Thông báo qua email</label>
                            <input
                                type="checkbox"
                                id="emailNotif"
                                checked />
                        </div>
                        <div class="input-group">
                            <label for="smsNotif">Thông báo qua SMS</label>
                            <input type="checkbox" id="smsNotif" />
                        </div>
                        <button type="submit" class="btn save-btn">
                            Lưu thay đổi
                        </button>
                    </form>
                </div>

                <!-- Interface Settings -->
                <div class="settings-section">
                    <h2>Giao diện</h2>
                    <form id="interfaceSettingsForm">
                        <div class="input-group">
                            <label for="theme">Chọn giao diện</label>
                            <select id="theme">
                                <option value="light">Sáng</option>
                                <option value="dark">Tối</option>
                            </select>
                        </div>
                        <button type="submit" class="btn save-btn">
                            Lưu thay đổi
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../assets/js/settings.js"></script>
</body>

</html>