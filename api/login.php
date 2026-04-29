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
        .btn-primary:hover { background-color: #d65d1a; }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card card-login p-4" style="width:400px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold">🌍 GoWisata</h2>
            <p class="text-muted">Masuk untuk menjelajahi Indonesia</p>
        </div>
        
        <div class="d-flex justify-content-center gap-2 mb-4">
            <button class="btn btn-sm px-4 btn-primary text-white" id="btnLoginTab" onclick="showLogin()">Login</button>
            <button class="btn btn-sm px-4 btn-outline-warning" id="btnRegTab" onclick="showRegister()">Register</button>
        </div>

        <form id="loginForm" action="prosesLogin.php" method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">MASUK KE DASHBOARD</button>
            <div class="text-center mt-3">
                <!-- BUG #5 FIX: Sebelumnya href="index.html class= (quote tidak ditutup sebelum spasi)
                     Ini menyebabkan tombol "Kembali ke Beranda" tidak berfungsi -->
                <a href="index.html" class="text-decoration-none small text-muted">← Kembali ke Beranda</a>
            </div>
        </form>

        <form id="registerForm" action="proses_register.php" method="POST" style="display:none;">
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username Baru" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email Aktif" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password Baru" required>
            </div>
            <!-- SECURITY FIX: Role admin tidak boleh bisa dipilih dari form publik.
                 Pendaftaran admin hanya boleh dilakukan langsung di database.
                 Role selalu dikunci menjadi 'user' oleh proses_register.php -->
            <input type="hidden" name="role" value="user">
            <button type="submit" name="register" class="btn btn-warning w-100 text-white fw-bold py-2 shadow-sm">DAFTAR AKUN</button>
        </form>
    </div>
</div>

<script>
    function showRegister() {
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('registerForm').style.display = 'block';
        document.getElementById('btnRegTab').classList.add('btn-primary', 'text-white');
        document.getElementById('btnRegTab').classList.remove('btn-outline-warning');
        document.getElementById('btnLoginTab').classList.add('btn-outline-warning');
        document.getElementById('btnLoginTab').classList.remove('btn-primary', 'text-white');
    }
    function showLogin() {
        document.getElementById('loginForm').style.display = 'block';
        document.getElementById('registerForm').style.display = 'none';
        document.getElementById('btnLoginTab').classList.add('btn-primary', 'text-white');
        document.getElementById('btnLoginTab').classList.remove('btn-outline-warning');
        document.getElementById('btnRegTab').classList.add('btn-outline-warning');
        document.getElementById('btnRegTab').classList.remove('btn-primary', 'text-white');
    }
</script>

</body>
</html>