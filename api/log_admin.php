<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();

// SECURITY FIX: Hanya admin yang bisa lihat log
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); exit();
}

$db = $conn;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Log Aktivitas - GoWisata Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">📜 Log Aktivitas</h2>
        <a href="admin_dashboard.php" class="btn btn-outline-secondary btn-sm">← Dashboard</a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr><th>No</th><th>Username</th><th>Role</th><th>Aktivitas</th><th>Waktu</th></tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($db, "SELECT * FROM log_aktivitas ORDER BY waktu DESC LIMIT 100");
                $no    = 1;
                if ($query && mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($row['username']); ?></td>
                        <td>
                            <span class="badge <?= $row['role'] === 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                <?= strtoupper(htmlspecialchars($row['role'])); ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['aktivitas']); ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['waktu'])); ?></td>
                    </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada log aktivitas.</td></tr>";
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>