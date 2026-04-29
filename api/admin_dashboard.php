<?php
// ORDER FIX: include koneksi SEBELUM session_start
include 'koneksi.php';
session_start();

// Cek Role Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("location:login.php");
    exit();
}

$db = isset($conn) ? $conn : $koneksi;

// BUG #8 FIX: Sebelumnya pakai $_SESSION['user'] yang tidak selalu di-set.
// Sekarang cek keduanya agar aman.
$nama_admin = $_SESSION['username'] ?? $_SESSION['user'] ?? 'Admin';

// --- Ambil Data Statistik ---
$res_pendapatan = mysqli_query($db, "SELECT SUM(total_bayar) as total FROM riwayat_transaksi");
$row_pendapatan = mysqli_fetch_assoc($res_pendapatan);
$total_duit     = $row_pendapatan['total'] ?? 0;

$res_pesanan = mysqli_query($db, "SELECT COUNT(*) as total FROM riwayat_transaksi");
$row_pesanan = mysqli_fetch_assoc($res_pesanan);

$res_user = mysqli_query($db, "SELECT COUNT(*) as total FROM pengguna");
$row_user = mysqli_fetch_assoc($res_user);

$res_wisata = mysqli_query($db, "SELECT COUNT(*) as total FROM destinasi");
$row_wisata = mysqli_fetch_assoc($res_wisata);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .stat-card { border: none; border-radius: 15px; transition: 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        .icon-box { font-size: 2.5rem; opacity: 0.3; position: absolute; right: 15px; bottom: 10px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark">🚀 Dashboard Admin</h1>
            <p class="text-muted">Selamat bekerja, <strong><?= htmlspecialchars($nama_admin); ?></strong>!</p>
        </div>
        <div>
            <a href="dashboard.php" class="btn btn-outline-primary me-2">Beranda</a>
            <a href="logout.php" class="btn btn-danger shadow-sm">Logout</a>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card bg-primary text-white p-3 shadow-sm">
                <h6>Total Pendapatan</h6>
                <h3 class="fw-bold">Rp <?= number_format($total_duit, 0, ',', '.'); ?></h3>
                <i class="bi bi-wallet2 icon-box"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-success text-white p-3 shadow-sm">
                <h6>Total Pesanan</h6>
                <h3 class="fw-bold"><?= $row_pesanan['total']; ?> Tiket</h3>
                <i class="bi bi-cart-check icon-box"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-warning text-dark p-3 shadow-sm">
                <h6>Jumlah Pengguna</h6>
                <h3 class="fw-bold"><?= $row_user['total']; ?> Akun</h3>
                <i class="bi bi-people icon-box"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card bg-info text-white p-3 shadow-sm">
                <h6>Destinasi Wisata</h6>
                <h3 class="fw-bold"><?= $row_wisata['total']; ?> Lokasi</h3>
                <i class="bi bi-map icon-box"></i>
            </div>
        </div>
    </div>

    <h4 class="fw-bold mb-3">🛠️ Menu Pengelolaan</h4>
    <div class="row g-3 text-center mb-5">
        <div class="col-md-4">
            <a href="kelola_user.php" class="card p-4 text-decoration-none shadow-sm stat-card border-start border-primary border-4">
                <i class="bi bi-person-gear fs-2 text-primary mb-2"></i>
                <h5 class="text-dark fw-bold">Kelola User</h5>
            </a>
        </div>
        <div class="col-md-4">
            <a href="kelola_admin.php" class="card p-4 text-decoration-none shadow-sm stat-card border-start border-success border-4">
                <i class="bi bi-shield-lock fs-2 text-success mb-2"></i>
                <h5 class="text-dark fw-bold">Kelola Admin</h5>
            </a>
        </div>
        <div class="col-md-4">
            <a href="kelola_destinasi.php" class="card p-4 text-decoration-none shadow-sm stat-card border-start border-info border-4">
                <i class="bi bi-image fs-2 text-info mb-2"></i>
                <h5 class="text-dark fw-bold">Kelola Destinasi</h5>
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">📑 Transaksi Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light text-muted">
                    <tr>
                        <th class="ps-4">No. Invoice</th>
                        <th>User</th>
                        <th>Destinasi</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res_transaksi = mysqli_query($db, "SELECT * FROM riwayat_transaksi ORDER BY tanggal DESC LIMIT 5");
                    while($t = mysqli_fetch_assoc($res_transaksi)) {
                    ?>
                    <tr>
                        <td class="ps-4 fw-bold">#<?= htmlspecialchars($t['no_invoice']); ?></td>
                        <td><?= htmlspecialchars($t['username']); ?></td>
                        <td><?= htmlspecialchars($t['destinasi']); ?></td>
                        <td>Rp <?= number_format($t['total_bayar'], 0, ',', '.'); ?></td>
                        <td><span class="badge bg-success">Lunas</span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white text-center">
            <a href="kelola_pesanan.php" class="text-decoration-none btn btn-sm btn-link">Lihat Semua Riwayat →</a>
        </div>
    </div>
</div>

</body>
</html>