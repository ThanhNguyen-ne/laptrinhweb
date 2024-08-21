<?php
include("../admin/pages/db_connect.php");
session_start();

$message = "";
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    $message = "Đăng ký thành công!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dangnhap'])) {
    $email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
    $so_dien_thoai = isset($_POST['Phone']) ? trim($_POST['Phone']) : '';
    $mat_khau = trim($_POST['Password']);

    if (!empty($email)) {
        $query = "SELECT * FROM nguoi_dung WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
    } elseif (!empty($so_dien_thoai)) {
        $query = "SELECT * FROM nguoi_dung WHERE so_dien_thoai = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $so_dien_thoai);
    } else {
        echo "<p style='color:red;'>Vui lòng nhập email hoặc số điện thoại.</p>";
        exit();
    }

    if (isset($stmt)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && $mat_khau == $user['mat_khau']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['vai_tro'];

            if ($user['vai_tro'] == 'admin') {
                echo json_encode(["status" => "success", "redirect" => "../admin/pages/store.php"]);
            } elseif ($user['vai_tro'] == 'khach_hang') {
                echo json_encode(["status" => "success", "redirect" => "index.php"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Vai trò người dùng không xác định."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Email hoặc mật khẩu không đúng."]);
        }
    }
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../assets/css/dangnhap.css" />
        <title>Đăng nhập</title>
        <style>
            .success-message {
                background-color: #5fa8d3;
                color: white;
                padding: 10px;
                text-align: center;
                position: fixed;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 100%;
                max-width: 400px;
                border-radius: 5px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                display: none;
            }
        </style>
    </head>
    <body>
        <?php if ($message) : ?>
            <div class="success-message" id="successMessage"><?php echo $message; ?></div>
            <script>
                document.getElementById("successMessage").style.display = "block";
                setTimeout(function() {
                    document.getElementById("successMessage").style.display = "none";
                }, 3000);
            </script>
        <?php endif; ?>

        <div align="center" id="id01">
            <div class="form-container">
                <p class="title">Đăng nhập</p>
                <div class="tab-buttons">
                    <button id="emailTab" class="tab-button active" onclick="switchToEmailLogin()">Email</button>
                    <button id="phoneTab" class="tab-button" onclick="switchToPhoneLogin()">Số Điện Thoại</button>
                </div>
                <form id="loginForm" class="form" method="post" action="dangnhap.php" onsubmit="login(event)">
                    <input id="loginEmail" placeholder="Email" type="email" name="Email" required />
                    <input id="loginPhone" placeholder="Số Điện Thoại" type="text" name="Phone" style="display:none;" />
                    <input id="loginPassword" placeholder="Mật khẩu" type="password" name="Password" required />
                    <div id="loginMessage"></div>
                    <p class="page-link"><span class="page-link-label">Quên mật khẩu?</span></p>
                    <button class="form-btn" type="submit">Đăng nhập</button>
                </form>
                <p class="sign-up-label">
                    Chưa có tài khoản?<span class="sign-up-link"><a href="javascript:switchToSignup()"> Đăng kí</a></span>
                </p>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
