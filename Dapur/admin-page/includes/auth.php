<?php
include '../koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit;
}
?>