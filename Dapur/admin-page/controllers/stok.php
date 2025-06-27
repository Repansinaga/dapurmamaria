<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$admin_id = $_SESSION['admin_id'];

if (!$admin_id) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

// Ambil daftar stok barang
$query_stok = "SELECT * FROM stok ORDER BY id ASC";
$result_stok = mysqli_query($koneksi, $query_stok);

// Tambah Stok
if (isset($_POST['tambah_stok'])) {
    $nama_barang = $_POST['nama_barang'];
    $stok_barang = $_POST['stok_barang'];
    $satuan_barang = $_POST['satuan_barang'];

    $check_stok = mysqli_query($koneksi, "SELECT id FROM stok WHERE nama_barang = '$nama_barang'");
    if (mysqli_num_rows($check_stok) < 1) {
        $query_tambah_stok = "INSERT INTO stok (admin_id, nama_barang, jumlah, satuan) VALUES ('$admin_id', '$nama_barang', '$stok_barang', '$satuan_barang')";

        if (mysqli_query($koneksi, $query_tambah_stok)) {
            header("Location: stok.php?status=berhasil");
            exit();
        } else {
            $error_message = "Gagal menambahkan stok barang: " . mysqli_error($koneksi);
        }
    }else if(mysqli_num_rows($check_stok) > 0){
        $query_stok = "UPDATE stok SET jumlah = '$stok_barang' + jumlah WHERE nama_barang = '$nama_barang'";

        if (mysqli_query($koneksi, $query_stok)) {
            header("Location: stok.php?status=update");
            exit();
        } else {
            $error_message = "Gagal menambahkan stok barang: " . mysqli_error($koneksi);
        }

    } else {
        $error_message = "Barang yang kamu masukkan sudah ada, silahkan pergi ke menu edit"; 
    }
}

// Hapus Stok
if (isset($_POST['btn-hapus-stok'])) {
    $id = intval($_POST['id']);

    $query_hapus_stok = "DELETE FROM stok WHERE id = '$id'";

    if (mysqli_query($koneksi, $query_hapus_stok)) {
        if (mysqli_affected_rows($koneksi) > 0) {
            header("Location: stok.php?status=hapus");
            exit();
        } else {
            $error_message = "Barang tidak ditemukan!";
        }
    } else {
        $error_message = "Gagal menghapus stok barang: " . mysqli_error($koneksi);
    }
}

// Edit Stok
if (isset($_POST['btn-edit-stok'])) {
    $id = intval($_POST['id']);
    $nama = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $satuan = $_POST['satuan'];

    $query = "UPDATE stok SET nama_barang='$nama', jumlah='$jumlah', satuan='$satuan' WHERE id='$id'";
    if ($jumlah < 0){
        $error_message = "Jumlah stok tidak boleh kurang dari 0!";
    }else{
        if (mysqli_query($koneksi, $query)) {
            header("Location: stok.php?status=update");
            exit();
        } else {
            $error_message = "Gagal update data: " . mysqli_error($koneksi);
        }
    }
}


?>