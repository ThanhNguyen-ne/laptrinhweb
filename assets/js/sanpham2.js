let cart = [];

function showProductDetails(productId) {
    const products = {
        'product1': {
            name: 'Yến huyết đảo thiên nhiên Khánh Hòa hộp 100g - 024',
            price: '37,800,000₫',
            image: '/assets/image/yskh_024.jpg',
            description: 'THÔNG TIN NỔI BẬT: Yến huyết đảo yến thiên nhiên nguyên tổ là tổ yến có màu đỏ tự nhiên. Sản phẩm Yến huyết đảo yến thiên nhiên nguyên tổ hộp 100g - MS 024 có giá trị dinh dưỡng rất cao.'
        },
        // Các sản phẩm khác...
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
    openCartSidebar(); // Mở giỏ hàng khi thêm sản phẩm
    
}

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

function removeFromCart(productId) {
    cart = cart.filter((product) => product.id !== productId);
    updateCart();
}

function openCartSidebar() {
    const cartSidebar = document.getElementById("cartSidebar");
    cartSidebar.classList.add("open");
    const mainContent = document.querySelector(".main-content");
    mainContent.style.marginRight = "350px";
}

function closeCartSidebar() {
    const cartSidebar = document.getElementById("cartSidebar");
    cartSidebar.classList.remove("open");
    const mainContent = document.querySelector(".main-content");
    mainContent.style.marginRight = "0";
}

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

function checkout() {
    alert("Thanh toán thành công!");
    // Add any additional checkout logic here
}

// Event Listeners
document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", function (event) {
        event.stopPropagation(); // Ngăn chặn sự kiện click lan ra thẻ cha
        const productId = this.dataset.productId;
        const productName = this.dataset.productName;
        const productPrice = this.dataset.productPrice;
        const productImage = this.dataset.productImage;
        addToCart(productId, productName, productPrice, productImage);
    });
});

document.querySelectorAll(".productCard").forEach((card) => {
    card.addEventListener("click", function () {
        const productId = this.querySelector(".add-to-cart").dataset.productId;
        showProductDetails(productId);
    });
});

document.getElementById("cartSidebar").querySelector(".close").addEventListener("click", closeCartSidebar);
