<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();

// FIX: Proteksi - hanya admin yang bisa tambah destinasi
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($conn)) {
    echo "<script>alert('Database tidak terhubung.'); window.location.href='kelola_destinasi.php';</script>";
    exit();
}

if (isset($_POST['simpan'])) {
    $nama      = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $lokasi    = mysqli_real_escape_string($conn, trim($_POST['lokasi']));
    $deskripsi = mysqli_real_escape_string($conn, trim($_POST['deskripsi'] ?? ''));
    $harga     = (int)$_POST['harga'];

    if (empty($nama) || $harga <= 0) {
        echo "<script>alert('Nama dan harga tidak boleh kosong!'); window.location.href='kelola_destinasi.php';</script>";
        exit();
    }

    // FIX: Kolom pakai nama_destinasi (sesuai CREATE TABLE di koneksi.php)
    $query = "INSERT INTO destinasi (nama_destinasi, lokasi, deskripsi, harga)
              VALUES ('$nama', '$lokasi', '$deskripsi', '$harga')";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_destinasi.php");
    } else {
        echo "<script>alert('Gagal simpan: " . addslashes(mysqli_error($conn)) . "'); window.location.href='kelola_destinasi.php';</script>";
    }
} else {
    header("Location: kelola_destinasi.php");
}