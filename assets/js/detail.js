document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.getElementById("carousel");
    const prevBtn = document.getElementById("prev-btn");
    const nextBtn = document.getElementById("next-btn");

    let scrollPosition = 0;

    function scrollCarousel(direction) {
        const cardWidth = carousel.querySelector('.product-card').offsetWidth + 20; // 20px là gap
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;

        scrollPosition += direction * cardWidth;

        if (scrollPosition > maxScroll) {
            scrollPosition = 0; // Quay lại đầu
        } else if (scrollPosition < 0) {
            scrollPosition = maxScroll; // Quay lại cuối
        }

        carousel.scrollTo({
            left: scrollPosition,
            behavior: 'smooth'
        });
    }

    prevBtn.addEventListener("click", function() {
        scrollCarousel(-1);
    });

    nextBtn.addEventListener("click", function() {
        scrollCarousel(1);
    });
});

function addToCart(productId) {
    fetch(`cart_actions.php?action=add&id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notification = document.createElement('div');
                notification.className = 'notification';
                notification.innerText = 'Đã thêm vào giỏ hàng';
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
}

function redirectToCheckout() {
    window.location.href = 'checkout.php';
}
