<?php
include 'koneksi.php';

// Tambahkan kode ini agar tidak Fatal Error di Vercel
if (!$conn || $conn === true) {
    echo "<script>
            alert('Fitur Register hanya dapat digunakan di Localhost (XAMPP) karena database Cloud belum terhubung.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

// ... sisa kode kamu yang ada mysqli_real_escape_string dan lain-lain ...
?>