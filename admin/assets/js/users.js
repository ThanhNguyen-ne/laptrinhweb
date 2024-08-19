const userModal = document.getElementById("userModal");
const userForm = document.getElementById("userForm");
const closeModal = document.querySelector(".close");
const addUserBtn = document.querySelector(".add-user-btn");
let editMode = false;
let currentEditRow = null;

function loadUsers() {
    fetch('get_users.php')
    .then(response => response.json())
    .then(data => {
        renderUsers(data);
    });
}

// Hàm để render người dùng
function renderUsers(users) {
    const tbody = document.querySelector(".user-table tbody");
    tbody.innerHTML = "";
    users.forEach((user, index) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${user.first_name} ${user.last_name}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td class="actions">
                <button class="btn edit-btn" data-id="${user.user_id}">Sửa</button>
                <button class="btn delete-btn" data-id="${user.user_id}">Xóa</button>
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

addUserBtn.addEventListener("click", () => {
    userModal.style.display = "block";
    userForm.reset();
    editMode = false;
    currentEditRow = null;
});

closeModal.addEventListener("click", () => {
    userModal.style.display = "none";
});

userForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(userForm);

    let url = 'add_user.php';
    if (editMode && currentEditRow !== null) {
        formData.append('user_id', currentEditRow);
        url = 'edit_user.php';
    }

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        userModal.style.display = "none";
        loadUsers();
    });
});

function handleEdit(e) {
    const userId = e.target.dataset.id;
    fetch(`get_user.php?id=${userId}`)
    .then(response => response.json())
    .then(data => {
        document.getElementById("userName").value = `${data.first_name} ${data.last_name}`;
        document.getElementById("userEmail").value = data.email;
        document.getElementById("userRole").value = data.role;

        userModal.style.display = "block";
        editMode = true;
        currentEditRow = userId;
    });
}

function handleDelete(e) {
    const userId = e.target.dataset.id;
    if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
        fetch(`delete_user.php?id=${userId}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadUsers();
        });
    }
}

window.onload = loadUsers;

const toggler = document.getElementById("theme-toggle");

toggler.addEventListener("change", function () {
    if (this.checked) {
        document.body.classList.add("dark");
    } else {
        document.body.classList.remove("dark");
    }
});
