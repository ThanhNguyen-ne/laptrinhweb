document.addEventListener('DOMContentLoaded', function () {
    const productModal = document.getElementById("productModal");
    const productForm = document.getElementById("productForm");
    const closeModal = document.querySelector(".close");
    const addProductBtn = document.querySelector(".add-product-btn");
    const productTypeSelect = document.getElementById("productType");
    const toast = document.getElementById("toast");
    const confirmDeleteModal = document.getElementById("confirmDeleteModal");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

    let editMode = false;
    let currentEditRow = null;
    let productIdToDelete = null;

    // Load danh sách loại sản phẩm
    function loadProductTypes() {
        fetch("api.php?action=get_product_types")
            .then((response) => response.json())
            .then((data) => {
                data.forEach((type) => {
                    const option = document.createElement("option");
                    option.value = type.id;
                    option.textContent = type.ten_loai;
                    productTypeSelect.appendChild(option);
                });
            });
    }

    // Load sản phẩm từ cơ sở dữ liệu
    function loadProducts() {
        fetch("api.php?action=get_products")
            .then((response) => response.json())
            .then((data) => {
                renderProducts(data);
            });
    }

    // Hàm để format giá theo kiểu Việt Nam
    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    }

    // Hàm để render sản phẩm
    function renderProducts(products) {
        const tbody = document.querySelector(".product-table tbody");
        tbody.innerHTML = "";
        products.forEach((product, index) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td><img src="${product.hinh_anh}" alt="${product.ten_san_pham}" style="width: 50px; height: 50px;"></td>
                <td>${product.ten_san_pham}</td>
                <td>${product.ten_loai}</td>
                <td>${formatCurrency(product.gia)}</td>
                <td>${product.so_luong_ton}</td>
                <td class="actions">
                    <button class="btn edit-btn" data-id="${product.id}">Sửa</button>
                    <button class="btn delete-btn" data-id="${product.id}">Xóa</button>
                </td>
            `;
            tbody.appendChild(tr);
        });

        // Thêm sự kiện click cho nút sửa và xóa
        document.querySelectorAll(".edit-btn").forEach((btn) => {
            btn.addEventListener("click", handleEdit);
        });

        document.querySelectorAll(".delete-btn").forEach((btn) => {
            btn.addEventListener("click", handleDelete);
        });
    }

    addProductBtn.addEventListener("click", () => {
        productModal.style.display = "block";
        productForm.reset();
        editMode = false;
        currentEditRow = null;
    });

    closeModal.addEventListener("click", () => {
        productModal.style.display = "none";
    });

    productForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(productForm);

        let actionUrl = "api.php?action=add_product";
        let successMessage = "Thêm sản phẩm thành công!";
        if (editMode) {
            formData.append("productId", currentEditRow);
            actionUrl = "api.php?action=update_product";
            successMessage = "Chỉnh sửa sản phẩm thành công!";
        }

        fetch(actionUrl, {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((data) => {
                showToast(successMessage);
                productModal.style.display = "none";
                loadProducts(); // Cập nhật lại danh sách sản phẩm sau khi thêm hoặc sửa
            });
    });

    function handleEdit(e) {
        const productId = e.target.dataset.id;
        fetch(`api.php?action=get_product&id=${productId}`)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById("productName").value = data.ten_san_pham;
                document.getElementById("productDescription").value = data.mo_ta;
                document.getElementById("productPrice").value = data.gia;
                document.getElementById("productQuantity").value = data.so_luong_ton;
                document.getElementById("productType").value = data.loai_san_pham_id;

                productModal.style.display = "block";
                editMode = true;
                currentEditRow = productId;
            });
    }

    function handleDelete(e) {
        productIdToDelete = e.target.dataset.id;
        confirmDeleteModal.style.display = "block";
    }

    confirmDeleteBtn.addEventListener("click", () => {
        fetch(`api.php?action=delete_product&id=${productIdToDelete}`, {
            method: "GET",
        })
            .then((response) => response.text())
            .then((data) => {
                showToast("Xóa sản phẩm thành công!");
                loadProducts(); // Cập nhật lại danh sách sản phẩm sau khi xóa
                confirmDeleteModal.style.display = "none";
            });
    });

    cancelDeleteBtn.addEventListener("click", () => {
        confirmDeleteModal.style.display = "none";
    });

    // Hàm hiển thị thông báo
    function showToast(message) {
        toast.textContent = message;
        toast.className = "show";
        setTimeout(() => {
            toast.className = toast.className.replace("show", "");
        }, 3000);
    }

    // Khởi động bằng cách load các loại sản phẩm và sản phẩm
    loadProductTypes();
    loadProducts();
});
