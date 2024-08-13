document
    .getElementById("accountSettingsForm")
    .addEventListener("submit", function (e) {
        e.preventDefault();
        const username = document.getElementById("username").value;
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        // Logic to save account settings
        alert("Đã lưu cài đặt tài khoản!");
    });

document
    .getElementById("notificationSettingsForm")
    .addEventListener("submit", function (e) {
        e.preventDefault();
        const emailNotif = document.getElementById("emailNotif").checked;
        const smsNotif = document.getElementById("smsNotif").checked;

        // Logic to save notification settings
        alert("Đã lưu cài đặt thông báo!");
    });

document
    .getElementById("interfaceSettingsForm")
    .addEventListener("submit", function (e) {
        e.preventDefault();
        const theme = document.getElementById("theme").value;

        // Apply the selected theme
        document.body.className = theme;

        // Logic to save interface settings
        alert("Đã lưu cài đặt giao diện!");
    });


    const toggler = document.getElementById("theme-toggle");

toggler.addEventListener("change", function () {
    if (this.checked) {
        document.body.classList.add("dark");
    } else {
        document.body.classList.remove("dark");
    }
});
