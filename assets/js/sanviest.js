const products = document.querySelector('.products');
let thisPage = 1; 
let limit = 12; 
let productList = []; // Biến để lưu danh sách sản phẩm

const getData = async () => {
    try {
        const response = await fetch('../assets/js/data.json'); // Kiểm tra lại đường dẫn
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();

        if (data) {
            // Lọc sản phẩm có id từ 1 tới 7
            productList = data.filter(item => item.id >= 16 && item.id <= 30);
            loadItem(); // Hiển thị sản phẩm
            listPage(); // Cập nhật phân trang
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

function loadItem() {
    const beginGet = limit * (thisPage - 1);
    const endGet = limit * thisPage;

    products.innerHTML = productList.slice(beginGet, endGet).map(item => {
        return `
        <div class="productCard" id="${item.id}">
          <a href="detail.html?id=${item.id}">  <img src="${item.img}" alt="${item.title}" /></a>
            <p class="name">${item.title}</p>
            <p class="price">${item.price}</p>
        </div>
        `;
    }).join('');
    
    listPage(); // Cập nhật phân trang
}

function listPage() {
    const count = Math.ceil(productList.length / limit);
    const listPageElement = document.querySelector('.listPage');
    listPageElement.innerHTML = ''; // Xóa nội dung cũ

    // Thêm nút "PREV"
    if (thisPage > 1) {
        const prev = document.createElement('li');
        prev.innerText = 'PREV';
        prev.setAttribute('onclick', "changePage(" + (thisPage - 1) + ")");
        listPageElement.appendChild(prev);
    }

    // Tạo các nút trang
    for (let i = 1; i <= count; i++) {
        const newPage = document.createElement('li');
        newPage.innerText = i;
        newPage.setAttribute('onclick', "changePage(" + i + ")");
        if (i === thisPage) {
            newPage.classList.add('active');
        }
        listPageElement.appendChild(newPage);
    }

    // Thêm nút "NEXT"
    if (thisPage < count) {
        const next = document.createElement('li');
        next.innerText = 'NEXT';
        next.setAttribute('onclick', "changePage(" + (thisPage + 1) + ")");
        listPageElement.appendChild(next);
    }
}

function changePage(i) {
    thisPage = i;
    loadItem(); // Cập nhật sản phẩm hiển thị trên trang mới
}

// Khởi động việc lấy dữ liệu
getData();