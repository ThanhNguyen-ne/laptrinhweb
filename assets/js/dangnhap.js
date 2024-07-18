function showLoginModal() {
    var modal = document.getElementById('loginModal');
    var modalBody = document.getElementById('loginModalBody');
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'dangnhap.html', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = 'flex';
        }
    };
    xhr.send();
}

function showSignupModal() {
    var modal = document.getElementById('signupModal');
    var modalBody = document.getElementById('signupModalBody');
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'dangki.html', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            modalBody.innerHTML = xhr.responseText;
            modal.style.display = 'flex';
        }
    };
    xhr.send();
}

function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}

// Switch to signup modal from login modal
function switchToSignup() {
    closeModal('loginModal');
    showSignupModal();
}

// Switch to login modal from signup modal
function switchToLogin() {
    closeModal('signupModal');
    showLoginModal();
}

// Khi người dùng click vào bất kỳ vị trí nào ngoài modal, đóng modal
window.onclick = function(event) {
    var loginModal = document.getElementById('loginModal');
    var signupModal = document.getElementById('signupModal');
    if (event.target == loginModal) {
        loginModal.style.display = "none";
    } else if (event.target == signupModal) {
        signupModal.style.display = "none";
    }
}

