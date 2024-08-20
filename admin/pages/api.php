<?php
include('db_connect.php');

// Hàm thêm sản phẩm
function addProduct($conn) {
    $stmt = $conn->prepare("INSERT INTO san_pham (ten_san_pham, mo_ta, gia, so_luong_ton, ngay_tao, ngay_cap_nhat) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssdi", $_POST['productName'], $_POST['productDescription'], $_POST['productPrice'], $_POST['productQuantity']);
    $stmt->execute();
    $product_id = $stmt->insert_id;
    $stmt->close();

    // Lưu file ảnh vào thư mục uploads
    if ($_FILES['productImage']['name']) {
        $stmt = $conn->prepare("UPDATE san_pham SET product_image = ? WHERE id = ?");
        $stmt->bind_param("si", $_FILES['productImage']['name'], $product_id);
        $stmt->execute();
        $stmt->close();

        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["productImage"]["name"]);
        move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file);
    }

    echo "Sản phẩm đã được thêm thành công.";
}

// Hàm cập nhật sản phẩm
function updateProduct($conn) {
    $stmt = $conn->prepare("UPDATE san_pham SET ten_san_pham=?, mo_ta=?, gia=?, so_luong_ton=?, ngay_cap_nhat=NOW() WHERE id=?");
    $stmt->bind_param("ssdii", $_POST['productName'], $_POST['productDescription'], $_POST['productPrice'], $_POST['productQuantity'], $_POST['productId']);
    $stmt->execute();

    // Nếu có cập nhật hình ảnh
    if ($_FILES['productImage']['name']) {
        $stmt = $conn->prepare("UPDATE san_pham SET product_image = ? WHERE id = ?");
        $stmt->bind_param("si", $_FILES['productImage']['name'], $_POST['productId']);
        $stmt->execute();
        $stmt->close();

        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["productImage"]["name"]);
        move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file);
    }

    echo "Sản phẩm đã được cập nhật thành công.";
}

// Hàm xóa sản phẩm
function deleteProduct($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM san_pham WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "Sản phẩm đã được xóa thành công.";
}

// Hàm thêm người dùng
function addUser($conn) {
    $stmt = $conn->prepare("INSERT INTO nguoi_dung (ho_ten, email, mat_khau, vai_tro, ngay_dang_ky) VALUES (?, ?, ?, ?, NOW())");
    $hashed_password = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);
    $full_name = $_POST['userFirstName'] . " " . $_POST['userLastName'];
    $stmt->bind_param("ssss", $full_name, $_POST['userEmail'], $hashed_password, $_POST['userRole']);
    $stmt->execute();
    $stmt->close();

    echo "Người dùng đã được thêm thành công.";
}

// Hàm cập nhật người dùng
function updateUser($conn) {
    $stmt = $conn->prepare("UPDATE nguoi_dung SET ho_ten=?, email=?, vai_tro=? WHERE id=?");
    $full_name = $_POST['userFirstName'] . " " . $_POST['userLastName'];
    $stmt->bind_param("sssi", $full_name, $_POST['userEmail'], $_POST['userRole'], $_POST['userId']);
    $stmt->execute();
    $stmt->close();

    echo "Người dùng đã được cập nhật thành công.";
}

// Hàm xóa người dùng
function deleteUser($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM nguoi_dung WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "Người dùng đã được xóa thành công.";
}

// Hàm lấy danh sách sản phẩm
function getProducts($conn) {
    $result = $conn->query("SELECT * FROM san_pham");
    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}

// Hàm lấy một sản phẩm
function getProduct($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM san_pham WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    echo json_encode($product);
    $stmt->close();
}

// Hàm lấy danh sách người dùng
function getUsers($conn) {
    $result = $conn->query("SELECT * FROM nguoi_dung");
    $users = [];

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
}

// Hàm lấy thông tin một người dùng
function getUser($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    echo json_encode($user);
    $stmt->close();
}

// Hàm lấy danh sách đơn hàng
function getOrders($conn) {
    $result = $conn->query("SELECT don_hang.id, nguoi_dung.ho_ten, don_hang.tong_tien, don_hang.ngay_dat, don_hang.trang_thai 
                            FROM don_hang 
                            JOIN nguoi_dung ON don_hang.nguoi_dung_id = nguoi_dung.id");
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    echo json_encode($orders);
}

// Hàm cập nhật trạng thái đơn hàng
function updateOrderStatus($conn) {
    $stmt = $conn->prepare("UPDATE don_hang SET trang_thai = ? WHERE id = ?");
    $stmt->bind_param("si", $_POST['orderStatus'], $_POST['orderId']);
    $stmt->execute();
    $stmt->close();

    echo "Trạng thái đơn hàng đã được cập nhật thành công.";
}

// Hàm xóa đơn hàng
function deleteOrder($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM don_hang WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "Đơn hàng đã được xóa thành công.";
}

// Hàm lấy danh sách phản hồi
function getFeedbacks($conn) {
    $result = $conn->query("SELECT phan_hoi.id, nguoi_dung.ho_ten, nguoi_dung.email, phan_hoi.noi_dung, phan_hoi.ngay_gui 
                            FROM phan_hoi 
                            JOIN nguoi_dung ON phan_hoi.nguoi_dung_id = nguoi_dung.id");
    $feedbacks = [];

    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }

    echo json_encode($feedbacks);
}

// Hàm xóa phản hồi
function deleteFeedback($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM phan_hoi WHERE id = ?");
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
        case 'get_product':
            if (isset($_GET['id'])) {
                getProduct($conn, $_GET['id']);
            }
            break;
        case 'add_product':
            addProduct($conn);
            break;
        case 'update_product':
            updateProduct($conn);
            break;
        case 'delete_product':
            if (isset($_GET['id'])) {
                deleteProduct($conn, $_GET['id']);
            }
            break;
        case 'get_users':
            getUsers($conn);
            break;
        case 'get_user':
            if (isset($_GET['id'])) {
                getUser($conn, $_GET['id']);
            }
            break;
        case 'add_user':
            addUser($conn);
            break;
        case 'update_user':
            updateUser($conn);
            break;
        case 'delete_user':
            if (isset($_GET['id'])) {
                deleteUser($conn, $_GET['id']);
            }
            break;
        case 'get_orders':
            getOrders($conn);
            break;
        case 'update_order_status':
            updateOrderStatus($conn);
            break;
        case 'delete_order':
            if (isset($_GET['id'])) {
                deleteOrder($conn, $_GET['id']);
            }
            break;
        case 'get_feedbacks':
            getFeedbacks($conn);
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
