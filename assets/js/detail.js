const detailContainer = document.querySelector('.detail9-container');
const btnAddCart = document.getElementById('addToCart');
const cartIcon = document.querySelector('.cart');

const getDetailProduct = async () => {
    const path = new URLSearchParams(window.location.search);
    const productId = path.get('id');
    
    try {
        const response = await fetch('../assets/js/data.json');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        const product = data.find(item => item.id == productId);

        if (product) {
            detailContainer.innerHTML = `
                <div class="detail9">
                    <div class="detail9-image">
                        <img src="${product.img}" alt="${product.title}">
                    </div>
                    <div class="detail9-info">
                        <div class="detail9-price">
                            <span>${product.price}₫</span>
                        </div>
                        <p class="detail9-description">${product.description}</p>
                        <div class="detail9-actions">
                            <button class="btn-add" id="addToCart">Thêm vào giỏ hàng</button>
                            <button class="btn-buy" id="buyNow">Mua ngay</button>
                        </div>
                    </div>
                </div>
                <div class="similar-products-container">
                    <h3>Sản phẩm tương tự</h3>
                    <div class="similar-products" id="similarProducts"></div>
                </div>
            `;

            const btnAddCart = document.getElementById('addToCart');
            const btnBuyNow = document.getElementById('buyNow');

            // Thêm sự kiện cho nút "Thêm vào giỏ hàng"
            btnAddCart.addEventListener('click', () => {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const itemIndex = cart.findIndex(item => item.id === product.id);

                if (itemIndex !== -1) {
                    cart[itemIndex].count += 1;
                } else {
                    cart.push({ id: product.id, count: 1 });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
            });

            // Thêm sự kiện cho nút "Mua ngay"
            btnBuyNow.addEventListener('click', () => {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                const itemIndex = cart.findIndex(item => item.id === product.id);

                if (itemIndex === -1) {
                    cart.push({ id: product.id, count: 1 });
                    localStorage.setItem('cart', JSON.stringify(cart));
                }
                window.location.href = 'giohang.html';
            });

            // Hiển thị các sản phẩm tương tự, chỉ lấy 6 sản phẩm
            const similarProductsContainer = document.getElementById('similarProducts');
            const similarProducts = data
                .filter(item => item.category === product.category && item.id !== product.id)
                .slice(0, 6); // Giới hạn 6 sản phẩm

            similarProductsContainer.innerHTML = similarProducts
                .map(item => `
                    <div class="product-card">
                        <img src="${item.img}" alt="${item.title}" />
                        <h4>${item.title}</h4>
                        <p>${item.price}</p>
                        <a href="detail.html?id=${item.id}" class="btn-detail">Xem chi tiết</a>
                    </div>
                `)
                .join('');
        }
    } catch (error) {
        console.error('Fetch error:', error);
    }
};

getDetailProduct();
