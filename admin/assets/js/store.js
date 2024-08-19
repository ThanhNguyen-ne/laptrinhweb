// Thêm các hàm AJAX để xử lý thêm, sửa, xóa sản phẩm từ cơ sở dữ liệu

const productModal = document.getElementById("productModal");
const productForm = document.getElementById("productForm");
const closeModal = document.querySelector(".close");
const addProductBtn = document.querySelector(".add-product-btn");
let editMode = false;
let currentEditRow = null;

function loadProducts() {
    fetch('get_products.php')
    .then(response => response.json())
    .then(data => {
        renderProducts(data);
    });
}

// Hàm để render sản phẩm
function renderProducts(products) {
    const tbody = document.querySelector(".product-table tbody");
    tbody.innerHTML = "";
    products.forEach((product, index) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${product.product_name}</td>
            <td>${product.product_desc}</td>
            <td>${product.price} VND</td>
            <td>${product.quantity_in_stock}</td>
            <td class="actions">
                <button class="btn edit-btn" data-id="${product.product_id}">Sửa</button>
                <button class="btn delete-btn" data-id="${product.product_id}">Xóa</button>
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

    let url = 'add_product.php';
    if (editMode && currentEditRow !== null) {
        formData.append('product_id', currentEditRow);
        url = 'edit_product.php';
    }

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        productModal.style.display = "none";
        loadProducts();
    });
});

function handleEdit(e) {
    const productId = e.target.dataset.id;
    fetch(`get_product.php?id=${productId}`)
    .then(response => response.json())
    .then(data => {
        document.getElementById("productName").value = data.product_name;
        document.getElementById("productDescription").value = data.product_desc;
        document.getElementById("productPrice").value = data.price;
        document.getElementById("productQuantity").value = data.quantity_in_stock;
        document.getElementById("productStatus").value = data.status;

        productModal.style.display = "block";
        editMode = true;
        currentEditRow = productId;
    });
}

function handleDelete(e) {
    const productId = e.target.dataset.id;
    if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
        fetch(`delete_product.php?id=${productId}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadProducts();
        });
    }
}

window.onload = loadProducts;

const toggler = document.getElementById("theme-toggle");

toggler.addEventListener("change", function () {
    if (this.checked) {
        document.body.classList.add("dark");
    } else {
        document.body.classList.remove("dark");
    }
});
