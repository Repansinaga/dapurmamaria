<?php
include '../koneksi.php';
include '../includes/auth.php';
include '../includes/header.php';
include '../includes/sidebar.php';
include '../controllers/stok.php'; // Include controller stok
include '../includes/footer.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Stok</title>
    <link rel="stylesheet" href="../css/pt2.css">
</head>
<body>
    <div class="container">
        <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'berhasil') {
                    $success_message = "Stok berhasil ditambahkan!";
                } else if ($_GET['status'] == 'update') {
                    $success_message = "Stok berhasil diperbarui!";
                } else if ($_GET['status'] == 'hapus') {
                    $success_message = "Stok berhasil dihapus!";
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
        <!-- Daftar Stok Bahan Baku -->

        <div class="card">
            <div class="card-header">
                <h4>Daftar Stok Bahan Baku</h4>
            </div>
            <div class="card-body">
                <?php
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $limit = 10; // jumlah data per halaman
                    $offset = ($page - 1) * $limit;
                    $query_total = "SELECT COUNT(*) as total FROM stok";
                    $result_total = mysqli_query($koneksi, $query_total);
                    $row_total = mysqli_fetch_assoc($result_total);
                    $total_data = $row_total['total'];
                    $total_pages = ceil($total_data / $limit);
                    $query_stok = "SELECT * FROM stok ORDER BY id ASC LIMIT $limit OFFSET $offset";
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
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result_stok) > 0): ?>
                                <?php $no = ($page - 1) * $limit + 1; ?>
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
                                        <td>
                                            <!-- Tombol hapus -->
                                            <form method="POST" action="" onsubmit="return confirm('Yakin ingin menghapus stok ini?');">
                                                <input type="hidden" name="id" value="<?php echo $stok['id']; ?>">
                                                <button type="submit" name="btn-hapus-stok" class="btn-hapus">Hapus</button>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- Tombol edit -->
                                            <button name="btn-edit-stok" class="btn btn-warning btn-edit" 
                                                data-id="<?= $stok['id']; ?>"
                                                data-nama="<?= htmlspecialchars($stok['nama_barang']); ?>"
                                                data-jumlah="<?= htmlspecialchars($stok['jumlah']); ?>"
                                                data-satuan="<?= htmlspecialchars($stok['satuan']); ?>">
                                                Ubah
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">Belum ada stok yang ditambahkan</td>
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

        <!-- Modal Edit -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h4>Edit Stok Bahan Baku</h4>
                <form action="stok.php" method="POST">
                    <input type="hidden" name="id" id="edit-id">
                    
                    <label>Nama Bahan Baku:</label>
                    <input type="text" name="nama_barang" id="edit-nama" required>
                    
                    <label>Jumlah Stok:</label>
                    <div class="jumlah-wrapper">
                        <input type="number" name="jumlah" id="edit-jumlah" min="0" value="0" required>
                        <div class="tombol-vertical">
                            <button type="button" onclick="tambahJumlah()">+</button>
                            <button type="button" onclick="kurangiJumlah()">-</button>
                        </div>
                    </div>
                    
                    <label>Satuan:</label>
                    <select name="satuan" id="edit-satuan">
                        <option value="buah">Buah</option>
                        <option value="butir">Butir</option>
                        <option value="kg">Kg</option>
                        <option value="gram">Gram</option>
                        <option value="liter">Liter</option>
                        <option value="ml">Ml</option>
                    </select>
                    <button type="submit" name="btn-edit-stok">Simpan</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Tambah Daftar Stok Barang</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang:</label>
                        <input type="text" id="nama_barang" name="nama_barang" required>
                    </div>

                    <div class="form-group">
                        <label for="stok_barang">Jumlah Stok Barang:</label>
                        <input type="number" id="stok_barang" name="stok_barang" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="satuan_barang">Satuan:</label>
                        <select name="satuan_barang" id="satuan_barang">
                            <option value="buah">Buah</option>
                            <option value="butir">Butir</option>
                            <option value="kg">Kg</option>
                            <option value="gram">Gram</option>
                            <option value="liter">Liter</option>
                            <option value="ml">Ml</option>
                        </select>
                    </div>

                    <button type="submit" name="tambah_stok">Tambah Stok</button>
                </form>
            </div>
        </div>

    </div>
<script>
document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function () {
        // Isi modal dengan data dari tombol
        document.getElementById('edit-id').value = this.dataset.id;
        document.getElementById('edit-nama').value = this.dataset.nama;
        document.getElementById('edit-jumlah').value = this.dataset.jumlah;
        document.getElementById('edit-satuan').value = this.dataset.satuan;

        // Tampilkan modal
        document.getElementById('editModal').style.display = 'block';
    });
});

// Tombol close
document.querySelector('.close').onclick = () => {
    document.getElementById('editModal').style.display = 'none';
};

// Klik luar modal
window.onclick = function(event) {
    if (event.target == document.getElementById('editModal')) {
        document.getElementById('editModal').style.display = 'none';
    }
};

function kurangiJumlah() {
        let input = document.getElementById('edit-jumlah');
        let value = parseInt(input.value) || 0;
        if (value > 0) {
            input.value = value - 1;
        }
    }

    function tambahJumlah() {
        let input = document.getElementById('edit-jumlah');
        let value = parseInt(input.value) || 0;
        input.value = value + 1;
    }

    // Cegah input negatif secara manual
    document.getElementById('edit-jumlah').addEventListener('input', function () {
        if (this.value < 0) this.value = 0;
    });
</script>

</body>
</html>