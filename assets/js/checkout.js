document.addEventListener("DOMContentLoaded", () => {
    const cartItemsContainer = document.getElementById("cartItems");
    const totalAmountElement = document.getElementById("totalAmount");

    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    let totalAmount = 0;

    const renderCartItems = async () => {
        const response = await fetch("../assets/js/data.json");
        const data = await response.json();

        if (cart.length > 0) {
            cartItemsContainer.innerHTML = cart
                .map((itemCart) => {
                    const product = data.find(
                        (item) => item.id === itemCart.id
                    );
                    const itemTotal =
                        parseFloat(product.price.replace(/,/g, "")) *
                        itemCart.count;
                    totalAmount += itemTotal;

                    return `
                        <div class="checkout-cart-item">
                            <img class="checkout-cart-item-img" src="${
                                product.img
                            }" alt="${product.title}">
                            <div class="checkout-cart-item-details">
                                <div class="checkout-cart-item-title">${
                                    product.title
                                }</div>
                                <div class="checkout-cart-item-quantity">Số lượng: ${
                                    itemCart.count
                                }</div>
                                <div class="checkout-cart-item-price">Thành tiền: ${itemTotal.toLocaleString()}₫</div>
                            </div>
                        </div>
                    `;
                })
                .join("");

            totalAmountElement.textContent = `${totalAmount.toLocaleString()}₫`;
        } else {
            cartItemsContainer.innerHTML =
                "<p>Giỏ hàng của bạn đang trống.</p>";
        }
    };

    renderCartItems();

    const checkoutForm = document.getElementById("checkoutForm");

    checkoutForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const address = document.getElementById("address").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const paymentMethod = document.getElementById("paymentMethod").value;

        clearErrors();
        let hasError = false;

        if (!name) {
            showError("nameError", "Bạn cần nhập tên để thực hiện thanh toán.");
            hasError = true;
        }
        if (!email) {
            showError(
                "emailError",
                "Bạn cần nhập email để thực hiện thanh toán."
            );
            hasError = true;
        }
        if (!address) {
            showError(
                "addressError",
                "Bạn cần nhập địa chỉ để thực hiện thanh toán."
            );
            hasError = true;
        }
        if (!phone) {
            showError(
                "phoneError",
                "Bạn cần nhập số điện thoại để thực hiện thanh toán."
            );
            hasError = true;
        } else if (!/^\d{10}$/.test(phone)) {
            showError("phoneError", "Bạn cần nhập đúng số điện thoại (10 số).");
            hasError = true;
        }

        if (!hasError) {
            if (cart.length > 0) {
                const orderDetails = {
                    name,
                    email,
                    address,
                    phone,
                    paymentMethod,
                    cart,
                    totalAmount,
                };

                console.log("Order Details:", orderDetails);
                alert("Đơn hàng của bạn đã được xác nhận!");
                localStorage.removeItem("cart");
                window.location.href = "index.php";
            } else {
                alert("Giỏ hàng của bạn đang trống!");
            }
        }
    });

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.style.display = "block";
    }

    function clearErrors() {
        const errorMessages = document.querySelectorAll(".error-message");
        errorMessages.forEach((error) => {
            error.style.display = "none";
        });
    }
});
