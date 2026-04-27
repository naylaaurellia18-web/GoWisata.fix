<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

// 1. Tangkap data dari URL
$wisata = $_GET['wisata'] ?? "Destinasi";
$harga_asli = (int)($_GET['harga'] ?? 0);
$diskon = isset($_GET['diskon']) ? (float)$_GET['diskon'] : 0;
$potongan = isset($_GET['potongan']) ? (int)$_GET['potongan'] : 0;
$kode = $_GET['kode'] ?? "";

// 2. Hitung Harga Awal
$harga_satuan_promo = $harga_asli;
if ($diskon > 0) {
    $harga_satuan_promo = $harga_asli - ($harga_asli * $diskon);
} elseif ($potongan > 0) {
    $harga_satuan_promo = $harga_asli - $potongan;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background: #f37021; font-family: 'Poppins', sans-serif; }
        .card-order { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        /* Gaya Kartu Promo yang Langsung Tampil */
        .promo-card { 
            cursor: pointer; 
            border: 2px solid #eee; 
            border-radius: 12px; 
            transition: 0.3s;
            background: white;
        }
        .promo-card:hover { border-color: #f37021; background: #fff9f5; }
        .promo-card.active { border-color: #f37021; background: #fff4ed; position: relative; }
        .promo-card.active::after {
            content: "\F272"; font-family: "bootstrap-icons"; position: absolute;
            top: 10px; right: 10px; color: #f37021; font-size: 1.2rem;
        }
        
        .total-box { background: #f8f9fa; border-radius: 15px; padding: 15px; border-left: 5px solid #f37021; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-order p-4">
                <h4 class="fw-bold mb-4"><i class="bi bi-ticket-detailed me-2"></i>Detail Pesanan</h4>
                
                <form action="pembayaran.php" method="GET">
                    <input type="hidden" name="nama" value="<?= $_SESSION['user']; ?>">
                    <input type="hidden" name="wisata" value="<?= $wisata; ?>">
                    <input type="hidden" id="harga_dasar_promo" value="<?= $harga_satuan_promo; ?>">
                    <input type="hidden" name="kode" id="input_kode" value="<?= $kode; ?>">

                    <div class="mb-4">
                        <label class="small text-muted d-block">Wisata Tujuan</label>
                        <h5 class="fw-bold"><?= $wisata; ?></h5>
                        <p class="text-primary fw-bold">Rp <?= number_format($harga_asli, 0, ',', '.'); ?> <span class="text-muted small fw-normal">/ tiket</span></p>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small mb-2">Pilih Promo Tersedia:</label>
                        <div class="promo-card p-3 mb-2 <?= ($kode == 'ALAM-INDO') ? 'active' : ''; ?>" onclick="pilihPromo('ALAM-INDO', 0.15, 0, this)">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-tree fs-3 me-3 text-success"></i>
                                <div>
                                    <h6 class="fw-bold mb-0">ALAM-INDO</h6>
                                    <small class="text-muted">Diskon 15% khusus wisata alam</small>
                                </div>
                            </div>
                        </div>

                        <div class="promo-card p-3 mb-2 <?= ($kode == 'HELLO-NAYLA') ? 'active' : ''; ?>" onclick="pilihPromo('HELLO-NAYLA', 0, 5000, this)">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-stars fs-3 me-3 text-warning"></i>
                                <div>
                                    <h6 class="fw-bold mb-0">HELLO-NAYLA</h6>
                                    <small class="text-muted">Potongan langsung Rp 5.000</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small mb-2">Jumlah Tiket</label>
                        <input type="number" name="jumlah" id="qty" class="form-control form-control-lg fw-bold" value="1" min="1" oninput="updateHarga()">
                    </div>

                    <div class="total-box mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small text-muted">Total Bayar:</span>
                            <span class="small text-decoration-line-through text-muted" id="tampilan_harga_asli"></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Harga Akhir</span>
                            <h3 class="fw-bold text-primary mb-0" id="tampilan_total">Rp <?= number_format($harga_satuan_promo, 0, ',', '.'); ?></h3>
                        </div>
                        <input type="hidden" name="total" id="input_total" value="<?= $harga_satuan_promo; ?>">
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small mb-2">Metode Pembayaran</label>
                        <select name="metode" class="form-select border-0 bg-light" required>
                            <option value="QRIS">QRIS</option>
                            <option value="BCA">BCA Transfer</option>
                            <option value="DANA">DANA</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-white shadow rounded-pill">
                        LANJUTKAN PEMBAYARAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function pilihPromo(kode, diskon, potongan, element) {
    // 1. Reset semua kartu promo (hapus class active)
    document.querySelectorAll('.promo-card').forEach(card => card.classList.remove('active'));
    
    // 2. Aktifkan kartu yang dipilih
    element.classList.add('active');
    
    // 3. Hitung harga baru
    const hargaAsli = <?= $harga_asli; ?>;
    let hargaBaru = hargaAsli;

    if (diskon > 0) {
        hargaBaru = hargaAsli - (hargaAsli * diskon);
    } else if (potongan > 0) {
        hargaBaru = hargaAsli - potongan;
    }

    // 4. Update data input
    document.getElementById('input_kode').value = kode;
    document.getElementById('harga_dasar_promo').value = hargaBaru;

    updateHarga();
    
    // Notifikasi kecil
    Swal.fire({ icon: 'success', title: 'Promo Terpasang!', text: 'Kode ' + kode + ' aktif', timer: 1000, showConfirmButton: false });
}

function updateHarga() {
    const hargaSatuan = parseInt(document.getElementById('harga_dasar_promo').value);
    const hargaAsliSatuan = <?= $harga_asli; ?>;
    let qty = document.getElementById('qty').value;
    
    if (qty < 1 || qty === "") qty = 1;
    
    const total = hargaSatuan * qty;
    const totalAsli = hargaAsliSatuan * qty;
    
    document.getElementById('tampilan_total').innerText = "Rp " + total.toLocaleString('id-ID');
    document.getElementById('tampilan_harga_asli').innerText = "Rp " + totalAsli.toLocaleString('id-ID');
    document.getElementById('input_total').value = total;
}

// Jalankan update harga pertama kali
updateHarga();
</script>
</body>
</html>