window.addEventListener("scroll", function () {
    var header = document.querySelector(".header_duoi");
    var headerPosition = header.offsetTop;
    if (window.pageYOffset > headerPosition) {
        header.classList.add("fixed");
    } else {
        header.classList.remove("fixed");
    }
});
