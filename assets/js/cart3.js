let container = document.querySelector(".container");
let cartContainer = document.querySelector(".cart-container");
let cart = JSON.parse(localStorage.getItem("cart")) || [];
const renderCartItem = async () => {
    const responese = await fetch("../assets/js/data.json");
    const data = await responese.json();
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
                            <input type="number" id="quantity" min="0" />
                        </div>
                        <div class="cart-price">
                            <h4> ${search.price}</h4>
                        </div>
                        <div class="cart-total"><h4>${
                            search.price * itemCart.count
                        }</h4></div>
                        <div class="cart-remove">
                            <button>Remove</button>
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

renderCartItem();
