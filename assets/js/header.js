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

