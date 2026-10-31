<?php
require 'config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    if ($nama === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
        $err = 'Isi nama, email yang valid, dan password minimal 6 karakter.';
    } else {
        $cek = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $cek->execute([$email]);
        if ($cek->fetch()) {
            $err = 'Email sudah terdaftar.';
        } else {
            $pdo->prepare('INSERT INTO users (nama, email, password) VALUES (?, ?, ?)')
                ->execute([$nama, $email, password_hash($pass, PASSWORD_DEFAULT)]);
            header('Location: login.php?daftar=ok');
            exit;
        }
    }
}
include 'header.php';
?>
<div class="box">
  <h2>Daftar</h2>
  <?php if ($err): ?><div class="note err"><?= e($err) ?></div><?php endif; ?>
  <form method="post">
    <label>Nama lengkap</label><input name="nama" required>
    <label>Email</label><input name="email" type="email" required>
    <label>Password (min. 6 karakter)</label><input name="password" type="password" required>
    <br><br><button class="btn full">Daftar</button>
  </form>
  <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
</div>
<?php include 'footer.php'; ?>
