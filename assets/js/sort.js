document.querySelector('.sort select').addEventListener('change', function () {
    const productList = document.querySelector('.product-list .products');
    const products = Array.from(productList.children);

    if (this.value === 'price_asc') {
        products.sort((a, b) => {
            const priceA = parseInt(a.querySelector('.price').innerText.replace(/[^0-9]/g, ''));
            const priceB = parseInt(b.querySelector('.price').innerText.replace(/[^0-9]/g, ''));
            return priceA - priceB;
        });
    } else if (this.value === 'price_desc') {
        products.sort((a, b) => {
            const priceA = parseInt(a.querySelector('.price').innerText.replace(/[^0-9]/g, ''));
            const priceB = parseInt(b.querySelector('.price').innerText.replace(/[^0-9]/g, ''));
            return priceB - priceA;
        });
    }

    products.forEach(product => productList.appendChild(product));
});
