<?php
session_start();
include 'koneksi.php';

// Ubah pengecekan dari $conn menjadi $pdo
if (!isset($pdo)) {
    echo "<script>
            alert('Gagal login: Database Cloud belum terhubung. Periksa file koneksi.php.');
            window.location.href = 'login.php';
          </script>";
    exit();
}

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Menggunakan PDO dengan Prepared Statement (Lebih aman dari serangan hacker/SQL Injection)
    try {
        $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':password', $pass);
        $stmt->execute();

        // Jika data ditemukan
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['status']   = "login";
            $_SESSION['role']     = $data['role'];
            $_SESSION['username'] = $data['username']; 
            
            if ($data['role'] == "admin") {
                header("location:admin_dashboard.php");
            } else {
                header("location:dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Username atau Password Salah!'); window.location.href='index.html';</script>";
        }
    } catch (PDOException $e) {
        die("Query error: " . $e->getMessage());
    }
}
?>