<?php
session_start();

// Koneksi database (XAMPP default: user root, password kosong)
$pdo = new PDO('mysql:host=localhost;dbname=piring_cantik;charset=utf8mb4', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rp($n) { return 'Rp' . number_format($n, 0, ',', '.'); }

// Harga dibuat otomatis dari ID kue (API tidak punya harga). Ubah rumusnya sesuka kamu.
function harga($id) { return 20000 + ((int)$id % 10) * 2500; }

function login_wajib() {
    if (empty($_SESSION['user'])) { header('Location: login.php'); exit; }
}

// Ambil katalog dessert dari TheMealDB, disimpan di cache 1 hari
function ambil_kue() {
    $f = __DIR__ . '/cache_kue.json';
    if (is_file($f) && time() - filemtime($f) < 86400) {
        return json_decode(file_get_contents($f), true) ?: [];
    }
    $j = @file_get_contents('https://www.themealdb.com/api/json/v1/1/filter.php?c=Dessert');
    $d = $j ? (json_decode($j, true)['meals'] ?? []) : [];
    if ($d) { file_put_contents($f, json_encode($d)); return $d; }
    return is_file($f) ? (json_decode(file_get_contents($f), true) ?: []) : [];
}

function cari_kue($id) {
    foreach (ambil_kue() as $k) { if ($k['idMeal'] == $id) return $k; }
    return null;
}

function tambah_ke_keranjang($id) {
    $k = cari_kue($id);
    if (!$k) return;
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = ['nama' => $k['strMeal'], 'foto' => $k['strMealThumb'], 'harga' => harga($id), 'qty' => 0];
    }
    $_SESSION['cart'][$id]['qty']++;
}

function jumlah_keranjang() {
    $t = 0;
    foreach ($_SESSION['cart'] ?? [] as $c) $t += $c['qty'];
    return $t;
}
