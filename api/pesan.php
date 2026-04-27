<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

// 1. Tangkap data dari URL (Data dasar dari destinasi.php)
$wisata = $_GET['wisata'] ?? "Destinasi";
$harga_asli = (int)($_GET['harga'] ?? 0);
$diskon = isset($_GET['diskon']) ? (float)$_GET['diskon'] : 0;
$potongan = isset($_GET['potongan']) ? (int)$_GET['potongan'] : 0;
$kode = $_GET['kode'] ?? "";

// 2. Hitung Harga Satuan Awal (Jika ada promo dari halaman sebelumnya)
$harga_satuan_promo = $harga_asli;
if ($diskon > 0) {
    $harga_satuan_promo = $harga_asli - ($harga_asli * $diskon);
} elseif ($potongan > 0) {
    $harga_satuan_promo = $harga_asli - $potongan;
}
if ($harga_satuan_promo < 0) $harga_satuan_promo = 0;
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
        .promo-section { background: #fff4ed; border: 2px dashed #f37021; border-radius: 15px; padding: 15px; }
        .promo-item { cursor: pointer; transition: 0.3s; border-radius: 12px; border: 1px solid #ddd; }
        .promo-item:hover { border-color: #f37021; background: #fff9f5; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-order p-4">
                <h4 class="fw-bold text-center mb-4">Detail Pemesanan</h4>
                
                <form action="pembayaran.php" method="GET">
                    <input type="hidden" name="nama" value="<?= $_SESSION['user']; ?>">
                    <input type="hidden" name="wisata" value="<?= $wisata; ?>">
                    <input type="hidden" id="harga_dasar_promo" value="<?= $harga_satuan_promo; ?>">
                    
                    <div class="mb-3">
                        <label class="small text-muted">Destinasi Pilihan</label>
                        <h5 class="fw-bold text-primary"><?= $wisata; ?></h5>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small mb-2">Promo Untukmu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-ticket-perforation text-warning"></i></span>
                            <input type="text" name="kode" id="input_kode" class="form-control bg-white" placeholder="Pilih promo..." value="<?= $kode; ?>" readonly>
                            <button class="btn btn-warning fw-bold text-white" type="button" data-bs-toggle="modal" data-bs-target="#modalPromo">PILIH</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small mb-2">Jumlah Tiket</label>
                        <input type="number" name="jumlah" id="qty" class="form-control form-control-lg fw-bold" value="1" min="1" oninput="updateHarga()">
                    </div>

                    <div class="promo-section mb-4">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span>Harga Satuan:</span>
                            <span class="fw-bold text-muted" style="text-decoration: line-through;">Rp <?= number_format($harga_asli, 0, ',', '.'); ?></span>
                        </div>
                        <div id="info_promo" class="d-flex justify-content-between mb-2 small <?= ($kode == '') ? 'd-none' : ''; ?>">
                            <span>Potongan:</span>
                            <span class="fw-bold text-success" id="teks_diskon">Terpasang</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Bayar:</span>
                            <h3 class="fw-bold text-primary mb-0" id="tampilan_total">Rp <?= number_format($harga_satuan_promo, 0, ',', '.'); ?></h3>
                            <input type="hidden" name="total" id="input_total" value="<?= $harga_satuan_promo; ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold small mb-2">Metode Pembayaran</label>
                        <select name="metode" class="form-select" required>
                            <option value="QRIS">QRIS</option>
                            <option value="BCA">Transfer BCA</option>
                            <option value="DANA">DANA</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-white shadow rounded-pill">BAYAR SEKARANG</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPromo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="fw-bold">Pilih Promo Tersedia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="promo-item p-3 mb-3" onclick="pilihPromo('ALAM-INDO', 0.15, 0, 'Diskon 15%')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0">ALAM-INDO</h6>
                            <small class="text-muted">Diskon 15% Spesial Wisata Alam</small>
                        </div>
                        <span class="badge bg-warning text-white">Pakai</span>
                    </div>
                </div>
                <div class="promo-item p-3 mb-3" onclick="pilihPromo('HELLO-NAYLA', 0, 5000, 'Potongan Rp 5.000')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0">HELLO-NAYLA</h6>
                            <small class="text-muted">Potongan Langsung Rp 5.000</small>
                        </div>
                        <span class="badge bg-warning text-white">Pakai</span>
                    </div>
                </div>
                <button class="btn btn-link w-100 text-muted small" onclick="pilihPromo('', 0, 0, '')">Tidak Gunakan Promo</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function pilihPromo(kode, diskon, potongan, label) {
    const hargaAsli = <?= $harga_asli; ?>;
    let hargaBaru = hargaAsli;

    if (diskon > 0) {
        hargaBaru = hargaAsli - (hargaAsli * diskon);
    } else if (potongan > 0) {
        hargaBaru = hargaAsli - potongan;
    }

    // Update Input Hidden
    document.getElementById('input_kode').value = kode;
    document.getElementById('harga_dasar_promo').value = hargaBaru;
    
    // Tampilkan label potongan
    if(kode !== "") {
        document.getElementById('info_promo').classList.remove('d-none');
        document.getElementById('teks_diskon').innerText = "-" + label;
    } else {
        document.getElementById('info_promo').classList.add('d-none');
    }

    updateHarga(); // Hitung ulang total
    bootstrap.Modal.getInstance(document.getElementById('modalPromo')).hide();
    
    if(kode !== "") {
        Swal.fire({ icon: 'success', title: 'Promo Terpasang!', text: kode, timer: 1200, showConfirmButton: false });
    }
}

function updateHarga() {
    const hargaSatuan = parseInt(document.getElementById('harga_dasar_promo').value);
    let qty = document.getElementById('qty').value;
    
    if (qty < 1 || qty === "") qty = 1;
    
    const total = hargaSatuan * qty;
    
    document.getElementById('tampilan_total').innerText = "Rp " + total.toLocaleString('id-ID');
    document.getElementById('input_total').value = total;
}
</script>
</body>
</html>