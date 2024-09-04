const userModal = document.getElementById("userModal");
const pinModal = document.getElementById("pinModal");
const userForm = document.getElementById("userForm");
const pinForm = document.getElementById("pinForm");
const closeModal = document.querySelectorAll(".close");
const addUserBtn = document.querySelector(".add-user-btn");
let editMode = false;
let currentEditRow = null;
let currentPassword = null;

function loadUsers() {
    const searchParams = new URLSearchParams(window.location.search);
    const searchQuery = searchParams.get('search') || '';

    fetch(`api.php?action=get_users&search=${encodeURIComponent(searchQuery)}`)
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
            <td>${user.id}</td>
            <td>${user.ho_ten}</td>
            <td>${user.email}</td>
            <td>${user.so_dien_thoai || 'Không có'}</td>
            <td class="password-cell">
                <span class="hidden-password">****</span>
                <button class="btn show-password-btn" data-id="${user.id}">Hiện</button>
                <button class="btn hide-password-btn" data-id="${user.id}" style="display:none;">Ẩn</button>
            </td>
            <td>${user.vai_tro}</td>
            <td class="actions">
                <button class="btn edit-btn" data-id="${user.id}">Sửa</button>
                <button class="btn delete-btn" data-id="${user.id}">Xóa</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Thêm sự kiện click cho nút sửa, xóa và hiển thị mật khẩu
    document.querySelectorAll(".edit-btn").forEach((btn) => {
        btn.addEventListener("click", handleEdit);
    });

    document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.addEventListener("click", handleDelete);
    });

    document.querySelectorAll(".show-password-btn").forEach((btn) => {
        btn.addEventListener("click", handleShowPassword);
    });

    document.querySelectorAll(".hide-password-btn").forEach((btn) => {
        btn.addEventListener("click", handleHidePassword);
    });
}

function handleShowPassword(e) {
    const userId = e.target.dataset.id;
    currentPassword = null;
    pinModal.style.display = "block";
    pinForm.reset();
    document.getElementById('pinError').innerText = '';

    pinForm.onsubmit = function(event) {
        event.preventDefault();
        const pin = document.getElementById('pinInput').value;

        fetch(`api.php?action=verify_pin&user_id=${userId}&pin=${pin}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    currentPassword = data.password;
                    const passwordCell = e.target.closest('.password-cell');
                    passwordCell.querySelector('.hidden-password').innerText = currentPassword;
                    e.target.style.display = 'none';  // Ẩn nút "Hiện"
                    passwordCell.querySelector('.hide-password-btn').style.display = 'inline-block';  // Hiện nút "Ẩn"
                    pinModal.style.display = "none";
                } else {
                    document.getElementById('pinError').innerText = `Sai mã PIN! Bạn còn ${data.attempts_left} lần thử.`;
                }
            });
    };
}

function handleHidePassword(e) {
    const passwordCell = e.target.closest('.password-cell');
    passwordCell.querySelector('.hidden-password').innerText = '****';
    e.target.style.display = 'none';  // Ẩn nút "Ẩn"
    passwordCell.querySelector('.show-password-btn').style.display = 'inline-block';  // Hiện nút "Hiện"
}

addUserBtn.addEventListener("click", () => {
    userModal.style.display = "block";
    userForm.reset();
    editMode = false;
    currentEditRow = null;
    userModal.querySelector("h2").innerText = "THÊM NGƯỜI DÙNG";  // Đặt tiêu đề modal là "Thêm Người dùng"
});

closeModal.forEach((btn) => {
    btn.addEventListener("click", () => {
        userModal.style.display = "none";
        pinModal.style.display = "none";
    });
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
            document.getElementById("userFullName").value = data.ho_ten;
            document.getElementById("userPhone").value = data.so_dien_thoai;
            document.getElementById("userEmail").value = data.email;
            document.getElementById("userAddress").value = data.dia_chi;
            document.getElementById("userRole").value = data.vai_tro;

            userModal.style.display = "block";
            editMode = true;
            currentEditRow = userId;
            userModal.querySelector("h2").innerText = "CHỈNH SỬA THÔNG TIN";  // Đặt tiêu đề modal là "Chỉnh sửa Người dùng"
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
