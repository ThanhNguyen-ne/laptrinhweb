// Không ẩn header khi cuộn
const header = document.querySelector("header");

window.addEventListener("scroll", function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > 100) {
        header.style.backgroundColor = "rgba(173, 216, 230, 0.9)"; // Thay đổi màu nền header khi cuộn xuống
    } else {
        header.style.backgroundColor = "rgb(173, 216, 230)"; // Khôi phục màu nền ban đầu khi quay lại đầu trang
    }
});

function validateSearch() {
    var searchInput = document.getElementById("searchInput").value.trim();
    if (searchInput === "") {
        showNotification("Vui lòng nhập thông tin tìm kiếm!");
        return false; // Ngăn form gửi đi nếu không có thông tin tìm kiếm
    }
    return true;
}

function showNotification(message) {
    var notificationBar = document.getElementById("notification-bar");
    var notificationMessage = document.getElementById("notification-message");
    notificationMessage.textContent = message;
    notificationBar.classList.add("show");

    setTimeout(function() {
        notificationBar.classList.remove("show");
    }, 3000); // Ẩn thông báo sau 3 giây
}

document.getElementById("loginBtn").onclick = function() {
    showLoginModal();
};

document.getElementById("signupBtn").onclick = function() {
    showSignupModal();
};

document.getElementById("closeLoginModal").onclick = function() {
    closeModal("loginModal");
};

document.getElementById("closeSignupModal").onclick = function() {
    closeModal("signupModal");
};

document.getElementById("cartBtn").onclick = function(event) {
    if (!isLoggedIn) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định
        showLoginModal(); // Hiển thị modal đăng nhập
    } else {
        window.location.href = "cart.php";
    }
};
