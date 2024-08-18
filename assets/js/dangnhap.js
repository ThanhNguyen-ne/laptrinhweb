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
}

function switchToPhoneLogin() {
    document.getElementById("loginEmail").style.display = "none";
    document.getElementById("loginPhone").style.display = "block";
    document.getElementById("emailTab").classList.remove("active");
    document.getElementById("phoneTab").classList.add("active");
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
    let lowerCaseLetter = /[a-z]/g;
    let upperCaseLetter = /[A-Z]/g;
    let numbers = /[0-9]/g;

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
    if (password.length < 8) {
        passwordError.innerText = "Mật khẩu phải có ít nhất 8 ký tự.";
        hasError = true;
    }
    if (!password.match(lowerCaseLetter)) {
        passwordError.innerText = "Mật khẩu phải có ít nhất một chữ thường.";
        hasError = true;
    }
    if (!password.match(upperCaseLetter)) {
        passwordError.innerText = "Mật khẩu phải có ít nhất một chữ in hoa.";
        hasError = true;
    }
    if (!password.match(numbers)) {
        passwordError.innerText = "Mật khẩu phải có ít nhất một chữ số.";
        hasError = true;
    }

    if (hasError) {
        return;
    }

    let user = {
        email: email,
        phone: phone,
        fullname: fullname,
        address: address,
        password: password,
    };

    let users = localStorage.getItem("users")
        ? JSON.parse(localStorage.getItem("users"))
        : {};

    if (users[email] || users[phone]) {
        regMessage.innerText = "Người dùng đã tồn tại.";
        regMessage.style.color = "red";
    } else {
        users[email] = user;
        localStorage.setItem("users", JSON.stringify(users));
        regMessage.innerText = "Đăng ký thành công!";
        regMessage.style.color = "green";
    }
}

function login(event) {
    event.preventDefault();

    let emailOrPhone = document.getElementById("loginEmail").style.display !== "none" ?
        document.getElementById("loginEmail").value.trim() :
        document.getElementById("loginPhone").value.trim();
    let password = document.getElementById("loginPassword").value.trim();
    let loginMessage = document.getElementById("loginMessage");

    let users = localStorage.getItem("users")
        ? JSON.parse(localStorage.getItem("users"))
        : {};

    if (!emailOrPhone || !password) {
        loginMessage.innerText = "Vui lòng nhập thông tin và mật khẩu.";
        loginMessage.style.color = "red";
        return;
    }

    if ((users[emailOrPhone] && users[emailOrPhone].password === password) ||
        Object.values(users).some(user => user.phone === emailOrPhone && user.password === password)) {
        loginMessage.innerText = "Đăng nhập thành công!";
        loginMessage.style.color = "green";
        window.location.href = "index.php";
        alert("Đăng nhập thành công");
    } else {
        loginMessage.innerText = "Thông tin hoặc mật khẩu không đúng.";
        loginMessage.style.color = "red";
    }
}
