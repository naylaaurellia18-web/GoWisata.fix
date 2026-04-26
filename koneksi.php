<?php
// Mendefinisikan parameter koneksi database
$host     = "localhost";
$user     = "root";
$password = "";
$database = "gowisata2";

// Membuat koneksi ke MySQL menggunakan fungsi mysqli_connect
$conn = mysqli_connect($host, $user, $password, $database);

// Melakukan pengecekan apakah koneksi berhasil atau gagal
if (!$conn) {
    // Jika gagal, hentikan program dan tampilkan pesan error
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>