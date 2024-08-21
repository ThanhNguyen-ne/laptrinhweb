function showLoginModal() {
    var modal = document.getElementById("loginModal");
    var modalBody = document.getElementById("loginModalBody");

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "dangnhap.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = "flex";
        }
    };
    xhr.send();
}

function showSignupModal() {
    var modal = document.getElementById("signupModal");
    var modalBody = document.getElementById("signupModalBody");

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "dangki.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = "flex";
        }
    };
    xhr.send();
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}

function switchToSignup() {
    closeModal("loginModal");
    showSignupModal();
}

function switchToLogin() {
    closeModal("signupModal");
    showLoginModal();
}

function switchToEmailLogin() {
    document.getElementById("loginEmail").style.display = "block";
    document.getElementById("loginPhone").style.display = "none";
    document.getElementById("emailTab").classList.add("active");
    document.getElementById("phoneTab").classList.remove("active");

    document.getElementById("loginEmail").setAttribute("name", "loginEmail");
    document.getElementById("loginPhone").removeAttribute("name");
}
function login(event) {
    event.preventDefault();

    let email = document.getElementById("loginEmail").value.trim();
    let phone = document.getElementById("loginPhone").value.trim();
    let password = document.getElementById("loginPassword").value.trim();
    let loginMessage = document.getElementById("loginMessage");

    let formData = new FormData();
    if (email !== '') {
        formData.append('loginEmail', email);
    } else if (phone !== '') {
        formData.append('loginPhone', phone);
    }
    formData.append('loginPassword', password);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "dangnhap.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            loginMessage.innerHTML = xhr.responseText;
        } else {
            loginMessage.innerText = "Có lỗi xảy ra, vui lòng thử lại.";
        }
    };
    xhr.send(formData);
}

function register(event) {
    event.preventDefault();

    // Lấy giá trị từ các input
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("so_dien_thoai").value.trim();
    let fullname = document.getElementById("ho_ten").value.trim();
    let password = document.getElementById("mat_khau").value.trim();

    // Các phần tử hiển thị lỗi
    let emailError = document.getElementById("emailError");
    let phoneError = document.getElementById("phoneError");
    let fullnameError = document.getElementById("fullnameError");
    let passwordError = document.getElementById("passwordError");
    let regMessage = document.getElementById("registerMessage");

    // Biểu thức chính quy để kiểm tra định dạng email
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Xóa các thông báo lỗi trước đó
    emailError.innerText = "";
    phoneError.innerText = "";
    fullnameError.innerText = "";
    passwordError.innerText = "";
    regMessage.innerText = "";

    // Biến kiểm tra lỗi
    let hasError = false;

    // Kiểm tra định dạng email
    if (!email.match(emailRegex)) {
        emailError.innerText = "Vui lòng nhập email hợp lệ.";
        hasError = true;
    }
    // Kiểm tra định dạng số điện thoại (10 chữ số)
    if (!phone.match(/^\d{10}$/)) {
        phoneError.innerText = "Số điện thoại phải có đúng 10 chữ số.";
        hasError = true;
    }
    // Kiểm tra họ và tên không được để trống
    if (!fullname) {
        fullnameError.innerText = "Vui lòng nhập họ và tên.";
        hasError = true;
    }
    // Kiểm tra mật khẩu có ít nhất 6 ký tự
    if (password.length < 6) {
        passwordError.innerText = "Mật khẩu phải có ít nhất 6 ký tự.";
        hasError = true;
    }

    // Nếu có lỗi, không gửi form
    if (hasError) {
        return;
    }

    // Gửi dữ liệu đăng ký tới server bằng Ajax nếu không có lỗi
    let formData = new FormData();
    formData.append('ho_ten', fullname);
    formData.append('email', email);
    formData.append('so_dien_thoai', phone);
    formData.append('mat_khau', password);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "dangki.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            regMessage.innerHTML = xhr.responseText;
        } else {
            regMessage.innerText = "Có lỗi xảy ra, vui lòng thử lại.";
        }
    };
    xhr.send(formData);
}
