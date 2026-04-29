<?php
// ORDER FIX: include koneksi SEBELUM session_start
include 'koneksi.php';
session_start();

// BUG #12 FIX: Sebelumnya tidak ada proteksi sama sekali — siapa saja bisa
// buka halaman ini tanpa login. Sekarang ditambahkan pengecekan role admin.
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("location:login.php");
    exit();
}

$db = isset($conn) ? $conn : (isset($koneksi) ? $koneksi : null);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - Admin GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .table-container { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .badge-lunas { background-color: #28a745; color: white; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📊 Riwayat Pesanan Masuk</h2>
        <div>
            <a href="kelola_destinasi.php" class="btn btn-outline-dark">Kelola Destinasi</a>
            <a href="admin_dashboard.php" class="btn btn-primary">Ke Dashboard</a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>No. Invoice</th>
                    <th>Nama Pemesan</th>
                    <th>Destinasi</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Gunakan tabel riwayat_transaksi yang konsisten dengan file lain
            $query = mysqli_query($db, "SELECT * FROM riwayat_transaksi ORDER BY tanggal DESC");
            $no = 1;

            if ($query && mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="fw-bold text-primary">#<?= htmlspecialchars($row['no_invoice']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['destinasi']) ?></td>
                    <td class="fw-bold">Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                    <td><span class="badge bg-success"><?= htmlspecialchars($row['status']) ?></span></td>
                </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='6' class='text-center py-4 text-muted'>Belum ada transaksi masuk.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>