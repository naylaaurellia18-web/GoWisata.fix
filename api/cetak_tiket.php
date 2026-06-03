<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();

$username_login = $_SESSION['user'] ?? $_SESSION['username'] ?? null;
if (!$username_login) {
    header("Location: login.php"); exit();
}

$id_invoice = isset($_GET['id']) ? strip_tags(trim($_GET['id'])) : '';
if (empty($id_invoice)) {
    echo "<script>alert('Data tiket tidak ditemukan.'); window.location.href='riwayat_pesanan.php';</script>";
    exit();
}

$db        = $conn;
$id_safe   = mysqli_real_escape_string($db, $id_invoice);
$is_admin  = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// FIX: User hanya bisa cetak tiket miliknya sendiri; admin bisa cetak semua
if ($is_admin) {
    $sql = "SELECT * FROM riwayat_transaksi WHERE no_invoice='$id_safe'";
} else {
    $u_safe = mysqli_real_escape_string($db, $username_login);
    $sql    = "SELECT * FROM riwayat_transaksi WHERE no_invoice='$id_safe' AND username='$u_safe'";
}

$query = mysqli_query($db, $sql);
$data  = $query ? mysqli_fetch_assoc($query) : null;

if (!$data) {
    echo "<script>alert('Tiket tidak ditemukan atau Anda tidak memiliki akses.'); window.location.href='riwayat_pesanan.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Tiket - #<?= htmlspecialchars($data['no_invoice']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color:#eee; font-family:'Inter', sans-serif; }
        .ticket-container { max-width:600px; margin:30px auto; background:white; border-radius:20px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,.1); }
        .ticket-header { background:#f37021; color:white; padding:25px; text-align:center; }
        .ticket-body { padding:30px; border-bottom:2px dashed #eee; position:relative; }
        .ticket-body::before, .ticket-body::after { content:''; position:absolute; bottom:-15px; width:30px; height:30px; background:#eee; border-radius:50%; }
        .ticket-body::before { left:-15px; }
        .ticket-body::after  { right:-15px; }
        .info-label { color:#999; font-size:0.75rem; text-transform:uppercase; font-weight:bold; }
        .info-value { font-weight:600; font-size:1.1rem; color:#2d3436; }
        @media print {
            body { background:white; }
            .no-print { display:none !important; }
            .ticket-container { box-shadow:none; margin:0; max-width:100%; }
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="ticket-container">
        <div class="ticket-header">
            <h4 class="fw-bold mb-0">✈ E-TICKET GOWISATA</h4>
            <p class="small mb-0 opacity-75">Tunjukkan tiket ini kepada petugas pintu masuk</p>
        </div>

        <div class="ticket-body">
            <div class="row g-4">
                <div class="col-6">
                    <div class="info-label">Nama Traveler</div>
                    <div class="info-value"><?= htmlspecialchars($data['username']); ?></div>
                </div>
                <div class="col-6 text-end">
                    <div class="info-label">No. Invoice</div>
                    <div class="info-value">#<?= htmlspecialchars($data['no_invoice']); ?></div>
                </div>
                <div class="col-12 text-center my-2">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=<?= urlencode($data['no_invoice']); ?>"
                         alt="QR Code" style="border:4px solid #f8f9fa; border-radius:8px;">
                    <p class="small text-muted mt-2">Scan di gerbang masuk</p>
                </div>
                <div class="col-12">
                    <div class="info-label">Destinasi Tujuan</div>
                    <div class="info-value text-primary"><?= htmlspecialchars($data['destinasi']); ?></div>
                </div>
                <div class="col-6">
                    <div class="info-label">Tanggal Kunjungan</div>
                    <div class="info-value"><?= date('d M Y', strtotime($data['tanggal'])); ?></div>
                </div>
                <div class="col-6 text-end">
                    <div class="info-label">Status</div>
                    <div class="info-value text-success"><?= htmlspecialchars($data['status']); ?></div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-light text-center">
            <div class="info-label">Total Bayar</div>
            <h3 class="fw-bold text-dark">Rp <?= number_format($data['total_bayar'], 0, ',', '.'); ?></h3>
            <p class="text-muted small mt-1 mb-0">Tiket ini berlaku sebagai tanda bukti sah pendaftaran wisata.</p>
        </div>
    </div>

    <div class="text-center mt-4 pb-5 no-print">
        <button onclick="window.print()" class="btn btn-primary px-4 py-2 fw-bold shadow me-2">
            <i class="bi bi-printer me-2"></i>Cetak / Simpan PDF
        </button>
        <a href="riwayat_pesanan.php" class="btn btn-outline-secondary px-4 py-2 fw-bold">
            ← Kembali
        </a>
    </div>
</div>
</body>
</html>