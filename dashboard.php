<?php
error_reporting(0); // Menghilangkan semua error orange
session_start();
include 'koneksi.php';

// HAPUS ATAU KOMENTAR BAGIAN INI AGAR TIDAK MUTER-MUTER:
/*
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php");
    exit();
}
*/

// Ambil nama dari session, kalau kosong otomatis jadi "lia"
$nama_tampil = isset($_SESSION['username']) ? $_SESSION['username'] : "lia";

// Data angka agar dashboard tidak kosong
$jumlah_destinasi = 9;
$status_akun = "Aktif";
$promo_spesial = 12;
$tahun_operasi = 2026;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Inter', sans-serif; }
        .navbar-custom { background-color: #f37021; padding: 12px 0; }
        
        /* Banner Welcome Gradasi */
        .welcome-banner {
            background: linear-gradient(45deg, #f37021, #ff9f43);
            border-radius: 20px;
            color: white;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(243, 112, 33, 0.2);
        }

        /* Card Statistik Modern dengan Border Samping */
        .stat-card {
            border: none;
            border-radius: 12px;
            transition: 0.3s;
            background: white;
        }
        .stat-card:hover { transform: translateY(-5px); }
        
        /* Desain Menu Utama */
        .menu-card {
            border: none;
            border-radius: 20px;
            transition: 0.4s;
            background: white;
            cursor: pointer;
        }
        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 1.5rem;
        }

        /* Tombol Custom */
        .btn-go { background-color: #f37021; color: white; border-radius: 50px; font-weight: 600; }
        .btn-go:hover { background-color: #d65a10; color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">
            <i class="bi bi-airplane-engines me-2"></i>GoWisata
        </a>
        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-block">Hallo,selamat datang <b><?= htmlspecialchars($nama_tampil); ?></b></span>
            <a href="logout.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">Keluar</a>
        </div>
    </div>
</nav>

<div class="container mb-5">
    <div class="welcome-banner text-center text-md-start">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold mb-2">Hallo Selamat datang, <?= htmlspecialchars($nama_tampil); ?>! 👋</h1>
                <p class="lead mb-0">Temukan pengalaman liburan tak terlupakan dengan pilihan destinasi terbaik kami.</p>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                <i class="bi bi-luggage-fill" style="font-size: 5rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3 col-sm-6">
            <div class="card stat-card shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                        <i class="bi bi-geo-alt-fill fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0">9</h3>
                        <p class="text-muted small mb-0">Destinasi Wisata</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card stat-card shadow-sm h-100 border-start border-success border-4">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="bi bi-shield-check fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="fw-bold mb-0 text-success" style="font-size: 1.1rem;">Aktif</h4>
                        <p class="text-muted small mb-0">Status Akun</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6" onclick="window.location.href='promo.php'" style="cursor: pointer;">
            <div class="card stat-card shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                        <i class="bi bi-lightning-charge-fill fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0">12</h3>
                        <p class="text-muted small mb-0">Promo Spesial</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card stat-card shadow-sm h-100 border-start border-danger border-4">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-danger bg-opacity-10 text-danger p-3 rounded-3">
                        <i class="bi bi-calendar3 fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h3 class="fw-bold mb-0">2026</h3>
                        <p class="text-muted small mb-0">Tahun Operasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h4 class="fw-bold mb-4 text-dark">Layanan Utama</h4>
    <div class="row g-4 text-center">
        <div class="col-md-4" onclick="window.location.href='destinasi.php'">
            <div class="card menu-card p-4 h-100 shadow-sm">
                <div class="icon-circle bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <h5 class="fw-bold">Sistem Tiket</h5>
                <p class="text-muted small">Lihat daftar 9 destinasi favorit dan pesan tiketnya.</p>
                <button class="btn btn-outline-primary btn-sm rounded-pill mt-2 px-4">Buka</button>
            </div>
        </div>

        <div class="col-md-4" onclick="window.location.href='statistik_bps.php'">
            <div class="card menu-card p-4 h-100 shadow-sm">
                <div class="icon-circle bg-success bg-opacity-10 text-success">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <h5 class="fw-bold">Statistik BPS</h5>
                <p class="text-muted small">Pantau data kunjungan wisatawan secara akurat.</p>
                <button class="btn btn-outline-success btn-sm rounded-pill mt-2 px-4">Buka</button>
            </div>
        </div>

        <div class="col-md-4" onclick="window.location.href='riwayat_pesanan.php'">
            <div class="card menu-card p-4 h-100 shadow-sm">
                <div class="icon-circle bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5 class="fw-bold">Riwayat Pesanan</h5>
                <p class="text-muted small">Cek kembali tiket yang pernah Anda beli.</p>
                <button class="btn btn-outline-warning btn-sm rounded-pill mt-2 px-4">Buka</button>
            </div>
        </div>
    </div>

    <div class="row mt-5 pt-2">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 20px; background-color: #ffffff;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle-fill text-primary fs-2 me-3"></i>
                    <div>
                        <h5 class="fw-bold mb-1">Tips Hari Ini</h5>
                        <p class="text-muted mb-0 small">Bawa salinan tiket digital Anda di ponsel untuk mempermudah proses check-in di gerbang masuk tempat wisata!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4">
    <p class="text-muted small">&copy; 2026 GoWisata - Aplikasi Manajemen Tiket Wisata</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>