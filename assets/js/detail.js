// Xử lý điều hướng cho các sản phẩm tương tự
document.getElementById('prevBtn').addEventListener('click', function() {
    document.getElementById('similarProducts').scrollBy({
        left: -200,
        behavior: 'smooth'
    });
});

document.getElementById('nextBtn').addEventListener('click', function() {
    document.getElementById('similarProducts').scrollBy({
        left: 200,
        behavior: 'smooth'
    });
});

// Xử lý sự kiện thêm vào giỏ hàng
document.getElementById('addToCart').addEventListener('click', function() {
    const productId = this.getAttribute('data-product-id');

    // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng
    fetch(`cart_actions.php?action=add&id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hiển thị thông báo sản phẩm đã được thêm vào giỏ hàng
                const notification = document.getElementById('notification');
                notification.textContent = 'Sản phẩm đã được thêm vào giỏ hàng';
                notification.style.display = 'block';

                // Ẩn thông báo sau 3 giây
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 3000);
            } else {
                console.error('Có lỗi xảy ra:', data.message);
            }
        })
        .catch(error => console.error('Lỗi:', error));
});

// Xử lý sự kiện mua ngay
document.querySelectorAll('.productCard').forEach(function(card) {
    card.addEventListener('click', function(event) {
        // Nếu không phải nút mua hoặc giỏ hàng, thì mới chuyển trang
        if (!event.target.closest('.btn-cart') && !event.target.closest('.btn-buy')) {
            const productId = this.id;
            window.location.href = 'detail.php?id=' + productId;
        }
    });
});
