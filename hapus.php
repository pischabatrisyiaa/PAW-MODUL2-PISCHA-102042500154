<?php
require 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $koneksi->prepare('SELECT * FROM showroom_mobil WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$hasil = $stmt->get_result();
$mobil = $hasil->fetch_assoc();
if (!$mobil) {
    exit('Mobil tidak ditemukan. Kembali ke daftar mobil.');
}

// Wajib POST dan wajib WHERE id.
if (isset($_POST['hapus'])) {
    $stmt = $koneksi->prepare('DELETE FROM showroom_mobil WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: index.php?pesan=1', true, 303);
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus mobil - ShowRoom EAD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body><main>
<p class="label">SHOWROOM EAD / KONFIRMASI</p>
<h1>Hapus mobil?</h1>
<p><?= htmlspecialchars($mobil['nama_mobil'], ENT_QUOTES, 'UTF-8') ?>
   (<?= htmlspecialchars($mobil['kode_mobil'], ENT_QUOTES, 'UTF-8') ?>) akan dihapus.</p>
<p>Data yang sudah dihapus tidak bisa dikembalikan.</p>
<form method="post" action="hapus.php?id=<?= $id ?>">
    <button name="hapus" class="bahaya">Ya, hapus mobil</button>
    <a href="detail.php?id=<?= $id ?>">Batal</a>
</form>
</main></body>
</html>
