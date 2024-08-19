<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link
            href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
            rel="stylesheet"
        />
        <link rel="stylesheet" href="../assets/css/feedback.css" />
        <title>Phản hồi</title>
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
                            placeholder="Tìm kiếm phản hồi..."
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
                    <span class="count">7</span>
                </a>
                <a href="#" class="profile">
                    <img src="../assets/images/logohdeader.webp" />
                </a>
            </nav>
            <!-- End of Navbar -->

            <main>
                <div class="header">
                    <div class="left">
                        <h1>Phản hồi</h1>
                        <ul class="breadcrumb">
                            <li><a href="#">Phản hồi</a></li>
                            /
                            <li><a href="#" class="active">Tin nhắn</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Feedback Table -->
                <div class="feedback-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Tên người gửi</th>
                                <th>Email</th>
                                <th>Nội dung</th>
                                <th>Thời gian</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic rows will be inserted here by JS -->
                        </tbody>
                    </table>
                </div>
            </main>
        </div>

        <script src="../assets/js/feedback.js"></script>
    </body>
</html>
