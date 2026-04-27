<?php
// Deteksi apakah sedang di localhost atau Vercel
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "gowisata2";
    $port = 3306;
} else {
    // GANTI DENGAN DATA ASLI DARI TIDB
    $host = "gateway01.ap-southeast-1.prod.aws.tidbcloud.com"; // Contoh host
    $user = "xxxxxx.root"; // Contoh user
    $pass = "password_kamu"; // Contoh password
    $db   = "gowisata-db"; 
    $port = 4000;
}
// ... sisa kode di bawahnya ...

try {
    // Menambahkan variabel port khusus untuk TiDB
    $conn = mysqli_connect($host, $user, $pass, $db, $port);
} catch (Exception $e) {
    error_log("Koneksi Gagal: " . $e->getMessage());
    $conn = false;
}
?>