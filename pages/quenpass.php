<?php
// Kết nối cơ sở dữ liệu
include("../admin/pages/db_connect.php");

$thongbao = "";
if (isset($_POST['btnQuenMatKhau'])) {
    // Lấy email từ form và loại bỏ các thẻ HTML
    $email = trim(strip_tags($_POST['email']));

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $thongbao = "Email không hợp lệ";
    } else {
        // Kiểm tra email trong cơ sở dữ liệu
        $sql = "SELECT COUNT(*) FROM nguoi_dung WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($row);
        $stmt->fetch();
        $stmt->close();

        if ($row == 0) {
            $thongbao = "Email này không phải là thành viên";
        } else {
            // Tạo mật khẩu mới ngẫu nhiên
            $pass_moi = substr(md5(rand(0, 9999)), 0, 8);

            // Cập nhật mật khẩu mới trong cơ sở dữ liệu
            $sql = "UPDATE nguoi_dung SET mat_khau = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($pass_moi, PASSWORD_DEFAULT);
            $stmt->bind_param("ss", $hashed_password, $email);
            $result = $stmt->execute();
            $stmt->close();

            if ($result) {
                // Gửi email với mật khẩu mới
                require_once "PHPMailer-master/src/PHPMailer.php";
                require_once "PHPMailer-master/src/Exception.php";
                require_once "PHPMailer-master/src/SMTP.php";

                $mail = new PHPMailer\PHPMailer\PHPMailer(true);

                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = '2251120259@ut.edu.vn'; 
                    $mail->Password = '5846#CN22'; 
                    $mail->SMTPSecure = 'ssl'; 
                    $mail->Port = 465; 
                    $mail->CharSet = "UTF-8";
                    $mail->smtpConnect([
                        "ssl" => [
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                            "allow_self_signed" => true
                        ]
                    ]);

                    $mail->setFrom('your-email@gmail.com', 'Ban quản trị website');
                    $mail->addAddress($email, 'Quý khách');
                    $mail->isHTML(true);
                    $mail->Subject = 'Cấp lại mật khẩu mới';
                    $mail->Body = "Đây là mật khẩu mới của bạn: <b>{$pass_moi}</b>";

                    $mail->send();
                    $thongbao = "Đã gửi mail thành công";
                } catch (Exception $e) {
                    $thongbao = "Lỗi khi gửi thư: " . $mail->ErrorInfo;
                }
            } else {
                $thongbao = "Cập nhật mật khẩu không thành công";
            }
        }
    }
}

echo json_encode(["message" => $thongbao]);
exit();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/dangnhap.css" />
    <title>Quên mật khẩu</title>
</head>

<body>
    <div align="center">
        <div class="form-container">
            <p class="title">Quên mật khẩu</p>
            <form id="quenPassForm" class="form" method="post" action="quenpass.php" onsubmit="quenPass(event)">
                <input id="quenPassEmail" class="input" placeholder="Email" type="email" name="email" required />
                <div id="emailError" class="error-message"></div>
                <div id="quenPassMessage"></div>
                <button class="form-btn" type="submit" name="btnQuenMatKhau">Gửi yêu cầu</button>
            </form>
        </div>
    </div>

    <script>
        function quenPass(event) {
            event.preventDefault();

            let email = document.getElementById("quenPassEmail").value.trim();
            let emailError = document.getElementById("emailError");
            let quenPassMessage = document.getElementById("quenPassMessage");

            emailError.innerText = "";
            quenPassMessage.innerText = "";

            if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                emailError.innerText = "Vui lòng nhập email hợp lệ.";
                return;
            }

            let formData = new FormData();
            formData.append('email', email);
            formData.append('btnQuenMatKhau', true);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "quenpass.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    quenPassMessage.innerText = response.message;
                    showNotification(response.message);
                } else {
                    quenPassMessage.innerText = "Có lỗi xảy ra, vui lòng thử lại.";
                }
            };
            xhr.send(formData);
        }

        function showNotification(message) {
            const notification = document.createElement("div");
            notification.className = "notification";
            notification.innerText = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
    </script>
</body>

</html>
