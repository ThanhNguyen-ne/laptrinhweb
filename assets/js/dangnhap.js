function showLoginModal() {
    var modal = document.getElementById("loginModal");
    var modalBody = document.getElementById("loginModalBody");

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "dangnhap.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = "flex";
            switchToEmailLogin(); // Mặc định hiển thị phần đăng nhập bằng email
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

    let isEmailLogin = document.getElementById("loginEmail").style.display === "block";
    let hasError = false;

    if (isEmailLogin) {
        if (!email) {
            emailError.innerText = "Vui lòng nhập email.";
            hasError = true;
        } 
    } else {
        if (!phone) {
            phoneError.innerText = "Vui lòng nhập số điện thoại.";
            hasError = true;
        } else if (!/^\d{10}$/.test(phone)) {
            phoneError.innerText = "Vui lòng nhập đúng số điện thoại.";
            hasError = true;
        }
    }

    if (!password) {
        passwordError.innerText = "Vui lòng nhập mật khẩu.";
        hasError = true;
    }

    if (hasError) return;

    let formData = new FormData();
    if (isEmailLogin) {
        formData.append("Email", email);
    } else {
        formData.append("Phone", phone);
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

    // Reset all error messages
    emailError.innerText = "";
    phoneError.innerText = "";
    fullnameError.innerText = "";
    addressError.innerText = "";
    passwordError.innerText = "";
    regMessage.innerText = "";

    let hasError = false;

    // Check each field and update error messages
    if (!fullname) {
        fullnameError.innerText = "Vui lòng nhập họ và tên.";
        hasError = true;
    }
    if (!email) {
        emailError.innerText = "Vui lòng nhập email.";
        hasError = true;
    }
    if (!phone) {
        phoneError.innerText = "Vui lòng nhập số điện thoại.";
        hasError = true;
    } else if (!/^\d{10}$/.test(phone)) {
        phoneError.innerText = "Vui lòng nhập đúng số điện thoại.";
        hasError = true;
    }
    if (!address) {
        addressError.innerText = "Vui lòng nhập địa chỉ.";
        hasError = true;
    }
    if (!password) {
        passwordError.innerText = "Vui lòng nhập mật khẩu.";
        hasError = true;
    } else if (password.length < 6) {
        passwordError.innerText = "Mật khẩu phải có ít nhất 6 ký tự.";
        hasError = true;
    }

    // If there's any error, stop the form submission
    if (hasError) return;

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
