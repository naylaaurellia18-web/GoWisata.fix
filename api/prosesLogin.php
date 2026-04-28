<?php
include 'koneksi.php';
session_start();

if (isset($_POST['login'])) {
    // Pastikan variabel $conn di koneksi.php sudah benar
    // Jika masih error di baris ini, cek file koneksi.php kamu
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM pengguna WHERE username='$user' AND password='$pass'");
    
    if (!$query) {
        die("Query gagal: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // Set session sesuai kebutuhan dashboard
        $_SESSION['status']   = "login";
        $_SESSION['role']     = $data['role'];
        $_SESSION['username'] = $data['username']; // Digunakan oleh dashboard
        
        if ($data['role'] == "admin") {
            header("location:admin_dashboard.php");
        } else {
            // Diarahkan ke dashboard.php, bukan index.html agar data session terbaca
            header("location:dashboard.php");
        }
        exit();
    } else {
        echo "<script>alert('Username atau Password Salah!'); window.location.href='login.php';</script>";
    }
}
?>