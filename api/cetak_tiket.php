<?php
session_start();
include 'koneksi.php';

// Ambil ID Invoice dari URL
$id_invoice = $_GET['id'] ?? '';

if (empty($id_invoice)) {
    die("Data tiket tidak ditemukan.");
}

// PERBAIKAN: Gunakan variabel koneksi yang fleksibel seperti di riwayat_pesanan.php
$db = isset($conn) ? $conn : $koneksi;

// Ambil data transaksi berdasarkan invoice
$sql = "SELECT * FROM riwayat_transaksi WHERE no_invoice = '$id_invoice'";
$query = mysqli_query($db, $sql);
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Tiket dengan nomor invoice tersebut tidak ada.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Tiket - #<?= $data['no_invoice']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #eee; font-family: 'Inter', sans-serif; }
        
        /* Desain Tiket */
        .ticket-container {
            max-width: 600px; margin: 30px auto;
            background: white; border-radius: 20px; overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .ticket-header {
            background: #f37021; color: white; padding: 25px; text-align: center;
        }

        .ticket-body { padding: 30px; border-bottom: 2px dashed #eee; position: relative; }
        
        /* Efek Lubang Tiket di Samping */
        .ticket-body::before, .ticket-body::after {
            content: ''; position: absolute; bottom: -15px;
            width: 30px; height: 30px; background: #eee; border-radius: 50%;
        }
        .ticket-body::before { left: -15px; }
        .ticket-body::after { right: -15px; }

        .info-label { color: #999; font-size: 0.75rem; text-transform: uppercase; font-weight: bold; }
        .info-value { font-weight: 600; font-size: 1.1rem; color: #2d3436; }

        .qr-placeholder {
            background: #f8f9fa; border: 1px solid #eee;
            width: 120px; height: 120px; margin: 0 auto;
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px;
        }

        /* Khusus Tampilan Cetak (Print) */
        @media print {
            body { background: white; }
            .btn-print, .btn-kembali { display: none; } /* Sembunyikan tombol saat diprint */
            .ticket-container { box-shadow: none; margin: 0; max-width: 100%; border: 1px solid #eee; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="ticket-container">
        <div class="ticket-header">
            <h4 class="fw-bold mb-0">E-TICKET GOWISATA</h4>
            <p class="small mb-0 opacity-75">Tunjukkan tiket ini ke petugas pintu masuk</p>
        </div>

        <div class="ticket-body">
            <div class="row g-4">
                <div class="col-6">
                    <div class="info-label">Nama Traveler</div>
                    <div class="info-value"><?= $data['username']; ?></div>
                </div>
                <div class="col-6 text-end">
                    <div class="info-label">No. Invoice</div>
                    <div class="info-value">#<?= $data['no_invoice']; ?></div>
                </div>
                <div class="col-12 text-center my-3">
                    <div class="qr-placeholder">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= $data['no_invoice']; ?>" alt="QR Code">
                    </div>
                    <p class="small text-muted mt-2">Scan di gerbang masuk</p>
                </div>
                <div class="col-12">
                    <div class="info-label">Destinasi Tujuan</div>
                    <div class="info-value text-primary"><?= $data['destinasi']; ?></div>
                </div>
                <div class="col-6">
                    <div class="info-label">Tanggal Kunjungan</div>
                    <div class="info-value"><?= date('d M Y', strtotime($data['tanggal'])); ?></div>
                </div>
                <div class="col-6 text-end">
                    <div class="info-label">Status Pembayaran</div>
                    <div class="info-value text-success"><?= $data['status']; ?></div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-light text-center">
            <div class="info-label">Total Bayar</div>
            <h3 class="fw-bold text-dark">Rp <?= number_format($data['total_bayar'], 0, ',', '.'); ?></h3>
            <p class="text-muted small mt-2 mb-0">Tiket ini berlaku sebagai tanda bukti sah pendaftaran wisata.</p>
        </div>
    </div>

    <div class="text-center mt-4 pb-5">
        <button onclick="window.print()" class="btn btn-primary btn-print px-4 py-2 fw-bold shadow">
            <i class="bi bi-printer me-2"></i> Cetak Tiket (PDF)
        </button>
        <a href="riwayat_pesanan.php" class="btn btn-outline-secondary btn-kembali px-4 py-2 fw-bold ms-2">
            Kembali
        </a>
    </div>
</div>

<script>
    // window.onload = function() { window.print(); } 
    // Hapus tanda komentar di atas jika ingin langsung print otomatis
</script>

</body>
</html>