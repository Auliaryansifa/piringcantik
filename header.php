<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Piring Cantik</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <div class="in">
    <a class="logo" href="index.php">Piring Cantik</a>
    <nav>
      <a href="index.php">Katalog</a>
      <a href="keranjang.php">Keranjang (<?= jumlah_keranjang() ?>)</a>
      <?php if (!empty($_SESSION['user'])): ?>
        <span>Hai, <?= e($_SESSION['user']['nama']) ?></span>
        <a href="logout.php">Keluar</a>
      <?php else: ?>
        <a href="login.php">Masuk</a>
        <a href="register.php">Daftar</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="wrap">
