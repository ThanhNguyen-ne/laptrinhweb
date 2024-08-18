let container = document.querySelector(".container");
let cartContainer = document.querySelector(".cart-content");
let cartSummary = document.querySelector(".cart-summary");

let cart = JSON.parse(localStorage.getItem("cart")) || [];
let totalAmount = 0;

const renderCartItem = async () => {
    const response = await fetch("../assets/js/data.json");
    const data = await response.json();

    if (cart.length > 0) {
        cartContainer.innerHTML = cart
            .map((itemCart) => {
                const product = data.find((item) => item.id === itemCart.id);

                if (!product) return "";

                const priceNumber =
                    parseFloat(product.price.replace(/,/g, "")) || 0;
                const totalPrice = priceNumber * itemCart.count;
                totalAmount += totalPrice;

                return `
                        <hr>
                        <div class="cart-part">
                            <div class="cart-img">
                                <img src="${product.img}" alt="${
                    product.title
                }" />
                            </div>
                            <div class="cart-desc">
                                <p>${product.title}</p>
                            </div>
                            <div class="cart-quantity">
                                <button class="quantity-btn" onclick="decrementQuantity(${
                                    product.id
                                })">-</button>
                                <span id="quantity-${
                                    product.id
                                }" class="quantity-number">${
                    itemCart.count
                }</span>
                                <button class="quantity-btn" onclick="incrementQuantity(${
                                    product.id
                                })">+</button>
                            </div>
                            <div class="cart-price">
                                <h4>${priceNumber.toLocaleString("en-US")}₫</h4>
                            </div>
                            <div class="cart-total"><h4>${totalPrice.toLocaleString(
                                "en-US"
                            )}₫</h4></div>
                            <div onclick="removeItem(${
                                product.id
                            })" class="cart-remove">
                                <button><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                    `;
            })
            .join("");
    } else {
        container.innerHTML = `
                <div class="cart-empty">
                    <h2>Giỏ hàng trống</h2>
                    <a href="index.php">
                        <button class="homeBtn">Trở về trang chủ</button>
                    </a>
                </div>
            `;
    }

    totalProducts();
};

const incrementQuantity = (id) => {
    let searchIndex = cart.findIndex((itemCart) => itemCart.id === id);

    if (searchIndex !== -1) {
        cart[searchIndex].count += 1;
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCartItem();
    }
};

const decrementQuantity = (id) => {
    let searchIndex = cart.findIndex((itemCart) => itemCart.id === id);

    if (searchIndex !== -1 && cart[searchIndex].count > 0) {
        cart[searchIndex].count -= 1;
        if (cart[searchIndex].count === 0) {
            removeItem(id);
        } else {
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCartItem();
        }
    }
};

const totalProducts = async () => {
    const response = await fetch("../assets/js/data.json");
    const data = await response.json();

    if (cart.length !== 0) {
        let total = cart
            .map((item) => {
                const product = data.find(
                    (itemData) => itemData.id === item.id
                );
                return (
                    item.count * parseFloat(product.price.replace(/,/g, "")) ||
                    0
                );
            })
            .reduce((x, y) => x + y, 0);

        cartSummary.innerHTML = `
                <div class="product-total">
                    <h2>Tổng giá tiền: <span id="total">${total.toLocaleString()}₫</span></h2>
                </div>
                <div class="product-checkout">
                    <a href="checkout.php" class="checkout">Thanh toán</a>
                </div>
                <button onclick="clearCart()" class="removeAll">Xóa giỏ hàng</button>
            `;
    }
};

const removeItem = (id) => {
    cart = cart.filter((item) => item.id !== id);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCartItem();
};

const clearCart = () => {
    cart = [];
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCartItem();
};

renderCartItem();
