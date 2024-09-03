document.addEventListener("DOMContentLoaded", function () {
    const orderModal = document.getElementById("orderModal");
    const closeModal = document.querySelector(".close");
    const orderDetails = document.getElementById("orderDetails");

    // Đảm bảo modal không hiển thị khi trang mới tải
    orderModal.style.display = "none";

    // Hàm tải danh sách đơn hàng
    function loadOrders(searchQuery = "") {
        fetch(`api.php?action=get_orders&search=${encodeURIComponent(searchQuery)}`)
            .then((response) => response.json())
            .then((data) => {
                renderOrders(data);
            });
    }

    // Hàm hiển thị danh sách đơn hàng lên bảng
    function renderOrders(orders) {
        const tbody = document.querySelector(".order-table tbody");
        tbody.innerHTML = "";
        orders.forEach((order) => {
            const formattedTotal = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.tong_tien);

            const date = new Date(order.ngay_dat);
            const formattedDate = `${date.toLocaleTimeString('vi-VN')} ${date.toLocaleDateString('vi-VN')}`;

            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${order.id}</td>
                <td>${order.ho_ten}</td>
                <td>${formattedTotal}</td>
                <td>${formattedDate}</td>
                <td>
                    <select class="order-status" data-id="${order.id}">
                        <option value="cho_xu_ly" ${order.trang_thai === "cho_xu_ly" ? "selected" : ""}>Chờ xử lý</option>
                        <option value="dang_xu_ly" ${order.trang_thai === "dang_xu_ly" ? "selected" : ""}>Đang xử lý</option>
                        <option value="hoan_thanh" ${order.trang_thai === "hoan_thanh" ? "selected" : ""}>Hoàn thành</option>
                        <option value="da_huy" ${order.trang_thai === "da_huy" ? "selected" : ""}>Đã hủy</option>
                    </select>
                </td>
                <td class="actions">
                    <button class="btn details-btn" data-id="${order.id}">Chi tiết</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Gán sự kiện cho tất cả các nút "Chi tiết"
        document.querySelectorAll(".details-btn").forEach((btn) => {
            btn.addEventListener("click", handleDetails);
        });

        // Gán sự kiện cho tất cả các dropdown thay đổi trạng thái đơn hàng
        document.querySelectorAll(".order-status").forEach((select) => {
            select.addEventListener("change", handleChangeStatus);
        });
    }

    // Hàm xử lý thay đổi trạng thái đơn hàng
    function handleChangeStatus(e) {
        const orderId = e.target.dataset.id;
        const orderStatus = e.target.value;

        const formData = new FormData();
        formData.append("orderId", orderId);
        formData.append("orderStatus", orderStatus);

        fetch("api.php?action=update_order_status", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((data) => {
                console.log(data);
                loadOrders(); // Cập nhật lại danh sách đơn hàng sau khi thay đổi trạng thái
            });
    }

    // Hàm xử lý hiển thị chi tiết đơn hàng
    function handleDetails(e) {
        const orderId = e.target.dataset.id;

        // Gọi API để lấy chi tiết đơn hàng
        fetch(`api.php?action=get_order_details&id=${orderId}`)
            .then((response) => response.json())
            .then((order) => {
                if (order) {
                    // Hiển thị thông tin chi tiết đơn hàng trong modal
                    let productsHtml = '';
                    order.products.forEach(product => {
                        productsHtml += `<p>Sản phẩm: ${product.ten_san_pham} - Số lượng: ${product.so_luong} - Giá: ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.gia_ban)}</p>`;
                    });

                    orderDetails.innerHTML = `
                        <p>Mã đơn hàng: ${order.id}</p>
                        <p>Khách hàng: ${order.ho_ten}</p>
                        <p>Email: ${order.email}</p>
                        <p>Số điện thoại: ${order.so_dien_thoai}</p>
                        <p>Địa chỉ: ${order.dia_chi}</p>
                        <p>Ngày đặt: ${new Date(order.ngay_dat).toLocaleString('vi-VN')}</p>
                        <p>Tổng tiền: ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.tong_tien)}</p>
                        <p>Trạng thái: ${order.trang_thai}</p>
                        <hr />
                        ${productsHtml}
                    `;
                    orderModal.style.display = "flex"; // Hiển thị modal
                }
            });
    }

    // Đóng modal khi nhấn nút "X"
    closeModal.addEventListener("click", () => {
        orderModal.style.display = "none";
    });

    // Đóng modal khi nhấn ra ngoài modal
    window.addEventListener("click", (e) => {
        if (e.target == orderModal) {
            orderModal.style.display = "none";
        }
    });

    // Xử lý tìm kiếm
    document.getElementById("ordersSearchForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const searchQuery = document.getElementById("ordersSearchInput").value;
        loadOrders(searchQuery);
    });

    loadOrders(); // Load tất cả đơn hàng khi bắt đầu
});
