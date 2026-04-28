<?php
$host = "gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com"; 
$user = "2TfJGdFNKpGMfMM.root";
$pass = "El1txkj4jwkvAQrE";
$db   = "gowisata2";
$port = 4000;

// Membuat koneksi dengan dukungan SSL (Wajib untuk TiDB Cloud)
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL); 

if (!mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL)) {
    die("Koneksi ke TiDB Cloud gagal: " . mysqli_connect_error());
}
?>