<?php

include 'fungsi.php';

// Cek login
requireLogin();

$id = $_GET['id'];
$action = $_GET['action']; // 'pinjam' or 'kembali'

// Ambil data barang
$item = $koneksi->query("SELECT * FROM barang WHERE id = $id")->fetch_assoc();

// Proses transaksi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $peminjam = $_POST['peminjam'];
    $jumlah = $_POST['jumlah'];
    $catatan = $_POST['catatan'];

    $valid = true;
    if ($action == 'pinjam' && $jumlah > $item['tersedia']) $valid = false;
    if ($action == 'kembali' && $jumlah > ($item['jumlah'] - $item['tersedia'])) $valid = false;

    if ($valid) {
        $stmt = $koneksi->prepare("INSERT INTO transaksi (id_barang, peminjam, jumlah, kategori, catatan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiss", $id, $peminjam, $jumlah, $action, $catatan);
        $stmt->execute();

        if ($action == 'pinjam') {
            $koneksi->query("UPDATE barang SET tersedia = tersedia - '$jumlah' WHERE id = '$id'");
        } else {
            $koneksi->query("UPDATE barang SET tersedia = tersedia + '$jumlah' WHERE id = '$id'");
        }

        header("Location: transaksi.php");
        exit();
    } else {
        echo "<script>alert('Jumlah tidak valid!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi Barang</title>

    <!-- INTERNAL CSS TEMA SOFT PINK -->
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ffd7e8, #ffe6f2);
        }

        h2 {
            color: #444;
            margin-bottom: 10px;
        }

        .form-box {
            background: white;
            padding: 25px;
            width: 400px;
            border-radius: 15px;
            border: 2px solid #ffc2d8;
            box-shadow: 0 2px 12px rgba(0,0,0,0.1);
        }

        p {
            font-size: 14px;
            margin-bottom: 15px;
            color: #555;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        label {
            font-weight: bold;
            color: #444;
        }

        input, textarea {
            padding: 12px;
            border-radius: 8px;
            border: 1.5px solid #a7c9ff; /* soft blue */
            outline: none;
            font-size: 14px;
            resize: none;
            transition: 0.2s;
        }

        input:focus, textarea:focus {
            border-color: #7aa6ff;
            box-shadow: 0 0 5px rgba(122,166,255,0.6);
        }

        button {
            padding: 12px;
            border: none;
            background: #ffb3d4; /* soft pink */
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #ff97c4;
        }

        a.cancel {
            padding: 12px 18px;
            background: #ddd;
            text-decoration: none;
            border-radius: 8px;
            color: #444;
            font-weight: bold;
            transition: 0.2s;
        }

        a.cancel:hover {
            background: #c7c7c7;
        }

        .btn-row {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="form-box">
        <h2><?= ucfirst($action) ?>: <?= $item['nama'] ?></h2>
        <p>Stok Tersedia: <?= $item['tersedia'] ?> / <?= $item['jumlah'] ?></p>

        <form method="post">
            <label>Nama Peminjam</label>
            <input type="text" name="peminjam" required>

            <label>Jumlah</label>
            <input type="number" name="jumlah" value="1" min="1" required>

            <label>Catatan</label>
            <textarea name="catatan" rows="3" required></textarea>

            <div class="btn-row">
                <button type="submit">Simpan</button>
                <a href="index.php" class="cancel">Batal</a>
            </div>
        </form>
    </div>

</body>

</html>