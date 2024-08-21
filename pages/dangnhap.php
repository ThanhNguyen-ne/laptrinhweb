<?php
// include("../admin/pages/db_connect.php");
// session_start();

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dangnhap'])) {
//     $email = isset($_POST['loginEmail']) ? trim($_POST['loginEmail']) : '';
//     $so_dien_thoai = isset($_POST['loginPhone']) ? trim($_POST['loginPhone']) : '';
//     $mat_khau = trim($_POST['loginPassword']);

//     if (!empty($email)) {
//         $query = "SELECT * FROM nguoi_dung WHERE email = ?";
//         $stmt = $conn->prepare($query);
//         $stmt->bind_param("s", $email);
//     } elseif (!empty($so_dien_thoai)) {
//         $query = "SELECT * FROM nguoi_dung WHERE so_dien_thoai = ?";
//         $stmt = $conn->prepare($query);
//         $stmt->bind_param("s", $so_dien_thoai);
//     } else {
//         $login_error = "Vui lòng nhập email hoặc số điện thoại.";
//     }

//     if (isset($stmt)) {
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $user = $result->fetch_assoc();

//         if ($user && $mat_khau == $user['mat_khau']) {
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['user_role'] = $user['vai_tro'];

//             if ($user['vai_tro'] == 'admin') {
//                 header("Location: ../admin/pages/users.php");
//             } elseif ($user['vai_tro'] == 'khach_hang') {
//                 header("Location: index.php");
//             } else {
//                 echo "Vai trò người dùng không xác định.";
//             }
//             exit();
//         } else {
//             $login_error = "Email hoặc mật khẩu không đúng.";
//         }
//     }
// }

include("../admin/pages/db_connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['dangnhap'])) {
    $email = isset($_POST['loginEmail']) ? trim($_POST['loginEmail']) : '';
    $so_dien_thoai = isset($_POST['loginPhone']) ? trim($_POST['loginPhone']) : '';
    $mat_khau = trim($_POST['loginPassword']);

    if (!empty($email)) {
        $query = "SELECT * FROM nguoi_dung WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
    } elseif (!empty($so_dien_thoai)) {
        $query = "SELECT * FROM nguoi_dung WHERE so_dien_thoai = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $so_dien_thoai);
    } else {
        echo "Vui lòng nhập email hoặc số điện thoại.";
        exit();
    }

    if (isset($stmt)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && $mat_khau == $user['mat_khau']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['vai_tro'];

            if ($user['vai_tro'] == 'admin') {
                echo "<script>window.location.href = '../admin/pages/users.php';</script>";
            } elseif ($user['vai_tro'] == 'khach_hang') {
                echo "<script>window.location.href = 'index.php';</script>";
            } else {
                echo "Vai trò người dùng không xác định.";
            }
            exit();
        } else {
            echo "Email hoặc mật khẩu không đúng.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="../assets/css/dangnhap.css">
</head>
<body>
    <div align="center" id="id01">
        <div class="form-container">
            <p class="title">Đăng nhập</p>
            <form id="loginForm" class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input id="loginEmail" name="loginEmail" placeholder="Email" type="email" required>
                <input id="loginPhone" name="loginPhone" placeholder="Số Điện Thoại" type="text" style="display:none;">
                <input id="loginPassword" name="loginPassword" placeholder="Mật khẩu" type="password" required>
                <div id="loginMessage"><?php if (isset($login_error)) { echo "<p style='color:red;'>$login_error</p>"; } ?></div>
                <p class="page-link"><span class="page-link-label">Quên mật khẩu?</span></p>
                <button class="form-btn" type="submit" name="dangnhap">Đăng nhập</button>
            </form>
            <p class="page-link"><span class="page-link-label">Chưa có tài khoản?</span> <a href="register.php">Đăng ký ngay!</a></p>
        </div>
    </div>
</body>
</html>
