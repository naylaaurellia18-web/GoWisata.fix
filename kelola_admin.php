<?php
session_start();
include 'koneksi.php';
$db = isset($koneksi) ? $koneksi : $conn;

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("location:login.php"); exit();
}

// Logika Hapus
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($db, $_GET['hapus']);
    mysqli_query($db, "DELETE FROM pengguna WHERE id_pengguna='$id' OR id='$id'");
    header("location:kelola_admin.php"); exit();
}

// AMBIL DATA STATISTIK
$res_adm = mysqli_query($db, "SELECT * FROM pengguna WHERE role='admin'");
$res_usr = mysqli_query($db, "SELECT * FROM pengguna WHERE role='user'");
$count_admin = $res_adm ? mysqli_num_rows($res_adm) : 0;
$count_user  = $res_usr ? mysqli_num_rows($res_usr) : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, sans-serif; }
        .stat-card { border: none; border-radius: 12px; color: white; padding: 20px; }
        .bg-adm { background: #0d6efd; } .bg-usr { background: #198754; }
        .main-card { border: none; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0"><i class="bi bi-shield-shaded"></i> Panel Admin</h2>
        <a href="admin_dashboard.php" class="btn btn-outline-dark rounded-pill px-4">Dashboard</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="stat-card bg-adm shadow-sm">
                <h6>Total Admin</h6>
                <h2 class="fw-bold"><?= $count_admin ?></h2>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="stat-card bg-usr shadow-sm">
                <h6>Total Pelanggan</h6>
                <h2 class="fw-bold"><?= $count_user ?></h2>
            </div>
        </div>
    </div>

    <div class="card main-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if ($res_adm) {
                            while($row = mysqli_fetch_assoc($res_adm)) {
                                // DETEKSI OTOMATIS: Mencari kolom yang ada isinya
                                $u_id   = $row['id_pengguna'] ?? $row['id'] ?? $no;
                                $u_name = $row['username'] ?? $row['user'] ?? $row['nama'] ?? 'Admin';
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fw-bold text-primary"><?= $u_name ?></td>
                            <td>
                                <?php if ($u_name !== ($_SESSION['username'] ?? '')): ?>
                                    <a href="kelola_admin.php?hapus=<?= $u_id ?>" class="btn btn-sm btn-danger rounded-pill px-3">Hapus</a>
                                <?php else: ?>
                                    <span class="text-muted small">Sedang Login</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>