let container = document.querySelector(".container");
let cartContainer = document.querySelector(".cart-container");
let cart = JSON.parse(localStorage.getItem("cart")) || [];
let cartSummary = document.querySelector(".cart-summary");

const renderCartItem = async () => {
    const response = await fetch("../assets/js/data.json");
    const data = await response.json();

    if (cart.length !== 0) {
        cartContainer.innerHTML = cart
            .map((itemCart) => {
                let search = data.find((itemData) => itemData.id === itemCart.id) || {};

                let priceNumber = parseFloat(search.price.replace(/,/g, '')) || 0;
                let totalPrice = priceNumber * itemCart.count;

                return `
                    <div class="cart-part">
                        <div class="cart-img">
                            <img src="../${search.img}" alt="${search.title}" />
                        </div>
                        <div class="cart-desc">
                            <h3>${search.title}</h3>
                        </div>
                        <div class="cart-quantity">
                            <button class="quantity-btn" onclick="decrementQuantity(${search.id})">-</button>
                            <span id="quantity-${search.id}" class="quantity-number">${itemCart.count}</span>
                            <button class="quantity-btn" onclick="incrementQuantity(${search.id})">+</button>
                        </div>
                        <div class="cart-price">
                            <h4>${priceNumber.toLocaleString('en-US')}₫</h4>
                        </div>
                        <div class="cart-total"><h4>${totalPrice.toLocaleString('en-US')}₫</h4></div>
                        <div onclick="removeItem(${search.id})" class="cart-remove">
                            <button>Xóa</button>
                        </div>
                    </div>
                `;
            })
            .join("");
    } else {
        container.innerHTML = `
            <div class="cart-empty">
                <h2>Giỏ hàng trống</h2>
                <a href="index.html">
                    <button class="homeBtn">Trở về trang chủ</button>
                </a>
            </div>
        `;
    }

    totalProducts();
};

let incrementQuantity = (id) => {
    let searchIndex = cart.findIndex((itemCart) => itemCart.id === id);

    if (searchIndex !== -1) {
        cart[searchIndex].count += 1;
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCartItem();
    }
};

let decrementQuantity = (id) => {
    let searchIndex = cart.findIndex((itemCart) => itemCart.id === id);

    if (searchIndex !== -1 && cart[searchIndex].count > 0) {
        cart[searchIndex].count -= 1;
        if (cart[searchIndex].count === 0) {
            removeItem(id); // Tự động xóa sản phẩm nếu số lượng về 0
        } else {
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCartItem();
        }
    }
};

let totalProducts = async () => {
    const response = await fetch("../assets/js/data.json");
    const data = await response.json();

    if (cart.length !== 0) {
        let total = cart
            .map((item) => {
                let search = data.find((itemData) => itemData.id === item.id) || {};
                
                return item.count * parseFloat(search.price.replace(/,/g, '')) || 0;
            })
            .reduce((x, y) => x + y, 0);

        cartSummary.innerHTML = `
            <div class="product-total">
                <h2>Tổng giá tiền: <span id="total">${total.toLocaleString()}₫</span></h2>
            </div>
            <div class="product-checkout">
                <a href="#" class="checkout">Thanh toán</a>
            </div>
            <button onclick="clearCart()" class="removeAll">Xóa giỏ hàng</button>
        `;
    }
};

let removeItem = (id) => {
    cart = cart.filter((item) => item.id !== id);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCartItem();
};

let clearCart = () => {
    cart = [];
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCartItem();
};

renderCartItem();
