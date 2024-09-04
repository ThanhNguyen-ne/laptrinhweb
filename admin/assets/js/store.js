document.addEventListener("DOMContentLoaded", function () {
    loadProducts();
    loadProductTypes();

    // Modal elements
    const productModal = document.getElementById("productModal");
    const confirmDeleteModal = document.getElementById("confirmDeleteModal");
    const closeModal = document.querySelector(".close");

    // Buttons
    const addProductBtn = document.getElementById("addProductBtn");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

    // Add product event
    addProductBtn.addEventListener("click", function () {
        document.getElementById("productForm").reset();
        document.getElementById("modalTitle").textContent = "THÊM SẢN PHẨM";
        productModal.style.display = "block";
    });

    // Close modal event
    closeModal.addEventListener("click", function () {
        productModal.style.display = "none";
    });

    // Handle form submission for adding/editing product
    document
        .getElementById("productForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);
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
                    loadProducts(); // Cập nhật lại danh sách sản phẩm mà không cần tải lại trang
                });
        });

    // Function to attach delete event to buttons
    function attachDeleteEvents() {
        document.querySelectorAll(".delete-btn").forEach((button) => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                confirmDeleteModal.style.display = "block";

                confirmDeleteBtn.onclick = function () {
                    fetch(`api.php?action=delete_product&id=${productId}`, {
                        method: "GET",
                    })
                        .then((response) => response.text())
                        .then((data) => {
                            showNotification(data);
                            confirmDeleteModal.style.display = "none";
                            loadProducts(); // Cập nhật lại danh sách sản phẩm mà không cần tải lại trang
                        });
                };

                cancelDeleteBtn.onclick = function () {
                    confirmDeleteModal.style.display = "none";
                };
            });
        });
    }

    // Load products
    function loadProducts() {
        fetch("api.php?action=get_products")
            .then((response) => response.json())
            .then((data) => {
                const productTableBody =
                    document.getElementById("productTableBody");
                productTableBody.innerHTML = "";
                data.forEach((product, index) => {
                    const row = `<tr>
                                    <td>${index + 1}</td>
                                    <td><img src="${
                                        product.hinh_anh
                                    }" alt="Hình ảnh"></td>
                                    <td>${product.ten_san_pham}</td>
                                    <td>${product.ten_loai}</td>
                                    <td>${new Intl.NumberFormat().format(
                                        product.gia
                                    )} ₫</td>
                                    <td>${product.so_luong_ton}</td>
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

                // Attach edit event after loading products
                document.querySelectorAll(".edit-btn").forEach((button) => {
                    button.addEventListener("click", function () {
                        const productId = this.getAttribute("data-id");
                        fetch(`api.php?action=get_product&id=${productId}`)
                            .then((response) => response.json())
                            .then((data) => {
                                document.getElementById("productId").value =
                                    data.id;
                                document.getElementById("productName").value =
                                    data.ten_san_pham;
                                document.getElementById(
                                    "productDescription"
                                ).value = data.mo_ta;
                                document.getElementById("productType").value =
                                    data.loai_san_pham_id;
                                document.getElementById("productPrice").value =
                                    data.gia;
                                document.getElementById(
                                    "productQuantity"
                                ).value = data.so_luong_ton;
                                document.getElementById(
                                    "modalTitle"
                                ).textContent = "CHỈNH SỬA THÔNG TIN";
                                productModal.style.display = "block";
                            });
                    });
                });

                // Attach delete event after loading products
                document.querySelectorAll(".delete-btn").forEach((button) => {
                    button.addEventListener("click", function () {
                        const productId = this.getAttribute("data-id");
                        confirmDeleteModal.style.display = "block";

                        confirmDeleteBtn.addEventListener("click", function () {
                            fetch(
                                `api.php?action=delete_product&id=${productId}`,
                                { method: "GET" }
                            )
                                .then((response) => response.text())
                                .then((data) => {
                                    showNotification(data);
                                    confirmDeleteModal.style.display = "none";
                                    loadProducts(); // Cập nhật lại danh sách sản phẩm mà không cần tải lại trang
                                });
                        });

                        cancelDeleteBtn.addEventListener("click", function () {
                            confirmDeleteModal.style.display = "none";
                        });
                    });
                });
            });
    }

    // Attach edit events to buttons (existing code)
    function attachEditEvents() {
        document.querySelectorAll(".edit-btn").forEach((button) => {
            button.addEventListener("click", function () {
                const productId = this.getAttribute("data-id");
                fetch(`api.php?action=get_product&id=${productId}`)
                    .then((response) => response.json())
                    .then((data) => {
                        document.getElementById("productId").value =
                            data.id;
                        document.getElementById("productName").value =
                            data.ten_san_pham;
                        document.getElementById(
                            "productDescription"
                        ).value = data.mo_ta;
                        document.getElementById("productType").value =
                            data.loai_san_pham_id;
                        document.getElementById("productPrice").value =
                            data.gia;
                        document.getElementById(
                            "productQuantity"
                        ).value = data.so_luong_ton;
                        document.getElementById(
                            "modalTitle"
                        ).textContent = "Chỉnh sửa sản phẩm";
                        productModal.style.display = "block";
                    });
            });
        });
    }

    // Load product types
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

    // Show notification function
    function showNotification(message) {
        const notification = document.createElement("div");
        notification.className = "notification";
        notification.innerText = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000); // Notification disappears after 5 seconds
    }

    // Close modal when clicking outside of it
    window.onclick = function (event) {
        if (event.target === productModal) {
            productModal.style.display = "none";
        }
        if (event.target === confirmDeleteModal) {
            confirmDeleteModal.style.display = "none";
        }
    };
});
