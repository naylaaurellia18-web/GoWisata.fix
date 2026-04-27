<?php
// Matikan laporan error supaya tampilan web tetap bersih di Vercel
mysqli_report(MYSQLI_REPORT_OFF);

// Biarkan localhost saja, Vercel akan otomatis menganggap koneksi ini gagal
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gowisata2";

// Mencoba koneksi dengan tanda @ (artinya: jangan tampilkan error kalau gagal)
$conn = @mysqli_connect($host, $user, $pass, $db);

// PENTING: Jangan pakai exit() atau die() di sini
// Biarkan script lanjut supaya login.php tetap bisa tampil
?>