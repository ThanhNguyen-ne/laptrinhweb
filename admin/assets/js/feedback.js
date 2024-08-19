const feedbacks = [];

function loadFeedbacks() {
    fetch('api.php?action=get_feedbacks')
    .then(response => response.json())
    .then(data => {
        renderFeedbacks(data);
    });
}

// Hàm để render feedbacks
function renderFeedbacks(feedbacks) {
    const tbody = document.querySelector(".feedback-table tbody");
    tbody.innerHTML = "";
    feedbacks.forEach((feedback, index) => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${feedback.name}</td>
            <td>${feedback.email}</td>
            <td>${feedback.message}</td>
            <td>${feedback.time}</td>
            <td class="actions">
                <button class="btn delete-btn" data-id="${feedback.id}">Xóa</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Thêm sự kiện click cho nút xóa
    document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.addEventListener("click", handleDelete);
    });
}

// Hàm xử lý xóa feedback
function handleDelete(e) {
    const feedbackId = e.target.dataset.id;
    if (confirm('Bạn có chắc chắn muốn xóa phản hồi này?')) {
        fetch(`api.php?action=delete_feedback&id=${feedbackId}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadFeedbacks();
        });
    }
}

window.onload = loadFeedbacks;

const toggler = document.getElementById("theme-toggle");

toggler.addEventListener("change", function () {
    if (this.checked) {
        document.body.classList.add("dark");
    } else {
        document.body.classList.remove("dark");
    }
});
