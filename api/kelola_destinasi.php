<?php
session_start();
include 'koneksi.php';
$db = isset($koneksi) ? $koneksi : $conn;

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("location:login.php");
    exit();
}

// --- LOGIKA HAPUS DESTINASI ---
if (isset($_GET['hapus'])) {
    // SQL INJECTION FIX: Sebelumnya $_GET['hapus'] langsung dimasukkan ke query
    // tanpa di-escape sama sekali — ini celah SQL Injection yang berbahaya.
    $id = mysqli_real_escape_string($db, $_GET['hapus']);
    mysqli_query($db, "DELETE FROM destinasi WHERE id_destinasi = '$id'");
    header("location:kelola_destinasi.php");
    exit();
}

// --- AMBIL DATA DESTINASI ---
$query = "SELECT * FROM destinasi";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Destinasi - Admin GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-admin { background: #f37021; }
        .card { border-radius: 15px; border: none; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-admin shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="admin_dashboard.php">🛠 Admin GoWisata</a>
        <a href="admin_dashboard.php" class="btn btn-light btn-sm rounded-pill px-3">Kembali</a>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manajemen Destinasi</h2>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-2"></i>Tambah Wisata
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Nama Wisata</th>
                        <th>Lokasi</th>
                        <th>Harga Tiket</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="ps-4 fw-bold"><?= $row['nama_destinasi']; ?></td>
                        <td><i class="bi bi-geo-alt text-danger me-1"></i><?= $row['lokasi']; ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td class="text-center">
                            <a href="edit_destinasi.php?id=<?= $row['id_destinasi']; ?>" class="btn btn-warning btn-sm text-white">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <a href="?hapus=<?= $row['id_destinasi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus wisata ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Destinasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="tambah_destinasi.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Destinasi</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Tiket</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Wisata</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>