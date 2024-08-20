
<?php
include("../admin/pages/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['Email']);
    $phone = trim($_POST['Phone']);
    $fullname = trim($_POST['Fullname']);
    $address = trim($_POST['Address']);
    $password = trim($_POST['Password']);

    $errors = [];

    // Validate dữ liệu (các validation khác có thể thêm vào)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ.";
    }
    if (!preg_match("/^\d{10}$/", $phone)) {
        $errors[] = "Số điện thoại không hợp lệ.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
    }

    if (empty($errors)) {
        // Thiết lập vai trò mặc định là 'khach_hang'
        $role = 'khach_hang';

        // Thêm người dùng vào cơ sở dữ liệu
        $query = "INSERT INTO nguoi_dung (email, so_dien_thoai, ho_ten, dia_chi, mat_khau, vai_tro) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $email, $phone, $fullname, $address, $password, $role);

        if ($stmt->execute()) {
            echo "Đăng ký thành công!";
        } else {
            echo "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    } else {
        // Hiển thị lỗi
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/dangnhap.css" />
    <script src="../assets/js/dangnhap.js"></script>
    <title>Đăng ký</title>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div align="center" id="id02" class="animate">
        <div class="form-container">
            <p class="title">Tạo tài khoản</p>
            <form class="form" action="dangki.php" method="post">
                <input type="email" id="regEmail" placeholder="Email" name="Email" />
                <div id="emailError" class="error-message"></div>

                <input type="text" id="regPhone" placeholder="Số Điện Thoại" name="Phone" />
                <div id="phoneError" class="error-message"></div>

                <input type="text" id="regFullName" placeholder="Họ và Tên" name="Fullname" />
                <div id="fullnameError" class="error-message"></div>

                <input type="text" id="regAddress" placeholder="Địa chỉ" name="Address" />
         

                <input type="password" id="regPassWord" placeholder="Mật khẩu" name="Password" />
                <div id="passwordError" class="error-message"></div>

                <button class="form-btn" type="submit" >Tạo tài khoản</button>
                <div id="regMessage" class="error-message"></div>
            </form>
            <p class="sign-in-label">
                Đã có tài khoản?<span class="sign-in-link"><a href="javascript:switchToLogin()"> Đăng nhập</a></span>
            </p>
        </div>
    </div>
</body>
</html>
