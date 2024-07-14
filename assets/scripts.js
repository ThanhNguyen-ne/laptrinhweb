let slideIndex = 0;
const slides = document.querySelectorAll('.slide');

function showSlide(index) {
    const totalSlides = slides.length;
    if (index >= totalSlides) slideIndex = 0;
    if (index < 0) slideIndex = totalSlides - 1;
    const newTransform = -slideIndex * 100 + '%';
    document.querySelector('.slides').style.transform = `translateX(${newTransform})`;
}

function nextSlide() {
    slideIndex++;
    showSlide(slideIndex);
}

function prevSlide() {
    slideIndex--;
    showSlide(slideIndex);
}

// Auto slide
setInterval(nextSlide, 3000);

// Khởi tạo slider
showSlide(slideIndex);