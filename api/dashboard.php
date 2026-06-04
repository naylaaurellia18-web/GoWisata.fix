<?php
// ORDER FIX: include koneksi SEBELUM session_start (agar handler DB aktif dulu)
include 'koneksi.php';
session_start();

$username_login = $_SESSION['user'] ?? $_SESSION['username'] ?? null;

if (!$username_login || !isset($_SESSION['status'])) {
    header("Location: login.php");
    exit();
}

$nama_tampil = $username_login;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #f6f9fc; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #2d3748;
        }
        .navbar-custom { 
            background: linear-gradient(135deg, #f37021, #e05600); 
            padding: 16px 0; 
        }
        .welcome-banner {
            background: linear-gradient(135deg, #f37021 0%, #ff8c42 100%);
            border-radius: 24px; 
            color: white; 
            padding: 45px;
            margin-bottom: 35px; 
            box-shadow: 0 12px 30px rgba(243,112,33,0.15);
            position: relative;
            overflow: hidden;
        }
        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .stat-card { 
            border: none; 
            border-radius: 16px; 
            transition: all 0.3s ease; 
            background: white; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .stat-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        }
        .menu-card { 
            border: none; 
            border-radius: 24px; 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            background: white; 
            cursor: pointer; 
            box-shadow: 0 6px 18px rgba(0,0,0,0.03);
        }
        .menu-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 38px rgba(0,0,0,0.08); 
        }
        .icon-circle {
            width: 64px; 
            height: 64px; 
            border-radius: 18px;
            display: flex; 
            align-items: center; 
            justify-content: center;
            margin: 0 auto 20px; 
            font-size: 1.6rem;
            transition: 0.3s;
        }
        .menu-card:hover .icon-circle {
            transform: scale(1.1) rotate(5deg);
        }
        .tips-card {
            border: none;
            border-radius: 20px;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border-left: 5px solid #f37021;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center fs-4" href="dashboard.php">
            <i class="bi bi-compass-fill me-2 text-warning"></i>GoWisata
        </a>
        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-block opacity-90">Hallo, selamat datang <b class="text-warning"><?= htmlspecialchars($nama_tampil); ?></b></span>
            <a href="logout.php" class="btn btn-light btn-sm rounded-pill px-4 fw-bold text-dark shadow-sm">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <!-- Banner Selamat Datang -->
    <div class="welcome-banner">
        <div class="row align-items-center">
            <div class="col-md-8 text-center text-md-start">
                <h1 class="fw-bold mb-2">Hallo Selamat datang, <?= htmlspecialchars($nama_tampil); ?>! 👋</h1>
                <p class="lead mb-0 opacity-90" style="font-weight: 400;">Temukan pengalaman liburan tak terlupakan di Jawa Tengah dengan pilihan destinasi terbaik kami.</p>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                <i class="bi bi-luggage-fill" style="font-size: 5.5rem; opacity: 0.25; animation: float 3s ease-in-out infinite;"></i>
            </div>
        </div>
    </div>

    <!-- Baris Statistik -->
    <div class="row g-4 mb-5">
        <!-- Stat 1 -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 border-start border-primary border-4">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                        <i class="bi bi-geo-alt-fill fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-dark">5</h3>
                        <p class="text-muted small mb-0">Destinasi Wisata</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stat 2 -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 border-start border-success border-4">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="bi bi-shield-check fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="fw-bold mb-0 text-success" style="font-size:1.1rem; padding-top: 4px;">Aktif</h4>
                        <p class="text-muted small mb-0">Status Akun</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stat 3 (Sinkronisasi ke 6 Promo baru) -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 border-start border-warning border-4">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                        <i class="bi bi-lightning-charge-fill fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-dark">6</h3>
                        <p class="text-muted small mb-0">Promo Spesial</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Stat 4 -->
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card h-100 border-start border-danger border-4">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="flex-shrink-0 bg-danger bg-opacity-10 text-danger p-3 rounded-3">
                        <i class="bi bi-calendar3 fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0 text-dark">2026</h3>
                        <p class="text-muted small mb-0">Tahun Operasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan Utama / Navigasi Menuju Fitur -->
    <h4 class="fw-bold mb-4 text-dark d-flex align-items-center">
        <span class="bg-warning d-inline-block me-2 rounded-pill" style="width: 6px; height: 24px;"></span>
        Layanan Utama Aplikasi
    </h4>
    <div class="row g-4 text-center">
        <!-- Menu 1: Sistem Tiket -->
        <div class="col-md-3" onclick="window.location.href='destinasi.php'">
            <div class="card menu-card p-4 h-100">
                <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </div>
                <h5 class="fw-bold text-dark fs-6 mb-2">Sistem Tiket</h5>
                <p class="text-muted small mb-3">Lihat 5 destinasi terfavorit Jawa Tengah dan pesan tiket masuk.</p>
                <button class="btn btn-outline-primary btn-sm rounded-pill mt-auto px-4 w-100">Buka Modul</button>
            </div>
        </div>

        <!-- Menu 2: Promo Eksklusif -->
        <div class="col-md-3" onclick="window.location.href='promo.php'">
            <div class="card menu-card p-4 h-100">
                <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-tags-fill"></i>
                </div>
                <h5 class="fw-bold text-dark fs-6 mb-2">Promo Eksklusif</h5>
                <p class="text-muted small mb-3">Klaim potongan diskon langsung untuk destinasi impian Anda.</p>
                <button class="btn btn-outline-warning btn-sm rounded-pill mt-auto px-4 w-100">Lihat Promo</button>
            </div>
        </div>

        <!-- Menu 3: Statistik BPS -->
        <div class="col-md-3" onclick="window.location.href='statistik_bps.php'">
            <div class="card menu-card p-4 h-100">
                <div class="icon-circle bg-success bg-opacity-10 text-success">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h5 class="fw-bold text-dark fs-6 mb-2">Statistik BPS</h5>
                <p class="text-muted small mb-3">Pantau diagram grafik data kunjungan wisatawan secara akurat.</p>
                <button class="btn btn-outline-success btn-sm rounded-pill mt-auto px-4 w-100">Buka Data</button>
            </div>
        </div>

        <!-- Menu 4: Riwayat Pesanan -->
        <div class="col-md-3" onclick="window.location.href='riwayat_pesanan.php'">
            <div class="card menu-card p-4 h-100">
                <div class="icon-circle bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5 class="fw-bold text-dark fs-6 mb-2">Riwayat Pesanan</h5>
                <p class="text-muted small mb-3">Cek kembali invoice dan e-ticket yang pernah Anda beli sebelumnya.</p>
                <button class="btn btn-outline-danger btn-sm rounded-pill mt-auto px-4 w-100">Buka Riwayat</button>
            </div>
        </div>
    </div>

    <!-- Informasi / Tips Hari Ini -->
    <div class="row mt-5 pt-2">
        <div class="col-md-12">
            <div class="card tips-card shadow-sm p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-light p-3 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-lightbulb-fill text-warning fs-3"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Tips Wisata Hari Ini</h6>
                        <p class="text-muted mb-0 small">Simpan atau screenshoot kode QR e-ticket Anda terlebih dahulu untuk mempermudah gerbang pemindaian jika sinyal internet di lokasi wisata kurang stabil!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 bg-white border-top mt-5">
    <p class="text-muted small mb-0">&copy; 2026 GoWisata - Aplikasi Manajemen Tiket Wisata Premium</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>