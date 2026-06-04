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
        .badge-promo { background: #ff4757; color: white; padding: 4px 12px; border-radius: 50px; font-weight: bold; font-size: 0.7rem; }
        .code-box { background: #f8f9fa; border: 2px dashed #dee2e6; border-radius: 10px; padding: 8px; font-family: monospace; font-weight: bold; font-size: 0.9rem; color: #f37021; letter-spacing: 0.5px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🌍 GoWisata</a>
        <div class="ms-auto">
            <a href="dashboard.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold" style="font-size: 0.8rem;">Kembali ke Dashboard</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="text-center mb-5">
        <h3 class="fw-bold text-dark">🔥 Promo Spesial Destinasi Pilihan</h3>
        <p class="text-muted small">Klik "Gunakan Sekarang" untuk mengaktifkan potongan harga otomatis di sistem tiket.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Promo 1: Candi Borobudur -->
        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo">DISKON 20%</span></div>
                <div class="card-body text-center pt-0">
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.95rem;">Jelajah Candi</h6>
                    <p class="text-muted" style="font-size: 0.75rem; min-height: 36px;">Khusus kemegahan budaya di <b>Candi Borobudur</b> Magelang.</p>
                    <div class="code-box mb-3">GO-JATENG20</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill text-white btn-sm py-2" onclick="window.location.href='destinasi.php?wisata=Candi Borobudur&diskon=0.2&kode=GO-JATENG20'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <!-- Promo 2: Solo Safari -->
        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #2ed573;">POTONGAN 5RB</span></div>
                <div class="card-body text-center pt-0">
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.95rem;">Eksplor Solo Safari</h6>
                    <p class="text-muted" style="font-size: 0.75rem; min-height: 36px;">Khusus liburan edukasi satwa interaktif di <b>Solo Safari</b> Surakarta.</p>
                    <div class="code-box mb-3">SOLO-SAFARI</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill text-white btn-sm py-2" onclick="window.location.href='destinasi.php?wisata=Solo Safari&potongan=5000&kode=SOLO-SAFARI'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <!-- Promo 3: Taman Nasional Karimunjawa -->
        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #ffa502;">DISKON 15%</span></div>
                <div class="card-body text-center pt-0">
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.95rem;">Pesona Bahari</h6>
                    <p class="text-muted" style="font-size: 0.75rem; min-height: 36px;">Spesial keindahan bawah laut <b>Taman Nasional Karimunjawa</b> Jepara.</p>
                    <div class="code-box mb-3">ALAM-INDO</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill text-white btn-sm py-2" onclick="window.location.href='destinasi.php?wisata=Taman Nasional Karimunjawa&diskon=0.15&kode=ALAM-INDO'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <!-- Promo 4: Rasamadu (The Heritage Palace) -->
        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #1e90ff;">POTONGAN 10RB</span></div>
                <div class="card-body text-center pt-0">
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.95rem;">Flash Sale Heritage</h6>
                    <p class="text-muted" style="font-size: 0.75rem; min-height: 36px;">Khusus spot estetik bergaya Eropa di <b>Rasamadu (The Heritage Palace)</b> Sukoharjo.</p>
                    <div class="code-box mb-3">HERITAGE-JATENG</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill text-white btn-sm py-2" onclick="window.location.href='destinasi.php?wisata=Rasamadu (The Heritage Palace)&potongan=10000&kode=HERITAGE-JATENG'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <!-- Promo 5: Saloka Theme Park -->
        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #6c5ce7;">DISKON 10%</span></div>
                <div class="card-body text-center pt-0">
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.95rem;">Weekend Deal Saloka</h6>
                    <p class="text-muted" style="font-size: 0.75rem; min-height: 36px;">Main sepuasnya di taman rekreasi terbesar <b>Saloka Theme Park</b> Semarang.</p>
                    <div class="code-box mb-3">SALOKA-SERU</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill text-white btn-sm py-2" onclick="window.location.href='destinasi.php?wisata=Saloka Theme Park&diskon=0.1&kode=SALOKA-SERU'">Gunakan Sekarang</button>
                </div>
            </div>
        </div>

        <!-- Promo 6: Semua Destinasi -->
        <div class="col-md-4">
            <div class="card promo-card h-100">
                <div class="p-3"><span class="badge-promo" style="background: #f37021;">POTONGAN 5RB</span></div>
                <div class="card-body text-center pt-0">
                    <h6 class="fw-bold text-dark mb-2" style="font-size: 0.95rem;">Pengguna Baru</h6>
                    <p class="text-muted" style="font-size: 0.75rem; min-height: 36px;">Potongan langsung otomatis yang berlaku untuk <b>Semua 5 Destinasi</b> Jawa Tengah.</p>
                    <div class="code-box mb-3">HELLO-NAYLA</div>
                    <button class="btn btn-warning w-100 fw-bold rounded-pill text-white btn-sm py-2" onclick="window.location.href='destinasi.php?potongan=5000&kode=HELLO-NAYLA'">Gunakan Sekarang</button>
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