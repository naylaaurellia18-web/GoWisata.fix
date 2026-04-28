<?php
include 'koneksi.php';
session_start();

if (isset($_POST['login'])) {
    // Memastikan koneksi $conn tersedia dari koneksi.php
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password']; // Jika password di database di-hash, gunakan password_verify nantinya

    // Menggunakan tabel 'pengguna'
    $query = mysqli_query($conn, "SELECT * FROM pengguna WHERE username='$user' AND password='$pass'");
    
    if (!$query) {
        die("Query gagal: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // Set session sesuai kebutuhan dashboard.php kamu
        $_SESSION['status']   = "login";
        $_SESSION['role']     = $data['role'];
        $_SESSION['username'] = $data['username']; 
        
        if ($data['role'] == "admin") {
            header("location:admin_dashboard.php");
        } else {
            header("location:dashboard.php");
        }
        exit();
    } else {
        echo "<script>alert('Username atau Password Salah!'); window.location.href='index.html';</script>";
    }
}
?>