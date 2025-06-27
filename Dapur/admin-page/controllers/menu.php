<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$admin_id = $_SESSION['admin_id'];

if (!$admin_id) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

// Ambil daftar kategori
$query_kategori_list = "SELECT * FROM kategori ORDER BY id ASC";
$result_kategori = mysqli_query($koneksi, $query_kategori_list);

// Proses tambah menu
if (isset($_POST['tambah_menu'])) {
    $nama_menu = $_POST['nama_menu'];
    //$kategori = $_POST['kategori'];
    $kategori_id = $_POST['kategori_id'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $tempImage = $_FILES['images']['tmp_name'];
    $original_file_name = basename($_FILES['images']['name']);
    $ext = pathinfo($original_file_name, PATHINFO_EXTENSION);
    
    // Cek apakah kategori_id valid
    $check_kategori = mysqli_query($koneksi, "SELECT id FROM kategori WHERE id = '$kategori_id'");
    $check_isi_data = mysqli_query($koneksi, "SELECT nama_menu FROM menu where nama_menu = '$nama_menu'");

    if (mysqli_num_rows($check_kategori) > 0) {
        if (mysqli_num_rows($check_isi_data) < 1){

            $random_file_name = time() . '-' . md5(rand()) . "." . $ext;
            $upload_dir = $_SERVER["DOCUMENT_ROOT"] . "../dapur/profil-page/images/";
            $upload_path = $upload_dir . $random_file_name;
            $upload = move_uploaded_file($tempImage, $upload_path);

            $query = "INSERT INTO menu (admin_id, nama_menu, kategori_id, deskripsi, harga, images) 
                VALUES ('$admin_id', '$nama_menu', '$kategori_id', '$deskripsi', '$harga','$random_file_name')";
        
            if (mysqli_query($koneksi, $query)) {
                header("Location: menu.php?status=berhasil");
                exit();
            } else {
                $error_message = "Gagal menambahkan menu: " . mysqli_error($koneksi);
            }
        }else {
            $error_message = "Menu yang Anda masukkan telah tersedia"; 
        }
    } else {
        $error_message = "Kategori ID tidak valid! Silakan pilih kategori yang tersedia.";
    }
}

// Proses Hapus Menu
if (isset($_POST['btn-hapus-menu'])) {
    $id = intval($_POST['id']);

    $query_hapus = "DELETE FROM menu WHERE id = '$id'";

    if (mysqli_query($koneksi, $query_hapus)) {
        if (mysqli_affected_rows($koneksi) > 0) {
            header("Location: menu.php?status=hapus");
            exit();
        } else {
            $error_message = "Menu tidak ditemukan!";
        }
    } else {
        $error_message = "Gagal menghapus menu: " . mysqli_error($koneksi);
    }
}

// Ambil daftar menu
$query_menu = "SELECT m.*, k.nama AS nama_kategori 
               FROM menu m
               LEFT JOIN kategori k ON m.kategori_id = k.id
               ORDER BY m.id DESC";
$result_menu = mysqli_query($koneksi, $query_menu);

// Proses Edit Menu
if (isset($_POST['btn-edit-menu'])) {
    $id = intval($_POST['edit_id']);
    $nama_menu = $_POST['edit_nama_menu'];
    $kategori_id = $_POST['edit_kategori_id'];
    $deskripsi = $_POST['edit_deskripsi'];
    $harga = $_POST['edit_harga'];
    $tempImage = $_FILES['images_edit']['tmp_name'];
    $original_file_name = basename($_FILES['images_edit']['name']);
    $ext = pathinfo($original_file_name, PATHINFO_EXTENSION);

    // Validasi apakah menu-nya ada
    $check_menu = mysqli_query($koneksi, "SELECT id FROM menu WHERE id = '$id'");
    
    if (mysqli_num_rows($check_menu) > 0) {
        $random_file_name = time() . '-' . md5(rand()) . "." . $ext;
        $upload_dir = $_SERVER["DOCUMENT_ROOT"] . "../dapur/profil-page/images/";
        $upload_path = $upload_dir . $random_file_name;
        $upload = move_uploaded_file($tempImage, $upload_path);
        $query_update = "UPDATE menu 
                         SET nama_menu = '$nama_menu', 
                             kategori_id = '$kategori_id', 
                             deskripsi = '$deskripsi', 
                             harga = '$harga',
                             images = '$random_file_name' 
                         WHERE id = '$id'";
        
        if (mysqli_query($koneksi, $query_update)) {
            header("Location: menu.php?status=update");
            exit();
        } else {
            $error_message = "Gagal memperbarui menu: " . mysqli_error($koneksi);
        }
    } else {
        $error_message = "Data menu tidak ditemukan.";
    }
}


?>