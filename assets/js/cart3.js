let container = document.querySelector(".container");
let cartContainer = document.querySelector(".cart-container");
let cart = JSON.parse(localStorage.getItem("cart")) || [];
let cartSummary = document.querySelector(".cart-summary");
const renderCartItem = async () => {
    const response = await fetch("../assets/js/data.json");
    const data = await response.json();
    if (cart.length !== 0) {
        return (cartContainer.innerHTML = cart
            .map((itemCart) => {
                let search =
                    data.find((itemData) => itemData.id === itemCart.id) || [];
                return `
                    <div class="cart-part">
                        <div class="cart-img">
                            <img
                                src="../${search.img}" alt = "${search.title}"
                            />
                        </div>
                        <div class="cart-desc">
                            <h3>${search.title}</h3>
                        </div>
                        <div class="cart-quantity">
                            <input onchange ="update(${
                                search.id
                            })" type="number" id="quantity" min="0" value = "${
                    itemCart.count
                }" id= "${search.id}" />
                        </div>
                        <div class="cart-price">
                            <h4> ${search.price}</h4>
                        </div>
                        <div class="cart-total"><h4>${
                            search.price * itemCart.count
                        }</h4></div>
                        <div onclick= "removeItem(${
                            search.id
                        })" class="cart-remove">
                            <button >Remove</button>
                        </div>
                    </div>
            
            `;
            })
            .join(""));
    } else {
        return (container.innerHTML = `
            <div class="cart-empty">
                <h2>Giỏ hàng trống</h2>
                <a href="index.html">
                    <button class="homeBtn">Trở về trang chủ</button>
                </a>
            </div>
        `);
    }
};

let update = (id) => {
    if (cart.length !== 0) {
        let searchIndex = cart.findIndex((itemCart) => itemCart.id === id);

        if (searchIndex !== -1) {
            let quantityElement = document.getElementById(id);

            if (quantityElement) {
                cart[searchIndex].count =
                    parseInt(quantityElement.value, 10) || 0;
                localStorage.setItem("cart", JSON.stringify(cart));
                renderCartItem();
                totalProducts();
            }
        }
    }
};

let totalProducts = async () => {
    let response = await fetch("../assets/js/data.json");
    let data = await response.json();

    if (cart.length !== 0) {
        let total = cart
            .map((item) => {
                let search =
                    data.find((itemData) => itemData.id === item.id) || [];
                return item.count * search.price;
            })
            .reduce((x, y) => x + y, 0);

        cartSummary.innerHTML = `
            <div class="product-total">
                        <h2>Tổng giá tiền: <span id="total">${total}</span></h2>
                    </div>
                    <div class="product-checkout">
                        <a href="#" class="checkout">Thanh toán</a>
                    </div>
                    <button onclick="clearCart" class="removeAll">Xóa giỏ hàng</button>
            `;
    } else return;
};

let removeItem = (id) => {
    let removeId = id;
    cart = cart.filter((item) => item.id !== removeId);
    renderCartItem();
    totalProducts();
    localStorage.setItem("cart", JSON.stringify(cart));
};

let clearCart = () => {
    cart = [];
    renderCartItem();
    localStorage.setItem("cart",JSON.stringify(cart));
};

totalProducts();
renderCartItem();

