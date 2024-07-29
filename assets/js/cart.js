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
    openCartSidebar();
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
    closeProductDetails();
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
    button.addEventListener("click", function () {
        const productId = parseInt(this.dataset.productId, 10);
        const productName = this.dataset.productName;
        const productPrice = parseInt(this.dataset.productPrice, 10);
        const productImage = this.dataset.productImage;
        addToCart(productId, productName, productPrice, productImage);
    });
});

document
    .getElementById("cartSidebar")
    .querySelector(".close")
    .addEventListener("click", closeCartSidebar);

document.querySelectorAll(".productCard").forEach((card) => {
    card.addEventListener("click", function () {
        const productId = parseInt(this.dataset.productId, 10);
        showProductDetails(productId);
    });
});

document.getElementById("addToCartButton").addEventListener("click", function () {
    const productId = parseInt(this.dataset.productId, 10);
    const productName = this.dataset.productName;
    const productPrice = parseInt(this.dataset.productPrice, 10);
    const productImage = this.dataset.productImage;
    addToCart(productId, productName, productPrice, productImage);
    closeProductDetails();
});

document.getElementById("closeProductDetails").addEventListener("click", closeProductDetails);

function openCartSidebar() {
    const cartSidebar = document.getElementById("cartSidebar");
    cartSidebar.classList.add("open");
    const mainContent = document.querySelector(".main-content");
    mainContent.style.marginRight = "350px";
    closeProductDetails();
}

function closeCartSidebar() {
    const cartSidebar = document.getElementById("cartSidebar");
    cartSidebar.classList.remove("open");
    const mainContent = document.querySelector(".main-content");
    mainContent.style.marginRight = "0";
}



document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('productDetailsModal');
    const overlay = document.getElementById('modalOverlay');
    const closeBtn = document.getElementById('closeProductDetails');
    
    function openModal(productId, productName, productPrice, productImage, productDescription) {
        document.getElementById('productName').textContent = productName;
        document.getElementById('productPrice').textContent = `Giá: ${productPrice.toLocaleString()} VND`;
        document.getElementById('productImage').src = productImage;
        document.getElementById('productDescription').textContent = productDescription;
        modal.classList.add('open');
        overlay.classList.add('open');
    }

    function closeModal() {
        modal.classList.remove('open');
        overlay.classList.remove('open');
    }

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', closeModal);

    document.querySelectorAll('.productCard').forEach(card => {
        card.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = parseInt(this.dataset.productPrice, 10);
            const productImage = this.dataset.productImage;
            const productDescription = this.dataset.productDescription;

            openModal(productId, productName, productPrice, productImage, productDescription);
        });
    });

    document.getElementById('addToCartButton').addEventListener('click', function () {
        const productId = modal.dataset.productId;
        // Add to cart logic here
        closeModal();
    });
});
