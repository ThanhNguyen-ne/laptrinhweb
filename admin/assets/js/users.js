const userModal = document.getElementById("userModal");
const userForm = document.getElementById("userForm");
const closeModal = document.querySelectorAll(".close");
const addUserBtn = document.querySelector(".add-user-btn");
let editMode = false;
let currentEditRow = null;

function loadUsers() {
    const searchParams = new URLSearchParams(window.location.search);
    const searchQuery = searchParams.get("search") || "";

    fetch(`api.php?action=get_users&search=${encodeURIComponent(searchQuery)}`)
        .then((response) => response.json())
        .then((data) => {
            renderUsers(data);
        });
}

// Hàm chuyển đổi vai trò từ tiếng Việt về định dạng cơ sở dữ liệu
function reverseTranslateRole(role) {
    switch (role) {
        case "Quản trị viên":
            return "admin";
        case "Khách hàng":
            return "khach_hang";
        default:
            return role;
    }
}

function translateRole(role) {
    switch (role) {
        case "admin":
            return "Quản trị viên";
        case "khach_hang":
            return "Khách hàng";
        default:
            return role;
    }
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
            <td>${user.so_dien_thoai || "Không có"}</td>
            <td>${translateRole(user.vai_tro)}</td>
<td class="actions">
    <button class="btn edit-btn" data-id="${user.id}" >
        <i class="bx bx-pencil"></i>
    </button>
</td>

        `;
        tbody.appendChild(tr);
    });

    attachEventHandlers(); // Gắn sự kiện sau khi render
}

function attachEventHandlers() {
    document.querySelectorAll(".edit-btn").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            e.stopPropagation();
            handleEdit(e);
        });
    });
}

// Hàm kiểm tra và hiển thị thông báo lỗi
function validateUserForm() {
    
    let fullname = document.getElementById("userFullName").value.trim();
    let phone = document.getElementById("userPhone").value.trim();
    let email = document.getElementById("userEmail").value.trim();
    let address = document.getElementById("userAddress").value.trim();
    let password = document.getElementById("userPassword").value.trim();
    let role = document.getElementById("userRole").value;

    let fullnameError = document.getElementById("fullnameError");
    let phoneError = document.getElementById("phoneError");
    let emailError = document.getElementById("emailError");
    let addressError = document.getElementById("addressError");
    let passwordError = document.getElementById("passwordError");
    let roleError = document.getElementById("roleError");

    // Reset all error messages
    fullnameError.innerText = "";
    phoneError.innerText = "";
    emailError.innerText = "";
    addressError.innerText = "";
    passwordError.innerText = "";
    roleError.innerText = "";

    let hasError = false;

    if (!fullname) {
        fullnameError.innerText = "Vui lòng nhập họ và tên.";
        hasError = true;
    }
    if (!phone) {
        phoneError.innerText = "Vui lòng nhập số điện thoại.";
        hasError = true;
    } else if (!/^\d{10}$/.test(phone)) {
        phoneError.innerText = "Vui lòng nhập đúng số điện thoại.";
        hasError = true;
    }
    if (!email) {
        emailError.innerText = "Vui lòng nhập email.";
        hasError = true;
    } else if (!email.includes("@")) {
        emailError.innerText = "Email phải có ký tự '@'.";
        hasError = true;
    } else if (!email.includes(".")) {
        emailError.innerText = "Email phải có dấu chấm '.'";
        hasError = true;
    } else if (email.indexOf(" ") !== -1) {
        emailError.innerText = "Vui lòng không để khoảng trắng.";
        hasError = true;
    } else if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
        emailError.innerText = "Vui lòng nhập email hợp lệ.";
        hasError = true;
    }
    if (!address) {
        addressError.innerText = "Vui lòng nhập địa chỉ.";
        hasError = true;
    }
    if (editMode === false && password.length < 6) {
        passwordError.innerText = "Mật khẩu phải có ít nhất 6 ký tự.";
        hasError = true;
    }
    if (!role) {
        roleError.innerText = "Vui lòng chọn vai trò.";
        hasError = true;
    }

    return !hasError;
}

// Ẩn thông báo lỗi khi đóng modal
function resetErrors() {
    document.getElementById("fullnameError").innerText = "";
    document.getElementById("phoneError").innerText = "";
    document.getElementById("emailError").innerText = "";
    document.getElementById("addressError").innerText = "";
    document.getElementById("passwordError").innerText = "";
    document.getElementById("roleError").innerText = "";
}

addUserBtn.addEventListener("click", () => {
    userModal.style.display = "block";
    userForm.reset();
    resetErrors(); // Ẩn các thông báo lỗi khi modal mở
    editMode = false;
    currentEditRow = null;
    userModal.querySelector("h2").innerText = "THÊM NGƯỜI DÙNG"; // Đặt tiêu đề modal là "Thêm Người dùng"
});

closeModal.forEach((btn) => {
    btn.addEventListener("click", () => {
        userModal.style.display = "none";
        resetErrors(); // Ẩn các thông báo lỗi khi đóng modal
    });
});

userForm.addEventListener("submit", (e) => {
    e.preventDefault();

    if (!validateUserForm()) {
        return; // Nếu có lỗi, dừng submit
    }

    const formData = new FormData(userForm);
    const role = document.getElementById("userRole").value;
    formData.set("userRole", reverseTranslateRole(role));

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
            document.getElementById("userRole").value = reverseTranslateRole(
                data.vai_tro
            ); // Hiển thị đúng vai trò

            userModal.style.display = "block";
            editMode = true;
            currentEditRow = userId;
            userModal.querySelector("h2").innerText = "CHỈNH SỬA THÔNG TIN";
            resetErrors(); // Ẩn các thông báo lỗi khi mở modal chỉnh sửa
        });
}

window.onload = loadUsers;
