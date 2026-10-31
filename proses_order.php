<?php
require 'config.php';
login_wajib();
$cart = $_SESSION['cart'] ?? [];
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$cart) { header('Location: keranjang.php'); exit; }

$nama = trim($_POST['nama'] ?? '');
$hp = trim($_POST['hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$tgl = $_POST['tanggal'] ?? '';
$cat = trim($_POST['catatan'] ?? '');
if ($nama === '' || $hp === '' || $alamat === '' || $tgl === '') { header('Location: keranjang.php'); exit; }

$total = 0;
foreach ($cart as $c) $total += $c['harga'] * $c['qty'];
$kode = 'PC-' . date('ymd') . '-' . random_int(1000, 9999);

$pdo->beginTransaction();
$pdo->prepare('INSERT INTO orders (kode, user_id, nama_penerima, hp, alamat, tanggal, catatan, total) VALUES (?,?,?,?,?,?,?,?)')
    ->execute([$kode, $_SESSION['user']['id'], $nama, $hp, $alamat, $tgl, $cat, $total]);
$oid = $pdo->lastInsertId();
$ins = $pdo->prepare('INSERT INTO order_items (order_id, meal_id, nama, harga, qty) VALUES (?,?,?,?,?)');
foreach ($cart as $id => $c) $ins->execute([$oid, $id, $c['nama'], $c['harga'], $c['qty']]);
$pdo->commit();

unset($_SESSION['cart']);
header('Location: sukses.php?kode=' . urlencode($kode));
