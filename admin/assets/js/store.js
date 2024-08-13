const productModal = document.getElementById("productModal");
const productForm = document.getElementById("productForm");
const closeModal = document.querySelector(".close");
const addProductBtn = document.querySelector(".add-product-btn");
let editMode = false;
let currentEditRow = null;

const products = [
    { name: "Sản phẩm A", price: 10000, status: "Còn hàng" },
    { name: "Sản phẩm B", price: 15000, status: "Hết hàng" },
];

// Function to render products
function renderProducts() {
    const tbody = document.querySelector(".product-table tbody");
    tbody.innerHTML = "";
    products.forEach((product, index) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${product.name}</td>
            <td>${product.price} VND</td>
            <td>${product.status}</td>
            <td class="actions">
                <button class="btn edit-btn" data-index="${index}">Sửa</button>
                <button class="btn delete-btn" data-index="${index}">Xóa</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Add event listeners for edit and delete buttons
    document.querySelectorAll(".edit-btn").forEach((btn) => {
        btn.addEventListener("click", handleEdit);
    });

    document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.addEventListener("click", handleDelete);
    });
}

// Open modal to add product
addProductBtn.addEventListener("click", () => {
    productModal.style.display = "block";
    productForm.reset();
    editMode = false;
    currentEditRow = null;
});

// Close modal
closeModal.addEventListener("click", () => {
    productModal.style.display = "none";
});

// Handle form submit
productForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const name = document.getElementById("productName").value;
    const price = document.getElementById("productPrice").value;
    const status = document.getElementById("productStatus").value;

    if (editMode && currentEditRow !== null) {
        products[currentEditRow] = { name, price, status };
    } else {
        products.push({ name, price, status });
    }

    productModal.style.display = "none";
    renderProducts();
});

// Handle edit
function handleEdit(e) {
    const index = e.target.dataset.index;
    const product = products[index];
    document.getElementById("productName").value = product.name;
    document.getElementById("productPrice").value = product.price;
    document.getElementById("productStatus").value = product.status;

    productModal.style.display = "block";
    editMode = true;
    currentEditRow = index;
}

// Handle delete
function handleDelete(e) {
    const index = e.target.dataset.index;
    products.splice(index, 1);
    renderProducts();
}

// Initial render
renderProducts();


const toggler = document.getElementById("theme-toggle");

toggler.addEventListener("change", function () {
    if (this.checked) {
        document.body.classList.add("dark");
    } else {
        document.body.classList.remove("dark");
    }
});
