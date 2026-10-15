<?php
require 'koneksi.php';

$tipe_boleh = ['MPV', 'SUV', 'Sedan', 'Hatchback'];
$kode = $nama = $brand = $warna = $tipe = $harga = '';
$pesan = '';

if (isset($_POST['simpan'])) {
    $kode  = trim($_POST['kode_mobil']);
    $nama  = trim($_POST['nama_mobil']);
    $brand = trim($_POST['brand_mobil']);
    $warna = trim($_POST['warna_mobil']);
    $tipe  = trim($_POST['tipe_mobil']);
    $harga = trim($_POST['harga_mobil']);

    if ($kode == '' || $nama == '' || $brand == '' ||
        $warna == '' || $tipe == '') {
        $pesan = 'Semua kolom wajib diisi.';
    } elseif (!in_array($tipe, $tipe_boleh)) {
        $pesan = 'Tipe mobil harus MPV, SUV, Sedan, atau Hatchback.';
    } elseif (!is_numeric($harga) || $harga <= 0 || $harga > 99999999999) {
        $pesan = 'Harga harus berupa angka positif, tanpa Rp dan titik.';
    } else {
        try {
            $stmt = $conn->prepare(
                'INSERT INTO showroom_mobil
                 (kode_mobil, nama_mobil, brand_mobil,
                  warna_mobil, tipe_mobil, harga_mobil)
                 VALUES (?, ?, ?, ?, ?, ?)'
            );
            $stmt->bind_param('ssssss', $kode, $nama, $brand,
                              $warna, $tipe, $harga);
            $stmt->execute();
            header('Location: index.php?pesan=1', true, 303);
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $pesan = 'Kode mobil sudah dipakai.';
            } else {
                throw $e;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah mobil - ShowRoom EAD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body><main>
<p class="label">SHOWROOM EAD</p>
<h1>Tambah mobil</h1>
<p><a href="index.php">Kembali ke daftar</a></p>
<?php if ($pesan != ''): ?>
    <div class="kesalahan"><?= $pesan ?></div>
<?php endif; ?>
<form method="post" action="tambah.php">
    <label for="kode">Kode mobil</label>
    <input id="kode" name="kode_mobil" maxlength="20"
           value="<?= htmlspecialchars($kode, ENT_QUOTES, 'UTF-8') ?>">
    <label for="nama">Nama mobil</label>
    <input id="nama" name="nama_mobil" maxlength="100"
           value="<?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?>">
    <label for="brand">Brand</label>
    <input id="brand" name="brand_mobil" maxlength="50"
           value="<?= htmlspecialchars($brand, ENT_QUOTES, 'UTF-8') ?>">
    <label for="warna">Warna</label>
    <input id="warna" name="warna_mobil" maxlength="30"
           value="<?= htmlspecialchars($warna, ENT_QUOTES, 'UTF-8') ?>">
    <label for="tipe">Tipe (MPV, SUV, Sedan, atau Hatchback)</label>
    <input id="tipe" name="tipe_mobil" maxlength="20"
           value="<?= htmlspecialchars($tipe, ENT_QUOTES, 'UTF-8') ?>">
    <label for="harga">Harga (angka saja, tanpa Rp dan titik)</label>
    <input id="harga" name="harga_mobil"
           value="<?= htmlspecialchars($harga, ENT_QUOTES, 'UTF-8') ?>">
    <button name="simpan">Simpan mobil</button>
</form>
</main></body>
</html>
