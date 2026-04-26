<?php
// Mencegah PHP melemparkan exception otomatis agar tidak Fatal Error
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "gowisata2";

$conn = @mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif; padding:20px; border:1px solid #ddd; display:inline-block;'>";
    echo "<h2 style='color:#2c3e50;'>Sistem GoWisata</h2>";
    echo "<p style='color:green;'>Server Status: <b>Online (Vercel)</b></p>";
    echo "<p style='color:orange;'>Database: <b>Mode Offline / Localhost</b></p>";
    echo "<hr>";
    echo "<p>Web berhasil dijalankan di cloud. Untuk akses database lengkap, jalankan via XAMPP.</p>";
    echo "</div>";
    exit();
}
?>