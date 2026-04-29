<?php
// BUG FIX: include koneksi.php HARUS sebelum session_start()
// Sebelumnya terbalik: session_start() dulu baru include koneksi
// Akibatnya DbSessionHandler tidak aktif → session tidak terbaca
include 'koneksi.php';
session_start();

$username_session = $_SESSION['user'] ?? $_SESSION['username'] ?? null;

if (!$username_session) {
    header("Location: login.php");
    exit();
}

// Tangkap data dari URL
$nama   = $_GET['nama'] ?? $username_session;
$total  = $_GET['total'] ?? 0;
$metode = $_GET['metode'] ?? "QRIS";
$wisata = $_GET['wisata'] ?? "Wisata";
$jumlah = $_GET['jumlah'] ?? 1;

$simpan_sukses = false;

// PROSES SIMPAN OTOMATIS
if ($total > 0 && isset($conn)) {
    $tanggal    = date("Y-m-d");
    $no_invoice = "INV-" . time();
    $status     = "Lunas";

    $nama_safe   = mysqli_real_escape_string($conn, $nama);
    $wisata_safe = mysqli_real_escape_string($conn, $wisata);
    $total_safe  = (int) $total;
    
    $query = "INSERT INTO riwayat_transaksi (no_invoice, username, destinasi, tanggal, total_bayar, status) 
              VALUES ('$no_invoice', '$nama_safe', '$wisata_safe', '$tanggal', '$total_safe', '$status')";
    
    if (mysqli_query($conn, $query)) {
        $simpan_sukses = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f37021; font-family: 'Poppins', sans-serif; display: flex; align-items: center; min-height: 100vh; }
        .card-pay { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2); width: 100%; max-width: 400px; margin: auto; }
    </style>
</head>
<body>

<div class="container">
    <div class="card card-pay p-4 text-center">
        <h5 class="fw-bold text-muted mb-1">Halo, <?= htmlspecialchars($nama); ?>!</h5>
        <p class="small text-muted mb-4">Selesaikan pembayaran untuk <b><?= htmlspecialchars($wisata); ?></b></p>
        
        <div class="bg-light p-3 rounded-4 mb-4">
            <p class="small text-muted mb-0">Total Tagihan</p>
            <h2 class="fw-bold text-primary">Rp <?= number_format($total, 0, ',', '.'); ?></h2>
        </div>

        <div class="mb-4">
            <?php if($metode == "QRIS"): ?>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=GOWISATA-<?= (int)$total; ?>" class="border p-2 bg-white mb-2">
                <p class="small text-muted">Scan QRIS di atas</p>
            <?php else: ?>
                <p class="small text-muted mb-1">Transfer ke <?= htmlspecialchars($metode); ?>:</p>
                <h4 class="fw-bold text-dark">8901234567</h4>
            <?php endif; ?>
        </div>

        <button id="btnSelesai" class="btn btn-warning w-100 py-3 rounded-pill fw-bold text-white shadow">
            KONFIRMASI PEMBAYARAN
        </button>
    </div>
</div>

<script>
    document.getElementById('btnSelesai').addEventListener('click', function() {
        <?php if($simpan_sukses): ?>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Pesanan kamu sudah tersimpan di riwayat.',
                icon: 'success',
                confirmButtonText: 'Lihat Tiket',
                confirmButtonColor: '#f37021'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'riwayat_pesanan.php';
                }
            });
        <?php else: ?>
            Swal.fire('Gagal!', 'Data tidak tersimpan. Pastikan tabel riwayat_transaksi sudah ada.', 'error');
        <?php endif; ?>
    });
</script>
</body>
</html>