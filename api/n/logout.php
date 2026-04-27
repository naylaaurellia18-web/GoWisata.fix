<?php
session_start(); // Memulai session agar bisa dihapus
session_unset(); // Menghapus semua variabel session
session_destroy(); // Menghancurkan session

// Arahkan kembali ke halaman login atau index
header("Location: index.html");
exit();
?>