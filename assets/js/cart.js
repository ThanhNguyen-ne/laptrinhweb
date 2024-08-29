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

// Chọn hoặc bỏ chọn tất cả các sản phẩm
function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById("selectAll");
    const checkboxes = document.querySelectorAll(".select-item");
    
    checkboxes.forEach((checkbox) => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateTotal();
}

// Chọn tất cả các sản phẩm khi checkbox "Chọn tất cả" thay đổi trạng thái
document.getElementById("selectAll").addEventListener("change", function () {
    toggleSelectAll();
});

// Khi thay đổi trạng thái checkbox của từng sản phẩm
document.querySelectorAll(".select-item").forEach((checkbox) => {
    checkbox.addEventListener("change", function() {
        const selectAllCheckbox = document.getElementById("selectAll");
        if (!checkbox.checked) {
            selectAllCheckbox.checked = false;
        } else {
            const allChecked = Array.from(document.querySelectorAll(".select-item")).every(item => item.checked);
            selectAllCheckbox.checked = allChecked;
        }
        updateTotal();
    });
});

// Khi nhấn nút thanh toán
document.querySelector(".checkout").addEventListener("click", function() {
    const selectedItems = [];
    document.querySelectorAll('.select-item:checked').forEach(item => {
        const cartItem = item.closest('.cart-item');
        const itemId = cartItem.getAttribute('data-item-id');
        const quantity = cartItem.querySelector('.quantity-number').textContent.trim();
        const price = cartItem.querySelector('.item-price').textContent.trim().replace(/[₫,.]/g, '');
        const productName = cartItem.querySelector('.item-desc').textContent.trim();
        const productImage = cartItem.querySelector('.item-img img').getAttribute('src');

        selectedItems.push({
            id: itemId,
            quantity: parseInt(quantity),
            price: parseInt(price),
            name: productName,
            image: productImage
        });
    });

    if (selectedItems.length > 0) {
        document.getElementById('cartItemsInput').value = JSON.stringify(selectedItems);
        document.getElementById('cartForm').submit(); // Đảm bảo form được submit sau khi có dữ liệu
    } else {
        alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán.');
        return false;
    }
});
