<?php
$host = getenv('TIDB_HOST') ?: 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = getenv('TIDB_PORT') ?: '4000';
$db   = getenv('TIDB_DATABASE') ?: 'gowisata2';
$user = getenv('TIDB_USER') ?: '2TfJGdFNKpGMfMM.root';
$pass = getenv('TIDB_PASSWORD') ?: 'ZGN76i1wcAXPurFo';

$conn = mysqli_init();

// 2. WAJIB untuk TiDB: Mengaktifkan mode keamanan SSL
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// 3. Lakukan koneksi nyata dengan parameter MYSQLI_CLIENT_SSL
$koneksi_berhasil = mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

if (!$koneksi_berhasil) {
    die("Koneksi database gagal. Cek kembali Host, User, atau Password: " . mysqli_connect_error());
}

// Backup variabel agar terbaca di file lain seperti riwayat_pesanan.php
$koneksi = $conn; 
?>