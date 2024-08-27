// Sự kiện cho nút thêm vào giỏ hàng
document.querySelectorAll('.btn-cart').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn không cho chuyển trang
        
        const url = this.href;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    // Hiển thị thông báo thành công
                    const notification = document.createElement('div');
                    notification.className = 'notification';
                    notification.innerText = data.message;
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                } else if (data.status === "error") {
                    // Hiển thị thông báo lỗi nếu có
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
    });
});

// Sự kiện cho nút mua ngay
document.querySelectorAll('.btn-buy').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.stopPropagation(); // Ngăn không cho kích hoạt sự kiện click của thẻ cha
        window.location.href = 'checkout.php';
    });
});

// Sự kiện click trên thẻ sản phẩm
document.querySelectorAll('.productCard').forEach(function(card) {
    card.addEventListener('click', function(event) {
        // Nếu không phải nút mua hoặc giỏ hàng, thì mới chuyển trang
        if (!event.target.closest('.btn-cart') && !event.target.closest('.btn-buy')) {
            const productId = this.id;
            window.location.href = 'detail.php?id=' + productId;
        }
    });
});

// Không ngăn sự kiện click của các liên kết phân trang
document.querySelectorAll('.listPage a').forEach(function(link) {
    link.addEventListener('click', function(event) {
        // Không ngăn chặn hành động mặc định của liên kết
    });
});
