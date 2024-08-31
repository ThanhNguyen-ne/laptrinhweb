// Cập nhật số lượng sản phẩm
function updateQuantity(itemId, change) {
    const item = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
    const quantityElement = item.querySelector(".quantity-number");
    const priceElement = item.querySelector(".item-price");
    const totalElement = item.querySelector(".item-total");

    let quantity = parseInt(quantityElement.textContent);
    const newQuantity = quantity + change;

    if (newQuantity > 0) {
        fetch(`cart_actions.php?action=update&id=${itemId}&quantity=${newQuantity}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    quantityElement.textContent = newQuantity;
                    const price = parseInt(priceElement.textContent.replace(/\D/g, ""));
                    const newTotal = price * newQuantity;
                    totalElement.textContent = newTotal.toLocaleString("vi-VN") + " ₫";
                    const checkbox = item.querySelector(".select-item");
                    checkbox.dataset.price = newTotal;
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
                const item = document.querySelector(`.cart-item[data-item-id="${itemId}"]`);
                item.remove();
                updateTotal();
                checkCartEmpty();
            }
        });
}

// Cập nhật tổng giá tiền sau khi số lượng thay đổi hoặc xóa sản phẩm
function updateTotal() {
    let totalPrice = 0;
    document.querySelectorAll(".select-item:checked").forEach((checkbox) => {
        totalPrice += parseInt(checkbox.dataset.price);
    });

    const totalElement = document.getElementById("total");
    totalElement.textContent = totalPrice.toLocaleString("vi-VN") + " ₫";

    const summaryElement = document.querySelector(".cart-summary");
    if (totalPrice > 0) {
        summaryElement.style.display = "block";
    } else {
        summaryElement.style.display = "none";
    }
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

// Submit giỏ hàng khi thanh toán
document.getElementById("cartForm").addEventListener("submit", function(event) {
    const selectedItems = [];
    document.querySelectorAll(".select-item:checked").forEach((checkbox) => {
        const item = checkbox.closest(".cart-item");
        const itemId = item.dataset.itemId;
        const quantity = parseInt(item.querySelector(".quantity-number").textContent);
        const price = parseInt(item.querySelector(".item-price").textContent.replace(/\D/g, ""));
        const name = item.querySelector(".item-desc").textContent;
        const image = item.querySelector(".item-img img").src;

        selectedItems.push({
            id: itemId,
            quantity: quantity,
            price: price,
            name: name,
            image: image
        });
    });

    if (selectedItems.length === 0) {
        event.preventDefault();
        alert("Vui lòng chọn ít nhất một sản phẩm để thanh toán.");
    } else {
        document.getElementById("cartItemsInput").value = JSON.stringify(selectedItems);
    }
});
