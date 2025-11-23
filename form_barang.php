<?php

include 'fungsi.php';

// Cek login
requireLogin();

$id = $_GET['id'] ?? null;
$data = null;

// Jika ada ID, ambil data barang untuk diedit
if ($id) {
    $data = $koneksi->query("SELECT * FROM barang WHERE id = $id")->fetch_assoc();
}

// Proses simpan data (Tambah/Edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah = $_POST['jumlah'];
    $tersedia = $_POST['tersedia'];
    $lokasi = $_POST['lokasi'];
    $kode = $_POST['kode'];

    if ($id && $data) {
        // Update data barang
        $stmt = $koneksi->prepare("UPDATE barang SET nama=?, deskripsi=?, jumlah=?, tersedia=?, lokasi=?, kode=? WHERE id=?");
        $stmt->bind_param("ssiissi", $nama, $deskripsi, $jumlah, $tersedia, $lokasi, $kode, $id);
    } else {
        // Insert data barang baru
        $stmt = $koneksi->prepare("INSERT INTO barang (nama, deskripsi, jumlah, tersedia, lokasi, kode) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiss", $nama, $deskripsi, $jumlah, $tersedia, $lokasi, $kode);
    }

    $stmt->execute();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Barang</title>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #ffd6ec;
        color: #444;
        padding: 20px;
    }

    .container {
        max-width: 650px;
        margin: 0 auto;
        background: #ffffff;
        padding: 25px;
        border-radius: 14px;
        border: 2px solid #ffb6d6;
        box-shadow: 0px 0px 12px rgba(255, 104, 176, 0.25);
    }

    h2 {
        margin-bottom: 22px;
        text-align: center;
        color: #d63a84;
        font-weight: bold;
    }

    form label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        color: #d63a84;
        font-weight: bold;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        background: #ffe9f3;
        border: 1px solid #ffb6d6;
        color: #444;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 15px;
    }

    input:focus,
    textarea:focus {
        outline: none;
        border: 1px solid #ff80ba;
        background: #ffe1ef;
    }

    textarea {
        height: 100px;
        resize: vertical;
    }

    button {
        background: #ff8fc4;
        color: white;
        padding: 10px 18px;
        border: 0;
        border-radius: 8px;
        cursor: pointer;
        font-size: 15px;
        font-weight: bold;
        transition: 0.2s;
    }

    button:hover {
        background: #ff6eb6;
    }

    a {
        color: #b24a8a;
        text-decoration: none;
        font-weight: bold;
        padding: 8px 12px;
    }

    a:hover {
        text-decoration: underline;
    }

    .btn-row {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 10px;
    }
</style>
</head>

<body>

    <div class="container">
        <h2><?= $id ? 'Edit' : 'Tambah' ?> Barang</h2>

        <form method="post">

            <label>Nama Barang</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?? '' ?>" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required><?= $data['deskripsi'] ?? '' ?></textarea>

            <label>Jumlah Total</label>
            <input type="number" name="jumlah" value="<?= $data['jumlah'] ?? '' ?>" required>

            <label>Jumlah Tersedia</label>
            <input type="number" name="tersedia" value="<?= $data['tersedia'] ?? '' ?>" required>

            <label>Lokasi</label>
            <input type="text" name="lokasi" value="<?= $data['lokasi'] ?? '' ?>" required>

            <label>Kode Barang</label>
            <input type="text" name="kode" value="<?= $data['kode'] ?? '' ?>" required>

            <div class="btn-row">
                <button type="submit">Simpan</button>
                <a href="index.php">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>
