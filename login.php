<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if (!empty($user) && !empty($pass)) {
        $_SESSION['status'] = "login";
        $_SESSION['username'] = $user;
        echo "<script>window.location.href='dashboard.php';</script>";
        exit();
        if (!$conn) {
    echo "Maaf, server sedang gangguan (Database tidak terhubung).";
} else {
    // Jalankan query login di sini
}
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoWisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f37021 0%, #ffba42 100%); min-height: 100vh; }
        .card-login { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .btn-primary { background-color: #f37021; border: none; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card card-login p-4" style="width:400px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold">🌍 GoWisata</h2>
            <p class="text-muted">Masuk ke Dashboard</p>
        </div>
        <form id="loginForm" method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold text-white">MASUK KE DASHBOARD</button>
            <div class="text-center mt-3">
                <a href="index.html" class="text-decoration-none small text-muted">← Kembali ke Beranda</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>