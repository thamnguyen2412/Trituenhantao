<?php
// index.php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Trang chủ có thể hiển thị thống kê hoặc chuyển hướng đến predict.php
header('Location: predict.php');
exit();