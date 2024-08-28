function showLoginModal() {
    var modal = document.getElementById("loginModal");
    var modalBody = document.getElementById("loginModalBody");

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "dangnhap.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = "flex";
            document.getElementById("loginEmail").style.display = "block";
            document.getElementById("loginPhone").style.display = "none";
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

function showQuenPassModal() {
    closeModal("loginModal");
    var modal = document.getElementById("quenPassModal");
    var modalBody = document.getElementById("quenPassModalBody");

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "quenpass.php", true);
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

    document.getElementById("loginEmail").setAttribute("name", "Email");
    document.getElementById("loginPhone").removeAttribute("name");
}

function switchToPhoneLogin() {
    document.getElementById("loginEmail").style.display = "none";
    document.getElementById("loginPhone").style.display = "block";
    document.getElementById("emailTab").classList.remove("active");
    document.getElementById("phoneTab").classList.add("active");

    document.getElementById("loginPhone").setAttribute("name", "Phone");
    document.getElementById("loginEmail").removeAttribute("name");
}

function login(event) {
    event.preventDefault();

    let email = document.getElementById("loginEmail").value.trim();
    let phone = document.getElementById("loginPhone").value.trim();
    let password = document.getElementById("loginPassword").value.trim();

    let emailError = document.getElementById("emailError");
    let phoneError = document.getElementById("phoneError");
    let passwordError = document.getElementById("passwordError");
    let loginMessage = document.getElementById("loginMessage");

    emailError.innerText = "";
    phoneError.innerText = "";
    passwordError.innerText = "";
    loginMessage.innerText = "";

    let formData = new FormData();
    if (email !== "") {
        formData.append("Email", email);
    } else if (phone !== "") {
        formData.append("Phone", phone);
    } else {
        loginMessage.innerText = "Vui lòng nhập email hoặc số điện thoại.";
        return;
    }
    formData.append("Password", password);
    formData.append("dangnhap", true);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "dangnhap.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                showNotification("Đăng nhập thành công!");
                window.location.href = response.redirect;
            } else {
                if (response.messages.email) {
                    emailError.innerText = response.messages.email;
                }
                if (response.messages.phone) {
                    phoneError.innerText = response.messages.phone;
                }
                if (response.messages.password) {
                    passwordError.innerText = response.messages.password;
                }
            }
        } else {
            loginMessage.innerText = "Có lỗi xảy ra, vui lòng thử lại.";
        }
    };
    xhr.send(formData);
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
    let addressError = document.getElementById("addressError");
    let passwordError = document.getElementById("passwordError");
    let regMessage = document.getElementById("regMessage");

    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    emailError.innerText = "";
    phoneError.innerText = "";
    fullnameError.innerText = "";
    addressError.innerText = "";
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
    if (!address) {
        addressError.innerText = "Vui lòng nhập địa chỉ.";
        hasError = true;
    }
    if (password.length < 6) {
        passwordError.innerText = "Mật khẩu phải có ít nhất 6 ký tự.";
        hasError = true;
    }

    if (hasError) {
        return;
    }

    let formData = new FormData();
    formData.append("Fullname", fullname);
    formData.append("Email", email);
    formData.append("Phone", phone);
    formData.append("Address", address);
    formData.append("Password", password);
    formData.append("dangki", true);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "dangki.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                showNotification("Đăng ký thành công!");
                closeModal("signupModal");

                showLoginModal();
            } else {
                regMessage.innerHTML = response.message;
            }
        } else {
            regMessage.innerText = "Có lỗi xảy ra, vui lòng thử lại.";
        }
    };
    xhr.send(formData);
}

function showNotification(message) {
    const notification = document.createElement("div");
    notification.className = "notification";
    notification.innerText = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);
}

function submitQuenPassForm(event) {
    event.preventDefault();

    let email = document.getElementById("quenPassEmail").value.trim();
    let quenPassMessage = document.getElementById("quenPassMessage");

    quenPassMessage.innerText = ""; // Xóa thông báo cũ

    let formData = new FormData();
    formData.append("email", email);
    formData.append("btnQuenMatKhau", true);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "quenpass.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                quenPassMessage.innerText = response.message; // Hiển thị thông báo thành công
                closeModal("quenPassModal");
                showLoginModal();
                showNotification("Yêu cầu đã được gửi đi"); // Hiển thị thông báo như mong muốn
            } else {
                quenPassMessage.innerText = response.message; // Hiển thị thông báo lỗi
            }
        } else {
            quenPassMessage.innerText = "Có lỗi xảy ra, vui lòng thử lại.";
        }
    };
    xhr.send(formData);
}

// Sử dụng hàm này khi form "Quên mật khẩu" được gửi đi
document
    .getElementById("quenPassForm")
    .addEventListener("submit", submitQuenPassForm);
