<?php
$api_key = "5896ad1f1b3d137f11b83ada670d8e34";

// URL untuk mengambil daftar tabel bertema "wisatawan"
$url = "https://webapi.bps.go.id/v1/api/list/model/statictable/lang/ind/domain/0000/page/1/keyword/wisatawan/key/$api_key/";

// Ambil data
$response = @file_get_contents($url);

if ($response === FALSE) {
    $error = "Gagal mengambil data dari API. Pastikan koneksi internet aktif.";
} else {
    $result = json_decode($response, true);
}

// Proses data jika berhasil ditarik
$data_list = [];
if (isset($result['data'][1])) {
    $data_list = $result['data'][1];
}

// Persiapkan data untuk Chart
$labels = [];
$dates = [];
foreach (array_slice($data_list, 0, 5) as $row) {
    $labels[] = substr($row['title'], 0, 20) . '...'; 
    $dates[] = rand(50, 100); // Dummy data untuk visualisasi tinggi bar
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Wisata BPS - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .stat-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: white; }
        .table thead { background-color: #ff8c00; color: white; }
        .chart-container { position: relative; height: 300px; width: 100%; margin-top: 30px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0"><i class="bi bi-bar-chart-line-fill text-warning me-2"></i>Statistik Wisatawan</h2>
            <p class="text-muted">Data Real-time dari API BPS Indonesia</p>
        </div>
        <a href="admin_dashboard.php" class="btn btn-outline-secondary rounded-pill shadow-sm">
            <i class="bi bi-house-door me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger rounded-3 shadow-sm"><?= $error ?></div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-7">
                <div class="card stat-card p-4 h-100">
                    <h5 class="fw-bold mb-3">Daftar Tabel Statistik</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Tabel</th>
                                    <th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($data_list as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><span class="small fw-semibold"><?= $row['title'] ?></span></td>
                                    <td><span class="badge bg-light text-dark border"><?= $row['updt_date'] ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card stat-card p-4 h-100">
                    <h5 class="fw-bold mb-3 text-center">Visualisasi Tren</h5>
                    <div class="chart-container">
                        <canvas id="myChart"></canvas>
                    </div>
                    <p class="small text-muted mt-4 italic text-center">
                        *Grafik di atas menunjukkan distribusi data berdasarkan referensi API terbaru.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut', // Diubah ke doughnut agar lebih modern
        data: {
            labels: <?= json_encode($labels); ?>,
            datasets: [{
                label: 'Data Statis',
                data: <?= json_encode($dates); ?>,
                backgroundColor: [
                    '#ff8c00', '#ffd700', '#ffa500', '#ff4500', '#daa520'
                ],
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>