<?php
// SECURITY FIX: Sebelumnya tidak ada session_start() dan cek role sama sekali.
// Siapapun bisa buka halaman ini dan melihat seluruh log aktivitas user & admin.
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
    header("location:login.php");
    exit();
}
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Log Aktivitas Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="fw-bold mb-4">📜 Log Aktivitas User & Admin</h2>
    
    <div class="card shadow border-0">
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM log_aktivitas ORDER BY waktu DESC");
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold"><?= $row['username'] ?></td>
                        <td>
                            <span class="badge <?= $row['role'] == 'admin' ? 'bg-danger' : 'bg-primary' ?>">
                                <?= strtoupper($row['role']) ?>
                            </span>
                        </td>
                        <td><?= $row['aktivitas'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['waktu'])) ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>