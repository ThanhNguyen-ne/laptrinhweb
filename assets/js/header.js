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
