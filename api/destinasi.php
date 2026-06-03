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
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRZqPWsn-DyTw7qSrAjenFvPuQsrCvnKjMsw&s" class="card-img-top" alt="Saloka Theme Park">
                <div class="card-body">
                    <h5 class="fw-bold">Saloka Theme Park</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Semarang, Jawa Tengah</p>
                    <p class="deskripsi">Taman rekreasi keluarga terbesar di Jawa Tengah dengan berbagai wahana seru.</p>
                    <p class="harga">Rp 120.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Saloka Theme Park','120000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://cdn1-production-images-kly.akamaized.net/KRV05_LNI_woM1xsLULUlF-KGZE=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/3023951/original/083764400_1579164554-indonesia-1098328_1920.jpg" class="card-img-top" alt="Candi Borobudur">
                <div class="card-body">
                    <h5 class="fw-bold">Candi Borobudur</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Magelang, Jawa Tengah</p>
                    <p class="deskripsi">Candi Buddha terbesar di dunia yang diakui sebagai warisan budaya dunia oleh UNESCO.</p>
                    <p class="harga">Rp 300.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Candi Borobudur','50000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2026/03/25/a31c0d96-04af-41a3-bf0d-e6e1dd47f723-1774431846858-13592ce40930746e3e717f6e07e07d04.jpg" class="card-img-top" alt="Taman Nasional Karimunjawa">
                <div class="card-body">
                    <h5 class="fw-bold">Taman Nasional Karimunjawa</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Jepara, Jawa Tengah</p>
                    <p class="deskripsi">Pesona wisata bahari terindah dengan keindahan bawah laut dan pantai pasir putih.</p>
                    <p class="harga">Rp 200.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Taman Nasional Karimunjawa','150000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://asset.kompas.com/crops/YcndS6e_j63Y8v-f-9jW2IitwIs=/0x47:1000x714/1200x800/data/photo/2023/09/27/6513d28bbdb38.jpg" class="card-img-top" alt="The Heritage Palace">
                <div class="card-body">
                    <h5 class="fw-bold">Rasamadu (The Heritage Palace)</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Sukoharjo, Jawa Tengah</p>
                    <p class="deskripsi">Bekas pabrik gula Gembongan abad ke-19 yang diubah menjadi tempat wisata bergaya Eropa.</p>
                    <p class="harga">Rp 80.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Rasamadu (The Heritage Palace)','30000')">Pesan Tiket</button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card wisata-card h-100">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSuZgalMALjLh8eeh4WdWlGIMKLeZ4RPPWGIg&s" class="card-img-top" alt="Solo Safari">
                <div class="card-body">
                    <h5 class="fw-bold">Solo Safari</h5>
                    <p class="lokasi"><i class="bi bi-geo-alt-fill"></i> Surakarta, Jawa Tengah</p>
                    <p class="deskripsi">Kawasan kebun binatang modern dengan konsep edukasi satwa yang interaktif.</p>
                    <p class="harga">Rp 60.000</p>
                    <button class="btn btn-warning w-100 fw-bold" onclick="pesanTiket('Solo Safari','45000')">Pesan Tiket</button>
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