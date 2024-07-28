let cart = [];

function addToCart(productId) {
    const product = document.getElementById(productId);
    const name = product.querySelector("p").innerText;
    const price = product.querySelector(".price").innerText;
    cart.push({ name, price, quantity: 1 });
    updateCart();
    openCart();
}

function updateCart() {
    const cartItems = document.getElementById("cartItems");
    cartItems.innerHTML = "";
    cart.forEach((item, index) => {
        const cartItem = document.createElement("div");
        cartItem.className = "cart-item";
        cartItem.innerHTML = `
                <p>${item.name} - ${item.price}</p>
                <input type="number" value="${item.quantity}" min="1" onchange="updateQuantity(${index}, this.value)" />
                <button onclick="removeFromCart(${index})">Xóa</button>
            `;
        cartItems.appendChild(cartItem);
    });
}

function updateQuantity(index, quantity) {
    cart[index].quantity = quantity;
    updateCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
}

function openCart() {
    document.getElementById("cart").classList.add("open");
}

function closeCart() {
    document.getElementById("cart").classList.remove("open");
}

function checkout() {
    alert("Thanh toán thành công!");
    cart = [];
    updateCart();
    closeCart();
}
