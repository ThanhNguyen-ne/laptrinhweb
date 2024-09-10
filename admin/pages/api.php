<?php
include('db_connect.php');

// Hàm thêm sản phẩm
function addProduct($conn) {
    $stmt = $conn->prepare("INSERT INTO san_pham (ten_san_pham, mo_ta, gia, so_luong_ton, ngay_tao, ngay_cap_nhat) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssdi", $_POST['productName'], $_POST['productDescription'], $_POST['productPrice'], $_POST['productQuantity']);
    $stmt->execute();
    $product_id = $stmt->insert_id;
    $stmt->close();

    // Lưu loại sản phẩm
    $stmt = $conn->prepare("INSERT INTO san_pham_loai (san_pham_id, loai_san_pham_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $product_id, $_POST['productType']);
    $stmt->execute();
    $stmt->close();

    // Lưu file ảnh vào thư mục /admin/assets/images/
    if ($_FILES['productImage']['name']) {
        $image_path = '/admin/assets/images/' . basename($_FILES['productImage']['name']);
        $stmt = $conn->prepare("UPDATE san_pham SET hinh_anh = ? WHERE id = ?");
        $stmt->bind_param("si", $image_path, $product_id);
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

    // Cập nhật loại sản phẩm
    $stmt = $conn->prepare("UPDATE san_pham_loai SET loai_san_pham_id=? WHERE san_pham_id=?");
    $stmt->bind_param("ii", $_POST['productType'], $_POST['productId']);
    $stmt->execute();
    $stmt->close();

    // Nếu có cập nhật hình ảnh
    if ($_FILES['productImage']['name']) {
        $image_path = '/admin/assets/images/' . basename($_FILES['productImage']['name']);
        $stmt = $conn->prepare("UPDATE san_pham SET hinh_anh = ? WHERE id = ?");
        $stmt->bind_param("si", $image_path, $_POST['productId']);
        $stmt->execute();
        $stmt->close();

        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($_FILES["productImage"]["name"]);
        move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file);
    }

    echo "Sản phẩm đã được cập nhật thành công.";
}

// Hàm xóa sản phẩm
function deleteProduct($conn, $id)
{
    // Xóa loại sản phẩm liên quan
    $stmt = $conn->prepare("DELETE FROM san_pham_loai WHERE san_pham_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Sau đó, mới xóa sản phẩm
    $stmt = $conn->prepare("DELETE FROM san_pham WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Trả về thông báo sau khi xóa
    echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được xóa thành công']);
}


// Hàm lấy danh sách sản phẩm
function getProducts($conn) {
    $search = isset($_GET['search']) ? trim($_GET['search']) : "";

    if ($search !== "") {
        $stmt = $conn->prepare("SELECT san_pham.*, loai_san_pham.ten_loai 
                                FROM san_pham 
                                JOIN san_pham_loai ON san_pham.id = san_pham_loai.san_pham_id 
                                JOIN loai_san_pham ON san_pham_loai.loai_san_pham_id = loai_san_pham.id
                                WHERE san_pham.ten_san_pham LIKE ? OR loai_san_pham.ten_loai LIKE ?
                                ORDER BY san_pham.ngay_tao DESC");
        $likeSearch = "%" . $search . "%";
        $stmt->bind_param("ss", $likeSearch, $likeSearch);
    } else {
        $stmt = $conn->prepare("SELECT san_pham.*, loai_san_pham.ten_loai 
                                FROM san_pham 
                                JOIN san_pham_loai ON san_pham.id = san_pham_loai.san_pham_id 
                                JOIN loai_san_pham ON san_pham_loai.loai_san_pham_id = loai_san_pham.id
                                ORDER BY san_pham.ngay_tao DESC");
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();

    echo json_encode($products);
}


// Hàm lấy một sản phẩm
function getProduct($conn, $id) {
    $stmt = $conn->prepare("SELECT san_pham.*, san_pham_loai.loai_san_pham_id 
                            FROM san_pham 
                            JOIN san_pham_loai ON san_pham.id = san_pham_loai.san_pham_id 
                            WHERE san_pham.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    echo json_encode($product);
    $stmt->close();
}

// Hàm lấy danh sách sản phẩm tương tự
function getSimilarProducts($conn, $type_id, $exclude_id)
{
    $stmt = $conn->prepare("SELECT * FROM san_pham WHERE id != ? AND id IN (SELECT san_pham_id FROM san_pham_loai WHERE loai_san_pham_id = ?) LIMIT 12");
    $stmt->bind_param("ii", $exclude_id, $type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $similar_products = [];

    while ($row = $result->fetch_assoc()) {
        $similar_products[] = $row;
    }

    echo json_encode($similar_products);
    $stmt->close();
}

// Hàm lấy danh sách loại sản phẩm
function getProductTypes($conn)
{
    $result = $conn->query("SELECT * FROM loai_san_pham");
    $productTypes = [];

    while ($row = $result->fetch_assoc()) {
        $productTypes[] = $row;
    }

    echo json_encode($productTypes);
}

// Hàm thêm người dùng
function addUser($conn)
{
    $stmt = $conn->prepare("INSERT INTO nguoi_dung (ho_ten, email, mat_khau, so_dien_thoai, dia_chi, vai_tro, ngay_dang_ky) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $hashed_password = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);
    $stmt->bind_param("ssssss", $_POST['userFullName'], $_POST['userEmail'], $hashed_password, $_POST['userPhone'], $_POST['userAddress'], $_POST['userRole']);
    $stmt->execute();
    $stmt->close();

    echo "Người dùng đã được thêm thành công.";
}


// Hàm cập nhật người dùng
function updateUser($conn)
{
    $stmt = $conn->prepare("UPDATE nguoi_dung SET ho_ten=?, email=?, so_dien_thoai=?, dia_chi=?, vai_tro=? WHERE id=?");
    $stmt->bind_param("sssssi", $_POST['userFullName'], $_POST['userEmail'], $_POST['userPhone'], $_POST['userAddress'], $_POST['userRole'], $_POST['userId']);
    $stmt->execute();

    if (!empty($_POST['userPassword'])) {
        $hashed_password = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE nguoi_dung SET mat_khau = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $_POST['userId']);
        $stmt->execute();
    }

    $stmt->close();
    echo "Người dùng đã được cập nhật thành công.";
}

function getUsers($conn)
{
    $search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%';
    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE ho_ten LIKE ? OR email LIKE ?");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = array();

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    $stmt->close();
    echo json_encode($users);
}

// Hàm lấy thông tin một người dùng
function getUser($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    echo json_encode($user);
    $stmt->close();
}

// Hàm lấy danh sách đơn hàng
function getOrders($conn)
{
    $search = isset($_GET['search']) ? trim($_GET['search']) : "";

    if ($search !== "") {
        $stmt = $conn->prepare("SELECT don_hang.id, nguoi_dung.ho_ten, nguoi_dung.dia_chi, don_hang.tong_tien, don_hang.ngay_dat, don_hang.trang_thai 
                                FROM don_hang 
                                JOIN nguoi_dung ON don_hang.nguoi_dung_id = nguoi_dung.id
                                WHERE don_hang.id = ? 
                                ORDER BY don_hang.ngay_dat DESC");  // Sắp xếp theo ngày đặt từ mới đến cũ
        $stmt->bind_param("i", $search);
    } else {
        $stmt = $conn->prepare("SELECT don_hang.id, nguoi_dung.ho_ten, nguoi_dung.dia_chi, don_hang.tong_tien, don_hang.ngay_dat, don_hang.trang_thai 
                                FROM don_hang 
                                JOIN nguoi_dung ON don_hang.nguoi_dung_id = nguoi_dung.id
                                ORDER BY don_hang.ngay_dat DESC");  // Sắp xếp theo ngày đặt từ mới đến cũ
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();

    echo json_encode($orders);
}


function getOrderDetails($conn, $orderId)
{
    $stmt = $conn->prepare("SELECT don_hang.id, don_hang.tong_tien, don_hang.ngay_dat, don_hang.trang_thai, don_hang.ly_do_huy, nguoi_dung.ho_ten, nguoi_dung.email, nguoi_dung.so_dien_thoai, nguoi_dung.dia_chi
                            FROM don_hang 
                            JOIN nguoi_dung ON don_hang.nguoi_dung_id = nguoi_dung.id
                            WHERE don_hang.id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $orderResult = $stmt->get_result();
    $orderDetails = $orderResult->fetch_assoc();

    $stmt->close();

    // Lấy thông tin chi tiết các sản phẩm trong đơn hàng
    $stmt = $conn->prepare("SELECT chi_tiet_don_hang.so_luong, chi_tiet_don_hang.gia_ban, san_pham.ten_san_pham, san_pham.hinh_anh 
                            FROM chi_tiet_don_hang 
                            JOIN san_pham ON chi_tiet_don_hang.san_pham_id = san_pham.id
                            WHERE chi_tiet_don_hang.don_hang_id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $productsResult = $stmt->get_result();

    $products = [];
    while ($row = $productsResult->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();

    // Kết hợp thông tin đơn hàng và sản phẩm
    $orderDetails['products'] = $products;

    echo json_encode($orderDetails);
}



// Hàm cập nhật trạng thái đơn hàng
function updateOrderStatus($conn)
{
    $stmt = $conn->prepare("UPDATE don_hang SET trang_thai = ?, ly_do_huy = ? WHERE id = ?");
    $stmt->bind_param("ssi", $_POST['orderStatus'], $_POST['cancelReason'], $_POST['orderId']);
    $stmt->execute();
    $stmt->close();

    echo "Trạng thái đơn hàng đã được cập nhật thành công.";
}


// Hàm xóa đơn hàng
function deleteOrder($conn, $id)
{
    $stmt = $conn->prepare("DELETE FROM don_hang WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "Đơn hàng đã được xóa thành công.";
}

// Thêm vào api.php phần lưu trữ và lấy lại giỏ hàng từ cơ sở dữ liệu.

function saveCart($conn, $userId, $cart)
{
    // Xóa giỏ hàng cũ của người dùng
    $stmt = $conn->prepare("DELETE FROM gio_hang WHERE nguoi_dung_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();

    // Lưu giỏ hàng mới
    $stmt = $conn->prepare("INSERT INTO gio_hang (nguoi_dung_id, san_pham_id, so_luong) VALUES (?, ?, ?)");
    foreach ($cart as $item) {
        $stmt->bind_param("iii", $userId, $item['id'], $item['count']);
        $stmt->execute();
    }
    $stmt->close();
}
function loadCart($conn, $userId)
{
    $stmt = $conn->prepare("SELECT san_pham.id, san_pham.ten_san_pham, san_pham.gia, san_pham.hinh_anh, gio_hang.so_luong 
                            FROM san_pham 
                            JOIN gio_hang ON san_pham.id = gio_hang.san_pham_id 
                            WHERE gio_hang.nguoi_dung_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart = [];
    while ($row = $result->fetch_assoc()) {
        $cart[] = $row;
    }
    echo json_encode($cart);
    $stmt->close();
}

// Xử lý yêu cầu AJAX
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'update_order_status' && isset($_POST['orderId'], $_POST['orderStatus'], $_POST['cancelReason'])) {
        $orderId = $_POST['orderId'];
        $orderStatus = $_POST['orderStatus'];
        $cancelReason = $_POST['cancelReason'];

        // Cập nhật trạng thái và lý do hủy
        $stmt = $conn->prepare("UPDATE don_hang SET trang_thai = ?, ly_do_huy = ? WHERE id = ?");
        $stmt->bind_param("ssi", $orderStatus, $cancelReason, $orderId);
        
        if ($stmt->execute()) {
            echo "Đơn hàng đã được hủy thành công.";
        } else {
            echo "Có lỗi xảy ra.";
        }
        $stmt->close();
    }
    
    switch ($action) {
        case 'get_products':
            getProducts($conn);
            break;
        case 'get_product':
            if (isset($_GET['id'])) {
                getProduct($conn, $_GET['id']);
            }
            break;
        case 'get_product_types':
            getProductTypes($conn);
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
        case 'load_cart': // Thêm hành động để tải giỏ hàng
            if (isset($_GET['user_id'])) {
                loadCart($conn, $_GET['user_id']);
            }
            break;
        case 'get_similar_products': // Trường hợp mới cho sản phẩm tương tự
            if (isset($_GET['type_id']) && isset($_GET['exclude_id'])) {
                getSimilarProducts($conn, $_GET['type_id'], $_GET['exclude_id']);
            }
            break;
        case 'get_order_details':
            if (isset($_GET['id'])) {
                getOrderDetails($conn, $_GET['id']);
            } else {
                echo json_encode(["error" => "Không có ID đơn hàng được cung cấp."]);
            }
            break;
        default:
            echo "Hành động không hợp lệ.";
            break;
    }

    
}

$conn->close();
