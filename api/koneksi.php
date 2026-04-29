<?php
$host = getenv('TIDB_HOST') ?: 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = getenv('TIDB_PORT') ?: '4000';
$db   = getenv('TIDB_DATABASE') ?: 'gowisata2';
$user = getenv('TIDB_USER') ?: '2TfJGdFNKpGMfMM.root';
$pass = getenv('TIDB_PASSWORD') ?: 'ZGN76i1wcAXPurFo';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

// Mengecek apakah koneksi berhasil
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Membuat cadangan nama variabel agar tidak error di file riwayat_pesanan.php
$koneksi = $conn; 
?>
