let container = document.querySelector(".container");
let cartContainer = document.querySelector(".cart-content");
let cartSummary = document.querySelector(".cart-summary");

let cart = JSON.parse(localStorage.getItem("cart")) || [];
let totalAmount = 0;

// Hiển thị các sản phẩm trong giỏ hàng
const renderCartItem = () => {
    
    totalAmount = 0; // Đặt lại tổng tiền về 0 trước khi tính toán lại
    if (cart.length > 0) {
        cartContainer.innerHTML = cart
            .map((itemCart, index) => {
                const totalPrice = itemCart.gia * itemCart.count;
                totalAmount += totalPrice;

                return `
                        <hr>
                        <div class="cart-part">
                            <div class="cart-serial">${index + 1}</div> <!-- Số thứ tự -->
                            <input type="checkbox" class="select-product" data-id="${itemCart.id}" onchange="calculateTotal()" checked>
                            <div class="cart-img">
                                <img src="../${itemCart.hinh_anh}" alt="${itemCart.ten_san_pham}" />
                            </div>
                            <div class="cart-desc">
                                <p>${itemCart.ten_san_pham}</p>
                            </div>
                            <div class="cart-quantity">
                                <button class="quantity-btn" onclick="decrementQuantity(${itemCart.id})">-</button>
                                <span id="quantity-${itemCart.id}" class="quantity-number">${itemCart.count}</span>
                                <button class="quantity-btn" onclick="incrementQuantity(${itemCart.id})">+</button>
                            </div>
                            <div class="cart-price">
                                <h4>${itemCart.gia.toLocaleString("vi-VN", { style: "currency", currency: "VND" })} ₫</h4>
                            </div>
                            <div class="cart-total"><h4>${totalPrice.toLocaleString("vi-VN", { style: "currency", currency: "VND" })} ₫</h4></div>
                            <div onclick="removeItem(${itemCart.id})" class="cart-remove">
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

    calculateTotal(); // Cập nhật tổng tiền sau khi render xong
};

// Tăng số lượng sản phẩm trong giỏ hàng
const incrementQuantity = (id) => {
    let searchIndex = cart.findIndex((itemCart) => itemCart.id === id);

    if (searchIndex !== -1) {
        cart[searchIndex].count += 1;
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCartItem();
    }
};

// Giảm số lượng sản phẩm trong giỏ hàng
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

// Tính tổng tiền của các sản phẩm trong giỏ hàng
const calculateTotal = () => {
    totalAmount = 0; // Đặt lại tổng tiền về 0 trước khi tính toán lại
    const selectedProducts = document.querySelectorAll('.select-product:checked');

    selectedProducts.forEach(productCheckbox => {
        const productId = parseInt(productCheckbox.dataset.id);
        const product = cart.find(item => item.id === productId);
        if (product) {
            totalAmount += product.count * product.gia;
        }
    });

    document.getElementById('total').innerText = totalAmount.toLocaleString("vi-VN", { style: "currency", currency: "VND" }) + " ₫";
};

// Xóa sản phẩm khỏi giỏ hàng
const removeItem = (id) => {
    cart = cart.filter((item) => item.id !== id);
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCartItem();
};

// Xóa toàn bộ giỏ hàng
const clearCart = () => {
    cart = [];
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCartItem();
};

// Gọi hàm để hiển thị các sản phẩm trong giỏ hàng
renderCartItem();
