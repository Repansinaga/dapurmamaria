<?php 
include "../koneksi.php";
include '../includes/auth.php';
include "../includes/header.php";
include "../includes/sidebar.php";
include "../includes/footer.php";

// Ambil data admin yang login
$admin_id = $_SESSION['admin_id'];
$admin_nama = $_SESSION['admin_nama'];

// Ambil daftar kategori
$query_kategori_list = "SELECT * FROM kategori ORDER BY id ASC";
$result_kategori = mysqli_query($koneksi, $query_kategori_list);

// Function untuk mempertahankan parameter GET lainnya
function build_pagination_url($page_param, $page_value) {
    $params = $_GET;
    $params[$page_param] = $page_value;
    return '?' . http_build_query($params);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Warung</title>
    <link rel="stylesheet" href="../css/pt2.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dapur Mama Ria</h1>
        </div>
        
        <div class="welcome">
            <h2>Selamat datang, <?php echo htmlspecialchars($admin_nama); ?>!</h2>
            <p>Anda login sebagai Admin dengan ID: <?php echo $admin_id; ?></p>
        </div>
        
        <?php if(isset($success_message)): ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
        <?php endif; ?>
        
        <?php if(isset($error_message)): ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>
        
        <!-- Daftar Kategori -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Kategori</h4>
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result_kategori) > 0): ?>
                                <?php $no = 1; ?>
                                <?php while($kategori = mysqli_fetch_assoc($result_kategori)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($kategori['nama']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">Belum ada kategori yang ditambahkan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Daftar Menu -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Menu</h4>
            </div>
            <div class="card-body">
                <?php
                    // Pagination untuk Menu
                    $page_menu = isset($_GET['menu_page']) ? max(1, (int)$_GET['menu_page']) : 1;
                    $limit_menu = 10;
                    $offset_menu = ($page_menu - 1) * $limit_menu;
                    
                    // Hitung total data menu
                    $query_total_menu = "SELECT COUNT(*) as total FROM menu";
                    $result_total_menu = mysqli_query($koneksi, $query_total_menu);
                    $row_total_menu = mysqli_fetch_assoc($result_total_menu);
                    $total_data_menu = $row_total_menu['total'];
                    $total_pages_menu = ceil($total_data_menu / $limit_menu);

                    // Query data menu dengan pagination
                    $query_menu = "SELECT menu.*, kategori.nama as nama_kategori 
                                   FROM menu 
                                   LEFT JOIN kategori ON menu.kategori_id = kategori.id 
                                   ORDER BY menu.id ASC 
                                   LIMIT $limit_menu OFFSET $offset_menu";
                    $result_menu = mysqli_query($koneksi, $query_menu);
                ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result_menu) > 0): ?>
                                <?php $no = ($page_menu - 1) * $limit_menu + 1; ?>
                                <?php while($menu = mysqli_fetch_assoc($result_menu)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($menu['nama_menu']); ?></td>
                                        <td><?php echo htmlspecialchars($menu['nama_kategori']); ?></td>
                                        <td><?php echo htmlspecialchars($menu['deskripsi']); ?></td>
                                        <td>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php
                                            $admin_query = mysqli_query($koneksi, "SELECT nama FROM admin WHERE id = '{$menu['admin_id']}'");
                                            if($admin_data = mysqli_fetch_assoc($admin_query)) {
                                                echo htmlspecialchars($admin_data['nama']);
                                            } else {
                                                echo "Admin tidak ditemukan";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">Belum ada menu yang ditambahkan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Menu -->
                <?php if($total_pages_menu > 1): ?>
                <nav aria-label="Menu navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= ($page_menu <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_pagination_url('menu_page', max(1, $page_menu - 1)) ?>">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages_menu; $i++): ?>
                            <li class="page-item <?= ($i == $page_menu) ? 'active' : '' ?>">
                                <a class="page-link" href="<?= build_pagination_url('menu_page', $i) ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page_menu >= $total_pages_menu) ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_pagination_url('menu_page', min($total_pages_menu, $page_menu + 1)) ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>

        <!-- Daftar Stok Barang -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Stok Barang</h4>
            </div>
            <div class="card-body">
                <?php
                    // Pagination untuk Stok
                    $page_stok = isset($_GET['stok_page']) ? max(1, (int)$_GET['stok_page']) : 1;
                    $limit_stok = 10;
                    $offset_stok = ($page_stok - 1) * $limit_stok;
                    
                    // Hitung total data stok
                    $query_total_stok = "SELECT COUNT(*) as total FROM stok";
                    $result_total_stok = mysqli_query($koneksi, $query_total_stok);
                    $row_total_stok = mysqli_fetch_assoc($result_total_stok);
                    $total_data_stok = $row_total_stok['total'];
                    $total_pages_stok = ceil($total_data_stok / $limit_stok);
                    
                    // Query data stok dengan pagination
                    $query_stok = "SELECT * FROM stok ORDER BY id ASC LIMIT $limit_stok OFFSET $offset_stok";
                    $result_stok = mysqli_query($koneksi, $query_stok);
                ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bahan Baku</th>
                                <th>Jumlah Stok Bahan Baku</th>
                                <th>Satuan</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result_stok) > 0): ?>
                                <?php $no = ($page_stok - 1) * $limit_stok + 1; ?>
                                <?php while($stok = mysqli_fetch_assoc($result_stok)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($stok['nama_barang']); ?></td>
                                        <td><?php echo htmlspecialchars($stok['jumlah']); ?></td>
                                        <td><?php echo htmlspecialchars($stok['satuan']); ?></td>
                                        <td>
                                            <?php
                                            $admin_query = mysqli_query($koneksi, "SELECT nama FROM admin WHERE id = '{$stok['admin_id']}'");
                                            if($admin_data = mysqli_fetch_assoc($admin_query)) {
                                                echo htmlspecialchars($admin_data['nama']);
                                            } else {
                                                echo "Admin tidak ditemukan";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">Belum ada stok yang ditambahkan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Stok -->
                <?php if($total_pages_stok > 1): ?>
                <nav aria-label="Stok navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= ($page_stok <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_pagination_url('stok_page', max(1, $page_stok - 1)) ?>">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages_stok; $i++): ?>
                            <li class="page-item <?= ($i == $page_stok) ? 'active' : '' ?>">
                                <a class="page-link" href="<?= build_pagination_url('stok_page', $i) ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page_stok >= $total_pages_stok) ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_pagination_url('stok_page', min($total_pages_stok, $page_stok + 1)) ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>

        <!-- Daftar Keuangan -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Keuangan</h4>
            </div>
            <div class="card-body">
                <?php
                    // Pagination untuk Keuangan
                    $page_keuangan = isset($_GET['keuangan_page']) ? max(1, (int)$_GET['keuangan_page']) : 1;
                    $limit_keuangan = 10;
                    $offset_keuangan = ($page_keuangan - 1) * $limit_keuangan;
                    
                    // Hitung total data keuangan
                    $query_total_keuangan = "SELECT COUNT(*) as total FROM keuangan";
                    $result_total_keuangan = mysqli_query($koneksi, $query_total_keuangan);
                    $row_total_keuangan = mysqli_fetch_assoc($result_total_keuangan);
                    $total_data_keuangan = $row_total_keuangan['total'];
                    $total_pages_keuangan = ceil($total_data_keuangan / $limit_keuangan);
                    
                    // Query data keuangan dengan pagination
                    $query_keuangan = "SELECT * FROM keuangan ORDER BY tanggal DESC, id DESC LIMIT $limit_keuangan OFFSET $offset_keuangan";
                    $result_keuangan = mysqli_query($koneksi, $query_keuangan);
                ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                                <th>Sumber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result_keuangan) > 0): ?>
                                <?php $no = ($page_keuangan - 1) * $limit_keuangan + 1; ?>
                                <?php while($keuangan = mysqli_fetch_assoc($result_keuangan)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($keuangan['tanggal']); ?></td>
                                        <td>Rp <?php echo number_format($keuangan['nominal'], 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($keuangan['sumber']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">Belum ada data keuangan yang ditambahkan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Keuangan -->
                <?php if($total_pages_keuangan > 1): ?>
                <nav aria-label="Keuangan navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?= ($page_keuangan <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_pagination_url('keuangan_page', max(1, $page_keuangan - 1)) ?>">&laquo;</a>
                        </li>
                        <?php for ($i = 1; $i <= $total_pages_keuangan; $i++): ?>
                            <li class="page-item <?= ($i == $page_keuangan) ? 'active' : '' ?>">
                                <a class="page-link" href="<?= build_pagination_url('keuangan_page', $i) ?>"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page_keuangan >= $total_pages_keuangan) ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_pagination_url('keuangan_page', min($total_pages_keuangan, $page_keuangan + 1)) ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>

    </div>
</body>
</html>