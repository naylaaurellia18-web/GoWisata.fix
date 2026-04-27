<?php
// Deteksi apakah sedang di localhost atau Vercel
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "gowisata2";
    $port = 3306;
} else {
    // DATA ASLI DARI TI DB CLOUD KAMU
    $host = "gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com"; 
    $user = "2jDX6rrVBhqHyCe.root";
    $pass = "El1txkj4jwkvAQrE";
    $db   = "gowisata-db";
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