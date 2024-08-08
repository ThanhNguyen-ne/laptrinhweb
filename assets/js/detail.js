const detailContainer = document.querySelector('.detail9-container');

const getDetailProduct = async () => {
    const path = new URLSearchParams(window.location.search);
    const productId = path.get('id');

    try {
        const response = await fetch('../assets/js/data.json'); // Đảm bảo đường dẫn đúng
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        // Tìm sản phẩm có id tương ứng
        const product = data.find(item => item.id == productId);

        if (product) {
            detailContainer.innerHTML = `
                <div class="detail9">
                    <div class="detail9-image">
                        <img src="${product.img}" alt="${product.title}">
                    </div>
                    <div class="detail9-info">
                        <h2>${product.title}</h2>
                        <p>${product.description}</p>
                        <div class="detail9-price">
                            Price:
                            <span class="price9">${product.price}</span>
                        </div>
                    </div>
                </div>
                <button class="btn-add" id="addToCart">Add to cart</button>
                
            `;
        } else {
            detailContainer.innerHTML = '<p>Product not found.</p>';
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

getDetailProduct();
