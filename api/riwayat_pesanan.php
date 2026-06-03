<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();

$username_login = $_SESSION['user'] ?? $_SESSION['username'] ?? null;
if (!$username_login) {
    header("Location: login.php"); exit();
}

$db = $conn;
$is_admin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// Admin lihat semua, user lihat miliknya saja
if ($is_admin) {
    $query = mysqli_query($db, "SELECT * FROM riwayat_transaksi ORDER BY tanggal DESC");
} else {
    $u = mysqli_real_escape_string($db, $username_login);
    $query = mysqli_query($db, "SELECT * FROM riwayat_transaksi WHERE username='$u' ORDER BY tanggal DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color:#f0f2f5; font-family:'Inter', sans-serif; }
        .navbar-custom { background-color:#f37021; }
        .card-tiket { border:none; border-radius:15px; transition:0.3s; }
        .card-tiket:hover { transform:translateY(-3px); box-shadow:0 8px 20px rgba(0,0,0,.1); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🌍 GoWisata</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">
                <i class="bi bi-arrow-left me-1"></i>Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="container pb-5">
    <h3 class="fw-bold mb-4">🧾 Riwayat Pesanan<?= $is_admin ? ' (Semua User)' : ''; ?></h3>

    <?php if ($query && mysqli_num_rows($query) > 0): ?>
        <div class="row g-3">
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <div class="col-md-6">
                <div class="card card-tiket shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($row['destinasi']); ?></h6>
                            <p class="text-muted small mb-1">
                                <i class="bi bi-person me-1"></i><?= htmlspecialchars($row['username']); ?> &middot;
                                <i class="bi bi-calendar me-1"></i><?= date('d M Y', strtotime($row['tanggal'])); ?>
                            </p>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-receipt me-1"></i>#<?= htmlspecialchars($row['no_invoice']); ?>
                            </p>
                        </div>
                        <div class="text-end">
                            <h6 class="fw-bold text-primary mb-1">Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></h6>
                            <span class="badge bg-success"><?= htmlspecialchars($row['status']); ?></span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="cetak_tiket.php?id=<?= urlencode($row['no_invoice']); ?>"
                           class="btn btn-outline-primary btn-sm rounded-pill px-3">
                            <i class="bi bi-printer me-1"></i>Cetak Tiket
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-bag-x text-muted" style="font-size:4rem;"></i>
            <h5 class="text-muted mt-3">Belum ada pesanan</h5>
            <a href="destinasi.php" class="btn btn-warning fw-bold rounded-pill px-4 mt-2">Pesan Tiket Sekarang</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>