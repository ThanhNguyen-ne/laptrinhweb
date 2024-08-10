let cart = [];

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
