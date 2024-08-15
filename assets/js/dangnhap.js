document.addEventListener('DOMContentLoaded', function() {

    const emailToggleBtn = document.getElementById('emailToggle');
    const phoneToggleBtn = document.getElementById('phoneToggle');
    const emailLoginForm = document.getElementById('emailLoginForm');
    const phoneLoginForm = document.getElementById('phoneLoginForm');
    const regForm = document.querySelector('.form');

    function toggleForm(showEmail) {
        if (showEmail) {
            emailLoginForm.style.display = 'block';
            phoneLoginForm.style.display = 'none';
            emailToggleBtn.classList.add('active');
            phoneToggleBtn.classList.remove('active');
        } else {
            emailLoginForm.style.display = 'none';
            phoneLoginForm.style.display = 'block';
            emailToggleBtn.classList.remove('active');
            phoneToggleBtn.classList.add('active');
        }
    }

    function showLoginModal(modalId, modalContentUrl) {
        const modal = document.getElementById(modalId);
        const modalBody = modal.querySelector('.modal-body');

        fetch(modalContentUrl)
            .then(response => response.text())
            .then(html => {
                modalBody.innerHTML = html;
                modal.style.display = 'flex';
            })
            .catch(error => console.error('Error fetching modal content:', error));
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'none';
    }

    function validateRegistrationForm() {
        const email = document.getElementById('regEmail').value.trim();
        const phone = document.getElementById('regPhone').value.trim();
        const fullName = document.getElementById('regFullName').value.trim();
        const username = document.getElementById('regUsername').value.trim();
        const password = document.getElementById('regPassWord').value.trim();
        const address = document.getElementById('regAddress').value.trim();

        const emailError = document.getElementById('emailError');
        const phoneError = document.getElementById('phoneError');
        const fullNameError = document.getElementById('fullnameError');
        const usernameError = document.getElementById('usernameError');
        const passwordError = document.getElementById('passwordError');
        const addressError = document.getElementById('addressError');
        const regMessage = document.getElementById('regMessage');

        emailError.innerText = '';
        phoneError.innerText = '';
        fullNameError.innerText = '';
        usernameError.innerText = '';
        passwordError.innerText = '';
        addressError.innerText = '';
        regMessage.innerText = '';

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const hasError = false;

        if (email && !email.match(emailRegex)) {
            emailError.innerText = 'Vui lòng nhập email hợp lệ.';
            hasError = true;
        }

        if (phone && !phone.match(/^\d{10}$/)) {
            phoneError.innerText = 'Số điện thoại phải có đúng 10 chữ số.';
            hasError = true;
        }

        if (!fullName) {
            fullNameError.innerText = 'Vui lòng nhập họ và tên.';
            hasError = true;
        }

        if (!username) {
            usernameError.innerText = 'Vui lòng nhập tên đăng nhập.';
            hasError = true;
        }

        if (password.length < 8) {
            passwordError.innerText = 'Mật khẩu phải có ít nhất 8 ký tự.';
            hasError = true;
        } else if (!/[a-z]/.test(password)) {
            passwordError.innerText = 'Mật khẩu phải có ít nhất một chữ thường.';
            hasError = true;
        } else if (!/[A-Z]/.test(password)) {
            passwordError.innerText = 'Mật khẩu phải có ít nhất một chữ in hoa.';
            hasError = true;
        } else if (!/[0-9]/.test(password)) {
            passwordError.innerText = 'Mật khẩu phải có ít nhất một chữ số.';
            hasError = true;
        }

        if (!address) {
            addressError.innerText = 'Vui lòng nhập địa chỉ.';
            hasError = true;
        }

        return !hasError;
    }

    function register(event) {
        event.preventDefault();

        if (!validateRegistrationForm()) {
            return;
        }

        const user = {
            email: document.getElementById('regEmail').value.trim(),
            phone: document.getElementById('regPhone').value.trim(),
            fullname: document.getElementById('regFullName').value.trim(),
            username: document.getElementById('regUsername').value.trim(),
            password: document.getElementById('regPassWord').value.trim(),
            address: document.getElementById('regAddress').value.trim()
        };

        const users = JSON.parse(localStorage.getItem('users')) || {};

        if (users[user.username]) {
            document.getElementById('regMessage').innerText = 'Tên người dùng đã tồn tại.';
            document.getElementById('regMessage').style.color = 'red';
        } else {
            users[user.username] = user;
            localStorage.setItem('users', JSON.stringify(users));
            document.getElementById('regMessage').innerText = 'Đăng ký thành công!';
            document.getElementById('regMessage').style.color = 'green';
        }
    }

    function login(event) {
        event.preventDefault();

        const usernameOrPhone = document.getElementById('loginEmail').value.trim() || document.getElementById('loginPhone').value.trim();
        const password = document.getElementById('loginPassword').value.trim();
        const loginMessage = document.getElementById('loginMessage');
        const users = JSON.parse(localStorage.getItem('users')) || {};

        if (!usernameOrPhone || !password) {
            loginMessage.innerText = 'Vui lòng nhập thông tin đăng nhập và mật khẩu.';
            loginMessage.style.color = 'red';
            return;
        }

        if (users[usernameOrPhone] && users[usernameOrPhone].password === password) {
            loginMessage.innerText = 'Đăng nhập thành công!';
            loginMessage.style.color = 'green';
            window.location.href = 'index.html';
        } else {
            loginMessage.innerText = 'Tên người dùng hoặc mật khẩu không đúng.';
            loginMessage.style.color = 'red';
        }
    }

    // Event listeners
    regForm.addEventListener('submit', register);
    emailToggleBtn.addEventListener('click', () => toggleForm(true));
    phoneToggleBtn.addEventListener('click', () => toggleForm(false));

    // Initialize with email form visible
    toggleForm(true);
});
