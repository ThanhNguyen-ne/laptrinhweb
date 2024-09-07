<?php
include("../admin/pages/db_connect.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: dangnhap.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin đơn hàng
$sql_orders = "
    SELECT dh.id, dh.ngay_dat, dh.tong_tien, dh.trang_thai, dh.ly_do_huy, GROUP_CONCAT(sp.ten_san_pham SEPARATOR ', ') AS san_pham
    FROM don_hang dh
    JOIN chi_tiet_don_hang ctdh ON dh.id = ctdh.don_hang_id
    JOIN san_pham sp ON ctdh.san_pham_id = sp.id
    WHERE dh.nguoi_dung_id = ?
    GROUP BY dh.id
    ORDER BY dh.ngay_dat DESC";  // Thêm ORDER BY để sắp xếp theo ngày đặt
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$result_orders = $stmt_orders->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/donhang.css">
    <title>Đơn hàng của bạn</title>
</head>

<body>
    <?php include('header.php'); ?>

    <!-- Thông báo hủy đơn hàng thành công -->
    <div id="notification" class="notification" style="display: none;"></div>

    <div class="container">
        <h2>Đơn hàng đã đặt</h2>
        <div class="order-info">
            <table id="ordersTable">
                <tr>
                    <th></th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Thời gian đặt</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                    <th>Hủy</th>
                </tr>
                <?php
                $i = 1;
                while ($order = $result_orders->fetch_assoc()) {
                    $ngay_dat = date("H:i:s - d/m/Y", strtotime($order['ngay_dat']));

                    switch ($order['trang_thai']) {
                        case 'cho_xu_ly':
                            $trang_thai = 'Chờ xử lý';
                            break;
                        case 'dang_xu_ly':
                            $trang_thai = 'Đang xử lý';
                            break;
                        case 'hoan_thanh':
                            $trang_thai = 'Hoàn thành';
                            break;
                        case 'da_huy':
                            $trang_thai = 'Đã hủy';
                            break;
                        default:
                            $trang_thai = 'Không xác định';
                    }
                ?>
                    <tr id="order-<?php echo $order['id']; ?>">
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($order['san_pham']); ?></td>
                        <td><?php echo htmlspecialchars(number_format($order['tong_tien'])); ?> </td>
                        <td><?php echo htmlspecialchars($ngay_dat); ?></td>
                        <td><?php echo htmlspecialchars($trang_thai); ?></td>
                        <td>
                            <button class="btn-detail" data-id="<?php echo $order['id']; ?>">Chi tiết</button>
                        </td>
                        <td>
                            <?php if ($order['trang_thai'] === 'da_huy') { ?>
                                <p>Lý do hủy: <?php echo htmlspecialchars($order['ly_do_huy']); ?></p>
                            <?php } else { ?>
                                <button class="btn-cancel" onclick="openCancelModal(<?php echo $order['id']; ?>)">Hủy</button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <!-- Modal Chi tiết đơn hàng -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('detailModal')">&times;</span>
            <h2>Chi tiết đơn hàng</h2>
            <div id="orderDetails"></div>
        </div>
    </div>

    <!-- Modal Hủy đơn hàng -->
    <div id="cancelModal" class="modal">
        <div class="modal-content cancel-content">
            <span class="close" onclick="closeModal('cancelModal')">&times;</span>
            <h2>Hủy đơn hàng</h2>
            <p>Vui lòng chọn lý do hủy đơn hàng:</p>
            <div class="cancel-reasons">
                <label><input type="radio" name="cancelReason" value="Không muốn mua nữa"> Không muốn mua nữa</label><br>
                <label><input type="radio" name="cancelReason" value="Thời gian giao hàng quá lâu"> Thời gian giao hàng quá lâu</label><br>
                <label><input type="radio" name="cancelReason" value="Tìm thấy giá rẻ hơn ở nơi khác"> Tìm thấy giá rẻ hơn ở nơi khác</label><br>
                <label><input type="radio" name="cancelReason" value="Sản phẩm không còn cần thiết"> Sản phẩm không còn cần thiết</label><br>
                <label><input type="radio" name="cancelReason" value="Khác"> Khác</label>
                <textarea id="customCancelReason" rows="4" placeholder="Nhập lý do khác..."></textarea>
            </div>
            <button class="btn-confirm" onclick="confirmCancel()">Xác nhận hủy</button>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script>
        // Mở modal chi tiết đơn hàng khi nhấn nút "Chi tiết"
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const orderId = this.getAttribute('data-id');
                openDetailModal(orderId);
            });
        });

        function openDetailModal(orderId) {
            fetch(`../admin/pages/api.php?action=get_order_details&id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data) {
                        alert("Không tìm thấy đơn hàng.");
                        return;
                    }

                    let productsHtml = '<table><tr><th>Hình ảnh</th><th>Sản phẩm</th><th>Số lượng</th><th>Giá</th></tr>';
                    data.products.forEach(product => {
                        productsHtml += `
                            <tr>
                                <td><img src="${product.hinh_anh}" alt="${product.ten_san_pham}" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                <td>${product.ten_san_pham}</td>
                                <td>${product.so_luong}</td>
                                <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.gia_ban)}</td>
                            </tr>`;
                    });
                    productsHtml += '</table>';

                    document.getElementById('orderDetails').innerHTML = `
                        <p><strong>Mã đơn hàng:</strong> ${data.id}</p>
                        <p><strong>Khách hàng:</strong> ${data.ho_ten}</p>
                        <p><strong>Email:</strong> ${data.email}</p>
                        <p><strong>Số điện thoại:</strong> ${data.so_dien_thoai}</p>
                        <p><strong>Địa chỉ:</strong> ${data.dia_chi}</p>
                        <p><strong>Ngày đặt:</strong> ${new Date(data.ngay_dat).toLocaleString('vi-VN')}</p>
                        <p><strong>Tổng tiền:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data.tong_tien)}</p>
                        <p><strong>Trạng thái:</strong> ${convertStatus(data.trang_thai)}</p>
                        <hr />
                        ${productsHtml}
                    `;
                    document.getElementById('detailModal').style.display = "flex";
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    alert("Có lỗi xảy ra khi lấy chi tiết đơn hàng.");
                });
        }

        function openCancelModal(orderId) {
            document.getElementById('cancelModal').style.display = "block";
            document.querySelectorAll('input[name="cancelReason"]').forEach(input => input.checked = false);
            document.getElementById('customCancelReason').style.display = 'none';
            document.getElementById('customCancelReason').value = '';
            document.querySelector('input[name="cancelReason"][value="Không muốn mua nữa"]').checked = true; // Default selection

            // Lưu lại orderId để dùng sau khi hủy
            document.querySelector('.btn-confirm').dataset.orderId = orderId;
        }

        document.querySelectorAll('input[name="cancelReason"]').forEach(input => {
            input.addEventListener('change', function() {
                const customReasonField = document.getElementById('customCancelReason');
                if (this.value === 'Khác') {
                    customReasonField.style.display = 'block';
                } else {
                    customReasonField.style.display = 'none';
                }
            });
        });

        function confirmCancel() {
            const reasonInput = document.querySelector('input[name="cancelReason"]:checked');
            const reason = reasonInput.value === 'Khác' ? document.getElementById('customCancelReason').value : reasonInput.value;
            const orderId = document.querySelector('.btn-confirm').dataset.orderId;

            if (reason.trim() === '') {
                showNotification('Vui lòng nhập lý do hủy đơn hàng.', 'error');
                return;
            }

            fetch('../admin/pages/api.php?action=update_order_status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `orderStatus=da_huy&orderId=${orderId}&cancelReason=${encodeURIComponent(reason)}`
            })
            .then(response => response.text())
            .then(data => {
                // Cập nhật dòng đơn hàng sau khi hủy thành công
                const orderRow = document.getElementById(`order-${orderId}`);
                orderRow.querySelector('td:nth-child(5)').textContent = 'Đã hủy'; // Cập nhật trạng thái
                orderRow.querySelector('td:nth-child(7)').innerHTML = `<p>Lý do hủy: ${reason}</p>`; // Cập nhật lý do hủy
                closeModal('cancelModal');  // Đóng modal sau khi hủy thành công
                showNotification('Đơn hàng đã hủy thành công.', 'success');
            });
        }

        // Hàm hiển thị thông báo
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`; // Thêm class type (success hoặc error)
            notification.style.display = 'block';

            setTimeout(() => {
                notification.style.display = 'none'; // Tự động ẩn thông báo sau 3 giây
            }, 3000);
        }

        // Hàm đóng modal
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function convertStatus(status) {
            switch (status) {
                case 'cho_xu_ly':
                    return 'Chờ xử lý';
                case 'dang_xu_ly':
                    return 'Đang xử lý';
                case 'hoan_thanh':
                    return 'Hoàn thành';
                case 'da_huy':
                    return 'Đã hủy';
                default:
                    return 'Không xác định';
            }
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>
