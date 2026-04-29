<?php
// ORDER FIX: include koneksi SEBELUM session_start
include 'koneksi.php';
session_start();

$db = isset($koneksi) ? $koneksi : $conn;

if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("location:login.php");
    exit();
}

// Proses Hapus User
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($db, $_GET['hapus']);
    // Cek kolom ID yang benar (id atau id_pengguna)
    mysqli_query($db, "DELETE FROM pengguna WHERE (id_pengguna='$id_hapus' OR id='$id_hapus') AND role='user'");
    header("location:kelola_user.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h3 class="fw-bold">👥 Daftar Pelanggan</h3>
        <a href="admin_dashboard.php" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card shadow-sm border-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="ps-4">Username</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($db, "SELECT * FROM pengguna WHERE role='user'");
                
                while($row = mysqli_fetch_assoc($res)) {
                    // DETEKSI OTOMATIS: Mencari kolom ID yang tersedia
                    $id_u = "";
                    if(isset($row['id_pengguna'])) { $id_u = $row['id_pengguna']; }
                    elseif(isset($row['id'])) { $id_u = $row['id']; }
                    elseif(isset($row['id_user'])) { $id_u = $row['id_user']; }
                    
                    $nama_u = $row['username'];
                ?>
                <tr class="align-middle">
                    <td class="ps-4"><?php echo $nama_u; ?></td>
                    <td><span class="badge bg-info text-dark">Pelanggan</span></td>
                    <td class="text-center">
                        <?php if($id_u != ""): ?>
                            <a href="kelola_user.php?hapus=<?php echo $id_u; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Yakin hapus user <?php echo $nama_u; ?>?')">
                               Hapus
                            </a>
                        <?php else: ?>
                            <span class="text-danger small">Kolom ID tak ditemukan</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>