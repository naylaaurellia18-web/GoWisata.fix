<?php
// Deteksi apakah sedang di localhost atau Vercel
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "gowisata2";
    $port = 3306;
} else {
    // ISI DENGAN DATA DARI DASHBOARD TIDB CLOUD KAMU
    $host = "masukkan-host-tidb-kamu"; 
    $user = "masukkan-user-tidb-kamu";
    $pass = "masukkan-password-tidb-kamu";
    $db   = "test"; // Database default TiDB biasanya 'test'
    $port = 4000;
}

try {
    // Menambahkan variabel port khusus untuk TiDB
    $conn = mysqli_connect($host, $user, $pass, $db, $port);
} catch (Exception $e) {
    error_log("Koneksi Gagal: " . $e->getMessage());
    $conn = false;
}
?>