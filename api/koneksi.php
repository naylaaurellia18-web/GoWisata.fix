<?php
$host = getenv('TIDB_HOST') ?: 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = getenv('TIDB_PORT') ?: '4000';
$db   = getenv('TIDB_DATABASE') ?: 'go-wisata';
$user = getenv('TIDB_USER') ?: '2TfJGdFNKpGMfMM.root';
$pass = getenv('TIDB_PASSWORD') ?: 'ZGN76i1wcAXPurFo';

// Data Source Name (DSN)
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

// Opsi PDO untuk mengaktifkan SSL dan memverifikasi sertifikat server
$options = [
    PDO::MYSQL_ATTR_SSL_CA => '/etc/ssl/certs/ca-certificates.crt', // Atau path CA Bundle Anda
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi PDO berhasil!";
} catch (PDOException $e) {
    die("Koneksi PDO gagal: " . $e->getMessage());
}
?>
