<?php
// Gunakan environment variable dari Vercel
$host = getenv('TIDB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = getenv('TIDB_PORT') ?: '4000';
$user = getenv('TIDB_USER') ?: '2TfJGdFNKpGMfMM.root';
$pass = getenv('TIDB_PASSWORD') ?: '';
$db   = getenv('TIDB_DATABASE') ?: 'gowisata2';

// Aktifkan pelaporan error
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Buat koneksi dengan port
$conn = new mysqli($host, $user, $pass, $db, (int)$port);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Wajib: Aktifkan SSL untuk TiDB Cloud
$conn->ssl_set(NULL, NULL, NULL, NULL, NULL);
$conn->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);

echo "Koneksi berhasil!";
?>
