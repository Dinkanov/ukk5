<?php

include 'db.php';
include 'fungsi.php';

// Cek login
requireLogin();

// Ambil data transaksi + barang
$transaksi = $koneksi->query("SELECT t.*, b.nama FROM transaksi t JOIN barang b ON t.id_barang = b.id ORDER BY t.tanggal DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>

    <!-- INTERNAL CSS TEMA SOFT PINK -->
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

    /* Status */
    td[style] {
        font-weight: bold;
    }
    </style>

</head>

<body>
    <div>

        <nav>
            <a href="index.php">📦Barang</a>
            <a href="transaksi.php">📝Transaksi</a>
            <?php if (isSuperAdmin()): ?>
                <a href="users.php">👥Users</a>
            <?php endif; ?>
            <a href="logout.php" style="color: red;">🚪Logout</a>
        </nav>

        <h2>Riwayat Transaksi</h2>

        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Peminjam</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($transaksi as $t): ?>
                    <tr>
                        <td><?= $t['nama'] ?></td>
                        <td><?= $t['peminjam'] ?></td>
                        <td><?= $t['jumlah'] ?></td>

                        <td>
                            <?php if ($t['kategori'] == 'pinjam'): ?>
                                <span class="badge-pinjam">Pinjam</span>
                            <?php else: ?>
                                <span class="badge-kembali">Kembali</span>
                            <?php endif; ?>
                        </td>

                        <td><?= $t['catatan'] ?></td>
                        <td><?= $t['tanggal'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>