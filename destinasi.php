<?php
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
    <title>Destinasi Wisata - GoWisata</title>
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
            <i class="bi bi-stars me-2"></i> Promo <b><?= $_SESSION['promo_aktif']['kode']; ?></b> Aktif! Harga akan terpotong otomatis saat pembayaran.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <h2 class="text-center mb-5 fw-bold text-dark">🌍 Jelajahi Destinasi Favorit Anda</h2>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRZqPWsn-DyTw7qSrAjenFvPuQsrCvnKjMsw&s" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">Saloka Theme Park</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Semarang, Jawa Tengah</p>
                    <p class="deskripsi">Taman rekreasi keluarga terbesar di Jawa Tengah.</p>
                    <p class="harga">Rp 120.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Saloka Theme Park','120000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://awsimages.detik.net.id/community/media/visual/2019/03/08/96d60356-f54f-4b9d-a5af-4cbc8c24f3c7_43.jpeg?w=600&q=90" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">Gunung Bromo</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Probolinggo, Jawa Timur</p>
                    <p class="deskripsi">Nikmati pemandangan matahari terbit yang ikonik.</p>
                    <p class="harga">Rp 54.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Gunung Bromo','54000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://akcdn.detik.net.id/visual/2025/06/10/fakta-menarik-raja-ampat-foto-unsplashcomsimon-spring-1749562020339_169.png?w=1200&q=90" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">Raja Ampat</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Papua Barat</p>
                    <p class="deskripsi">Surga bawah laut terbaik di dunia.</p>
                    <p class="harga">Rp 70.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Raja Ampat','70000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7OM01Hpm8lN8VlvB0rVRT1nIxcHEC5_f5pQ&s" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">Solo Safari</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Surakarta, Jawa Tengah</p>
                    <p class="deskripsi">Kebun binatang modern konsep edukasi.</p>
                    <p class="harga">Rp 45.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Solo Safari','45000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRYjd_AdX84M7qpvH7oaF042Vhqd0iEqjZd0z3m8AcJzJ_-mpbs" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">Candi Borobudur</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Magelang, Jawa Tengah</p>
                    <p class="deskripsi">Candi Buddha terbesar warisan UNESCO.</p>
                    <p class="harga">Rp 60.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Candi Borobudur','60000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://asset.kompas.com/crops/vEYhqHZtFtBSHdSty4yOKzoebtE=/68x0:755x458/1200x800/data/photo/2021/05/06/609377da73201.jpg" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">The Lawu Park</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Tawangmangu, Jawa Tengah</p>
                    <p class="deskripsi">Wisata alam pegunungan dengan wahana salju.</p>
                    <p class="harga">Rp 20.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('The Lawu Park','20000')">Pesan Tiket</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2023/02/27/0a058f5d-0a8f-4786-a9a7-f1ce72b5aecb-1677480708452-83c74269952404a6069d23b5469fad72.jpg" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">Jatim Park 1</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Kota Batu, Jawa Timur</p>
                    <p class="deskripsi">Paduan taman belajar dan rekreasi seru.</p>
                    <p class="harga">Rp 115.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Jatim Park 1','115000')">Pesan Tiket</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://jadiberangkat.id/wp-content/uploads/2024/12/kawah-ijen-banyuwangi-2.webp" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">Kawah Ijen</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Banyuwangi, Jawa Timur</p>
                    <p class="deskripsi">Fenomena Blue Fire dan kawah asam terbesar.</p>
                    <p class="harga">Rp 30.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Kawah Ijen','30000')">Pesan Tiket</button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://nagantour.com/wp-content/uploads/2024/07/Pura-Tirta-Empul-Bali-.webp" class="card-img-top">
                <div class="card-body">
                    <h5 class="fw-bold">Pura Tirta Empul</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Tampaksiring, Bali</p>
                    <p class="deskripsi">Pura suci dengan sumber mata air ritual.</p>
                    <p class="harga">Rp 75.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Pura Tirta Empul','75000')">Pesan Tiket</button>
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
              "&kode=" + kode;
              
    window.location.href = url;
}
</script>
</body>
</html>