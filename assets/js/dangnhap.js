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



function register(event) {
    event.preventDefault();

    let email = document.getElementById("regEmail").value.trim();
    let phone = document.getElementById("regPhone").value.trim();
    let fullname = document.getElementById("regFullName").value.trim();
    let address = document.getElementById("regAddress").value.trim();
    let password = document.getElementById("regPassWord").value.trim();

    let emailError = document.getElementById("emailError");
    let phoneError = document.getElementById("phoneError");
    let fullnameError = document.getElementById("fullnameError");
    let passwordError = document.getElementById("passwordError"); // Đảm bảo biến này đã khai báo
    let regMessage = document.getElementById("regMessage");

    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Xóa phần kiểm tra lỗi địa chỉ
    emailError.innerText = "";
    phoneError.innerText = "";
    fullnameError.innerText = "";
    passwordError.innerText = "";
    regMessage.innerText = "";

    let hasError = false;

    if (!email.match(emailRegex)) {
        emailError.innerText = "Vui lòng nhập email hợp lệ.";
        hasError = true;
    }
    if (!phone.match(/^\d{10}$/)) {
        phoneError.innerText = "Số điện thoại phải có đúng 10 chữ số.";
        hasError = true;
    }
    if (!fullname) {
        fullnameError.innerText = "Vui lòng nhập họ và tên.";
        hasError = true;
    }
    if (password.length < 6) {
        passwordError.innerText = "Mật khẩu phải có ít nhất 6 ký tự.";
        hasError = true;
    }

    if (hasError) {
        return;
    }

    // Gửi dữ liệu đăng ký tới server bằng Ajax
    let formData = new FormData();
    formData.append('Email', email);
    formData.append('Phone', phone);
    formData.append('Fullname', fullname);
    formData.append('Address', address);
    formData.append('Password', password);
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "dangki.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            regMessage.innerText = xhr.responseText;
        } else {
            regMessage.innerText = "Có lỗi xảy ra, vui lòng thử lại.";
        }
    };
    xhr.send(formData);
}
