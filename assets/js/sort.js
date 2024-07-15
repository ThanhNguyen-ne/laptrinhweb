document.getElementById("sortOptions").addEventListener("change", function () {
    let productList = document.querySelector(".product-list .products");
    let products = Array.from(
        productList.getElementsByClassName("product-card")
    );

    products.sort((a, b) => {
        let priceA = parseInt(
            a.querySelector(".price").textContent.replace(/[^0-9]/g, "")
        );
        let priceB = parseInt(
            b.querySelector(".price").textContent.replace(/[^0-9]/g, "")
        );

        if (this.value === "price_asc") {
            return priceA - priceB;
        } else if (this.value === "price_desc") {
            return priceB - priceA;
        }
        return 0;
    });

    // Clear and re-append sorted products
    productList.innerHTML = "";
    products.forEach((product) => productList.appendChild(product));
});
