<?php
// WAJIB: koneksi.php SEBELUM session_start()
include 'koneksi.php';
session_start();

// FIX: Proteksi - hanya admin yang bisa tambah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (!isset($conn)) {
    echo "<script>alert('Database tidak terhubung.'); window.location.href='kelola_admin.php';</script>";
    exit();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = mysqli_real_escape_string($conn, trim($_POST['username']));
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($user) || empty($pass)) {
        echo "<script>alert('Username dan password tidak boleh kosong!'); window.location.href='kelola_admin.php';</script>";
        exit();
    }

    // Cek apakah username sudah ada
    $cek = mysqli_query($conn, "SELECT id FROM pengguna WHERE username='$user'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah digunakan!'); window.location.href='kelola_admin.php';</script>";
        exit();
    }

    // Generate ID manual
    $res_max = mysqli_query($conn, "SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM pengguna");
    $row_max = mysqli_fetch_assoc($res_max);
    $new_id  = (int)$row_max['next_id'];

    // Simpan ke tabel pengguna dengan role=admin (bukan tabel admin terpisah)
    $query = mysqli_query($conn, "INSERT INTO pengguna (id, username, email, password, role)
                                  VALUES ('$new_id', '$user', '', '$pass', 'admin')");

    if ($query) {
        echo "<script>alert('Admin berhasil ditambahkan!'); window.location.href='kelola_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . addslashes(mysqli_error($conn)) . "'); window.location.href='kelola_admin.php';</script>";
    }
} else {
    header("Location: kelola_admin.php");
    exit();
}