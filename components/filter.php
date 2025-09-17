<?php
require_once __DIR__ . '/../db_connect.php';
$db = get_db();

// Xác định loại grid: festival hay gallery
$type     = $_GET['type'] ?? 'festival';
$religion = $_GET['religion'] ?? '';
$month    = $_GET['month'] ?? '';
$country  = $_GET['country'] ?? '';
$page     = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Đóng gói filter để truyền vào grid
$filters = [
    'religion' => $religion,
    'month'    => $month,
    'country'  => $country,
    'page'     => $page
];

if ($type === 'gallery') {
    include __DIR__ . '/gallery-grid.php';
} else {
    include __DIR__ . '/festival-grid.php';
}
