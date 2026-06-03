<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();

// Tangkap promo dari URL dan simpan ke session
if (isset($_GET['kode'])) {
    $_SESSION['promo_aktif'] = [
        'kode'     => strip_tags($_GET['kode']),
        'diskon'   => isset($_GET['diskon'])   ? (float)$_GET['diskon']   : 0,
        'potongan' => isset($_GET['potongan']) ? (int)$_GET['potongan']   : 0
    ];
}

$nama_tampil = $_SESSION['user'] ?? $_SESSION['username'] ?? null;

if (!$nama_tampil) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}

// Ambil daftar destinasi dari DB; fallback ke data statis jika tabel kosong
$db = $conn;
$res_dest = mysqli_query($db, "SELECT * FROM destinasi ORDER BY id_destinasi ASC");
$dari_db  = ($res_dest && mysqli_num_rows($res_dest) > 0);

// Data statis sebagai fallback (jika tabel destinasi belum diisi)
$destinasi_statis = [
    ['nama'=>'Saloka Theme Park',          'lokasi'=>'Semarang',   'deskripsi'=>'Taman rekreasi keluarga terbesar di Jawa Tengah dengan berbagai wahana seru.',                     'harga'=>120000, 'gambar'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRZqPWsn-DyTw7qSrAjenFvPuQsrCvnKjMsw&s'],
    ['nama'=>'Candi Borobudur',             'lokasi'=>'Magelang',   'deskripsi'=>'Candi Buddha terbesar di dunia, warisan budaya UNESCO.',                                          'harga'=>300000, 'gambar'=>'https://cdn1-production-images-kly.akamaized.net/KRV05_LNI_woM1xsLULUlF-KGZE=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/3023951/original/083764400_1579164554-indonesia-1098328_1920.jpg'],
    ['nama'=>'Taman Nasional Karimunjawa', 'lokasi'=>'Jepara',     'deskripsi'=>'Pesona wisata bahari terindah dengan keindahan bawah laut dan pantai pasir putih.',             'harga'=>200000, 'gambar'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQsIs1YIW602fv8a-S9qUgwZWFd8_qyp7X5lQ&s'],
    ['nama'=>'Rasamadu (The Heritage Palace)', 'lokasi'=>'Sukoharjo','deskripsi'=>'Bekas pabrik gula abad ke-19 yang diubah menjadi tempat wisata bergaya Eropa.',               'harga'=>80000,  'gambar'=>'https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2026/03/25/a31c0d96-04af-41a3-bf0d-e6e1dd47f723-1774431846858-13592ce40930746e3e717f6e07e07d04.jpg'],
    ['nama'=>'Solo Safari',                 'lokasi'=>'Surakarta',  'deskripsi'=>'Kawasan kebun binatang modern dengan konsep edukasi satwa yang interaktif.',                    'harga'=>60000,  'gambar'=>'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSuZgalMALjLh8eeh4WdWlGIMKLeZ4RPPWGIg&s'],
];
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
        .navbar-custom { background-color: #f37021; padding:15px 0; }
        .wisata-card { border:none; border-radius:15px; overflow:hidden; transition:0.3s; box-shadow:0 4px 15px rgba(0,0,0,.1); }
        .wisata-card:hover { transform:translateY(-10px); }
        .card-img-top { height:200px; object-fit:cover; }
        .harga { font-weight:bold; color:#f37021; font-size:1.2rem; margin-bottom:15px; }
        .lokasi { color:#dc3545; font-size:0.85rem; font-weight:500; }
        .deskripsi { font-size:0.85rem; color:#6c757d; min-height:45px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php">🌍 GoWisata</a>
        <div class="ms-auto d-flex align-items-center">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin_dashboard.php" class="btn btn-danger btn-sm rounded-pill px-3 me-2 fw-bold">
                    <i class="bi bi-shield-lock me-1"></i>Panel Admin
                </a>
            <?php endif; ?>
            <a href="dashboard.php" class="btn btn-outline-light btn-sm rounded-pill px-3 me-3">
                <i class="bi bi-arrow-left-circle me-1"></i>Dashboard
            </a>
            <span class="text-white me-3 d-none d-md-inline">Halo, <b><?= htmlspecialchars($nama_tampil); ?></b>!</span>
            <a href="logout.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <?php if (isset($_SESSION['promo_aktif'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="bi bi-stars me-2"></i> Promo <b><?= htmlspecialchars($_SESSION['promo_aktif']['kode']); ?></b> Aktif!
            Harga akan terpotong otomatis saat pemesanan.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <h2 class="text-center mb-5 fw-bold text-dark">🌍 Jelajahi Destinasi Favorit Jawa Tengah</h2>

    <div class="row g-4 justify-content-center">
    <?php
    if ($dari_db) {
        while ($row = mysqli_fetch_assoc($res_dest)) {
            $nm  = htmlspecialchars($row['nama_destinasi']);
            $lok = htmlspecialchars($row['lokasi']);
            $des = htmlspecialchars($row['deskripsi'] ?? '');
            $hrg = (int)$row['harga'];
            $img = !empty($row['gambar']) ? $row['gambar'] : 'https://via.placeholder.com/400x200?text=' . urlencode($nm);
            echo renderCard($nm, $lok, $des, $hrg, $img);
        }
    } else {
        foreach ($destinasi_statis as $d) {
            echo renderCard($d['nama'], $d['lokasi'], $d['deskripsi'], $d['harga'], $d['gambar']);
        }
    }

    function renderCard($nm, $lok, $des, $hrg, $img) {
        $nm_js  = addslashes($nm);
        return "
        <div class=\"col-md-4\">
            <div class=\"card wisata-card h-100\">
                <img src=\"$img\" class=\"card-img-top\" alt=\"$nm\" onerror=\"this.src='https://via.placeholder.com/400x200?text=Gambar+Tidak+Tersedia'\">
                <div class=\"card-body\">
                    <h5 class=\"fw-bold\">$nm</h5>
                    <p class=\"lokasi\"><i class=\"bi bi-geo-alt-fill\"></i> $lok, Jawa Tengah</p>
                    <p class=\"deskripsi\">$des</p>
                    <p class=\"harga\">Rp " . number_format($hrg, 0, ',', '.') . "</p>
                    <button class=\"btn btn-warning w-100 fw-bold\" onclick=\"pesanTiket('$nm_js','$hrg')\">Pesan Tiket</button>
                </div>
            </div>
        </div>";
    }
    ?>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="tiketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px;">
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
let hargaTerpilih  = "";

function pesanTiket(nama, harga) {
    wisataTerpilih = nama;
    hargaTerpilih  = harga;
    document.getElementById('infoTiket').innerHTML =
        `Anda akan memesan tiket <br><b>${nama}</b> seharga <b>Rp ${parseInt(harga).toLocaleString('id-ID')}</b>`;
    new bootstrap.Modal(document.getElementById('tiketModal')).show();
}

function lanjutBayar() {
    // Ambil promo aktif dari URL jika ada
    const params   = new URLSearchParams(window.location.search);
    const diskon   = params.get('diskon')   || 0;
    const potongan = params.get('potongan') || 0;
    const kode     = params.get('kode')     || '';
    window.location.href = "pesan.php?wisata=" + encodeURIComponent(wisataTerpilih)
        + "&harga="    + hargaTerpilih
        + "&diskon="   + diskon
        + "&potongan=" + potongan
        + "&kode="     + encodeURIComponent(kode);
}
</script>
</body>
</html>