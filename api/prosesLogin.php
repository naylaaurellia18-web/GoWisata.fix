<?php
include 'koneksi.php';
session_start();

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    // Menggunakan tabel 'pengguna' sesuai database yang berhasil dibuat
    $query = mysqli_query($conn, "SELECT * FROM pengguna WHERE username='$user' AND password='$pass'");
    
    if (!$query) {
        die("Query gagal: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        $_SESSION['role'] = $data['role'];
        $_SESSION['user'] = $data['username'];
        
        if ($data['role'] == "admin") {
            header("location:admin_dashboard.php");
        } else {
            header("location:index.html");
        }
        exit();
    } else {
        echo "<script>alert('Username atau Password Salah!');</script>";
    }
}
?><?php
session_start();
include 'koneksi.php';

// Cek apakah koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    // Ambil data dari form
    $user = isset($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($user) && !empty($pass)) {
        // Query mencari pengguna
        $sql = "SELECT * FROM pengguna WHERE username='$user' AND password='$pass'";
        $query = mysqli_query($conn, $sql);
        
        if (!$query) {
            die("Query gagal: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            $_SESSION['role'] = $data['role'];
            $_SESSION['user'] = $data['username'];
            
            // Redirect sesuai role
            if ($data['role'] == "admin") {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.html");
            }
            exit();
        } else {
            echo "<script>alert('Username atau Password Salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Isi semua kolom!'); window.location='login.php';</script>";
    }
}
?>