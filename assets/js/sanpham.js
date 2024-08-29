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
                    const notification = document.createElement('div');
                    notification.className = 'notification';
                    notification.style.color = 'white';
                    notification.innerText = data.message;
                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                const notification = document.createElement('div');
                notification.className = 'notification';
                notification.style.color = 'red';
                notification.innerText = "Lỗi khi thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.";
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            });
    });
});


// Sự kiện cho nút mua ngay
document.querySelectorAll('.btn-buy').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.stopPropagation(); // Ngăn không cho kích hoạt sự kiện click của thẻ cha
        const productId = this.parentNode.parentNode.id; // Get the product ID from the parent element
        window.location.href = 'checkout.php?id=' + productId;
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

// Sự kiện click cho các liên kết phân trang
document.querySelectorAll('.listPage li').forEach(function(li) {
    li.addEventListener('click', function(event) {
        const link = this.querySelector('a');
        if (link) {
            window.location.href = link.href;
        }
    });
});
