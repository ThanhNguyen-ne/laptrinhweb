<?php
// include("../admin/pages/db_connect.php");

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dangki'])) {
//     $ho_ten = trim($_POST['ho_ten']);
//     $email = trim($_POST['email']);
//     $so_dien_thoai = trim($_POST['so_dien_thoai']);
//     $mat_khau = trim($_POST['mat_khau']);

//     // Kiểm tra xem người dùng đã tồn tại hay chưa
//     $query = "SELECT * FROM nguoi_dung WHERE email = ? OR so_dien_thoai = ?";
//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("ss", $email, $so_dien_thoai);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $register_error = "Email hoặc số điện thoại đã tồn tại.";
//     } else {
//         // Chèn người dùng mới vào cơ sở dữ liệu
//         $query = "INSERT INTO nguoi_dung (ho_ten, email, so_dien_thoai, mat_khau, vai_tro) VALUES (?, ?, ?, ?, 'khach_hang')";
//         $stmt = $conn->prepare($query);
//         $stmt->bind_param("ssss", $ho_ten, $email, $so_dien_thoai, $mat_khau);

//         if ($stmt->execute()) {
//             header("Location: dangnhap.php");
//             exit();
//         } else {
//             $register_error = "Đăng ký thất bại. Vui lòng thử lại.";
//         }
//     }
// }
include("../admin/pages/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dangki'])) {
    $ho_ten = trim($_POST['ho_ten']);
    $email = trim($_POST['email']);
    $so_dien_thoai = trim($_POST['so_dien_thoai']);
    $mat_khau = trim($_POST['mat_khau']);

    $query = "SELECT * FROM nguoi_dung WHERE email = ? OR so_dien_thoai = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $so_dien_thoai);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email hoặc số điện thoại đã tồn tại.";
    } else {
        $query = "INSERT INTO nguoi_dung (ho_ten, email, so_dien_thoai, mat_khau, vai_tro) VALUES (?, ?, ?, ?, 'khach_hang')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $ho_ten, $email, $so_dien_thoai, $mat_khau);

        if ($stmt->execute()) {
            echo "Đăng ký thành công. Bạn có thể đăng nhập ngay.";
        } else {
            echo "Đăng ký thất bại. Vui lòng thử lại.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="../assets/css/dangnhap.css">
</head>
<body>
    <div align="center" id="id01" class="animate">
        <div class="form-container">
            <p class="title">Đăng ký</p>
            <form id="registerForm" class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input class="regiregi" id="ho_ten" name="ho_ten" placeholder="Họ và tên" type="text" required>
                <div id="fullnameError" class="error-message"></div>
                <input class="regiregi" id="email" name="email" placeholder="Email" type="email" required>
                <div id="emailError" class="error-message"></div>
                <input class="regiregi" id="so_dien_thoai" name="so_dien_thoai" placeholder="Số Điện Thoại" type="text" required>
                <div id="phoneError" class="error-message"></div>
                <input class="regiregi" id="mat_khau" name="mat_khau" placeholder="Mật khẩu" type="password" required>
                <div id="passwordError" class="error-message"></div>
                <div id="registerMessage"><?php if (isset($register_error)) { echo "<p style='color:red;'>$register_error</p>"; } ?></div>
                <button class="form-btn" type="submit" name="dangki">Đăng ký</button>
            </form>
            <p class="page-link"><span class="page-link-label">Đã có tài khoản?</span> <a href="login.php">Đăng nhập ngay!</a></p>
        </div>
    </div>
</body>
</html>
