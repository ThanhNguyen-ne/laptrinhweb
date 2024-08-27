// const productsContainer = document.querySelector(".products");
// let thisPage = 1;
// let limit = 12;
// let productList = [];

// // Lấy dữ liệu sản phẩm từ API
// const getData = async () => {
//     try {
//         const response = await fetch("../admin/pages/api.php?action=get_products");
//         const data = await response.json();

//         if (data) {
//             // Lọc sản phẩm với id từ 51 đến 60
//             productList = data.filter(product => product.id >= 51 && product.id <= 60);
//             loadItem();
//             loadFeaturedProducts();
//         }
//     } catch (error) {
//         console.error("Lỗi khi lấy dữ liệu sản phẩm:", error);
//     }
// };

// // Hiển thị các sản phẩm trên trang sản phẩm
// function loadItem() {
//     let beginGet = limit * (thisPage - 1);
//     let endGet = limit * thisPage;
//     productsContainer.innerHTML = productList.slice(beginGet, endGet)
//         .map((item) => {
//             return `
//             <div class="productCard" id="${item.id}" onclick="redirectToDetail(${item.id})">
//                 <img src="../${item.hinh_anh}" alt="${item.ten_san_pham}" />
//                 <p class="name">${item.ten_san_pham}</p>
//                  <p class="price">${parseFloat(item.gia).toLocaleString("vi-VN", { style: "currency", currency: "VND" })} </p>
//                 <div class="product-buttons">
//                     <button class="btn-cart" onclick="addToCart(event, ${item.id})">
//                         <i class="fa-solid fa-cart-shopping"></i>
//                     </button>
//                     <button class="btn-buy" onclick="redirectToCheckout(event, ${item.id})">
//                         Mua ngay
//                     </button>
//                 </div>
//             </div>
//             `;
//         })
//         .join("");
//     listPage();
// }

// // Danh sách phân trang
// function listPage() {
//     let count = Math.ceil(productList.length / limit);
//     document.querySelector(".listPage").innerHTML = "";

//     if (thisPage != 1) {
//         let prev = document.createElement("li");
//         prev.innerText = "TRƯỚC";
//         prev.setAttribute("onclick", `changePage(${thisPage - 1})`);
//         document.querySelector(".listPage").appendChild(prev);
//     }

//     for (let i = 1; i <= count; i++) {
//         let newPage = document.createElement("li");
//         newPage.innerText = i;
//         if (i == thisPage) {
//             newPage.classList.add("active");
//         }
//         newPage.setAttribute("onclick", `changePage(${i})`);
//         document.querySelector(".listPage").appendChild(newPage);
//     }

//     if (thisPage != count) {
//         let next = document.createElement("li");
//         next.innerText = "SAU";
//         next.setAttribute("onclick", `changePage(${thisPage + 1})`);
//         document.querySelector(".listPage").appendChild(next);
//     }
// }

// function changePage(i) {
//     thisPage = i;
//     loadItem();
// }

// function redirectToDetail(productId) {
//     window.location.href = `detail.php?id=${productId}`;
// }

// function addToCart(event, productId) {
//     event.stopPropagation();
//     const cart = JSON.parse(localStorage.getItem('cart')) || [];
//     const product = productList.find(p => p.id === productId);

//     const existingProductIndex = cart.findIndex(item => item.id === productId);
//     if (existingProductIndex !== -1) {
//         cart[existingProductIndex].count += 1;
//     } else {
//         cart.push({ ...product, count: 1 });
//     }

//     localStorage.setItem('cart', JSON.stringify(cart));
//     showNotification("Sản phẩm đã được thêm vào giỏ hàng!");
//     renderCartItem();
// }

// function redirectToCheckout(event, productId) {
//     event.stopPropagation();
//     addToCart(event, productId);
//     window.location.href = 'checkout.php';
// }

// function showNotification(message) {
//     const notification = document.createElement("div");
//     notification.className = "notification";
//     notification.innerText = message;

//     document.body.appendChild(notification);

//     setTimeout(() => {
//         notification.remove();
//     }, 3000);
// }

// // Hiển thị các sản phẩm nổi bật
// function loadFeaturedProducts() {
//     const featuredProductsContainer = document.getElementById("featuredProducts");
//     // Chỉ lấy 5 sản phẩm đầu tiên làm sản phẩm nổi bật
//     const featuredProducts = productList.slice(0, 5);

//     featuredProductsContainer.innerHTML = featuredProducts
//         .map((item) => `
//             <a href="detail.php?id=${item.id}" style="text-decoration:none;color:black;">
//                 <li>
//                     <img src="../${item.hinh_anh}" alt="${item.ten_san_pham}" />
//                     <p>${item.ten_san_pham}</p>
//                      <span>${parseFloat(item.gia).toLocaleString("vi-VN", {
//                         style: "currency",
//                         currency: "VND",
//                     })} </span>
//                 </li>
//             </a>
//         `)
//         .join("");
// }

// getData();
