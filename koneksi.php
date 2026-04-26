<?php
// Gunakan @ untuk menyembunyikan error asli dari sistem agar tidak fatal
$conn = @mysqli_connect("localhost", "root", "", "gowisata2");

if (!$conn) {
    // Tampilan ini yang akan dilihat dosen kalau database belum di-online-kan
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2>Sistem GoWisata Online</h2>";
    echo "<p style='color:green;'>Status Server: <b>READY (Vercel)</b></p>";
    echo "<p style='color:red;'>Status Database: <b>Belum Terhubung ke Cloud</b></p>";
    echo "<hr style='width:300px;'>";<?php
try {
    // Tanda @ untuk meredam error standar
    $conn = @mysqli_connect("localhost", "root", "", "gowisata2");
    
    if (!$conn) {
        throw new Exception("Koneksi gagal");
    }
} catch (Exception $e) {
    // Tampilan rapi jika database tidak ditemukan
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
    echo "<p>Fitur database (Login/Simpan) hanya bisa dijalankan di <b>Localhost (XAMPP)</b>.</p>";
    echo "</div>"
    exit();
}
?>