<?php
include('db_connect.php');

// Hàm lấy sản phẩm
function getProducts($conn) {
    $result = $conn->query("SELECT * FROM product");
    $products = [];

    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}

// Hàm lấy người dùng
function getUsers($conn) {
    $result = $conn->query("SELECT user_id, first_name, last_name, email, IF(isAdmin = 1, 'Admin', 'User') AS role FROM users");
    $users = [];

    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
}

// Hàm lấy phản hồi
function getFeedbacks($conn) {
    $result = $conn->query("SELECT * FROM feedback"); // Giả sử bạn có bảng `feedback`
    $feedbacks = [];

    while($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }

    echo json_encode($feedbacks);
}

// Hàm xóa người dùng
function deleteUser($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "Người dùng đã được xóa thành công.";
}

// Hàm xóa phản hồi
function deleteFeedback($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "Phản hồi đã được xóa thành công.";
}

// Xử lý yêu cầu AJAX
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'get_products':
            getProducts($conn);
            break;
        case 'get_users':
            getUsers($conn);
            break;
        case 'get_feedbacks':
            getFeedbacks($conn);
            break;
        case 'delete_user':
            if (isset($_GET['id'])) {
                deleteUser($conn, $_GET['id']);
            }
            break;
        case 'delete_feedback':
            if (isset($_GET['id'])) {
                deleteFeedback($conn, $_GET['id']);
            }
            break;
        default:
            echo "Hành động không hợp lệ.";
            break;
    }
}

$conn->close();
?>
