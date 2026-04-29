<?php
session_start();
include 'koneksi.php';

// BUG #1 FIX: Sebelumnya cek $pdo padahal koneksi.php pakai mysqli ($conn)
// Akibatnya login SELALU gagal karena $pdo tidak pernah ada
if (!isset($conn)) {
    echo "<script>
            alert('Gagal login: Database Cloud belum terhubung. Periksa file koneksi.php.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

if (isset($_POST['login'])) {
    // BUG #2 FIX: Sebelumnya pakai PDO (prepare/bindParam/execute)
    // padahal koneksi.php pakai mysqli — ini menyebabkan Fatal Error
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $sql    = "SELECT * FROM pengguna WHERE username = '$user' AND password = '$pass'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        $_SESSION['status']   = "login";
        $_SESSION['role']     = $data['role'];
        // BUG #3 FIX: Set KEDUA variabel supaya semua file bisa baca session
        // Sebelumnya hanya set 'username', tapi banyak file cek $_SESSION['user']
        $_SESSION['username'] = $data['username'];
        $_SESSION['user']     = $data['username'];

        if ($data['role'] == "admin") {
            header("location:admin_dashboard.php");
        } else {
            header("location:dashboard.php");
        }
        exit();
    } else {
        // BUG #4 FIX: Sebelumnya redirect ke index.html, harusnya ke login.php
        echo "<script>alert('Username atau Password Salah!'); window.location.href='login.php';</script>";
    }
}
?>