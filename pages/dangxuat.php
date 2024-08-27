<?php
session_start();

// Lấy đường dẫn trang hiện tại
$current_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// Hủy session
session_destroy();

// Chuyển hướng về trang trước đó hoặc `index.php` nếu không có trang trước đó
header("Location: $current_page");
exit();
