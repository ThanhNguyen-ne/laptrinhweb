const feedbacks = [
    {
        name: "Nguyễn Quốc Tùng",
        email: "tung@gmail.com",
        message: "Tôi rất hài lòng với sản phẩm!",
        time: "10-08-2024 10:30 AM",
    },
    {
        name: "Nguyễn Quốc Tùng",
        email: "tung@gmail.com",
        message: "Dịch vụ hỗ trợ rất tốt.",
        time: "10-08-2024 10:30 AM",
    },
    {
        name: "Nguyễn Võ Thành",
        email: "thanh@gmail.com",
        message: "Tôi gặp vấn đề với sản phẩm.",
        time: "10-08-2024 10:30 AM",
    },
];

// Function to render feedbacks
function renderFeedbacks() {
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
                <button class="btn delete-btn" data-index="${index}">Xóa</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    // Add event listeners for delete buttons
    document.querySelectorAll(".delete-btn").forEach((btn) => {
        btn.addEventListener("click", handleDelete);
    });
}

// Handle delete
function handleDelete(e) {
    const index = e.target.dataset.index;
    feedbacks.splice(index, 1);
    renderFeedbacks();
}

// Initial render
renderFeedbacks();

const toggler = document.getElementById("theme-toggle");

toggler.addEventListener("change", function () {
    if (this.checked) {
        document.body.classList.add("dark");
    } else {
        document.body.classList.remove("dark");
    }
});
