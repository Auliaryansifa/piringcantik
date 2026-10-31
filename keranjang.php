<?php
require 'config.php';
login_wajib();

if (isset($_GET['plus']) && isset($_SESSION['cart'][$_GET['plus']])) $_SESSION['cart'][$_GET['plus']]['qty']++;
if (isset($_GET['minus']) && isset($_SESSION['cart'][$_GET['minus']])) {
    if (--$_SESSION['cart'][$_GET['minus']]['qty'] <= 0) unset($_SESSION['cart'][$_GET['minus']]);
}
if (isset($_GET['hapus'])) unset($_SESSION['cart'][$_GET['hapus']]);

$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $c) $total += $c['harga'] * $c['qty'];
include 'header.php';
?>
<h2>Keranjang & Format Order</h2>
<?php if (!$cart): ?>
  <div class="note">Keranjang masih kosong.</div>
  <a class="btn" href="index.php">Pilih kue</a>
<?php else: ?>
<div class="two">
  <div class="box">
    <?php foreach ($cart as $id => $c): ?>
    <div class="row">
      <img src="<?= e($c['foto']) ?>/small" alt="">
      <div class="n"><?= e($c['nama']) ?><br><small><?= rp($c['harga']) ?></small></div>
      <div class="q">
        <a href="?minus=<?= e($id) ?>">&minus;</a> <?= $c['qty'] ?> <a href="?plus=<?= e($id) ?>">+</a>
      </div>
      <b><?= rp($c['harga'] * $c['qty']) ?></b>
      <a href="?hapus=<?= e($id) ?>" title="Hapus">&times;</a>
    </div>
    <?php endforeach; ?>
    <div class="tot"><span>Total</span><span><?= rp($total) ?></span></div>
  </div>

  <div class="box">
    <b>Data pemesan</b>
    <form method="post" action="proses_order.php">
      <label>Nama penerima</label><input name="nama" value="<?= e($_SESSION['user']['nama']) ?>" required>
      <label>No. HP / WhatsApp</label><input name="hp" required>
      <label>Alamat / ambil di toko</label><textarea name="alamat" rows="2" required></textarea>
      <label>Tanggal ambil / kirim</label><input name="tanggal" type="date" min="<?= date('Y-m-d') ?>" required>
      <label>Catatan (tulisan di kue, dll.)</label><input name="catatan">
      <br><br><button class="btn full">Buat Pesanan</button>
    </form>
  </div>
</div>
<?php endif; ?>
<?php include 'footer.php'; ?>
