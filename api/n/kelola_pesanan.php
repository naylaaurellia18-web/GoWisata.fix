<?php
session_start();
include 'koneksi.php';

// Opsional: Tambahkan proteksi agar hanya Admin yang bisa buka halaman ini
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
            <a href="dashboard.php" class="btn btn-primary">Ke Dashboard</a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>ID Invoice</th>
                    <th>Nama Pemesan</th>
                    <th>Destinasi</th>
                    <th>Jumlah</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Query untuk mengambil semua data pesanan
            // Gantilah $conn menjadi $koneksi jika itu yang ada di koneksi.php
            $query = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY id_pesanan DESC");
            $no = 1;

            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td class="fw-bold text-primary"><?= $row['id_pesanan'] ?></td>
                    <td><?= isset($row['nama_user']) ? $row['nama_user'] : 'Pelanggan' ?></td>
                    <td><?= $row['destinasi'] ?></td>
                    <td><?= isset($row['jumlah']) ? $row['jumlah'] : '-' ?> Tiket</td>
                    <td class="fw-bold">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                    <td><span class="badge badge-lunas"><?= $row['status'] ?></span></td>
                </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='7' class='text-center py-4 text-muted'>Belum ada transaksi masuk.</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>