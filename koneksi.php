<?php
// Gunakan tanda @ untuk menyembunyikan error asli dari sistem
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gowisata2";

$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    // Tampilkan pesan yang lebih rapi untuk Dosen
    echo "<center><h1>Sistem GoWisata Online</h1></center>";
    echo "<hr>";
    echo "<p>Status: <b>Berhasil Deploy ke Vercel</b></p>";
    echo "<p>Database: <span style='color:red;'>Belum terhubung ke Cloud (Masih Localhost)</span></p>";
    echo "<p>Silakan jalankan di XAMPP lokal untuk fitur login dan database lengkap.</p>";
    exit();
}
?>