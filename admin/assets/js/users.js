const userModal = document.getElementById("userModal");
const userForm = document.getElementById("userForm");
const closeModal = document.querySelector(".close");
const addUserBtn = document.querySelector(".add-user-btn");
let editMode = false;
let currentEditRow = null;

function loadUsers() {
    fetch("api.php?action=get_users")
        .then((response) => response.json())
        .then((data) => {
            renderUsers(data);
        });
}

// Hàm để render người dùng
function renderUsers(users) {
    const tbody = document.querySelector(".user-table tbody");
    tbody.innerHTML = "";
    users.forEach((user) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${user.ho_ten}</td>
            <td>${user.email}</td>
            <td>${user.vai_tro}</td>
            <td class="actions">
                <button class="btn edit-btn" data-id="${user.id}">Sửa</button>
                <button class="btn delete-btn" data-id="${user.id}">Xóa</button>
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

    let actionUrl = "api.php?action=add_user";
    if (editMode) {
        formData.append("userId", currentEditRow);
        actionUrl = "api.php?action=update_user";
    }

    fetch(actionUrl, {
        method: "POST",
        body: formData,
    })
        .then((response) => response.text())
        .then((data) => {
            console.log(data);
            userModal.style.display = "none";
            loadUsers(); // Cập nhật lại danh sách người dùng sau khi thêm hoặc sửa
        });
});

function handleEdit(e) {
    const userId = e.target.dataset.id;
    fetch(`api.php?action=get_user&id=${userId}`)
        .then((response) => response.json())
        .then((data) => {
            const nameParts = data.ho_ten.split(' ');
            const firstName = nameParts[0];
            const lastName = nameParts.slice(1).join(' ');

            document.getElementById("userFirstName").value = firstName;
            document.getElementById("userLastName").value = lastName;
            document.getElementById("userEmail").value = data.email;
            document.getElementById("userRole").value = data.vai_tro;

            userModal.style.display = "block";
            editMode = true;
            currentEditRow = userId;
        });
}

function handleDelete(e) {
    const userId = e.target.dataset.id;
    if (confirm("Bạn có chắc chắn muốn xóa người dùng này?")) {
        fetch(`api.php?action=delete_user&id=${userId}`, {
            method: "GET",
        })
            .then((response) => response.text())
            .then((data) => {
                console.log(data);
                loadUsers(); // Cập nhật lại danh sách người dùng sau khi xóa
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
