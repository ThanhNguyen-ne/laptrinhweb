document.addEventListener('DOMContentLoaded', function () {
    const productModal = document.getElementById("productModal");
    const productForm = document.getElementById("productForm");
    const closeModal = document.querySelector(".close");
    const addProductBtn = document.querySelector(".add-product-btn");
    let editMode = false;
    let currentEditRow = null;

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
        products.forEach((product) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td><img src="${product.hinh_anh}" alt="${product.ten_san_pham}" style="width: 50px; height: 50px;"></td>
                <td>${product.ten_san_pham}</td>
                <td>${product.mo_ta}</td>
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
        if (editMode) {
            formData.append("productId", currentEditRow);
            actionUrl = "api.php?action=update_product";
        }

        fetch(actionUrl, {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((data) => {
                console.log(data);
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

                productModal.style.display = "block";
                editMode = true;
                currentEditRow = productId;
            });
    }

    function handleDelete(e) {
        const productId = e.target.dataset.id;
        if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
            fetch(`api.php?action=delete_product&id=${productId}`, {
                method: "GET",
            })
                .then((response) => response.text())
                .then((data) => {
                    console.log(data);
                    loadProducts(); // Cập nhật lại danh sách sản phẩm sau khi xóa
                });
        }
    }

    // Khởi động bằng cách load các sản phẩm
    loadProducts();
});
