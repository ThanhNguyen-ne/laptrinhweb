<?php
// db_connect.php
$servername = "localhost"; // Địa chỉ server
$username = "root"; // Tên người dùng MySQL (mặc định thường là 'root')
$password = ""; // Mật khẩu MySQL (thường để trống nếu bạn không đặt)
$dbname = "cua_hang_yen_sao"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
