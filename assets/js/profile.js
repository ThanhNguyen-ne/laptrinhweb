function showNotification(message) {
    // Tạo một thông báo mới
    const notification = document.createElement("div");
    notification.className = "notification";
    notification.innerText = message;

    // Thêm thông báo vào body
    document.body.appendChild(notification);

    // Loại bỏ thông báo sau 3 giây
    setTimeout(() => {
        notification.remove();
    }, 3000);
}