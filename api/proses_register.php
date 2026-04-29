<?php
// ORDER FIX: include koneksi SEBELUM session_start
include 'koneksi.php';
session_start();

if (!isset($conn)) {
    echo "<script>
            alert('Database Cloud belum terhubung. Periksa file koneksi.php.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // SECURITY FIX: Role TIDAK BOLEH diambil dari $_POST (bisa dimanipulasi hacker).
    // Selalu hardcode 'user' untuk pendaftaran publik.
    $role = 'user';

    // Validasi: username tidak boleh kosong
    if (empty($username) || empty($password)) {
        echo "<script>alert('Username dan Password tidak boleh kosong!'); window.location.href='login.php';</script>";
        exit();
    }

    // Cek apakah username sudah dipakai
    $cek = mysqli_query($conn, "SELECT id FROM pengguna WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan! Silakan pilih username lain.'); window.location.href='login.php';</script>";
        exit();
    }

    // Simpan user baru ke database
    $sql = "INSERT INTO pengguna (username, email, password, role) 
            VALUES ('$username', '$email', '$password', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Akun berhasil dibuat! Silakan login.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal membuat akun: " . mysqli_error($conn) . "');
                window.location.href = 'login.php';
              </script>";
    }
} else {
    // Jika diakses langsung tanpa form
    header("Location: login.php");
    exit();
}
?>