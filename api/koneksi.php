<?php
// Deteksi apakah sedang di localhost atau Vercel
if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || $_SERVER['SERVER_NAME'] == 'localhost') {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "gowisata2";
    $port = 3306;
} else {
    // DATA ASLI DARI TI DB CLOUD
    $host = "gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com"; 
    $user = "2TfJGdFNKpGMfMM.root";
    $pass = "XN6skrhyza9SU2zX";
    $db   = "gowisata2";
    $port = 4000; 
}

// Gunakan koneksi biasa tanpa try-catch untuk mysqli jika ingin simpel, 
// atau biarkan seperti di bawah agar tidak fatal error
$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    error_log("Koneksi Gagal: " . mysqli_connect_error());
}
?>