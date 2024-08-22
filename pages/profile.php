<?php
include("../admin/pages/db_connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM nguoi_dung WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $ho_ten = trim($_POST['ho_ten']);
    $email = trim($_POST['email']);
    $so_dien_thoai = trim($_POST['so_dien_thoai']);
    $mat_khau = trim($_POST['mat_khau']);

    $query = "UPDATE nguoi_dung SET ho_ten = ?, email = ?, so_dien_thoai = ?, mat_khau = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $ho_ten, $email, $so_dien_thoai, $mat_khau, $user_id);

    if ($stmt->execute()) {
        $update_success = "Cập nhật thông tin thành công.";
    } else {
        $update_error = "Cập nhật thất bại. Vui lòng thử lại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ sơ của tôi</title>
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
<?php include("header.php"); ?>
<div align="center">
    <div class="form-container">
        <p class="title">Hồ sơ của tôi</p>
        <form id="profileForm" class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input id="ho_ten" name="ho_ten" placeholder="Họ và tên" type="text" value="<?php echo htmlspecialchars($user['ho_ten']); ?>" required>
            <input id="email" name="email" placeholder="Email" type="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <input id="so_dien_thoai" name="so_dien_thoai" placeholder="Số Điện Thoại" type="text" value="<?php echo htmlspecialchars($user['so_dien_thoai']); ?>" required>
            <input id="mat_khau" name="mat_khau" placeholder="Mật khẩu" type="password" value="<?php echo htmlspecialchars($user['mat_khau']); ?>" required>
            <div id="updateMessage"><?php if (isset($update_success)) { echo "<p style='color:green;'>$update_success</p>"; } elseif (isset($update_error)) { echo "<p style='color:red;'>$update_error</p>"; } ?></div>
            <button type="submit" name="update_profile">Cập nhật</button>
        </form>
        <form method="post" action="logout.php" style="margin-top: 20px;">
            <button type="submit" name="logout">Đăng xuất</button>
        </form>
    </div>
</div>
    <?php include("footer.php"); ?>
</body>
</html>
