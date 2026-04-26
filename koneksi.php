<?php
// Gunakan @ untuk menyembunyikan error asli dari sistem agar tidak fatal
$conn = @mysqli_connect("localhost", "root", "", "gowisata2");

if (!$conn) {
    // Tampilan ini yang akan dilihat dosen kalau database belum di-online-kan
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2>Sistem GoWisata Online</h2>";
    echo "<p style='color:green;'>Status Server: <b>READY (Vercel)</b></p>";
    echo "<p style='color:red;'>Status Database: <b>Belum Terhubung ke Cloud</b></p>";
    echo "<hr style='width:300px;'>";
    echo "<p>Fitur database (Login/Simpan) hanya bisa dijalankan di <b>Localhost (XAMPP)</b>.</p>";
    echo "</div>";
    exit();
}
?>