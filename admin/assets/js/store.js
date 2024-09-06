document.addEventListener("DOMContentLoaded", function () {
    loadProducts(); // Tải sản phẩm khi trang được tải
    loadProductTypes(); // Tải loại sản phẩm

    // Modal elements
    const productModal = document.getElementById("productModal");
    const confirmDeleteModal = document.getElementById("confirmDeleteModal");
    const closeModal = document.querySelector(".close");

    // Buttons
    const addProductBtn = document.getElementById("addProductBtn");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

    // Thêm sản phẩm
    addProductBtn.addEventListener("click", function () {
        document.getElementById("productForm").reset();
        clearErrors();
        document.getElementById("modalTitle").textContent = "THÊM SẢN PHẨM";
        productModal.style.display = "block";
    });

    // Đóng modal
    closeModal.addEventListener("click", function () {
        productModal.style.display = "none";
    });

    // Xử lý form khi thêm/chỉnh sửa sản phẩm
    document
        .getElementById("productForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(this);
            const productName = formData.get("productName");
            const productDescription = formData.get("productDescription");
            const productType = formData.get("productType");
            const productPrice = formData.get("productPrice");
            const productQuantity = formData.get("productQuantity");

            // Kiểm tra các trường nhập và hiển thị lỗi nếu có
            if (!productName) {
                showError("productName", "Vui lòng nhập tên sản phẩm.");
                return;
            }
            if (!productDescription) {
                showError(
                    "productDescription",
                    "Vui lòng nhập mô tả sản phẩm."
                );
                return;
            }
            if (!productType) {
                showError("productType", "Vui lòng chọn loại sản phẩm.");
                return;
            }
            if (!productPrice) {
                showError("productPrice", "Vui lòng nhập giá sản phẩm.");
                return;
            }
            if (!productQuantity) {
                showError("productQuantity", "Vui lòng nhập số lượng.");
                return;
            }

            const actionUrl = formData.get("productId")
                ? "api.php?action=update_product"
                : "api.php?action=add_product";

            fetch(actionUrl, {
                method: "POST",
                body: formData,
            })
                .then((response) => response.text())
                .then((data) => {
                    showNotification(data);
                    productModal.style.display = "none";
                    loadProducts(); // Cập nhật danh sách sản phẩm
                });
        });

    // Tìm kiếm sản phẩm
    document
        .getElementById("searchForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();
            const searchInput = document
                .getElementById("searchInput")
                .value.trim();
            loadProducts(searchInput);
        });

    // Hàm tải danh sách sản phẩm
    function loadProducts(searchKeyword = "") {
        const url = searchKeyword
            ? `api.php?action=get_products&search=${encodeURIComponent(
                  searchKeyword
              )}`
            : "api.php?action=get_products";

        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                const productTableBody =
                    document.getElementById("productTableBody");
                productTableBody.innerHTML = "";

                if (data.length === 0) {
                    productTableBody.innerHTML =
                        "<tr><td colspan='7'>Không tìm thấy sản phẩm nào</td></tr>";
                    return;
                }

                data.forEach((product, index) => {
                    const row = `<tr>
                                    <td>${index + 1}</td>
                                    <td><img src="${
                                        product.hinh_anh
                                    }" alt="Hình ảnh"></td>
                                    <td>${product.ten_san_pham}</td>
                                    <td>${product.ten_loai}</td>
                                    <td>${new Intl.NumberFormat("vi-VN").format(
                                        product.gia
                                    )} ₫</td>
                                    <td>${new Intl.NumberFormat("vi-VN").format(
                                        product.so_luong_ton
                                    )}</td>
                                    <td class="actions">
                                        <button class="btn edit-btn" data-id="${
                                            product.id
                                        }">
                                            <i class="bx bx-pencil"></i>
                                        </button>
                                        <button class="btn delete-btn" data-id="${
                                            product.id
                                        }">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </td>
                                </tr>`;
                    productTableBody.insertAdjacentHTML("beforeend", row);
                });

                // Gắn sự kiện sau khi sản phẩm được tải
                attachEventHandlers();
            });
    }

    // Hàm tải danh sách loại sản phẩm
    function loadProductTypes() {
        fetch("api.php?action=get_product_types")
            .then((response) => response.json())
            .then((data) => {
                const productTypeSelect =
                    document.getElementById("productType");
                productTypeSelect.innerHTML = "";
                data.forEach((type) => {
                    const option = `<option value="${type.id}">${type.ten_loai}</option>`;
                    productTypeSelect.insertAdjacentHTML("beforeend", option);
                });
            });
    }

    // Hàm gắn sự kiện sau khi tải sản phẩm
    function attachEventHandlers() {
        // Sự kiện chỉnh sửa sản phẩm
        document.querySelectorAll(".edit-btn").forEach((button) => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                fetch(`api.php?action=get_product&id=${productId}`)
                    .then((response) => response.json())
                    .then((data) => {
                        clearErrors();
                        document.getElementById("productId").value = data.id;
                        document.getElementById("productName").value =
                            data.ten_san_pham;
                        document.getElementById("productDescription").value =
                            data.mo_ta;
                        document.getElementById("productType").value =
                            data.loai_san_pham_id;
                        document.getElementById("productPrice").value =
                            data.gia;
                        document.getElementById("productQuantity").value =
                            data.so_luong_ton;
                        document.getElementById("modalTitle").textContent =
                            "CHỈNH SỬA THÔNG TIN";
                        productModal.style.display = "block";
                    });
            });
        });

        // Sự kiện xóa sản phẩm
        document.querySelectorAll(".delete-btn").forEach((button) => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                confirmDeleteModal.style.display = "block";

                confirmDeleteBtn.addEventListener("click", function () {
                    fetch(`api.php?action=delete_product&id=${productId}`, {
                        method: "GET",
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                showNotification(data.message);
                            } else {
                                showNotification(
                                    "Đã xảy ra lỗi khi xóa sản phẩm."
                                );
                            }
                            confirmDeleteModal.style.display = "none";
                            loadProducts(); // Cập nhật lại danh sách sản phẩm
                        });
                });

                cancelDeleteBtn.addEventListener("click", function () {
                    confirmDeleteModal.style.display = "none";
                });
            });
        });
    }

    // Hàm hiển thị thông báo lỗi cho trường cụ thể
    function showError(inputId, message) {
        const inputElement = document.getElementById(inputId);
        const errorElement = document.createElement("div");
        errorElement.className = "error-message";
        errorElement.innerText = message;
        inputElement.parentElement.appendChild(errorElement);
    }

    // Hàm xóa toàn bộ thông báo lỗi
    function clearErrors() {
        const errors = document.querySelectorAll(".error-message");
        errors.forEach((error) => error.remove());
    }

    // Hàm hiển thị thông báo
    function showNotification(message) {
        const notification = document.createElement("div");
        notification.className = "notification";
        notification.innerText = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000); // Thông báo sẽ tự động biến mất sau 5 giây
    }

    // Hàm định dạng giá
    window.formatPrice = function (input) {
        let value = input.value.replace(/[^\d]/g, "");
        if (parseInt(value, 10) < 0) value = "0";
        if (value) {
            input.value = new Intl.NumberFormat("vi-VN").format(value);
        }
    };

    // Hàm định dạng số lượng
    window.formatQuantity = function (input) {
        let value = input.value.replace(/[^\d]/g, "");
        if (parseInt(value, 10) < 0) value = "0";
        if (value) {
            input.value = new Intl.NumberFormat("vi-VN").format(value);
        }
    };
});
