<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$routes = [
    '/admin/dashboard' => __DIR__ . '/../pages/admin/dashboard.php',
    '/admin/form-pelanggan' => __DIR__ . '/../pages/admin/form-pelanggan.php',
    '/admin/proses-pelanggan' => __DIR__ . '/../pages/admin/proses-pelanggan.php'
];

if (array_key_exists($uri, $routes)) {
    include $routes[$uri];
} else {
    echo "❌ Halaman tidak ditemukan.";
}
?>