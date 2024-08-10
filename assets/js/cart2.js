let cart = [];

document.addEventListener("DOMContentLoaded", function () {
    const productContainer = document.querySelector(".product-container");

    // Load products from data.json and generate product cards
    fetch("../assets/js/data.json")
        .then((response) => response.json())
        .then((products) => {
            products.forEach((product) => {
                const productCard = document.createElement("div");
                productCard.classList.add("productCard"); // Sửa tên lớp cho phù hợp với CSS

                productCard.innerHTML = `
                    <img src="${product.img}" alt="${product.title}">
                    <div class="product-info">
                        <h3>${product.title}</h3>
                        <p>${product.price}</p>
                    </div>
                    <button class="add-to-cart" data-product-id="${product.id}" 
                        data-product-name="${product.title}" 
                        data-product-price="${parseFloat(
                            product.price.replace(/\D/g, "")
                        )}" 
                        data-product-image="${product.img}">
                        🛒 Thêm vào giỏ
                    </button>
                `;
                productContainer.appendChild(productCard);

                // Event listeners for buttons
                productCard
                    .querySelector(".add-to-cart")
                    .addEventListener("click", function () {
                        const productId = parseInt(this.dataset.productId, 10);
                        const productName = this.dataset.productName;
                        const productPrice = parseFloat(
                            this.dataset.productPrice
                        );
                        const productImage = this.dataset.productImage;
                        addToCart(
                            productId,
                            productName,
                            productPrice,
                            productImage
                        );
                    });

                productCard.addEventListener("mouseover", function () {
                    productCard.querySelector(".add-to-cart").style.display =
                        "block";
                });

                productCard.addEventListener("mouseout", function () {
                    productCard.querySelector(".add-to-cart").style.display =
                        "none";
                });
            });
        });

    // Toggle cart sidebar
    document
        .getElementById("cartBtn")
        .addEventListener("click", function (event) {
            event.preventDefault();
            toggleCartSidebar();
        });

    // Close cart sidebar
    document
        .getElementById("cartSidebar")
        .querySelector(".close")
        .addEventListener("click", closeCartSidebar);
});

// Function to add product to cart
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

// Function to update cart
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
                <p>${product.price.toLocaleString()} VND x ${
            product.quantity
        }</p>
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

// Function to change product quantity
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

// Function to remove product from cart
function removeFromCart(productId) {
    cart = cart.filter((product) => product.id !== productId);
    updateCart();
}

// Function to toggle cart sidebar
function toggleCartSidebar() {
    const cartSidebar = document.getElementById("cartSidebar");
    const mainContent = document.querySelector(".main-content");

    if (cartSidebar.classList.contains("open")) {
        cartSidebar.classList.remove("open");
        mainContent.style.marginRight = "0";
    } else {
        cartSidebar.classList.add("open");
        mainContent.style.marginRight = "350px";
    }
}

// Function to close cart sidebar
function closeCartSidebar() {
    const cartSidebar = document.getElementById("cartSidebar");
    const mainContent = document.querySelector(".main-content");
    cartSidebar.classList.remove("open");
    mainContent.style.marginRight = "0";
}

// Function to show notification
function showNotification(message) {
    const notificationContainer = document.getElementById(
        "notification-container"
    );
    const notification = document.createElement("div");
    notification.classList.add("notification");
    notification.textContent = message;
    notificationContainer.appendChild(notification);

    setTimeout(() => {
        notification.style.opacity = 1;
    }, 100);

    setTimeout(() => {
        notification.style.opacity = 0;
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Function to handle checkout
function checkout() {
    window.location.href = "checkout.html";
}
