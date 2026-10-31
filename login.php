<?php
require 'config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $st->execute([trim($_POST['email'] ?? '')]);
    $u = $st->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $u['id'], 'nama' => $u['nama']];
        // Kalau tadi tamu klik "Pesan", kue itu langsung masuk keranjang
        if (!empty($_SESSION['pending'])) {
            tambah_ke_keranjang($_SESSION['pending']);
            unset($_SESSION['pending']);
            header('Location: keranjang.php');
        } else {
            header('Location: index.php');
        }
        exit;
    }
    $err = 'Email atau password salah.';
}
include 'header.php';
?>
<div class="box">
  <h2>Masuk</h2>
  <?php if (isset($_GET['daftar'])): ?><div class="note">Pendaftaran berhasil, silakan masuk.</div><?php endif; ?>
  <?php if (!empty($_SESSION['pending'])): ?><div class="note">Login dulu untuk menambahkan kue ke keranjang.</div><?php endif; ?>
  <?php if ($err): ?><div class="note err"><?= e($err) ?></div><?php endif; ?>
  <form method="post">
    <label>Email</label><input name="email" type="email" required>
    <label>Password</label><input name="password" type="password" required>
    <br><br><button class="btn full">Masuk</button>
  </form>
  <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</div>
<?php include 'footer.php'; ?>
