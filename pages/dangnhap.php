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
    
    $error_messages = ["email" => "", "phone" => "", "password" => ""];
    $user = null;

    if (!empty($email)) {
        $query = "SELECT * FROM nguoi_dung WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
    } elseif (!empty($so_dien_thoai)) {
        $query = "SELECT * FROM nguoi_dung WHERE so_dien_thoai = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $so_dien_thoai);
    } else {
        $error_messages["email"] = "Vui lòng nhập email hoặc số điện thoại.";
    }

    if (!empty($stmt)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            if (!empty($email)) {
                $error_messages["email"] = "Email không tồn tại.";
            } elseif (!empty($so_dien_thoai)) {
                $error_messages["phone"] = "Số điện thoại không tồn tại.";
            }
        } elseif (!password_verify($mat_khau, $user['mat_khau'])) {
            $error_messages["password"] = "Mật khẩu không đúng.";
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['vai_tro'];

            if ($user['vai_tro'] == 'admin') {
                echo json_encode(["status" => "success", "redirect" => "../admin/pages/store.php"]);
            } elseif ($user['vai_tro'] == 'khach_hang') {
                echo json_encode(["status" => "success", "redirect" => "index.php"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Vai trò người dùng không xác định."]);
            }
            exit();
        }
    }

    echo json_encode(["status" => "error", "messages" => $error_messages]);
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

        <div align="center">
            <div class="form-container">
                <p class="title">Đăng nhập</p>
                <div class="tab-buttons">
                    <button id="emailTab" class="tab-button active" onclick="switchToEmailLogin()">Email</button>
                    <button id="phoneTab" class="tab-button" onclick="switchToPhoneLogin()">Số Điện Thoại</button>
                </div>
                <form id="loginForm" class="form" method="post" action="dangnhap.php" onsubmit="login(event)">
                    <input id="loginEmail" placeholder="Email" type="email" name="Email" />
                    <div id="emailError" class="error-message"></div>

                    <input id="loginPhone" placeholder="Số Điện Thoại" type="text" name="Phone" style="display:none;" />
                    <div id="phoneError" class="error-message"></div>

                    <input id="loginPassword" placeholder="Mật khẩu" type="password" name="Password" required />
                    <div id="passwordError" class="error-message"></div>

                    <div id="loginMessage"></div>
                    <a href="quenpass.php" class="page-link" ><span class="page-link-label">Quên mật khẩu?</span></a>
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
