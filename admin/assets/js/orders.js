document.addEventListener("DOMContentLoaded", function () {
    function loadOrders(searchQuery = "") {
        fetch(`api.php?action=get_orders&search=${encodeURIComponent(searchQuery)}`)
            .then((response) => response.json())
            .then((data) => {
                renderOrders(data);
            });
    }

    function renderOrders(orders) {
        const tbody = document.querySelector(".order-table tbody");
        tbody.innerHTML = "";
        orders.forEach((order) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${order.id}</td>
                <td>${order.ho_ten}</td>
                <td>${order.tong_tien} VND</td>
                <td>${order.ngay_dat}</td>
                <td>
                    <select class="order-status" data-id="${order.id}">
                        <option value="cho_xu_ly" ${order.trang_thai === "cho_xu_ly" ? "selected" : ""}>Chờ xử lý</option>
                        <option value="dang_xu_ly" ${order.trang_thai === "dang_xu_ly" ? "selected" : ""}>Đang xử lý</option>
                        <option value="hoan_thanh" ${order.trang_thai === "hoan_thanh" ? "selected" : ""}>Hoàn thành</option>
                        <option value="da_huy" ${order.trang_thai === "da_huy" ? "selected" : ""}>Đã hủy</option>
                    </select>
                </td>
                <td class="actions">
                    <button class="btn delete-btn" data-id="${order.id}">Xóa</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        document.querySelectorAll(".order-status").forEach((select) => {
            select.addEventListener("change", handleChangeStatus);
        });

        document.querySelectorAll(".delete-btn").forEach((btn) => {
            btn.addEventListener("click", handleDelete);
        });
    }

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

    function handleDelete(e) {
        const orderId = e.target.dataset.id;
        if (confirm("Bạn có chắc chắn muốn xóa đơn hàng này?")) {
            fetch(`api.php?action=delete_order&id=${orderId}`, {
                method: "GET",
            })
                .then((response) => response.text())
                .then((data) => {
                    console.log(data);
                    loadOrders(); // Cập nhật lại danh sách đơn hàng sau khi xóa
                });
        }
    }

    // Xử lý tìm kiếm
    document.getElementById("ordersSearchForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const searchQuery = document.getElementById("ordersSearchInput").value;
        loadOrders(searchQuery);
    });

    loadOrders(); // Load tất cả đơn hàng khi bắt đầu
});
