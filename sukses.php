<?php
require 'config.php';
login_wajib();
$st = $pdo->prepare('SELECT * FROM orders WHERE kode = ? AND user_id = ?');
$st->execute([$_GET['kode'] ?? '', $_SESSION['user']['id']]);
$o = $st->fetch();
if (!$o) { header('Location: index.php'); exit; }
$it = $pdo->prepare('SELECT * FROM order_items WHERE order_id = ?');
$it->execute([$o['id']]);
include 'header.php';
?>
<div class="box">
  <h2>Pesanan diterima 🎉</h2>
  <p>No. pesanan <b><?= e($o['kode']) ?></b><br>
  Atas nama <?= e($o['nama_penerima']) ?> (<?= e($o['hp']) ?>)<br>
  <?= nl2br(e($o['alamat'])) ?><br>
  Tanggal: <?= e($o['tanggal']) ?>
  <?php if ($o['catatan']): ?><br>Catatan: <?= e($o['catatan']) ?><?php endif; ?></p>
  <?php foreach ($it as $r): ?>
    <div class="row"><div class="n"><?= e($r['nama']) ?> &times; <?= $r['qty'] ?></div><b><?= rp($r['harga'] * $r['qty']) ?></b></div>
  <?php endforeach; ?>
  <div class="tot"><span>Total</span><span><?= rp($o['total']) ?></span></div>
  <a class="btn o" href="index.php">Pesan lagi</a>
</div>
<?php include 'footer.php'; ?>
