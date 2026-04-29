<?php
// ORDER FIX: include koneksi SEBELUM session_start
// Tanpa ini, session di TiDB tidak ter-destroy dengan benar di Vercel
include 'koneksi.php';
session_start();
session_unset(); // Menghapus semua variabel session
session_destroy(); // Menghancurkan session

// Arahkan kembali ke halaman login atau index
header("Location: index.html");
exit();
?>