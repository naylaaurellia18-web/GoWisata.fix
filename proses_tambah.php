<?php
// 1. WAJIB: Panggil file koneksi di baris paling atas
include "koneksi.php"; 

// 2. Ambil data dari form
$user = $_POST['username'];
$pass = $_POST['password'];

// 3. Jalankan query (Sekarang $koneksi sudah dikenali)
$query = mysqli_query($conn , "INSERT INTO admin (username, password) VALUES ('$user', '$pass')");

if($query){
    echo "<script>alert('Data Berhasil Disimpan'); window.location.href='kelola_admin.php';</script>";
} else {
    echo "Gagal menyimpan: " . mysqli_error($conn );
}
?>