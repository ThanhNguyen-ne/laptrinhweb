const products = document.querySelector(".products");
let thisPage = 1;
let limit = 12;
let productList = []; // Biến để lưu danh sách sản phẩm

const getData = async () => {
    const response = await fetch("../assets/js/data.json");
    const data = await response.json();

    if (data) {
        productList = data; // Lưu sản phẩm vào biến productList
        loadItem();
    }
};

function loadItem() {
    let beginGet = limit * (thisPage - 1);
    let endGet = limit * thisPage;
    products.innerHTML = productList.slice(beginGet, endGet)
        .map((item) => {
            return `
            <div class="productCard" id="${item.id}">
                <a href="detail.html?id=${item.id}">  
                <img src="${item.img}" alt="${item.title}" /></a>
                <p class="name">${item.title}</p>
                <p class="price">${item.price}</p>
                <div class="product-buttons">
                    <button class="btn-cart" onclick="addToCart(${item.id})">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </button>
                    <button class="btn-buy" onclick="redirectToCheckout(${item.id})">
                        Mua ngay
                    </button>
                </div>
            </div>
            `;
        })
        .join("");
    listPage();
}

function listPage() {
    let count = Math.ceil(productList.length / limit);
    document.querySelector(".listPage").innerHTML = "";

    if (thisPage != 1) {
        let prev = document.createElement("li");
        prev.innerText = "PREV";
        prev.setAttribute("onclick", `changePage(${thisPage - 1})`);
        document.querySelector(".listPage").appendChild(prev);
    }

    for (let i = 1; i <= count; i++) {
        let newPage = document.createElement("li");
        newPage.innerText = i;
        if (i == thisPage) {
            newPage.classList.add("active");
        }
        newPage.setAttribute("onclick", `changePage(${i})`);
        document.querySelector(".listPage").appendChild(newPage);
    }

    if (thisPage != count) {
        let next = document.createElement("li");
        next.innerText = "NEXT";
        next.setAttribute("onclick", `changePage(${thisPage + 1})`);
        document.querySelector(".listPage").appendChild(next);
    }
}

function changePage(i) {
    thisPage = i;
    loadItem();
}

// Hàm để thêm sản phẩm vào giỏ hàng
function addToCart(productId) {
    // Hiển thị thông báo
    alert("Sản phẩm của bạn đã được thêm vào giỏ hàng!");
    
    // Thêm sản phẩm vào trang giohang.html
    // Đây là một ví dụ đơn giản, thực tế bạn sẽ cần lưu dữ liệu sản phẩm vào LocalStorage hoặc gửi lên server
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const product = productList.find(p => p.id === productId);
    cart.push(product);
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Hàm để chuyển hướng đến trang checkout
function redirectToCheckout(productId) {
    window.location.href = 'checkout.html';
}

// Khởi động việc lấy dữ liệu
getData();
