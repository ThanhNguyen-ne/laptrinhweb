// orderStatus.js

document.getElementById('orderStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Lấy mã đơn hàng từ input
    const orderID = document.getElementById('orderID').value;

    // Đây là nơi bạn sẽ thực hiện API call hoặc logic kiểm tra đơn hàng.
    // Hiện tại, tôi sẽ sử dụng một ví dụ đơn giản.
    let orderResult;

    if (orderID === "123456") {
        orderResult = "Đơn hàng đang được xử lý.";
    } else if (orderID === "654321") {
        orderResult = "Đơn hàng đã được giao thành công.";
    } else {
        orderResult = "Không tìm thấy đơn hàng.";
    }

    // Hiển thị kết quả kiểm tra trạng thái đơn hàng
    document.getElementById('orderResult').textContent = orderResult;
});
