function quenPass(event) {
    event.preventDefault();
    let email = document.getElementById("quenPassEmail").value.trim();
    if (!validateEmail(email)) {
        displayError("emailError", "Vui lòng nhập email hợp lệ.");
        return;
    }
    let formData = new FormData();
    formData.append('email', email);
    formData.append('btnQuenMatKhau', true);

    sendAjaxRequest("quenpass.php", "POST", formData, (response) => {
        // Hiển thị thông báo trên đầu trang
        showNotification(response.message);
        // Đóng modal quên mật khẩu và mở lại modal đăng nhập
        closeModal("quenPassModal");
        showLoginModal();
    }, (error) => {
        displayError("quenPassMessage", error.message);
    });
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function displayError(elementId, message) {
    document.getElementById(elementId).innerText = message;
}
