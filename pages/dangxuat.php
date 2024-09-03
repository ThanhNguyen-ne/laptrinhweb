<?php
session_start();
$current_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

// Hủy session
session_unset();
session_destroy();

// Chuyển hướng về trang trước đó hoặc trang chủ
header("Location: $current_page");
exit();
?>
