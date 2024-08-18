<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../assets/css/dangnhap.css" />
    <script src="../assets/js/dangnhap.js"></script>
    <title>Đăng nhập</title>
</head>
<body>
    <div align="center" id="id01">
        <div class="form-container">
            <p class="title">Đăng nhập</p>
            <div class="tab-buttons">
                <button id="emailTab" class="tab-button active" onclick="switchToEmailLogin()">Email</button>
                <button id="phoneTab" class="tab-button" onclick="switchToPhoneLogin()">Số Điện Thoại</button>
            </div>
            <form id="loginForm" class="form">
                <input id="loginEmail" placeholder="Email" type="email" />
                <input id="loginPhone" placeholder="Số Điện Thoại" type="text" style="display:none;" />
                <input id="loginPassword" placeholder="Mật khẩu" type="password" />
                <div id="loginMessage"></div>
                <p class="page-link"><span class="page-link-label">Quên mật khẩu?</span></p>
                <button class="form-btn" onclick="login(event)">Đăng nhập</button>
            </form>
            <p class="sign-up-label">
                Chưa có tài khoản?<span class="sign-up-link"><a href="javascript:switchToSignup()"> Đăng kí</a></span>
            </p>
        </div>
    </div>
</body>
</html>
