<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();
$db = $conn;

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Logika Hapus
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus']; // FIX: cast ke int, lebih aman dari escape string
    mysqli_query($db, "DELETE FROM destinasi WHERE id_destinasi = $id");
    header("Location: kelola_destinasi.php");
    exit();
}

// Ambil semua destinasi
$result = mysqli_query($db, "SELECT * FROM destinasi ORDER BY id_destinasi ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Destinasi - Admin GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color:#f8f9fa; }
        .navbar-admin { background:#f37021; }
        .card { border-radius:15px; border:none; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-admin shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="admin_dashboard.php">🛠 Admin GoWisata</a>
        <a href="admin_dashboard.php" class="btn btn-light btn-sm rounded-pill px-3">Kembali</a>
    </div>
</nav>

<div class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manajemen Destinasi</h2>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-2"></i>Tambah Wisata
        </button>
    </div>

    <?php if (isset($_GET['sukses'])): ?>
        <div class="alert alert-success">Destinasi berhasil ditambahkan!</div>
    <?php endif; ?>

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
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td class="ps-4 fw-bold"><?= htmlspecialchars($row['nama_destinasi']); ?></td>
                        <td><i class="bi bi-geo-alt text-danger me-1"></i><?= htmlspecialchars($row['lokasi'] ?? ''); ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td class="text-center">
                            <a href="?hapus=<?= (int)$row['id_destinasi']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin hapus destinasi ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='4' class='text-center py-4 text-muted'>Belum ada destinasi. Tambah sekarang!</td></tr>";
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Destinasi -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Destinasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- FIX: action ke proses_tambah_destinasi.php, method POST -->
            <form action="proses_tambah_destinasi.php" method="POST">
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
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Tiket (Rp)</label>
                        <input type="number" name="harga" class="form-control" min="1000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- FIX: name="simpan" sesuai yang dicek di proses_tambah_destinasi.php -->
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan Wisata</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>