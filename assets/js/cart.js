// Cập nhật số lượng sản phẩm
function updateQuantity(itemId, change) {
    const item = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
    const quantityElement = item.querySelector(".quantity-number");
    const priceElement = item.querySelector(".item-price");
    const totalElement = item.querySelector(".item-total");

    let quantity = parseInt(quantityElement.textContent);
    const newQuantity = quantity + change;

    if (newQuantity > 0) {
        fetch(
            `cart_actions.php?action=update&id=${itemId}&quantity=${newQuantity}`
        )
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    quantityElement.textContent = newQuantity;
                    const price = parseInt(
                        priceElement.textContent.replace(/\D/g, "")
                    );
                    const newTotal = price * newQuantity;
                    totalElement.textContent =
                        newTotal.toLocaleString("vi-VN") + " ₫";
                    updateTotal();
                }
            });
    } else if (newQuantity === 0) {
        removeItem(itemId);
    }
}

// Xóa sản phẩm khỏi giỏ hàng
function removeItem(itemId) {
    fetch(`cart_actions.php?action=remove&id=${itemId}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const item = document.querySelector(
                    `.cart-item[data-item-id="${itemId}"]`
                );
                item.remove();
                updateTotal();
                checkCartEmpty();
            }
        });
}

// Cập nhật tổng giá tiền sau khi số lượng thay đổi hoặc xóa sản phẩm
function updateTotal() {
    let totalPrice = 0;
    document.querySelectorAll(".item-total").forEach((total) => {
        totalPrice += parseInt(total.textContent.replace(/\D/g, ""));
    });

    document.getElementById("total").textContent =
        totalPrice.toLocaleString("vi-VN") + "₫";
}

// Kiểm tra xem giỏ hàng có trống không
function checkCartEmpty() {
    const cartItems = document.querySelectorAll(".cart-item");
    if (cartItems.length === 0) {
        document.querySelector(".cart-container").innerHTML = `
            <div class='cart-empty'>
                <h2>Giỏ hàng của bạn đang trống</h2>
                <button class='homeBtn' onclick='window.location.href="index.php"'>Về trang chủ</button>
            </div>`;
        document.querySelector(".cart-summary").style.display = "none";
    }
}

// Xóa toàn bộ giỏ hàng
function clearCart() {
    fetch("cart_actions.php?action=clear")
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                document.querySelector(".cart-container").innerHTML = `
                    <div class='cart-empty'>
                        <h2>Giỏ hàng của bạn đang trống</h2>
                        <button class='homeBtn' onclick='window.location.href="index.php"'>Về trang chủ</button>
                    </div>`;
                document.querySelector(".cart-summary").style.display = "none";
            }
        });
}
document.querySelectorAll('.productCard').forEach(function(card) {
    card.addEventListener('click', function(event) {
        // Nếu không phải nút mua hoặc giỏ hàng, thì mới chuyển trang
        if (!event.target.closest('.btn-cart') && !event.target.closest('.btn-buy')) {
            const productId = this.id;
            window.location.href = 'detail.php?id=' + productId;
        }
    });
});
