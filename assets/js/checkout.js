document.addEventListener("DOMContentLoaded", () => {
    const cartItemsContainer = document.getElementById("cartItems");
    const totalAmountElement = document.getElementById("totalAmount");

    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    let totalAmount = 0;

    const renderCartItems = async () => {
        const response = await fetch('../assets/js/data.json');
        const data = await response.json();

        if (cart.length > 0) {
            cartItemsContainer.innerHTML = cart.map(itemCart => {
                const product = data.find(item => item.id === itemCart.id);
                const itemTotal = parseFloat(product.price.replace(/,/g, '')) * itemCart.count;
                totalAmount += itemTotal;

                return `
                    <div class="cart-item">
                        <img class="cart-item-img" src="${product.img}" alt="${product.title}">
                        <div class="cart-item-details">
                            <div class="cart-item-title">${product.title} x ${itemCart.count}</div>
                            <div class="cart-item-price">${itemTotal.toLocaleString()}₫</div>
                        </div>
                    </div>
                `;
            }).join("");

            totalAmountElement.textContent = `${totalAmount.toLocaleString()}₫`;
        } else {
            cartItemsContainer.innerHTML = '<p>Giỏ hàng của bạn đang trống.</p>';
        }
    };

    renderCartItems();

    const checkoutForm = document.getElementById("checkoutForm");
    checkoutForm.addEventListener("submit", (e) => {
        e.preventDefault();
        
        const name = document.getElementById("name").value;
        const address = document.getElementById("address").value;
        const phone = document.getElementById("phone").value;
        const paymentMethod = document.getElementById("paymentMethod").value;

        if (cart.length > 0) {
            const orderDetails = {
                name,
                address,
                phone,
                paymentMethod,
                cart,
                totalAmount
            };

            // Xử lý logic thanh toán tại đây
            console.log("Order Details:", orderDetails);

            // Sau khi xử lý thanh toán thành công
            alert("Đơn hàng của bạn đã được xác nhận!");
            localStorage.removeItem("cart");  // Xóa giỏ hàng
            window.location.href = "index.html";  // Điều hướng về trang chủ
        } else {
            alert("Giỏ hàng của bạn đang trống!");
        }
    });
});
