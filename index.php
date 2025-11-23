<?php

require_once __DIR__ . '/fungsi.php';

// Cek login
requireLogin();

// Handle Delete jika ada parameter delete_id
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $koneksi->query("DELETE FROM barang WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Ambil semua data barang
$items = $koneksi->query("SELECT * FROM barang")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Barang</title>

    <style>
        body {
            background: #ffd6ec;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        nav {
            background: #ffe3f1;
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        nav a {
            text-decoration: none;
            padding: 6px 12px;
            background: white;
            border-radius: 6px;
            color: #444;
            font-weight: bold;
            border: 1px solid #f5b6d6;
        }

        nav a:hover {
            background: #ffccdf;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 15px;
            margin-left: 2px;
        }

        /* Tombol Tambah */
        a[href*="form_barang"] {
            background: #ffb6d6;
            padding: 8px 14px;
            color: white !important;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            border: 1px solid #ff9ec8;
        }

        a[href*="form_barang"]:hover {
            background: #ff8fbe;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: #ffb8d9;
        }

        thead th {
            padding: 12px;
            text-align: left;
            color: white;
            font-weight: bold;
            font-size: 15px;
        }

        tbody tr:nth-child(even) {
            background: #ffe7f2;
        }

        tbody tr:hover {
            background: #ffd0e5;
        }

        td {
            padding: 12px;
            color: #333;
        }

        /* Link aksi */
        td a {
            color: #cc2d6f;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <nav>
        <a href="index.php">📦Barang</a>
        <a href="transaksi.php">📝Transaksi</a>
        <?php if (isSuperAdmin()): ?>
            <a href="users.php">👥Users</a>
        <?php endif; ?>
        <a href="logout.php" style="color: red;">🚪Logout</a>
    </nav>

    <div class="top-area">
        <h2>Daftar Barang</h2>
        <a href="form_barang.php">+ Tambah Barang</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Stok</th>
                <th>Tersedia</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['nama'] ?></td>
                    <td><?= $item['deskripsi'] ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td><?= $item['tersedia'] ?></td>
                    <td><?= $item['lokasi'] ?></td>
                    <td>
                        <a class="action-btn" href="form_barang.php?id=<?= $item['id'] ?>">Edit</a> |
                        <a class="action-btn" href="peminjaman.php?action=pinjam&id=<?= $item['id'] ?>">Pinjam</a> |
                        <a class="action-btn" href="index.php?delete_id=<?= $item['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>