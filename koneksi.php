<?php
// Mencegah error fatal agar tampilan tetap rapi
mysqli_report(MYSQLI_REPORT_OFF);

// Masukkan data dari TiDB Cloud di sini
$host = "MASUKKAN_HOST_DISINI";
$user = "MASUKKAN_USER_DISINI";
$pass = "MASUKKAN_PASSWORD_YANG_KAMU_GENERATE";
$db   = "test"; // Secara default TiDB pakai nama 'test', nanti bisa kita ubah
$port = 4000;

// Koneksi menggunakan SSL (Wajib untuk TiDB Cloud)
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
$success = mysqli_real_connect($conn, $host, $user, $pass, $db, $port);

if (!$success) {
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2>Sistem GoWisata</h2>";
    echo "<p style='color:red;'>Koneksi Cloud Gagal: " . mysqli_connect_error() . "</p>";
    echo "</div>";
    exit();
}
?>