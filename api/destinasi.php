<?php
// BUG FIX: include koneksi.php SEBELUM session_start()
// Tanpa ini, DbSessionHandler tidak terdaftar → session TiDB tidak terbaca
// → $_SESSION selalu kosong → selalu redirect ke login (bug utama dari screenshot)
include 'koneksi.php';
session_start();

// --- TAMBAHAN LOGIKA PROMO ---
if (isset($_GET['kode'])) {
    $_SESSION['promo_aktif'] = [
        'kode' => $_GET['kode'],
        'diskon' => $_GET['diskon'] ?? 0,
        'potongan' => $_GET['potongan'] ?? 0
    ];
}
// -----------------------------

$nama_tampil = $_SESSION['user'] ?? $_SESSION['username'] ?? null;

if (!$nama_tampil) {
    echo "<script>
            alert('Silakan login terlebih dahulu!');
            window.location.href = 'login.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasi Wisata Jawa Tengah - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-custom { background-color: #f37021; padding: 15px 0; }
        .wisata-card { border: none; border-radius: 15px; overflow: hidden; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .wisata-card:hover { transform: translateY(-10px); }
        .card-img-top { height: 200px; object-fit: cover; }
        .harga { font-weight: bold; color: #f37021; font-size: 1.2rem; margin-bottom: 15px; }
        .lokasi { color: #dc3545; font-size: 0.85rem; font-weight: 500; }
        .deskripsi { font-size: 0.85rem; color: #6c757d; min-height: 45px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🌍 GoWisata</a>
        <div class="ms-auto d-flex align-items-center">
            
            <?php if(isset($_SESSION['user']) && $_SESSION['user'] == 'admin'): ?>
                <a href="admin_dashboard.php" class="btn btn-danger btn-sm rounded-pill px-3 me-2 fw-bold shadow-sm">
                    <i class="bi bi-shield-lock me-1"></i> Panel Admin
                </a>
            <?php endif; ?>
            <a href="dashboard.php" class="btn btn-outline-light btn-sm rounded-pill px-3 me-3">
                <i class="bi bi-arrow-left-circle me-1"></i> Dashboard
            </a>
            <span class="text-white me-3 d-none d-md-inline">Halo, <b><?= htmlspecialchars($nama_tampil); ?></b>!</span>
            <a href="logout.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <?php if(isset($_SESSION['promo_aktif'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="bi bi-stars me-2"></i> Promo <b><?= htmlspecialchars($_SESSION['promo_aktif']['kode']); ?></b> Aktif! Harga akan terpotong otomatis saat pembayaran.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <h2 class="text-center mb-5 fw-bold text-dark">🌍 Jelajahi Destinasi Favorit Jawa Tengah</h2>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAHYCesL6XLyhzBwbkww_PeeSZDKQ47exD9SJ-wO8B51ymrZ3w2W3HzqulvlFezRB1kYvUXdyDeIib9b-NBQ4k1IWbAnZlkSQkFFDNen3DBW2PWYpMJPYerFtdWI549x5dQmr23I=s1360-w1360-h1020-rw" class="card-img-top" alt="Lawang Sewu">
                <div class="card-body">
                    <h5 class="fw-bold">Lawang Sewu</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Semarang, Jawa Tengah</p>
                    <p class="deskripsi">Gedung bersejarah peninggalan Belanda yang ikonik dengan seribu pintu.</p>
                    <p class="harga">Rp 20.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Lawang Sewu','20000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://asset.kompas.com/crops/r66iXas8w0bQoRz_jE2O8wOaRms=/0x47:1000x714/1200x800/data/photo/2022/12/26/63a92543e2646.jpg" class="card-img-top" alt="Keraton Surakarta">
                <div class="card-body">
                    <h5 class="fw-bold">Kasunanan Surakarta</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Surakarta, Jawa Tengah</p>
                    <p class="deskripsi">Istana resmi Kasunanan Surakarta Hadiningrat yang kaya akan budaya Jawa.</p>
                    <p class="harga">Rp 15.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Kasunanan Surakarta','15000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7DZoaweDpD-e9Uxr6qDQHJxZR_SNHVfYwvw&s" class="card-img-top" alt="Air Terjun Jumog">
                <div class="card-body">
                    <h5 class="fw-bold">Jumog Waterfall</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Karanganyar, Jawa Tengah</p>
                    <p class="deskripsi">Air terjun asri di lereng Gunung Lawu, sering dijuluki Surga yang Hilang.</p>
                    <p class="harga">Rp 20.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Jumog Waterfall','20000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR0zQ6xPY9sCcj8YltSdQBlJAYeyb7KaFBsfw&s" class="card-img-top" alt="Dieng Plateau">
                <div class="card-body">
                    <h5 class="fw-bold">Dieng Plateau</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Wonosobo, Jawa Tengah</p>
                    <p class="deskripsi">Dataran tinggi dengan pesona kompleks candi Hindu purba dan kawah aktif.</p>
                    <p class="harga">Rp 30.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Dieng Plateau','30000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://cdn.digitaldesa.id/uploads/profil/33.01.11.2008/berita/921d4dcfcd851db65d1a051fbe54a224.jpg" class="card-img-top" alt="Karimunjawa">
                <div class="card-body">
                    <h5 class="fw-bold">Kepulauan Karimunjawa</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Jepara, Jawa Tengah</p>
                    <p class="deskripsi">Pesona taman nasional laut dengan pasir putih dan terumbu karang yang indah.</p>
                    <p class="harga">Rp 150.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Kepulauan Karimunjawa','15000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tiketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px;">
            <div class="modal-header border-0 text-center d-block">
                <h5 class="modal-title fw-bold mt-2">🎟 Konfirmasi Pemesanan</h5>
            </div>
            <div class="modal-body text-center p-4">
                <p id="infoTiket" class="fs-5"></p>
                <hr>
                <div class="d-grid gap-2">
                    <button class="btn btn-success py-2 fw-bold" onclick="lanjutBayar()">
                        Lanjut Pembayaran <i class="bi bi-chevron-right"></i>
                    </button>
                    <button type="button" class="btn btn-light py-2 text-muted fw-bold" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Kembali Pilih Wisata
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let wisataTerpilih = "";
let hargaTerpilih = "";

function pesanTiket(nama, harga) {
    wisataTerpilih = nama;
    hargaTerpilih = harga;
    
    document.getElementById('infoTiket').innerHTML = `Anda akan memesan tiket <br><b>${nama}</b> seharga <b>Rp ${parseInt(harga).toLocaleString('id-ID')}</b>`;
    
    var myModal = new bootstrap.Modal(document.getElementById('tiketModal'));
    myModal.show();
}

function lanjutBayar() {
    // Ambil parameter dari URL (untuk cek apakah ada promo aktif)
    const urlParams = new URLSearchParams(window.location.search);
    let diskon = urlParams.get('diskon') || 0;
    let potongan = urlParams.get('potongan') || 0;
    let kode = urlParams.get('kode') || '';
    
    // Kirim data ke pesan.php
    let url = "pesan.php?wisata=" + encodeURIComponent(wisataTerpilih) + 
              "&harga=" + hargaTerpilih + 
              "&diskon=" + diskon + 
              "&potongan=" + potongan + 
              "&kode=" + encodeURIComponent(kode);
              
    window.location.href = url;
}
</script>
</body>
</html>