<?php
// Matikan laporan error agar tidak muncul pesan hitam-putih
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "gowisata2";

// Mencoba koneksi tapi TIDAK pakai exit() atau die()
$conn = @mysqli_connect($host, $user, $pass, $db);

// Biarkan kosong di bawah sini agar login.php bisa tampil
?>