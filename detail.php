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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail mobil - ShowRoom EAD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body><main>
<p class="label">SHOWROOM EAD / DETAIL</p>
<h1><?= htmlspecialchars($mobil['nama_mobil'], ENT_QUOTES, 'UTF-8') ?></h1>
<dl>
    <dt>Kode</dt><dd><?= htmlspecialchars($mobil['kode_mobil'], ENT_QUOTES, 'UTF-8') ?></dd>
    <dt>Brand</dt><dd><?= htmlspecialchars($mobil['brand_mobil'], ENT_QUOTES, 'UTF-8') ?></dd>
    <dt>Warna</dt><dd><?= htmlspecialchars($mobil['warna_mobil'], ENT_QUOTES, 'UTF-8') ?></dd>
    <dt>Tipe</dt><dd><?= htmlspecialchars($mobil['tipe_mobil'], ENT_QUOTES, 'UTF-8') ?></dd>
    <dt>Harga</dt>
    <dd>Rp <?= number_format($mobil['harga_mobil'], 0, ',', '.') ?></dd>
</dl>
<a href="index.php">Daftar mobil</a>
<a href="edit.php?id=<?= $id ?>">Edit mobil</a>
<a href="hapus.php?id=<?= $id ?>">Hapus mobil</a>
</main></body>
</html>
