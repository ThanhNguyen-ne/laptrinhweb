const detailContainer = document.querySelector(".detail9-container");

const getDetailProduct = async () => {
    const path = new URLSearchParams(window.location.search);
    const productId = path.get("id");

    try {
        const response = await fetch(
            "../admin/pages/api.php?action=get_product&id=" + productId
        );
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const product = await response.json();

        if (product) {
            detailContainer.innerHTML = `
                <div class="detail9">
                    <div class="detail9-image">
                        <img src="../${product.hinh_anh}" alt="${
                product.ten_san_pham
            }">
                    </div>
                    <div class="detail9-info">
                        <h2 class="detail9-name">${product.ten_san_pham}</h2>
                        <div class="detail9-price">
                            <span>${product.gia.toLocaleString("vi-VN", {
                                style: "currency",
                                currency: "VND",
                            })} </span>
                        </div>
                        <p class="detail9-description">${product.mo_ta}</p>
                        <div class="detail9-actions">
                            <button class="btn-add" id="addToCart">Thêm vào giỏ hàng</button>
                            <button class="btn-buy" id="buyNow">Mua ngay</button>
                        </div>
                    </div>
                </div>
                <div class="similar-products-container">
                    <h3>Sản phẩm tương tự</h3>
                    <div class="similar-products-navigation">
                        <button id="prevBtn" class="nav-btn">&#10094;</button>
                        <div class="similar-products" id="similarProducts"></div>
                        <button id="nextBtn" class="nav-btn">&#10095;</button>
                    </div>
                </div>
            `;

            // Thêm sự kiện cho nút "Thêm vào giỏ hàng" và "Mua ngay"
            const btnAddCart = document.getElementById("addToCart");
            const btnBuyNow = document.getElementById("buyNow");

            btnAddCart.addEventListener("click", () => {
                let cart = JSON.parse(localStorage.getItem("cart")) || [];
                const itemIndex = cart.findIndex(
                    (item) => item.id === product.id
                );

                if (itemIndex !== -1) {
                    cart[itemIndex].count += 1;
                } else {
                    cart.push({ id: product.id, count: 1 });
                }

                localStorage.setItem("cart", JSON.stringify(cart));
                showNotification("Sản phẩm đã được thêm vào giỏ hàng!");
            });

            btnBuyNow.addEventListener("click", () => {
                let cart = JSON.parse(localStorage.getItem("cart")) || [];
                const itemIndex = cart.findIndex(
                    (item) => item.id === product.id
                );

                if (itemIndex === -1) {
                    cart.push({ id: product.id, count: 1 });
                    localStorage.setItem("cart", JSON.stringify(cart));
                }
                window.location.href = "checkout.php";
            });

            // Lấy danh sách sản phẩm tương tự
            getSimilarProducts(product.loai_san_pham_id, productId);
        }
    } catch (error) {
        console.error("Fetch error:", error);
    }
};

const getSimilarProducts = async (productTypeId, currentProductId) => {
    try {
        const response = await fetch(
            "../admin/pages/api.php?action=get_similar_products&type_id=" +
                productTypeId +
                "&exclude_id=" +
                currentProductId
        );
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const products = await response.json();

        if (products.length > 0) {
            const similarProductsContainer =
                document.getElementById("similarProducts");
            similarProductsContainer.innerHTML = products
                .map(
                    (product) => `
                    <div class="product-card">
                        <img src="../${product.hinh_anh}" alt="${
                        product.ten_san_pham
                    }">
                        <h4>${product.ten_san_pham}</h4>
                        <p>${product.gia.toLocaleString("vi-VN", {
                            style: "currency",
                            currency: "VND",
                        })} </p>
                        <a href="detail.php?id=${
                            product.id
                        }" class="btn-detail">Xem chi tiết</a>
                    </div>
                `
                )
                .join("");

            // Thêm chức năng di chuyển sản phẩm
            addCarouselFunctionality(products.length);
        }
    } catch (error) {
        console.error("Fetch error:", error);
    }
};

const addCarouselFunctionality = (totalItems) => {
    let currentIndex = 0;
    const itemsToShow = 4;
    const similarProductsContainer = document.getElementById("similarProducts");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");

    const updateCarousel = () => {
        const start = currentIndex * itemsToShow;
        const end = start + itemsToShow;
        const items = Array.from(similarProductsContainer.children);
        items.forEach((item, index) => {
            item.style.display =
                index >= start && index < end ? "block" : "none";
        });
    };

    prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    nextBtn.addEventListener("click", () => {
        if (currentIndex < Math.ceil(totalItems / itemsToShow) - 1) {
            currentIndex++;
            updateCarousel();
        }
    });

    updateCarousel();
};

function showNotification(message) {
    const notification = document.createElement("div");
    notification.className = "notification";
    notification.innerText = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

getDetailProduct();
