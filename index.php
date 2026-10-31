<?php
require 'config.php';
$q = trim($_GET['q'] ?? '');
$kue = ambil_kue();
if ($q !== '') {
    $kue = array_filter($kue, fn($k) => stripos($k['strMeal'], $q) !== false);
}
include 'header.php';
?>
<div class="hero">
  <h1>Piring Cantik</h1>
  <p>Kue manis, cantik di piring, enak di hati. Lihat-lihat dulu, pesan kalau sudah jatuh cinta.</p>
</div>

<?php if (empty($_SESSION['user'])): ?>
  <div class="note">Kamu masuk sebagai tamu. Untuk memesan, silakan <a href="login.php">login</a> atau <a href="register.php">daftar</a> dulu.</div>
<?php endif; ?>

<form class="cari" method="get">
  <input name="q" placeholder="Cari kue..." value="<?= e($q) ?>">
  <button class="btn">Cari</button>
</form>

<h2>Katalog Kue</h2>
<?php if (!$kue): ?>
  <p>Kue tidak ditemukan atau katalog belum bisa dimuat. Cek koneksi internet.</p>
<?php endif; ?>
<div class="grid">
<?php foreach ($kue as $k): ?>
  <div class="card">
    <img src="<?= e($k['strMealThumb']) ?>/preview" alt="<?= e($k['strMeal']) ?>" loading="lazy">
    <div class="b">
      <h3><?= e($k['strMeal']) ?></h3>
      <div class="price"><?= rp(harga($k['idMeal'])) ?></div>
      <form method="post" action="tambah.php">
        <input type="hidden" name="id" value="<?= e($k['idMeal']) ?>">
        <button class="btn">Pesan</button>
      </form>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include 'footer.php'; ?>
