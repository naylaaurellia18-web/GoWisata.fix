<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();
$db = $conn;

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit();
}

// Proses Hapus User
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus']; // FIX: cast ke int
    mysqli_query($db, "DELETE FROM pengguna WHERE id=$id_hapus AND role='user'");
    header("Location: kelola_user.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h3 class="fw-bold">👥 Daftar Pelanggan</h3>
        <a href="admin_dashboard.php" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card shadow-sm border-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="ps-4">No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $res = mysqli_query($db, "SELECT * FROM pengguna WHERE role='user' ORDER BY id ASC");
            $no  = 1;
            if ($res && mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id_u   = (int)($row['id'] ?? 0);
                    $nama_u = htmlspecialchars($row['username']);
                    $email_u= htmlspecialchars($row['email'] ?? '-');
            ?>
            <tr class="align-middle">
                <td class="ps-4"><?= $no++ ?></td>
                <td><?= $nama_u ?></td>
                <td class="text-muted small"><?= $email_u ?></td>
                <td><span class="badge bg-info text-dark">Pelanggan</span></td>
                <td class="text-center">
                    <?php if ($id_u > 0): ?>
                        <a href="kelola_user.php?hapus=<?= $id_u ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Yakin hapus user <?= addslashes($nama_u) ?>?')">
                            Hapus
                        </a>
                    <?php else: ?>
                        <span class="text-danger small">ID tidak ditemukan</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php }
            } else {
                echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada pelanggan terdaftar.</td></tr>";
            } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>