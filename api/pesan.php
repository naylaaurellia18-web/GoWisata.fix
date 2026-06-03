<?php
include 'koneksi.php';
session_start();

$username_session = $_SESSION['user'] ?? $_SESSION['username'] ?? null;
if (!$username_session) { header("Location: login.php"); exit(); }

$wisata    = isset($_GET['wisata'])   ? strip_tags($_GET['wisata'])   : "Destinasi";
$harga_asli= isset($_GET['harga'])   ? (int)$_GET['harga']           : 0;
$diskon    = isset($_GET['diskon'])   ? (float)$_GET['diskon']        : 0;
$potongan  = isset($_GET['potongan'])? (int)$_GET['potongan']         : 0;
$kode      = isset($_GET['kode'])    ? strip_tags($_GET['kode'])      : '';

if ($harga_asli <= 0) {
    echo "<script>alert('Harga tidak valid.'); window.location.href='destinasi.php';</script>";
    exit();
}

$harga_satuan_promo = $harga_asli;
if ($diskon > 0) {
    $harga_satuan_promo = $harga_asli - ($harga_asli * $diskon);
} elseif ($potongan > 0) {
    $harga_satuan_promo = $harga_asli - $potongan;
}
if ($harga_satuan_promo < 0) $harga_satuan_promo = 0;

// Tanggal minimum = besok, maksimum = 1 tahun ke depan
$tgl_min = date('Y-m-d', strtotime('+1 day'));
$tgl_max = date('Y-m-d', strtotime('+1 year'));
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
        .card-order { border-radius:20px; border:none; box-shadow:0 10px 30px rgba(0,0,0,.1); }
        .promo-section { background:#fff4ed; border:2px dashed #f37021; border-radius:15px; padding:15px; }
        .promo-item { cursor:pointer; transition:0.3s; border-radius:12px; border:1px solid #ddd; }
        .promo-item:hover { border-color:#f37021; background:#fff9f5; }
        .section-label { font-weight:700; font-size:0.85rem; color:#444; margin-bottom:6px; display:block; }
        input[type="date"] { color: #333; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card card-order p-4">
                <h4 class="fw-bold text-center mb-4">🎟 Detail Pemesanan</h4>

                <form action="pembayaran.php" method="GET" id="formPesan" onsubmit="return validasiForm()">
                    <input type="hidden" name="nama"   value="<?= htmlspecialchars($username_session); ?>">
                    <input type="hidden" name="wisata" value="<?= htmlspecialchars($wisata); ?>">
                    <input type="hidden" id="harga_dasar_promo" value="<?= (int)$harga_satuan_promo; ?>">

                    <!-- Destinasi -->
                    <div class="mb-3 p-3 bg-light rounded-3">
                        <span class="section-label text-muted">Destinasi Pilihan</span>
                        <h5 class="fw-bold text-primary mb-0"><?= htmlspecialchars($wisata); ?></h5>
                    </div>

                    <!-- TANGGAL KUNJUNGAN (BARU) -->
                    <div class="mb-4">
                        <label class="section-label">
                            <i class="bi bi-calendar-event text-danger me-1"></i>Tanggal Kunjungan
                        </label>
                        <input type="date"
                               name="tanggal"
                               id="input_tanggal"
                               class="form-control form-control-lg"
                               min="<?= $tgl_min; ?>"
                               max="<?= $tgl_max; ?>"
                               required>
                        <div class="form-text text-muted small">
                            <i class="bi bi-info-circle me-1"></i>Pilih tanggal kunjungan Anda (mulai besok)
                        </div>
                    </div>

                    <!-- Promo -->
                    <div class="mb-4">
                        <label class="section-label">
                            <i class="bi bi-ticket-perforated text-warning me-1"></i>Kode Promo
                        </label>
                        <div class="input-group">
                            <input type="text" name="kode" id="input_kode" class="form-control bg-white"
                                   placeholder="Pilih promo (opsional)..."
                                   value="<?= htmlspecialchars($kode); ?>" readonly>
                            <button class="btn btn-warning fw-bold text-white" type="button"
                                    data-bs-toggle="modal" data-bs-target="#modalPromo">PILIH</button>
                        </div>
                    </div>

                    <!-- Jumlah Tiket -->
                    <div class="mb-4">
                        <label class="section-label">
                            <i class="bi bi-people me-1"></i>Jumlah Tiket
                        </label>
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button" onclick="ubahQty(-1)">−</button>
                            <input type="number" name="jumlah" id="qty"
                                   class="form-control text-center fw-bold fs-5"
                                   value="1" min="1" max="20" oninput="updateHarga()">
                            <button class="btn btn-outline-secondary" type="button" onclick="ubahQty(1)">+</button>
                        </div>
                    </div>

                    <!-- Ringkasan Harga -->
                    <div class="promo-section mb-4">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Harga Normal / tiket:</span>
                            <span class="fw-bold <?= ($kode !== '') ? 'text-decoration-line-through text-muted' : 'text-dark'; ?>">
                                Rp <?= number_format($harga_asli, 0, ',', '.'); ?>
                            </span>
                        </div>
                        <div id="info_promo" class="d-flex justify-content-between mb-2 small <?= ($kode === '') ? 'd-none' : ''; ?>">
                            <span class="text-muted">Potongan Promo:</span>
                            <span class="fw-bold text-success" id="teks_diskon">
                                <?php
                                if ($kode !== '') {
                                    if ($diskon > 0) echo '-Diskon ' . ($diskon*100) . '%';
                                    elseif ($potongan > 0) echo '-Rp ' . number_format($potongan,0,',','.');
                                }
                                ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 small text-muted">
                            <span>Jumlah Tiket:</span>
                            <span id="teks_qty">1 tiket</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total Bayar:</span>
                            <h3 class="fw-bold text-primary mb-0" id="tampilan_total">
                                Rp <?= number_format($harga_satuan_promo, 0, ',', '.'); ?>
                            </h3>
                            <input type="hidden" name="total" id="input_total" value="<?= (int)$harga_satuan_promo; ?>">
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="mb-4">
                        <label class="section-label">
                            <i class="bi bi-credit-card me-1"></i>Metode Pembayaran
                        </label>
                        <select name="metode" class="form-select form-select-lg" required>
                            <option value="QRIS">🔲 QRIS</option>
                            <option value="BCA">🏦 Transfer BCA</option>
                            <option value="DANA">💙 DANA</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-white shadow rounded-pill fs-5">
                        BAYAR SEKARANG 🚀
                    </button>
                    <a href="destinasi.php" class="btn btn-link w-100 text-muted small mt-1">← Kembali ke Destinasi</a>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Promo -->
<div class="modal fade" id="modalPromo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold">🏷 Pilih Promo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="promo-item p-3 mb-2" onclick="pilihPromo('GO-JATENG20', 0.20, 0, 'Diskon 20%')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0 text-warning">GO-JATENG20</h6>
                            <small class="text-muted">Diskon 20% Wisata Jawa Tengah</small>
                        </div>
                        <span class="badge bg-warning text-dark px-3">Pakai</span>
                    </div>
                </div>
                <div class="promo-item p-3 mb-2" onclick="pilihPromo('JATIM-HEBAT', 0, 50000, 'Potongan Rp 50.000')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0 text-success">JATIM-HEBAT</h6>
                            <small class="text-muted">Potongan Langsung Rp 50.000</small>
                        </div>
                        <span class="badge bg-success px-3">Pakai</span>
                    </div>
                </div>
                <div class="promo-item p-3 mb-2" onclick="pilihPromo('ALAM-INDO', 0.15, 0, 'Diskon 15%')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0 text-info">ALAM-INDO</h6>
                            <small class="text-muted">Diskon 15% Wisata Alam & Air</small>
                        </div>
                        <span class="badge bg-info px-3">Pakai</span>
                    </div>
                </div>
                <div class="promo-item p-3 mb-2" onclick="pilihPromo('IJEN-BLUE', 0, 10000, 'Potongan Rp 10.000')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0" style="color:#1e90ff">IJEN-BLUE</h6>
                            <small class="text-muted">Flash Sale Kawah Ijen – Potongan Rp 10.000</small>
                        </div>
                        <span class="badge px-3" style="background:#1e90ff">Pakai</span>
                    </div>
                </div>
                <div class="promo-item p-3 mb-2" onclick="pilihPromo('LAWU-DINGIN', 0.10, 0, 'Diskon 10%')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0" style="color:#6c5ce7">LAWU-DINGIN</h6>
                            <small class="text-muted">Diskon 10% The Lawu Park</small>
                        </div>
                        <span class="badge px-3" style="background:#6c5ce7">Pakai</span>
                    </div>
                </div>
                <div class="promo-item p-3 mb-2" onclick="pilihPromo('HELLO-NAYLA', 0, 5000, 'Potongan Rp 5.000')">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fw-bold mb-0 text-danger">HELLO-NAYLA</h6>
                            <small class="text-muted">Pengguna Baru – Semua Destinasi</small>
                        </div>
                        <span class="badge bg-danger px-3">Pakai</span>
                    </div>
                </div>
                <button class="btn btn-link w-100 text-muted small mt-2" onclick="pilihPromo('', 0, 0, '')">
                    <i class="bi bi-x-circle me-1"></i>Tidak Gunakan Promo
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const hargaAsliGlobal = <?= $harga_asli; ?>;

function ubahQty(delta) {
    const el  = document.getElementById('qty');
    let val   = parseInt(el.value) + delta;
    if (val < 1) val = 1;
    if (val > 20) val = 20;
    el.value  = val;
    updateHarga();
}

function pilihPromo(kode, diskon, potongan, label) {
    let hargaBaru = hargaAsliGlobal;
    if (diskon > 0)        hargaBaru = hargaAsliGlobal - (hargaAsliGlobal * diskon);
    else if (potongan > 0) hargaBaru = hargaAsliGlobal - potongan;
    if (hargaBaru < 0) hargaBaru = 0;

    document.getElementById('input_kode').value        = kode;
    document.getElementById('harga_dasar_promo').value = Math.round(hargaBaru);

    if (kode !== '') {
        document.getElementById('info_promo').classList.remove('d-none');
        document.getElementById('teks_diskon').innerText = '-' + label;
    } else {
        document.getElementById('info_promo').classList.add('d-none');
    }

    updateHarga();
    bootstrap.Modal.getInstance(document.getElementById('modalPromo')).hide();

    if (kode !== '') {
        Swal.fire({
            icon: 'success',
            title: 'Promo Terpasang! 🎉',
            html: '<b>' + kode + '</b><br><small>' + label + '</small>',
            timer: 1800,
            showConfirmButton: false
        });
    }
}

function updateHarga() {
    const hargaSatuan = parseInt(document.getElementById('harga_dasar_promo').value) || 0;
    let qty = parseInt(document.getElementById('qty').value) || 1;
    if (qty < 1) qty = 1;
    const total = hargaSatuan * qty;
    document.getElementById('tampilan_total').innerText = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('input_total').value = total;
    document.getElementById('teks_qty').innerText = qty + ' tiket';
}

function validasiForm() {
    const tgl = document.getElementById('input_tanggal').value;
    if (!tgl) {
        Swal.fire({
            icon: 'warning',
            title: 'Tanggal Belum Dipilih',
            text: 'Silakan pilih tanggal kunjungan terlebih dahulu.',
            confirmButtonColor: '#f37021'
        });
        return false;
    }
    return true;
}
</script>
</body>
</html>