// const detailContainer = document.querySelector(".detail9-container");
// const btnAddCart = document.getElementById("addCart");
// const cartIcon = document.querySelector(".cart1");
// const getDetailProduct = async () => {
//     const path = new URLSearchParams(window.location.search);
//     const productId = path.get("id");

//     const response = await fetch("../assets/js/data.json"); // Đảm bảo đường dẫn đúng
//     const data = await response.json();
//     const findProductId = data.find(
//         (item) => item.id.toString() === productId.toString()
//     );
//     detailContainer.innerHTML = `
// 				<div class="detail9">
// 					<div class="detail9-image">
// 						<img src="${findProductId.img}" alt="${findProductId.title}">
// 					</div>
// 					<div class="detail9-info">
// 						<h2>${findProductId.title}</h2>
// 						<p>${findProductId.description}</p>
// 						<div class="detail9-price">
// 							Price:
// 							<span class="price9">${findProductId.price}</span>
// 						</div>
// 					</div>
// 				</div>
// 			`;
//     btnAddCart.addEventListener("click", () => {
//         const cart = JSON.parse(localStorage.getItem("cart1"));

//         if (cart) {
//             s;
//             const item = cart.findIndex((item) => item.id === findProductId.id);

//             if (item !== -1) {
//                 cart[item].count += 1;
//             } else {
//                 cart.push({ id: findProductId.id, count: 1 });
//             }
//             localStorage.setItem("cart", JSON.stringify(cart));
//         } else {
//             const cart = [
//                 {
//                     id: findProductId.id,
//                     count: 1,
//                 },
//             ];
//             localStorage.setItem("cart1", JSON.stringify(cart));
//         }
//         setCartItem();
//     });
// };

// const setCartItem = () => {
//     const cart = JSON.parse(localStorage.getItem("cart1"));
//     if (cart && cart.length > 0) {
//         CSSMatrixComponent.innerHTML = `
// 			<p class = "cart-item"> ${cart.length}</p>
// 			<i class = "fa fa-shopping-bag"></i>
// 		`;
//     }
// };

// setCartItem();
// getDetailProduct();
const detailContainer = document.querySelector('.detail9-container');
const btnAddCart =document.getElementById('addToCart');
const cartIcon =document.querySelector('.cart');


const getDetailProduct = async () => {
    const path = new URLSearchParams(window.location.search);
    const productId = path.get('id');
    console.log('Product ID:', productId);
    
        const response = await fetch('../assets/js/data.json'); // Đảm bảo đường dẫn đúng
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        // Tìm sản phẩm có id tương ứng
        const product = data.find(item => item.id == productId);
        console.log('Product:', product); // Log sản phẩm tìm thấy
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
                
                
            `
            btnAddCart.addEventListener('click',()=>{
                console.log('Button clicked'); // Log để kiểm tra xem nút có được nhấn không
                const cart =JSON.parse(localStorage.getItem('cart'));
                
                if(cart) {
                    const item = cart.findIndex(item => item.id === product.id);


                    if(item != -1){
                        cart[item].count  +=1; 
                    }else{
                        cart.push({id: product.id,count:1})
                    }
                    localStorage.setItem('cart',JSON.stringify(cart));



                }else{
                    const cart = 
                    [
                        {
                        id: product.id,
                        count: 1
                        }
                    ]

                    localStorage.setItem('cart',JSON.stringify(cart));
                    console.log('Cart updated:', cart); // Log để kiểm tra
                }

                
            });
        } 
};

getDetailProduct();

