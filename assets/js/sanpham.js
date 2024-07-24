function showProductDetails(productId) {
    // Thông tin giả lập về sản phẩm, bạn có thể thay thế bằng API hoặc dữ liệu từ server
    const products = {
        'product1': {
            name: 'Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024',
            price: '37,800,000đ',
            image: '/assets/image/yskh_024.jpg'
        },
        'product2': {
            name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
            price: '23,760,000đ',
            image: '/assets/image/yskh_026.jpg'
        },
        // Thêm các sản phẩm khác ở đây
    };

    const product = products[productId];

    document.getElementById('productImage').src = product.image;
    document.getElementById('productName').textContent = product.name;
    document.getElementById('productPrice').textContent = product.price;

    document.getElementById('productDetails').style.display = 'block';
}

function closeProductDetails() {
    document.getElementById('productDetails').style.display = 'none';
}

function addToCart() {
    alert('Đã thêm vào giỏ hàng');
}
