document.addEventListener("DOMContentLoaded", function () {
    const orderModal = document.getElementById("orderModal");
    const closeModalBtn = document.querySelectorAll(".close");
    const orderDetails = document.getElementById("orderDetails");
    const notificationList = document.getElementById("notificationList");

    orderModal.style.display = "none";

    let lastOrderId = 0;

    function loadOrders(searchQuery = "") {
        fetch(`api.php?action=get_orders&search=${encodeURIComponent(searchQuery)}`)
            .then((response) => response.json())
            .then((data) => {
                renderOrders(data);
                checkForNewOrders(data);
            });
    }

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
                <td>${order.dia_chi || "N/A"}</td>
                <td class="actions">
                    <button class="btn details-btn" data-id="${order.id}">Chi tiết</button>
                    ${
                        order.trang_thai === 'hoan_thanh' 
                        ? `<button class="btn complete-btn" disabled>Đã hoàn thành</button>`
                        : (order.trang_thai === 'da_huy'
                        ? `<button class="btn cancel-btn" disabled>Đã hủy</button>`
                        : `<button class="btn complete-btn" data-id="${order.id}">Hoàn thành</button>`)
                    }
                </td>
            `;
            tbody.appendChild(tr);
        });
    
        document.querySelectorAll(".details-btn").forEach((btn) => {
            btn.addEventListener("click", handleDetails);
        });
    
        document.querySelectorAll(".complete-btn").forEach((btn) => {
            btn.addEventListener("click", handleComplete);
        });
    }

    function handleDetails(e) {
        const orderId = e.target.dataset.id;

        fetch(`api.php?action=get_order_details&id=${orderId}`)
            .then((response) => response.json())
            .then((order) => {
                if (order) {
                    let productsHtml = '<table><tr><th>Hình ảnh</th><th>Sản phẩm</th><th>Số lượng</th><th>Giá</th></tr>';
                    order.products.forEach(product => {
                        productsHtml += `
                            <tr>
                                <td><img src="${product.hinh_anh}" alt="${product.ten_san_pham}" style="width: 50px; height: 50px; object-fit: cover;"></td>
                                <td>${product.ten_san_pham}</td>
                                <td>${product.so_luong}</td>
                                <td>${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.gia_ban)}</td>
                            </tr>`;
                    });
                    productsHtml += '</table>';

                    let cancelReasonHtml = '';
                    if (order.trang_thai === 'da_huy' && order.ly_do_huy) {
                        cancelReasonHtml = `<p><strong>Lý do hủy:</strong> ${order.ly_do_huy}</p>`;
                    }

                    orderDetails.innerHTML = `
                        <p><strong>Mã đơn hàng:</strong> ${order.id}</p>
                        <p><strong>Khách hàng:</strong> ${order.ho_ten}</p>
                        <p><strong>Email:</strong> ${order.email}</p>
                        <p><strong>Số điện thoại:</strong> ${order.so_dien_thoai}</p>
                        <p><strong>Địa chỉ:</strong> ${order.dia_chi}</p>
                        <p><strong>Ngày đặt:</strong> ${new Date(order.ngay_dat).toLocaleString('vi-VN')}</p>
                        <p><strong>Tổng tiền:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.tong_tien)}</p>
                        <p><strong>Trạng thái:</strong> ${convertStatus(order.trang_thai)}</p>
                        ${cancelReasonHtml}
                        <hr />
                        ${productsHtml}
                    `;
                    orderModal.style.display = "flex";
                } else {
                    alert("Không tìm thấy thông tin đơn hàng.");
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert("Có lỗi xảy ra khi tải chi tiết đơn hàng.");
            });
    }

    function handleComplete(e) {
        const orderId = e.target.dataset.id;
    
        fetch(`api.php?action=update_order_status`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `orderId=${orderId}&orderStatus=hoan_thanh`,
        })
        .then((response) => response.text())
        .then(() => {
            // Chuyển đổi nút hoàn thành thành "Đã hoàn thành"
            const completeButton = e.target;
            completeButton.textContent = "Đã hoàn thành";
            completeButton.disabled = true;
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Có lỗi xảy ra khi cập nhật trạng thái đơn hàng.");
        });
    }

    function convertStatus(status) {
        const statusMap = {
            'cho_xu_ly': 'Chờ xử lý',
            'dang_xu_ly': 'Đang xử lý',
            'hoan_thanh': 'Hoàn thành',
            'da_huy': 'Đã hủy',
            'da_thanh_toan': 'Đã thanh toán'
        };
    
        return statusMap[status] || status;
    }

    function checkForNewOrders(orders) {
        if (orders.length > 0) {
            const latestOrder = orders[0];
            if (latestOrder.id > lastOrderId) {
                lastOrderId = latestOrder.id;
                addNotification(`Đơn hàng mới: Mã ${latestOrder.id} từ khách hàng ${latestOrder.ho_ten}.`);
            }
        }
    }

    function addNotification(message) {
        const li = document.createElement("li");
        li.textContent = message;
        notificationList.prepend(li);
    }

    setInterval(() => {
        loadOrders();
    }, 30000);

    closeModalBtn.forEach((btn) => {
        btn.addEventListener("click", () => {
            orderModal.style.display = "none";
        });
    });

    window.addEventListener("click", (e) => {
        if (e.target == orderModal) {
            orderModal.style.display = "none";
        }
    });

    document.getElementById("ordersSearchForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const searchQuery = document.getElementById("ordersSearchInput").value;
        loadOrders(searchQuery);
    });

    loadOrders();
});
