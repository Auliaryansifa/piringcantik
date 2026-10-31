<?php
require 'config.php';
$id = $_POST['id'] ?? '';
if (empty($_SESSION['user'])) {
    $_SESSION['pending'] = $id;   // diingat, dimasukkan ke keranjang setelah login
    header('Location: login.php');
    exit;
}
tambah_ke_keranjang($id);
header('Location: index.php');
