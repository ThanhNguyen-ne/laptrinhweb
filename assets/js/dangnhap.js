function showLoginModal() {
    var modal = document.getElementById('loginModal');
    var modalBody = document.getElementById('loginModalBody');
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'dangnhap.html', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = 'flex';
        }
    };
    xhr.send();
}

function showSignupModal() {
    var modal = document.getElementById('signupModal');
    var modalBody = document.getElementById('signupModalBody');
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'dangki.html', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = 'flex';
        }
    };
    
    xhr.send();

}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}

// Switch to signup modal from login modal
function switchToSignup() {
    closeModal('loginModal');
    showSignupModal();
}

// Switch to login modal from signup modal
function switchToLogin() {
    closeModal('signupModal');
    showLoginModal();
}

function register(event) {
    event.preventDefault();

    // Lấy giá trị từ các input
    let username = document.getElementById('regUsername').value.trim();
    let password = document.getElementById('regPassWord').value.trim();
    let email = document.getElementById('regEmail').value.trim();
    let fullname = document.getElementById('regFullName').value.trim();
    let phone = document.getElementById('regPhone').value.trim();

    // Các phần tử để hiển thị lỗi
    let emailError = document.getElementById('emailError');
    let phoneError = document.getElementById('phoneError');
    let fullnameError = document.getElementById('fullnameError');
    let usernameError = document.getElementById('usernameError');
    let passwordError = document.getElementById('passwordError');
    let regMessage = document.getElementById('regMessage');

    // Biểu thức regex kiểm tra các điều kiện mật khẩu
    let lowerCaseLetter = /[a-z]/g;
    let upperCaseLetter = /[A-Z]/g;
    let numbers = /[0-9]/g;
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Xóa các thông báo lỗi trước đó
    emailError.innerText = '';
    phoneError.innerText = '';
    fullnameError.innerText = '';
    usernameError.innerText = '';
    passwordError.innerText = '';
    regMessage.innerText = '';

    // Biến chứa thông báo lỗi
    let hasError = false;

    // Kiểm tra nếu các trường bắt buộc bị bỏ trống hoặc không hợp lệ
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
    if (!username) {
        usernameError.innerText = "Vui lòng nhập tên đăng nhập.";
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

    // Nếu có lỗi, dừng quá trình đăng ký
    if (hasError) {
        return;
    }

    // Kiểm tra và lưu thông tin người dùng
    let user = {
        username: username,
        password: password,
        fullname: fullname,
        email: email,
    };

    let users = localStorage.getItem('users') ? JSON.parse(localStorage.getItem('users')) : {};

    if (users[username]) {
        regMessage.innerText = 'Tên người dùng đã tồn tại.';
        regMessage.style.color = 'red';
    } else {
        users[username] = user;
        localStorage.setItem('users', JSON.stringify(users));
        regMessage.innerText = "Đăng ký thành công!";
        regMessage.style.color = 'green';
    }
}


function login(event) {
        event.preventDefault();

        let username = document.getElementById('loginUsername').value.trim();
        let password = document.getElementById('loginPassword').value.trim();
        let loginMessage = document.getElementById('loginMessage');

        let users = localStorage.getItem('users') ? JSON.parse(localStorage.getItem('users')) : {};

        // Kiểm tra thông tin đăng nhập
        if (!username || !password) {
            loginMessage.innerText = "Vui lòng nhập tên người dùng và mật khẩu.";
            loginMessage.style.color = 'red';
            return;
        }

        if (users[username] && users[username].password === password) {
            loginMessage.innerText = "Đăng nhập thành công!";
            loginMessage.style.color = 'green';
            // Chuyển hướng đến trang chính hoặc thực hiện hành động sau khi đăng nhập thành công
            window.location.href = 'index.html'; // Ví dụ: chuyển hướng đến trang chính
            alert("Đăng nhập thành công")
        } else {
            loginMessage.innerText = "Tên người dùng hoặc mật khẩu không đúng.";
            loginMessage.style.color = 'red';
        }
    }
