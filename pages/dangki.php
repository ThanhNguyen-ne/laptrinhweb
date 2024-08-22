<?php
include("../admin/pages/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dangki'])) {
    $ho_ten = trim($_POST['Fullname']);
    $email = trim($_POST['Email']);
    $so_dien_thoai = trim($_POST['Phone']);
    $dia_chi = trim($_POST['Address']);
    $mat_khau = password_hash(trim($_POST['Password']), PASSWORD_DEFAULT); // Mã hóa mật khẩu

    $query = "SELECT * FROM nguoi_dung WHERE email = ? OR so_dien_thoai = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $so_dien_thoai);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Email hoặc số điện thoại đã tồn tại."]);
    } else {
        $query = "INSERT INTO nguoi_dung (ho_ten, email, so_dien_thoai, dia_chi, mat_khau, vai_tro) VALUES (?, ?, ?, ?, ?, 'khach_hang')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $ho_ten, $email, $so_dien_thoai, $dia_chi, $mat_khau);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "redirect" => "dangnhap.php?message=success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Đăng ký thất bại. Vui lòng thử lại."]);
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
        <title>Đăng ký</title>
    </head>
    <body>
        <div class="animate" align="center">
            <div class="form-container">
                <p class="title">Tạo tài khoản</p>
                <form id="registerForm" class="form" method="post" action="dangki.php" onsubmit="register(event)">
                    <input type="email" id="regEmail" placeholder="Email" name="Email" required />
                    <div id="emailError" class="error-message"></div>

                    <input type="text" id="regPhone" placeholder="Số Điện Thoại" name="Phone" required />
                    <div id="phoneError" class="error-message"></div>

                    <input type="text" id="regFullName" placeholder="Họ và Tên" name="Fullname" required />
                    <div id="fullnameError" class="error-message"></div>

                    <input type="text" id="regAddress" placeholder="Địa chỉ" name="Address" required />
                    <div id="addressError" class="error-message"></div>

                    <input type="password" id="regPassWord" placeholder="Mật khẩu" name="Password" required />
                    <div id="passwordError" class="error-message"></div>

                    <button class="form-btn" type="submit">Tạo tài khoản</button>
                    <div id="regMessage" class="error-message"></div>
                </form>
                <p class="sign-in-label">
                    Đã có tài khoản?<span class="sign-in-link"><a href="javascript:switchToLogin()"> Đăng nhập</a></span>
                </p>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>
