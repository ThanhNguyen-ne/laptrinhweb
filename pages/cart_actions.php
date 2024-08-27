<?php
session_start();
include('../admin/pages/db_connect.php');

// Kiểm tra nếu user đã đăng nhập và lấy đúng user_id từ session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Lấy user_id từ session để đảm bảo rằng chỉ thực hiện thao tác cho người dùng đang đăng nhập
$user_id = $_SESSION['user_id'];

// Kiểm tra hành động được yêu cầu
$action = $_GET['action'];

switch ($action) {
    case 'add':
        $product_id = $_GET['id'];
        
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng hay chưa
        $check_query = "SELECT * FROM gio_hang WHERE san_pham_id = ? AND nguoi_dung_id = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("ii", $product_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng lên 1
            $update_query = "UPDATE gio_hang SET so_luong = so_luong + 1 WHERE san_pham_id = ? AND nguoi_dung_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ii", $product_id, $user_id);
            $stmt->execute();
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm vào giỏ hàng với số lượng là 1
            $insert_query = "INSERT INTO gio_hang (san_pham_id, nguoi_dung_id, so_luong) VALUES (?, ?, 1)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ii", $product_id, $user_id);
            $stmt->execute();
        }

        $stmt->close();
        echo json_encode(['success' => true]);
        break;

    case 'update':
        $id = $_GET['id'];
        $quantity = $_GET['quantity'];

        if ($quantity > 0) {
            $update_query = "UPDATE gio_hang SET so_luong = ? WHERE id = ? AND nguoi_dung_id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("iii", $quantity, $id, $user_id);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['success' => true]);
        } else {
            $delete_query = "DELETE FROM gio_hang WHERE id = ? AND nguoi_dung_id = ?";
            $stmt = $conn->prepare($delete_query);
            $stmt->bind_param("ii", $id, $user_id);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['success' => true]);
        }
        break;

    case 'remove':
        $id = $_GET['id'];

        $delete_query = "DELETE FROM gio_hang WHERE id = ? AND nguoi_dung_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true]);
        break;

    case 'clear':
        $clear_query = "DELETE FROM gio_hang WHERE nguoi_dung_id = ?";
        $stmt = $conn->prepare($clear_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['success' => true]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}

$conn->close();
?>
