<?php
// BUG FIX: include koneksi.php SEBELUM session_start() agar DbSessionHandler aktif
include 'koneksi.php';
session_start();
$nama_tampil = $_SESSION['user'] ?? $_SESSION['username'] ?? "Pengguna";

if (!isset($_SESSION['user']) && !isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Eksklusif - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Inter', sans-serif; }
        .navbar-custom { background-color: #f37021; padding: 12px 0; }
        .promo-card { border: none; border-radius: 20px; overflow: hidden; transition: 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.05); background: white; }
        .promo-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .badge-promo { background: #ff4757; color: white; padding: 5px 15px; border-radius: 50px; font-weight: bold; font-size: 0.75rem; }
        .code-box { background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 10px; padding: 10px; font-family: monospace; font-weight: bold; color: #f37021; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🌍 GoWisata</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold">Kembali ke Dashboard</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">🔥 Promo Spesial Destinasi Pilihan</h2>
        <p class="text-muted">Klik "Gunakan Sekarang" untuk mengaktifkan potongan harga otomatis di sistem tiket.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo">DISKON 20%</span></div>
                <div class="card-body text-center">
                    <h5 class="fw-bold">Jelajah Jateng</h5>
                    <p class="text-muted small">Berlaku untuk <b>Candi Borobudur</b>, <b>Saloka</b>, atau <b>Solo Safari</b>.</p>
                    <div class="code-box mb-3">GO-JATENG20</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill" onclick="window.location.href='destinasi.php?diskon=0.2&kode=GO-JATENG20'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #2ed573;">POTONGAN 50RB</span></div>
                <div class="card-body text-center">
                    <h5 class="fw-bold">Eksplor Jatim</h5>
                    <p class="text-muted small">Khusus untuk <b>Gunung Bromo</b> atau <b>Jatim Park 1</b>.</p>
                    <div class="code-box mb-3">JATIM-HEBAT</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill" onclick="window.location.href='destinasi.php?potongan=50000&kode=JATIM-HEBAT'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #ffa502;">DISKON 15%</span></div>
                <div class="card-body text-center">
                    <h5 class="fw-bold">Wisata Alam & Air</h5>
                    <p class="text-muted small">Berlaku untuk <b>Raja Ampat</b> atau <b>Pura Tirta Empul</b>.</p>
                    <div class="code-box mb-3">ALAM-INDO</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill" onclick="window.location.href='destinasi.php?diskon=0.15&kode=ALAM-INDO'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #1e90ff;">POTONGAN 10RB</span></div>
                <div class="card-body text-center">
                    <h5 class="fw-bold">Flash Sale Ijen</h5>
                    <p class="text-muted small">Khusus pendakian <b>Kawah Ijen</b> Banyuwangi.</p>
                    <div class="code-box mb-3">IJEN-BLUE</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill" onclick="window.location.href='destinasi.php?potongan=10000&kode=IJEN-BLUE'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #6c5ce7;">DISKON 10%</span></div>
                <div class="card-body text-center">
                    <h5 class="fw-bold">Lawu Park Deal</h5>
                    <p class="text-muted small">Nikmati udara dingin <b>The Lawu Park</b> dengan harga lebih murah.</p>
                    <div class="code-box mb-3">LAWU-DINGIN</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill" onclick="window.location.href='destinasi.php?diskon=0.1&kode=LAWU-DINGIN'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #f37021;">POTONGAN 5RB</span></div>
                <div class="card-body text-center">
                    <h5 class="fw-bold">Pengguna Baru</h5>
                    <p class="text-muted small">Potongan langsung untuk <b>Semua (9) Destinasi</b> wisata.</p>
                    <div class="code-box mb-3">HELLO-NAYLA</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill" onclick="window.location.href='destinasi.php?potongan=5000&kode=HELLO-NAYLA'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 text-muted small">
    &copy; 2026 GoWisata - Promo Update by Nayla
</footer>

</body>
</html>