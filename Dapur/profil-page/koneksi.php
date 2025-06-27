<?php
    $host = "localhost";
    $user = "root";       // Ganti jika user DB kamu berbeda
    $pass = "";           // Ganti sesuai password MySQL kamu
    $db   = "warung_mysql";     // Nama database yang sesuai

    $koneksi = mysqli_connect($host, $user, $pass, $db);

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }
?>
