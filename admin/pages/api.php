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
function deleteProduct($conn, $id) {
    // Xóa loại sản phẩm liên quan
    $stmt = $conn->prepare("DELETE FROM san_pham_loai WHERE san_pham_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Xóa sản phẩm
    $stmt = $conn->prepare("DELETE FROM san_pham WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "Sản phẩm đã được xóa thành công.";
}

// Hàm lấy danh sách sản phẩm
function getProducts($conn) {
    $result = $conn->query("SELECT san_pham.*, loai_san_pham.ten_loai 
                            FROM san_pham 
                            JOIN san_pham_loai ON san_pham.id = san_pham_loai.san_pham_id 
                            JOIN loai_san_pham ON san_pham_loai.loai_san_pham_id = loai_san_pham.id
                            ORDER BY san_pham.ngay_tao DESC"); // Sắp xếp sản phẩm mới nhất lên đầu
    $products = [];

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

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

// Hàm lấy danh sách loại sản phẩm
function getProductTypes($conn) {
    $result = $conn->query("SELECT * FROM loai_san_pham");
    $productTypes = [];

    while ($row = $result->fetch_assoc()) {
        $productTypes[] = $row;
    }

    echo json_encode($productTypes);
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
        default:
            echo "Hành động không hợp lệ.";
            break;
    }
}

$conn->close();
?>

