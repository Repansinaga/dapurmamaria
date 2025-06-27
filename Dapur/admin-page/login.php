<?php 
include "koneksi.php"; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kalau sudah login, redirect ke dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: pages/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin Warung Makan</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="container">
    <h2>Login Admin</h2>
    <form method="POST" action="">
        <label>Email Admin:</label>
        <input type="text" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" id="password" required>

        <div class="show-password">
            <input type="checkbox" onclick="togglePassword()"> Tampilkan Password
        </div>

        <a href="lupa_password.php" class="forgot">Lupa Password?</a>

        <input type="submit" name="login" value="Login">

        <a href="buat_akun.php" class="register">Belum punya akun?</a>

        <div class="back-home">
            <a href="../profil-page/index.php">← Kembali ke Halaman Depan</a>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    var x = document.getElementById("password");
    x.type = (x.type === "password") ? "text" : "password";
}
</script>

<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM admin WHERE email='$email'";
    $result = mysqli_query($koneksi, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $data['password'])) {
            // Set session data
            session_start();
            $_SESSION['admin_id'] = $data['id'];
            $_SESSION['admin_nama'] = $data['nama'];
            $_SESSION['admin_email'] = $data['email'];
            
            // Login berhasil
            echo "<script>alert('Login berhasil sebagai admin'); window.location.href='pages/dashboard.php';</script>";
        } else {
            // Password salah
            echo "<script>alert('Password salah!');</script>";
        }
    } else {
        // Email tidak ditemukan
        echo "<script>alert('Email tidak terdaftar!');</script>";
    }
}
?>
</body>
</html>