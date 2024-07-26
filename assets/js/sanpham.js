function showProductDetails(productId) {
    // Thông tin giả lập về sản phẩm, bạn có thể thay thế bằng API hoặc dữ liệu từ server
    const products = {
        'product1': {
            name: 'Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024',
            price: '37,800,000đ',
            image: '/assets/image/yskh_024.jpg',
            description:'THÔNG TIN NỔI BẬT: Yến huyết đảo yến thiên nhiên nguyên tổ là tổ yến có màu đỏ tự nhiên. Sản phẩm Yến huyết đảo yến thiên nhiên nguyên tổ hộp 100g - MS 024 có giá trị dinh dưỡng rất cao.'
        },
        'product2': {
            name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
            price: '23,760,000đ',
            image: '/assets/image/yskh_026.jpg',
            description:'THÔNG TIN NỔI BẬT: Sản phẩm Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100g (mã số: 026), bao gồm những tổ yến hồng còn nguyên tổ, màu hồng nhạt có giá trị dinh dưỡng cao. Đặc biệt, chỉ có một số hang đảo thiên nhiên tại các đảo yến Khánh Hòa có tổ yến hồng.'
        },
        'product': {
            name: 'Yến huyết đảo thiên nhiên Khánh Hòa mẫu hộp quà tặng - 024S',
            price: '19,170,000₫',
            image: '/assets/image/_024s.jpg',
            description:' THÔNG TIN NỔI BẬT: Yến huyết đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng là tổ yến có màu sắc đỏ, màu đỏ tự nhiên của tổ yến đảo thiên nhiên. Sản phẩm Yến huyết đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng 50g (mã số: 024S) có giá trị dinh dưỡng rất cao.'

        },
        'product3': {
            name: 'Yến sao đảo yến thiên nhiên Khánh Hòa hộp 100G - TP1',
            price: '13,500,000₫',
            image: '/assets/image/tp1_9547ae75719143bea6c155e98e1fc816.jpg',
            description:' THÔNG TIN NỔI BẬT: Yến sào đảo yến thiên nhiên Khánh Hòa (nguyên tổ) hộp TP1-100g còn gọi là Yến Quang: là tổ yến còn nguyên, có xơ mướp, khoảng từ 15 đến 16 tổ yến/100g. Tổ yến có màu trắng theo thuộc tính tổ yến đảo thiên nhiên.'

        },
        'product4': {
            name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng - 026S',
            price: '12,150,000đ',
            image: '../assets/image/product/sanpham/yskh_026s.webp',
            description:'THÔNG TIN NỔI BẬT: Yến sào đảo yến thiên nhiên Khánh Hòa nguyên tổ hồng là tổ yến có màu sắc hồng nhạt trên bề mặt của tổ yến, màu sắc hồng tự nhiên của tổ yến đảo thiên nhiên. Sản phẩm Yến sào đảo yến thiên nhiên Khánh Hòa (Yến hồng hộp quà tặng 50g - 026S) được đóng gói bao bì theo kiểu dáng quà tặng trang trọng.'

        },
        // 'product5': {
        //     name: 'Yến sào đảo thiên nhiên tinh chế hộp 100G - 014',
        //     price: '6,568,452đ ' <Del>7,128,000đ </del>',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },
        // 'product2': {
        //     name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        //     price: '23,760,000đ',
        //     image: '/assets/image/yskh_026.jpg'
        // },

        
        // Thêm các sản phẩm khác ở đây
    };

    const product = products[productId];

    document.getElementById('productImage').src = product.image;
    document.getElementById('productName').textContent = product.name;
    document.getElementById('productPrice').textContent = product.price;
    document.getElementById('description').textContent = product.description;

    document.getElementById('productDetails').style.display = 'block';
}

function closeProductDetails() {
    document.getElementById('productDetails').style.display = 'none';
}
function addToCart() {
    alert('Đã thêm vào giỏ hàng');
}

