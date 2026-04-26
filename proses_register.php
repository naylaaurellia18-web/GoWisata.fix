<?php
include 'koneksi.php'; // Pastikan file koneksi.php ada di folder yang sama

if (isset($_POST['register'])) {
    // Ambil data dari form login.php
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role     = $_POST['role'];

    // Query masukkan data
    $query = "INSERT INTO pengguna (username, email, password, role) 
              VALUES ('$username', '$email', '$password', '$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
    } else {
        echo "Gagal daftar: " . mysqli_error($conn);
    }
}
?>