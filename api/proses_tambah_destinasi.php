<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $lokasi = $_POST['lokasi'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO destinasi (nama, lokasi, deskripsi, harga) 
              VALUES ('$nama', '$lokasi', '$deskripsi', '$harga')";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_destinasi.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>