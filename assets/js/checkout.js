document.addEventListener("DOMContentLoaded", function () {
    fetch("../admin/pages/api.php?action=get_user_info")
        .then((response) => response.json())
        .then((userInfo) => {
            if (userInfo.logged_in) {
                document.getElementById("name").value = userInfo.name || "";
                document.getElementById("email").value = userInfo.email || "";
                document.getElementById("address").value =
                    userInfo.address || "";
                document.getElementById("phone").value = userInfo.phone || "";
            }
        });

    const checkoutForm = document.getElementById("checkoutForm");

    checkoutForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();
        const address = document.getElementById("address").value.trim();
        const phone = document.getElementById("phone").value.trim();
        const paymentMethod = document.getElementById("paymentMethod").value;

        clearErrors();
        let hasError = false;

        if (!name) {
            showError("nameError", "Bạn cần nhập tên để thực hiện thanh toán.");
            hasError = true;
        }
        if (!email) {
            showError(
                "emailError",
                "Bạn cần nhập email để thực hiện thanh toán."
            );
            hasError = true;
        }
        if (!address) {
            showError(
                "addressError",
                "Bạn cần nhập địa chỉ để thực hiện thanh toán."
            );
            hasError = true;
        }
        if (!phone) {
            showError(
                "phoneError",
                "Bạn cần nhập số điện thoại để thực hiện thanh toán."
            );
            hasError = true;
        } else if (!/^\d{10}$/.test(phone)) {
            showError("phoneError", "Bạn cần nhập đúng số điện thoại (10 số).");
            hasError = true;
        }

        if (!hasError) {
            checkoutForm.submit();
        }
    });

    function showError(elementId, message) {
        const errorElement = document.getElementById(elementId);
        errorElement.textContent = message;
        errorElement.style.display = "block";
    }

    function clearErrors() {
        const errorMessages = document.querySelectorAll(
            ".checkout-error-message"
        );
        errorMessages.forEach((error) => {
            error.style.display = "none";
        });
    }
});
