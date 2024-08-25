// Thay đổi URL API nếu cần
const apiUrl = '../admin/pages/api.php';

// Hàm gửi yêu cầu AJAX
const sendRequest = async (url, method = 'GET', data = null) => {
    const options = {
        method,
        headers: {
            'Content-Type': 'application/json',
        },
    };
    if (data) {
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(url, options);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
};

// Hàm hiển thị các sản phẩm trong giỏ hàng
const renderCartItem = async () => {
    try {
        const cart = await loadCart();
        let totalAmount = 0;

        const cartContainer = document.querySelector(".cart-content");
        const container = document.querySelector(".container");

        if (cart.length > 0) {
            cartContainer.innerHTML = cart
                .map((itemCart, index) => {
                    const totalPrice = itemCart.gia * itemCart.so_luong;
                    totalAmount += totalPrice;

                    return `
                            <hr>
                            <div class="cart-part">
                                <div class="cart-serial">${index + 1}</div>
                                <input type="checkbox" class="select-product" data-id="${itemCart.id}" onchange="calculateTotal()" checked>
                                <div class="cart-img">
                                    <img src="../${itemCart.hinh_anh}" alt="${itemCart.ten_san_pham}" />
                                </div>
                                <div class="cart-desc">
                                    <p>${itemCart.ten_san_pham}</p>
                                </div>
                                <div class="cart-quantity">
                                    <button class="quantity-btn" onclick="decrementQuantity(${itemCart.id})">-</button>
                                    <span id="quantity-${itemCart.id}" class="quantity-number">${itemCart.so_luong}</span>
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

            calculateTotal();
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
    } catch (error) {
        console.error('Failed to render cart items:', error);
    }
};
const addToCart2 = async (productId, quantity) => {
    try {
        const cart = await loadCart();
        const itemIndex = cart.findIndex(item => item.id === productId);

        if (itemIndex !== -1) {
            // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
            cart[itemIndex].so_luong += quantity;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            const response = await sendRequest(`../admin/pages/api.php?action=get_product&id=${productId}`);
            const product = response;
            if (product) {
                cart.push({
                    id: product.id,
                    ten_san_pham: product.ten_san_pham,
                    gia: product.gia,
                    hinh_anh: product.hinh_anh,
                    so_luong: quantity
                });
            }
        }

        await saveCart(cart);
        renderCartItem();
    } catch (error) {
        console.error('Failed to add item to cart:', error);
    }
};
// Tăng số lượng sản phẩm trong giỏ hàng
const incrementQuantity = async (id) => {
    try {
        const cart = await loadCart();
        const itemIndex = cart.findIndex(item => item.id === id);

        if (itemIndex !== -1) {
            cart[itemIndex].so_luong += 1;
            await saveCart(cart);
            renderCartItem();
        }
    } catch (error) {
        console.error('Failed to increment quantity:', error);
    }
};

// Giảm số lượng sản phẩm trong giỏ hàng
const decrementQuantity = async (id) => {
    try {
        const cart = await loadCart();
        const itemIndex = cart.findIndex(item => item.id === id);

        if (itemIndex !== -1 && cart[itemIndex].so_luong > 0) {
            cart[itemIndex].so_luong -= 1;
            if (cart[itemIndex].so_luong === 0) {
                await removeItem(id);
            } else {
                await saveCart(cart);
                renderCartItem();
            }
        }
    } catch (error) {
        console.error('Failed to decrement quantity:', error);
    }
};

// Tính tổng tiền của các sản phẩm được chọn
const calculateTotal = async () => {
    try {
        const cart = await loadCart();
        let totalAmount = 0;
        const selectedProducts = document.querySelectorAll('.select-product:checked');

        selectedProducts.forEach(productCheckbox => {
            const productId = parseInt(productCheckbox.dataset.id);
            const product = cart.find(item => item.id === productId);
            if (product) {
                totalAmount += product.so_luong * product.gia;
            }
        });

        document.getElementById('total').innerText = totalAmount.toLocaleString("vi-VN", { style: "currency", currency: "VND" }) + " ₫";
    } catch (error) {
        console.error('Failed to calculate total:', error);
    }
};

// Lưu giỏ hàng
const saveCart = async (cart) => {
    try {
        await sendRequest(apiUrl + '?action=save_cart', 'POST', { user_id: userId, cart });
    } catch (error) {
        console.error('Failed to save cart:', error);
    }
};

// Tải giỏ hàng
const loadCart = async () => {
    try {
        return await sendRequest(apiUrl + '?action=load_cart&user_id=' + userId);
    } catch (error) {
        console.error('Failed to load cart:', error);
        return [];
    }
};

// Xóa sản phẩm khỏi giỏ hàng
const removeItem = async (id) => {
    try {
        const cart = await loadCart();
        const updatedCart = cart.filter(item => item.id !== id);
        await saveCart(updatedCart);
        renderCartItem();
    } catch (error) {
        console.error('Failed to remove item:', error);
    }
};

// Xóa toàn bộ giỏ hàng
const clearCart = async () => {
    try {
        const emptyCart = [];
        await saveCart(emptyCart);
        renderCartItem();
    } catch (error) {
        console.error('Failed to clear cart:', error);
    }
};

// Gọi hàm để hiển thị các sản phẩm trong giỏ hàng khi trang tải
document.addEventListener('DOMContentLoaded', renderCartItem);
