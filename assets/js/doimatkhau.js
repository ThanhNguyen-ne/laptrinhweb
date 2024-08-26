document.getElementById("change-password-btn").onclick = function() {
    showChangePasswordModal();
};

document.getElementById("closeChangePasswordModal").onclick = function() {
    closeModal("changePasswordModal");
};

window.onclick = function(event) {
    if (event.target == document.getElementById("changePasswordModal")) {
        closeModal("changePasswordModal");
    }
};

function showChangePasswordModal() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "doimatkhau.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("changePasswordBody").innerHTML = xhr.responseText;
            document.getElementById("changePasswordModal").style.display = "block";
        }
    };
    xhr.send();
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function changePassword(event) {
    event.preventDefault();

    let currentPassword = document.getElementById("current_password").value.trim();
    let newPassword = document.getElementById("new_password").value.trim();
    let confirmPassword = document.getElementById("confirm_password").value.trim();

    let currentPasswordError = document.getElementById("currentPasswordError");
    let newPasswordError = document.getElementById("newPasswordError");
    let confirmPasswordError = document.getElementById("confirmPasswordError");
    let passwordMessage = document.getElementById("passwordMessage");

    currentPasswordError.innerText = "";
    newPasswordError.innerText = "";
    confirmPasswordError.innerText = "";
    passwordMessage.innerText = "";

    let formData = new FormData();
    formData.append('current_password', currentPassword);
    formData.append('new_password', newPassword);
    formData.append('confirm_password', confirmPassword);
    formData.append('change_password', true);

    fetch("doimatkhau.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            showNotification("Đổi mật khẩu thành công!");
            closeModal("changePasswordModal");
        } else {
            if (data.messages.current_password) {
                currentPasswordError.innerText = data.messages.current_password;
            }
            if (data.messages.new_password) {
                newPasswordError.innerText = data.messages.new_password;
            }
            if (data.messages.confirm_password) {
                confirmPasswordError.innerText = data.messages.confirm_password;
            }
        }
    })
    .catch(() => {
        passwordMessage.innerText = "Có lỗi xảy ra. Vui lòng thử lại.";
    });
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
