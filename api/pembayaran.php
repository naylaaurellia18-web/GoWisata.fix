<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();

// FIX: Cek kedua key session
$username_session = $_SESSION['user'] ?? $_SESSION['username'] ?? null;
if (!$username_session) {
    header("Location: login.php");
    exit();
}

// Tangkap data dari URL (dari pesan.php via GET)
$nama   = isset($_GET['nama'])   ? htmlspecialchars(strip_tags($_GET['nama']))   : $username_session;
$total  = isset($_GET['total'])  ? (int)$_GET['total']  : 0;
$metode = isset($_GET['metode']) ? htmlspecialchars(strip_tags($_GET['metode'])) : "QRIS";
$wisata = isset($_GET['wisata']) ? htmlspecialchars(strip_tags($_GET['wisata'])) : "Wisata";
$jumlah = isset($_GET['jumlah']) ? (int)$_GET['jumlah'] : 1;

// Validasi minimal
if ($total <= 0) {
    echo "<script>alert('Data pesanan tidak valid. Silakan ulangi dari halaman destinasi.'); window.location.href='destinasi.php';</script>";
    exit();
}

$simpan_sukses  = false;
$no_invoice_gen = '';

// PROSES SIMPAN KE DATABASE
if (isset($conn)) {
    $tanggal    = date("Y-m-d");
    $no_invoice = "INV-" . strtoupper(substr(md5(uniqid()), 0, 8)) . "-" . time();
    $status     = "Lunas";

    $nama_safe   = mysqli_real_escape_string($conn, $nama);
    $wisata_safe = mysqli_real_escape_string($conn, $wisata);
    $inv_safe    = mysqli_real_escape_string($conn, $no_invoice);
    $total_safe  = (int)$total;

    // FIX: Generate ID manual
    $res_max = mysqli_query($conn, "SELECT COALESCE(MAX(id_transaksi), 0) + 1 AS next_id FROM riwayat_transaksi");
    $row_max = mysqli_fetch_assoc($res_max);
    $new_id  = (int)$row_max['next_id'];

    $query = "INSERT INTO riwayat_transaksi
                (id_transaksi, no_invoice, username, destinasi, tanggal, total_bayar, status)
              VALUES
                ('$new_id', '$inv_safe', '$nama_safe', '$wisata_safe', '$tanggal', '$total_safe', '$status')";

    if (mysqli_query($conn, $query)) {
        $simpan_sukses  = true;
        $no_invoice_gen = $no_invoice;
        // Log aktivitas
        mysqli_query($conn, "INSERT INTO log_aktivitas (username, role, aktivitas, waktu)
                             VALUES ('$nama_safe', 'user', 'Pembelian tiket: $wisata_safe', NOW())");
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f37021; font-family: 'Poppins', sans-serif; display:flex; align-items:center; min-height:100vh; }
        .card-pay { border-radius:20px; border:none; box-shadow:0 10px 30px rgba(0,0,0,.2); width:100%; max-width:420px; margin:auto; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="card card-pay p-4 text-center">
        <h5 class="fw-bold text-muted mb-1">Halo, <?= htmlspecialchars($nama); ?>!</h5>
        <p class="small text-muted mb-4">Selesaikan pembayaran untuk <b><?= htmlspecialchars($wisata); ?></b></p>

        <div class="bg-light p-3 rounded-4 mb-4">
            <p class="small text-muted mb-0">Total Tagihan</p>
            <h2 class="fw-bold text-primary">Rp <?= number_format($total, 0, ',', '.'); ?></h2>
            <p class="small text-muted mb-0"><?= $jumlah ?> tiket &middot; Metode: <b><?= htmlspecialchars($metode); ?></b></p>
        </div>

        <div class="mb-4">
            <?php if ($metode === "QRIS"): ?>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=GOWISATA-<?= $total; ?>"
                     class="border p-2 bg-white mb-2" alt="QR Code Pembayaran">
                <p class="small text-muted">Scan QRIS di atas untuk membayar</p>
            <?php else: ?>
                <p class="small text-muted mb-1">Transfer ke <b><?= htmlspecialchars($metode); ?></b>:</p>
                <h4 class="fw-bold text-dark">8901234567</h4>
                <p class="small text-muted">a.n GoWisata Official</p>
            <?php endif; ?>
        </div>

        <button id="btnSelesai" class="btn btn-warning w-100 py-3 rounded-pill fw-bold text-white shadow">
            ✅ KONFIRMASI PEMBAYARAN
        </button>
        <a href="destinasi.php" class="btn btn-link text-muted small mt-2">← Kembali ke Destinasi</a>
    </div>
</div>

<script>
document.getElementById('btnSelesai').addEventListener('click', function () {
    <?php if ($simpan_sukses): ?>
    Swal.fire({
        title: '🎉 Pembayaran Berhasil!',
        html: 'Tiket <b><?= addslashes(htmlspecialchars($wisata)); ?></b> sudah tersimpan.<br><small class="text-muted">No. Invoice: <?= $no_invoice_gen; ?></small>',
        icon: 'success',
        confirmButtonText: 'Lihat Riwayat Tiket',
        confirmButtonColor: '#f37021'
    }).then(function (result) {
        if (result.isConfirmed) {
            window.location.href = 'riwayat_pesanan.php';
        }
    });
    <?php else: ?>
    Swal.fire('Gagal!', 'Data tidak tersimpan. Pastikan koneksi database aktif.', 'error');
    <?php endif; ?>
});
</script>
</body>
</html>