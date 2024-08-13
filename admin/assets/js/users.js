const userModal = document.getElementById("userModal");
const userForm = document.getElementById("userForm");
const closeModal = document.querySelector(".close");
const addUserBtn = document.querySelector(".add-user-btn");
let editMode = false;
let currentEditRow = null;

const users = [
    { name: "Nguyễn Quốc Tùng", email: "tung@gmail.com", role: "Admin" },
    { name: "Nguyễn Võ Thành", email: "thanh@gmai.com", role: "User" },
];

// Function to render users
function renderUsers() {
    const tbody = document.querySelector(".user-table tbody");
    tbody.innerHTML = "";
    users.forEach((user, index) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
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

// Open modal to add user
addUserBtn.addEventListener("click", () => {
    userModal.style.display = "block";
    userForm.reset();
    editMode = false;
    currentEditRow = null;
});

// Close modal
closeModal.addEventListener("click", () => {
    userModal.style.display = "none";
});

// Handle form submit
userForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const name = document.getElementById("userName").value;
    const email = document.getElementById("userEmail").value;
    const role = document.getElementById("userRole").value;

    if (editMode && currentEditRow !== null) {
        users[currentEditRow] = { name, email, role };
    } else {
        users.push({ name, email, role });
    }

    userModal.style.display = "none";
    renderUsers();
});

// Handle edit
function handleEdit(e) {
    const index = e.target.dataset.index;
    const user = users[index];
    document.getElementById("userName").value = user.name;
    document.getElementById("userEmail").value = user.email;
    document.getElementById("userRole").value = user.role;

    userModal.style.display = "block";
    editMode = true;
    currentEditRow = index;
}

// Handle delete
function handleDelete(e) {
    const index = e.target.dataset.index;
    users.splice(index, 1);
    renderUsers();
}

// Initial render
renderUsers();


const toggler = document.getElementById("theme-toggle");

toggler.addEventListener("change", function () {
    if (this.checked) {
        document.body.classList.add("dark");
    } else {
        document.body.classList.remove("dark");
    }
});
