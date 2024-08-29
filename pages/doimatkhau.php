<?php
include("../admin/pages/db_connect.php");
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    $user_id = $_SESSION['user_id'];
    $error_messages = ["current_password" => "", "new_password" => "", "confirm_password" => ""];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $message = "Vui lòng nhập đầy đủ thông tin.";
    } else {
        $query = "SELECT mat_khau FROM nguoi_dung WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user || !password_verify($current_password, $user['mat_khau'])) {
            $error_messages["current_password"] = "Mật khẩu hiện tại không đúng.";
        } elseif (strlen($new_password) < 6) {
            $error_messages["new_password"] = "Mật khẩu mới phải có ít nhất 6 ký tự.";
        } elseif ($new_password !== $confirm_password) {
            $error_messages["confirm_password"] = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE nguoi_dung SET mat_khau = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("si", $hashed_password, $user_id);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Đổi mật khẩu thành công!"]);
                exit();
            } else {
                $message = "Có lỗi xảy ra khi đổi mật khẩu. Vui lòng thử lại.";
            }
        }
    }

    echo json_encode(["status" => "error", "messages" => $error_messages]);
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../assets/css/dangnhap.css" />
        <title>Đổi mật khẩu</title>
    </head>
    <body>
        <?php if ($message) : ?>
            <div class="error-message"><?php echo $message; ?></div>
        <?php endif; ?>
        <div align="center">
            <div class="form-container">
                <p class="title">Đổi mật khẩu</p>
                <form id="changePasswordForm" class="form" method="post" action="doimatkhau.php" onsubmit="changePassword(event)">
                    <input type="password" id="current_password" placeholder="Mật khẩu hiện tại" name="current_password" />
                    <div id="currentPasswordError" class="error-message"></div>

                    <input type="password" id="new_password" placeholder="Mật khẩu mới" name="new_password" />
                    <div id="newPasswordError" class="error-message"></div>

                    <input type="password" id="confirm_password" placeholder="Nhập lại mật khẩu mới" name="confirm_password" />
                    <div id="confirmPasswordError" class="error-message"></div>

                    <div id="passwordMessage"></div>
                    <button class="form-btn" type="submit" name="change_password">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
        <script src="../assets/js/doimatkhau.js"></script>
    </body>
    </html>
    <?php
}
?>
