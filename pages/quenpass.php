<?php
// Kết nối cơ sở dữ liệu
include("../admin/pages/db_connect.php");

$thongbao = "";
if (isset($_POST['btn1'])) {
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
                    $mail->Username = 'nguyenvothanh20044@gmail.com'; 
                    $mail->Password = 'wpfpjrlsbbizpjwg'; 
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
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/quenpass.css">
</head>

<body>
    <?php include("header.php"); ?>
    <form action="quenpass.php" method="post" class="col-5 m-auto bg-secondary p-2 text-white">
        <div class="form-group">
            <h4 class="border-bottom pb-2">QUÊN MẬT KHẨU</h4>
            <label for="email">Nhập email</label>
            <input class="form-control" name="email" type="email" required>
        </div>
        <div class="form-group">
            <button type="submit" name="btn1" class="btn btn-primary">Gửi yêu cầu</button>
        </div>
    </form>
   

    <!-- Gọi hàm thông báo nếu có thông báo từ PHP -->
    <script>
        function showNotification(message) {
            const notification = document.createElement("div");
            notification.className = "notification alert alert-info text-center mt-3";
            notification.innerText = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            <?php if (!empty($thongbao)): ?>
                showNotification("<?php echo $thongbao; ?>");
            <?php endif; ?>
        });
    </script>
     <?php include("footer.php"); ?>
</body>
</html>
