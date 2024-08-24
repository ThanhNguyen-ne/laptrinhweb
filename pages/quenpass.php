<?php
// Kết nối cơ sở dữ liệu
include("../admin/pages/db_connect.php");

$thongbao = "";
if (isset($_POST['btn1'])) {
    // Lấy email từ form và loại bỏ các thẻ HTML
    $email = trim(strip_tags($_POST['email']));

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $thongbao .= "Email không hợp lệ <br>";
    } else {
        // Kiểm tra email trong cơ sở dữ liệu
        $sql = "SELECT COUNT(*) FROM nguoi_dung WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email); // Sử dụng bind_param thay vì bind value trực tiếp để bảo mật hơn
        $stmt->execute();
        $stmt->bind_result($row);
        $stmt->fetch();
        $stmt->close();

        if ($row == 0) {
            $thongbao .= "Email này không phải là thành viên <br>";
        } else {
            // Tạo mật khẩu mới ngẫu nhiên
            $pass_moi = substr(md5(rand(0, 9999)), 0, 8);

            // Cập nhật mật khẩu mới trong cơ sở dữ liệu
            $sql = "UPDATE nguoi_dung SET mat_khau = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($pass_moi, PASSWORD_DEFAULT); // Mã hóa mật khẩu mới
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
    $mail->SMTPDebug = 0; // Tắt debug
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'nguyenvothanh20044@gmail.com'; // Đảm bảo là email đúng
    $mail->Password = 'wpfpjrlsbbizpjwg'; // Mật khẩu ứng dụng của bạn
    $mail->SMTPSecure = 'ssl'; // Hoặc 'tls'
    $mail->Port = 465; // Hoặc 587 cho 'tls'
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
    $thongbao .= "Đã gửi mail thành công<br>";
} catch (Exception $e) {
    $thongbao .= "Lỗi khi gửi thư: " . $mail->ErrorInfo . "<br>";
}
            } else {
                $thongbao .= "Cập nhật mật khẩu không thành công<br>";
            }
        }
    }

    if (!empty($thongbao)) {
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<div class="col-8 m-auto">';
        echo '<div class="alert alert-danger mt-5 text-center">';
        echo $thongbao;
        echo '<button class="btn btn-primary" onclick="history.back()">Trở lại</button>';
        echo '<a href="index.php" class="btn btn-info">Trang chủ</a>';
        echo '</div>';
        echo '</div>';
        exit();
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
    <?php include("footer.php"); ?>
</body>
</html>
