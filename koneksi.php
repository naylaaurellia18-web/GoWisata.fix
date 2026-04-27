<?php
// 1. Pengaturan Error Reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// 2. Deteksi Lingkungan (Localhost vs Vercel/Produksi)
// Jika dijalankan di laptop (127.0.0.1 atau localhost)
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_NAME'] == 'localhost') {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "gowisata2";
} else {
    // JIKA DI VERCEL: Masukkan detail database online kamu di sini
    // Vercel tidak bisa akses 'localhost'
    $host = "alamat_host_database_online"; 
    $user = "username_database_online";
    $pass = "password_database_online";
    $db   = "nama_database_online";
}

try {
    // 3. Membuat Koneksi
    $conn = mysqli_connect($host, $user, $pass, $db);
    
    // Set charset agar karakter unik muncul dengan benar
    mysqli_set_charset($conn, "utf8mb4");

} catch (Exception $e) {
    // Jika gagal, jangan matikan script (die), cukup simpan pesan error ke log
    // Agar halaman login tetap bisa terbuka meskipun DB mati
    error_log("Koneksi Database Gagal: " . $e->getMessage());
    $conn = false; 
}
?>