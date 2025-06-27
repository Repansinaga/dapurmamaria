<?php
include '../koneksi.php'; 
include '../includes/auth.php';
include '../includes/header.php'; 
include '../includes/sidebar.php'; 
include '../controllers/menu.php'; 
include '../includes/footer.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Menu</title>
    <link rel="stylesheet" href="../css/pt2.css">
</head>
<body>
    <div class="container">
        <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'berhasil') {
                    $success_message = "Menu berhasil ditambahkan!";
                } else if ($_GET['status'] == 'update') {
                    $success_message = "Menu berhasil diperbarui!";
                } else if ($_GET['status'] == 'hapus') {
                    $success_message = "Menu berhasil dihapus!";
                }
            }
        ?>
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
        
        <div class="card">
            <div class="card-header">
                <h4>Daftar Menu</h4>
            </div>
            <div class="card-body">
                <?php
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $limit = 10; // jumlah data per halaman
                    $offset = ($page - 1) * $limit;
                    $query_total = "SELECT COUNT(*) as total FROM menu";
                    $result_total = mysqli_query($koneksi, $query_total);
                    $row_total = mysqli_fetch_assoc($result_total);
                    $total_data = $row_total['total'];
                    $total_pages = ceil($total_data / $limit);

                    $result_menu = mysqli_query($koneksi, "
                        SELECT menu.*, kategori.nama as nama_kategori 
                        FROM menu 
                        JOIN kategori ON menu.kategori_id = kategori.id 
                        ORDER BY menu.id ASC 
                        LIMIT $limit OFFSET $offset
                    ");
                    
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
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result_menu) > 0): ?>
                                <?php $no = ($page - 1) * $limit + 1; ?>
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
                                        <td>
                                            <!-- Tombol hapus -->
                                            <form method="POST" action="" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                                <input type="hidden" name="id" value="<?php echo $menu['id']; ?>">
                                                <button type="submit" name="btn-hapus-menu" class="btn-hapus">Hapus</button>
                                            </form>
                                        </td>
                                        <!-- Tombol Edit -->
                                        <td>
                                            <button 
                                                type="button" class="btn btn-warning btn-edit" 
                                                data-id="<?= $menu['id']; ?>" 
                                                data-nama="<?= htmlspecialchars($menu['nama_menu']); ?>" 
                                                data-kategori="<?= $menu['kategori_id']; ?>" 
                                                data-deskripsi="<?= htmlspecialchars($menu['deskripsi']); ?>" 
                                                data-harga="<?= $menu['harga']; ?>" 
                                                onclick="isiFormEdit(this)">
                                                Ubah
                                            </button>
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
            </div>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- Tombol Previous -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= max(1, $page - 1); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
                </li>

                <!-- Nomor Halaman -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
                <?php endfor; ?>

                <!-- Tombol Next -->
                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= min($total_pages, $page + 1); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
                </li>
            </ul>
        </nav>

        <!-- Modal Edit Menu -->
        <div id="editModal" class="modal-menu" style="display:none;">
            <div class="modal-content-menu">
                <span class="close-menu" onclick="tutupModal()">&times;</span>
                <h4>Edit Menu</h4>
                <form method="POST" action="" enctype="multipart/form-data" >
                    <input type="hidden" id="edit_id" name="edit_id">

                    <div class="form-group">
                        <label for="edit_nama_menu">Nama Menu:</label>
                        <input type="text" id="edit_nama_menu" name="edit_nama_menu" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_kategori_id">Kategori:</label>
                        <select id="edit_kategori_id" name="edit_kategori_id" required>
                            <?php 
                            mysqli_data_seek($result_kategori, 0);
                            while($kat = mysqli_fetch_assoc($result_kategori)): 
                            ?>
                                <option value="<?php echo $kat['id']; ?>">
                                    <?php echo htmlspecialchars($kat['nama']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_deskripsi">Deskripsi:</label>
                        <textarea id="edit_deskripsi" name="edit_deskripsi" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_harga">Harga (Rp):</label>
                        <input type="number" id="edit_harga" name="edit_harga" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="images">Gambar:</label>
                        <input type="file" id="images" name="images_edit">
                    </div>

                    <div class="form-group" style="text-align: center; margin-top: 1rem;">
                        <button type="submit" name="btn-edit-menu" class="button">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Tambah Menu Baru</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_menu">Nama Menu:</label>
                        <input type="text" id="nama_menu" name="nama_menu" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kategori_id">Kategori:</label>
                        <select id="kategori_id" name="kategori_id" required>
                            <?php 
                            // Reset pointer hasil query
                            mysqli_data_seek($result_kategori, 0);
                            while($kat = mysqli_fetch_assoc($result_kategori)): 
                            ?>
                                <option value="<?php echo $kat['id']; ?>">
                                    <?php echo htmlspecialchars($kat['nama']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <small>Pilih kategori yang tersedia</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi:</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga (Rp):</label>
                        <input type="number" id="harga" name="harga" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="images">Input Gambar</label>
                        <input type="file" id="images" name="images" required>
                    </div>
                    
                    <button type="submit" name="tambah_menu">Tambah Menu</button>
                </form>
            </div>
        </div>

    </div>
<script>
    function isiFormEdit(button) {
        document.getElementById('edit_id').value = button.getAttribute('data-id');
        document.getElementById('edit_nama_menu').value = button.getAttribute('data-nama');
        document.getElementById('edit_kategori_id').value = button.getAttribute('data-kategori');
        document.getElementById('edit_deskripsi').value = button.getAttribute('data-deskripsi');
        document.getElementById('edit_harga').value = button.getAttribute('data-harga');

        document.getElementById('editModal').style.display = 'flex';
    }

    function tutupModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Tutup modal saat klik di luar modal
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>

<?php include '../includes/footer.php'; ?>