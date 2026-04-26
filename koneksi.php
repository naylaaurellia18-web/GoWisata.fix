<?php
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "gowisata2";

// Mencoba koneksi
$conn = @mysqli_connect($host, $user, $pass, $db);

// Jika gagal (seperti di Vercel), tampilkan pesan profesional
if (!$conn) {
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif; padding:20px; border:1px solid #ddd; display:inline-block; border-radius:10px;'>";
    echo "<h2 style='color:#2c3e50;'>Sistem GoWisata</h2>";
    echo "<p style='color:green;'>Server Status: <b>Online (Vercel)</b></p>";
    echo "<p style='color:orange;'>Database Status: <b>Mode Localhost</b></p>";
    echo "<hr>";
    echo "<p>Web berhasil dideploy. Untuk fitur database lengkap, silakan jalankan via XAMPP.</p>";
    echo "</div>";
    exit();
}
?>