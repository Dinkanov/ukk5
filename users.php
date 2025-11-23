<?php

include 'fungsi.php';

// Cek login
requireLogin();

// Cek akses superadmin
if (!isSuperAdmin()) {
    echo "Anda tidak memiliki akses ke halaman ini.";
    exit();
}

// Handle Delete user
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $koneksi->query("DELETE FROM users WHERE id = $id");
    header("Location: users.php");
    exit();
}

// Ambil semua data user
$users = $koneksi->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div>
        <nav style="display: flex; gap: 15px;">
            <a href="index.php">📦Barang</a>
            <a href="transaksi.php">📝Transaksi</a>
            <?php if (isSuperAdmin()): ?>
                <a href="users.php">👥Users</a>
            <?php endif; ?>
            <a href="logout.php" style="color: red;">🚪Logout</a>
        </nav>

        <div style="display: flex; justify-content: space-between; margin: 20px 0;">
            <h2>Daftar User</h2>
            <a href="form_user.php">+ Tambah User</a>
        </div>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['fullname'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td>
                            <a href="users.php?delete_id=<?= $user['id'] ?>" onclick="return confirm('Hapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>