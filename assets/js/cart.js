let cart = [];

const products = {
    '1': {
        name: 'Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024',
        price: 37800000,
        image: '/assets/image/yskh_024.jpg',
        description: 'THÔNG TIN NỔI BẬT: Yến huyết đảo yến thiên nhiên nguyên tổ là tổ yến có màu đỏ tự nhiên. Sản phẩm Yến huyết đảo yến thiên nhiên nguyên tổ hộp 100g - MS 024 có giá trị dinh dưỡng rất cao.'
    },
    '2': {
        name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100G - 026',
        price: 23760000,
        image: '/assets/image/yskh_026.jpg',
        description: 'THÔNG TIN NỔI BẬT: Sản phẩm Yến hồng đảo yến thiên nhiên Khánh Hòa hộp 100g (mã số: 026), bao gồm những tổ yến hồng còn nguyên tổ, màu hồng nhạt có giá trị dinh dưỡng cao. Đặc biệt, chỉ có một số hang đảo thiên nhiên tại các đảo yến Khánh Hòa có tổ yến hồng.'
    },
    '3': {
        name: 'Yến huyết đảo thiên nhiên Khánh Hòa mẫu hộp quà tặng - 024S',
        price: 19170000,
        image: '/assets/image/_024s.jpg',
        description: 'THÔNG TIN NỔI BẬT: Yến huyết đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng là tổ yến có màu sắc đỏ, màu đỏ tự nhiên của tổ yến đảo thiên nhiên. Sản phẩm Yến huyết đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng 50g (mã số: 024S) có giá trị dinh dưỡng rất cao.'
    },
    '4': {
        name: 'Yến sao đảo yến thiên nhiên Khánh Hòa hộp 100G - TP1',
        price: 13500000,
        image: '/assets/image/tp1_9547ae75719143bea6c155e98e1fc816.jpg',
        description: 'THÔNG TIN NỔI BẬT: Yến sào đảo yến thiên nhiên Khánh Hòa (nguyên tổ) hộp TP1-100g còn gọi là Yến Quang: là tổ yến còn nguyên, có xơ mướp, khoảng từ 15 đến 16 tổ yến/100g. Tổ yến có màu trắng theo thuộc tính tổ yến đảo thiên nhiên.'
    },
    '5': {
        name: 'Yến hồng đảo yến thiên nhiên Khánh Hòa mẫu hộp quà tặng - 026S',
        price: 12150000,
        image: '../assets/image/product/sanpham/yskh_026s.webp',
        description: 'THÔNG TIN NỔI BẬT: Yến sào đảo yến thiên nhiên Khánh Hòa nguyên tổ hồng là tổ yến có màu sắc hồng nhạt trên bề mặt của tổ yến, màu sắc hồng tự nhiên của tổ yến đảo thiên nhiên. Sản phẩm Yến sào đảo yến thiên nhiên Khánh Hòa (Yến hồng hộp quà tặng 50g - 026S) được đóng gói bao bì theo kiểu dáng quà tặng trang trọng.'
    },
};

// Hiển thị chi tiết sản phẩm
function showProductDetails(productId) {
    const product = products[productId];
    if (product) {
        document.getElementById('productImage').src = product.image;
        document.getElementById('productName').textContent = product.name;
        document.getElementById('productPrice').textContent = `${product.price.toLocaleString()} VND`;
        document.getElementById('description').textContent = product.description;

        const addToCartButton = document.getElementById('addToCartButton');
        addToCartButton.dataset.productId = productId;
        addToCartButton.dataset.productName = product.name;
        addToCartButton.dataset.productPrice = product.price;
        addToCartButton.dataset.productImage = product.image;

        document.getElementById('productDetails').style.display = 'block';
        closeCartSidebar();
    }
}

function closeProductDetails() {
    document.getElementById('productDetails').style.display = 'none';
}

// Thêm sản phẩm vào giỏ hàng
function addToCart(productId, productName, productPrice, productImage) {
    const existingProduct = cart.find((product) => product.id === productId);
    if (existingProduct) {
        existingProduct.quantity++;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: productPrice,
            image: productImage,
            quantity: 1,
        });
    }
    updateCart();
    showNotification(`${productName} đã được thêm vào giỏ hàng`);
}

// Thay đổi số lượng sản phẩm trong giỏ hàng
function changeQuantity(productId, change) {
    const product = cart.find((product) => product.id === productId);
    if (product) {
        product.quantity += change;
        if (product.quantity <= 0) {
            removeFromCart(productId);
        } else {
            updateCart();
        }
    }
}

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart(productId) {
    cart = cart.filter((product) => product.id !== productId);
    updateCart();
}

// Cập nhật giỏ hàng
function updateCart() {
    const cartSidebar = document.getElementById("cartSidebar");
    const cartItemsContainer = cartSidebar.querySelector(".cart-items");
    cartItemsContainer.innerHTML = "";

    let totalPrice = 0;

    cart.forEach((product) => {
        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-item");
        cartItem.innerHTML = `
            <img src="${product.image}" alt="${product.name}">
            <div class="cart-item-details">
                <p>${product.name}</p>
                <p>${product.price.toLocaleString()} VND x ${product.quantity}</p>
            </div>
            <div class="cart-item-controls">
                <button onclick="changeQuantity(${product.id}, -1)">-</button>
                <button onclick="changeQuantity(${product.id}, 1)">+</button>
                <button onclick="removeFromCart(${product.id})">Xóa</button>
            </div>
        `;
        cartItemsContainer.appendChild(cartItem);

        totalPrice += product.price * product.quantity;
    });

    const cartTotal = cartSidebar.querySelector(".total");
    cartTotal.innerHTML = `
        <p>Tổng tiền: ${totalPrice.toLocaleString()} VND</p>
        <button onclick="checkout()" class="checkout-btn">Thanh toán</button>
    `;
}

// Hiển thị thông báo
function showNotification(message) {
    const notification = document.createElement('div');
    notification.classList.add('notification');
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Xử lý thanh toán
function checkout() {
    window.location.href = 'checkout.html';
    // Add any additional checkout logic here
}

// Chuyển đổi thanh bên giỏ hàng
function toggleCartSidebar() {
    const cartSidebar = document.getElementById("cartSidebar");
    const mainContent = document.querySelector(".main-content");
    
    if (cartSidebar.classList.contains("open")) {
        cartSidebar.classList.remove("open");
        mainContent.style.marginRight = "0";
    } else {
        cartSidebar.classList.add("open");
        mainContent.style.marginRight = "350px";
        closeProductDetails();
    }
}

// Sự kiện khi DOM đã tải xong
document.addEventListener('DOMContentLoaded', function () {
    // Xử lý sự kiện mở giỏ hàng
    document.getElementById('cartBtn').addEventListener('click', function (event) {
        event.preventDefault();
        toggleCartSidebar();
    });

    // Thêm sản phẩm vào giỏ hàng khi click nút "Add to Cart"
    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", function () {
            const productId = parseInt(this.dataset.productId, 10);
            const productName = this.dataset.productName;
            const productPrice = parseInt(this.dataset.productPrice, 10);
            const productImage = this.dataset.productImage;
            addToCart(productId, productName, productPrice, productImage);
        });
    });

    // Đóng giỏ hàng
    document
        .getElementById("cartSidebar")
        .querySelector(".close")
        .addEventListener("click", closeCartSidebar);

    // Hiển thị chi tiết sản phẩm khi click vào card sản phẩm
    document.querySelectorAll(".productCard").forEach((card) => {
        card.addEventListener("click", function () {
            const productId = parseInt(this.dataset.productId, 10);
            showProductDetails(productId);
        });
    });

    // Thêm sản phẩm vào giỏ hàng khi click nút trong chi tiết sản phẩm
    document.getElementById('addToCartButton').addEventListener('click', function () {
        const productId = parseInt(this.dataset.productId, 10);
        const productName = this.dataset.productName;
        const productPrice = parseInt(this.dataset.productPrice, 10);
        const productImage = this.dataset.productImage;
        addToCart(productId, productName, productPrice, productImage);
    });
});


function showNotification(message) {
    const notificationContainer = document.getElementById('notification-container');
    const notification = document.createElement('div');
    notification.classList.add('notification');
    notification.textContent = message;
    notificationContainer.appendChild(notification);

    // Hiển thị thông báo
    setTimeout(() => {
        notification.style.opacity = 1;
    }, 100);

    // Tự động ẩn thông báo sau 3 giây
    setTimeout(() => {
        notification.style.opacity = 0;
        setTimeout(() => {
            notification.remove();
        }, 300); // Xóa thông báo sau khi ẩn
    }, 3000);
}
