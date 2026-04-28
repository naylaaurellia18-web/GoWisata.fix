<?php
include 'koneksi.php';
session_start();

// Validasi tambahan: Pastikan koneksi tersedia
if (!$conn) {
    die("Error: Koneksi database tidak ditemukan. Periksa file koneksi.php");
}

if (isset($_POST['login'])) {
    // Sekarang $conn dipastikan bukan 'false'
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM pengguna WHERE username='$user' AND password='$pass'");
    
    if (!$query) {
        die("Query gagal: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['status'] = "login";
        $_SESSION['role'] = $data['role'];
        $_SESSION['username'] = $data['username'];
        
        if ($data['role'] == "admin") {
            header("location:admin_dashboard.php");
        } else {
            header("location:dashboard.php");
        }
        exit();
    } else {
        echo "<script>alert('Username atau Password Salah!'); window.location.href='login.php';</script>";
    }
}
?>