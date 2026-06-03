<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();
$db = $conn;

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit();
}

// Logika Hapus
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    // Pastikan tidak bisa hapus diri sendiri
    $cek_self = mysqli_query($db, "SELECT username FROM pengguna WHERE id=$id");
    $row_self  = mysqli_fetch_assoc($cek_self);
    if ($row_self && $row_self['username'] !== ($_SESSION['username'] ?? '')) {
        mysqli_query($db, "DELETE FROM pengguna WHERE id=$id AND role='admin'");
    }
    header("Location: kelola_admin.php"); exit();
}

// Statistik
$res_adm  = mysqli_query($db, "SELECT * FROM pengguna WHERE role='admin'");
$res_usr  = mysqli_query($db, "SELECT COUNT(*) AS total FROM pengguna WHERE role='user'");
$row_usr  = mysqli_fetch_assoc($res_usr);
$count_admin = $res_adm ? mysqli_num_rows($res_adm) : 0;
$count_user  = $row_usr['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color:#f8f9fa; font-family:'Segoe UI', Tahoma, sans-serif; }
        .stat-card { border:none; border-radius:12px; color:white; padding:20px; }
        .main-card { border:none; border-radius:15px; box-shadow:0 4px 12px rgba(0,0,0,.05); }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0"><i class="bi bi-shield-shaded"></i> Panel Admin</h2>
        <div>
            <button class="btn btn-success rounded-pill px-4 me-2" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin">
                <i class="bi bi-person-plus me-1"></i> Tambah Admin
            </button>
            <a href="admin_dashboard.php" class="btn btn-outline-dark rounded-pill px-4">Dashboard</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="stat-card shadow-sm" style="background:#0d6efd;">
                <h6>Total Admin</h6><h2 class="fw-bold"><?= $count_admin ?></h2>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="stat-card shadow-sm" style="background:#198754;">
                <h6>Total Pelanggan</h6><h2 class="fw-bold"><?= $count_user ?></h2>
            </div>
        </div>
    </div>

    <div class="card main-card">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-dark">
                    <tr><th>No</th><th>Username</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                // FIX: Re-query karena pointer sudah dipakai untuk count
                $res_adm = mysqli_query($db, "SELECT * FROM pengguna WHERE role='admin'");
                while ($row = mysqli_fetch_assoc($res_adm)) {
                    $u_id   = (int)($row['id'] ?? 0);
                    $u_name = htmlspecialchars($row['username'] ?? 'Admin');
                    $is_self = ($u_name === ($_SESSION['username'] ?? ''));
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="fw-bold text-primary"><?= $u_name ?></td>
                    <td>
                        <?php if (!$is_self && $u_id > 0): ?>
                            <a href="kelola_admin.php?hapus=<?= $u_id ?>"
                               class="btn btn-sm btn-danger rounded-pill px-3"
                               onclick="return confirm('Yakin hapus admin <?= $u_name ?>?')">Hapus</a>
                        <?php else: ?>
                            <span class="text-muted small">Sedang Login</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Admin -->
<div class="modal fade" id="modalTambahAdmin" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Admin Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_tambah.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Username Admin</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>