<?php
// Matikan laporan error agar tidak muncul pesan hitam-putih
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "gowisata2";

// Mencoba koneksi tapi TIDAK pakai exit() kalau gagal
$conn = @mysqli_connect($host, $user, $pass, $db);

// Kita tidak pakai IF (!$conn) EXIT di sini supaya file selanjutnya (login.php) tetap dibaca
?>