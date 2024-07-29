document.querySelector('.sort select').addEventListener('change', function () {
    const sortBy = this.value;
    sortProducts(sortBy);
});

function sortProducts(sortBy) {
    const productsContainer = document.querySelector('.product-list .products');
    const products = Array.from(productsContainer.getElementsByClassName('productCard'));

    let sortedProducts;
    if (sortBy === 'price_asc') {
        sortedProducts = products.sort((a, b) => parsePrice(a) - parsePrice(b));
    } else if (sortBy === 'price_desc') {
        sortedProducts = products.sort((a, b) => parsePrice(b) - parsePrice(a));
    } else {
        sortedProducts = products;
    }

    productsContainer.innerHTML = '';
    sortedProducts.forEach(product => productsContainer.appendChild(product));
}

function parsePrice(product) {
    const priceText = product.querySelector('.price').textContent;
    const price = parseFloat(priceText.replace(/[^\d.-]/g, ''));
    return price;
}
