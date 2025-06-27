<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$admin_id = $_SESSION['admin_id'];

if (!$admin_id) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

// Ambil daftar keuangan
$query_keuangan = "SELECT * FROM keuangan ORDER BY id ASC";
$result_keuangan = mysqli_query($koneksi, $query_keuangan);

// Tambah Pencatatan Keuangan
if (isset($_POST['tambah_keuangan'])) {
    $sumber = $_POST['sumber'];
    $nominal = $_POST['nominal'];
    $tanggal = $_POST['tanggal'];
    $bulan   = $_POST['bulan'];
    $tahun   = $_POST['tahun'];

    $tanggal_lengkap = "$tahun-$bulan-$tanggal"; // Format YYYY-MM-DD

    
    $query_keuangan = "INSERT INTO keuangan (admin_id, sumber, nominal, tanggal) VALUES ('$admin_id', '$sumber', '$nominal', '$tanggal_lengkap')";
    if (mysqli_query($koneksi, $query_keuangan)) {
        $success_message = "Catatan keuangan berhasil ditambahkan!";
    } else {
        $error_message = "Gagal menambahkan catatan keuangan: " . mysqli_error($koneksi);
    }
}

// Hapus Data Keuangan
if (isset($_POST['btn-hapus-keuangan'])) {
    $id = intval($_POST['id']);

    $query_hapus_keuangan = "DELETE FROM keuangan WHERE id = '$id'";

    if (mysqli_query($koneksi, $query_hapus_keuangan)) {
        if (mysqli_affected_rows($koneksi) > 0) {
            $success_message = "Data keuangan berhasil dihapus!";
        } else {
            $error_message = "Data keuangan tidak ditemukan!";
        }
    } else {
        $error_message = "Gagal menghapus data keuangan: " . mysqli_error($koneksi);
    }
}

// Ubah Data Keuangan
if (isset($_POST['btn-edit-keuangan'])) {
    $id      = intval($_POST['edit_id']);
    $sumber  = $_POST['edit_sumber'];
    $nominal = $_POST['edit_nominal'];
    $tanggal = $_POST['edit_tanggal']; // sudah dalam format YYYY-MM-DD

    $query_update = "UPDATE keuangan SET sumber = '$sumber', nominal = '$nominal', tanggal = '$tanggal' WHERE id = '$id'";

    if (mysqli_query($koneksi, $query_update)) {
        if (mysqli_affected_rows($koneksi) > 0) {
            $success_message = "Data keuangan berhasil diperbarui!";
        } else {
            $error_message = "Tidak ada perubahan data keuangan.";
        }
    } else {
        $error_message = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}

?>