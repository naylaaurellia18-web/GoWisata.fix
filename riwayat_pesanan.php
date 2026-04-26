<?php 
session_start();
include 'koneksi.php'; 

// Menggunakan variabel koneksi yang fleksibel ($db atau $koneksi)
$db = isset($conn) ? $conn : $koneksi;

// Cek apakah user sudah login
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$username_login = $_SESSION['user'];

// Query mengambil data dari tabel 'riwayat_transaksi' sesuai database kamu
$sql = "SELECT * FROM riwayat_transaksi WHERE username = '$username_login' ORDER BY tanggal DESC";
$query = mysqli_query($db, $sql);

if (!$query) {
    die("Gagal mengambil data: " . mysqli_error($db)); 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .card-custom { border-radius: 15px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .btn-back { border-radius: 10px; font-weight: 600; transition: 0.3s; }
        .btn-back:hover { transform: translateX(-5px); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">📋 Riwayat Pesanan Anda</h2>
            <p class="text-muted">Halo, <?= $username_login; ?>! Berikut daftar perjalananmu.</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary btn-back px-4 shadow-sm">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="card card-custom">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">No. Invoice</th>
                            <th>Destinasi</th>
                            <th>Tanggal</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($query) > 0) {
                            while($data = mysqli_fetch_assoc($query)) { 
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#<?= $data['no_invoice']; ?></td>
                            <td><?= $data['destinasi']; ?></td>
                            <td><?= date('d M Y', strtotime($data['tanggal'])); ?></td>
                            <td class="fw-bold text-success">Rp <?= number_format($data['total_bayar'], 0, ',', '.'); ?></td>
                            <td>
                                <span class="badge bg-success">
                                    <?= $data['status']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="cetak_tiket.php?id=<?= $data['no_invoice']; ?>" class="btn btn-sm btn-primary px-3 shadow-sm">Cetak Tiket</a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } else {
                            echo "<tr><td colspan='6' class='text-center text-muted py-5'>Belum ada riwayat pemesanan untuk akun <b>$username_login</b>.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="destinasi.php" class="btn btn-primary px-5 py-2 shadow fw-bold">Tambah Pesanan Baru</a>
    </div>
</div>

</body>
</html>