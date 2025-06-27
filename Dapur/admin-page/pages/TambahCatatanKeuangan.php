<?php
include '../koneksi.php';
include '../includes/auth.php';
include '../includes/header.php';
include '../includes/sidebar.php';
include '../controllers/keuangan.php'; 
include '../includes/footer.php'; 

function getBulanIndonesia($tanggal) {
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $bulan_num = (int)date('m', strtotime($tanggal));
    return $bulan[$bulan_num];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Keuangan</title>
    <link rel="stylesheet" href="../css/pt2.css">
</head>
<body>
    <div class="container">
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
        
        <!-- Daftar Keuangan -->
        <div class="card">
            <div class="card-header">
                <h4>Daftar Keuangan</h4>
            </div>
            <div class="card-body">
                <?php
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $limit = 10; // jumlah data per halaman
                    $offset = ($page - 1) * $limit;   
                    $query_total = "SELECT COUNT(*) as total FROM keuangan";
                    $result_total = mysqli_query($koneksi, $query_total);
                    $row_total = mysqli_fetch_assoc($result_total);
                    $total_data = $row_total['total'];
                    $total_pages = ceil($total_data / $limit);
                    $query_keuangan = "SELECT * FROM keuangan ORDER BY tanggal DESC, id DESC LIMIT $limit OFFSET $offset";
                    $result_keuangan = mysqli_query($koneksi, $query_keuangan);
                ?>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th> 
                                <th>Tanggal</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Nominal</th>
                                <th>Sumber</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result_keuangan) > 0): ?>
                                <?php $no = ($page - 1) * $limit + 1; ?>
                                <?php while($keuangan = mysqli_fetch_assoc($result_keuangan)): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($keuangan['tanggal']); ?></td>
                                        <td><?php echo getBulanIndonesia($keuangan['tanggal']); ?></td>
                                        <td><?php echo date('Y', strtotime($keuangan['tanggal'])); ?></td>
                                        <td><?php echo htmlspecialchars($keuangan['nominal']); ?></td>
                                        <td><?php echo htmlspecialchars($keuangan['sumber']); ?></td>
                                        <td>
                                            <!-- Tombol hapus -->
                                            <form method="POST" action="" onsubmit="return confirm('Yakin ingin menghapus data keuangan ini?');">
                                                <input type="hidden" name="id" value="<?php echo $keuangan['id']; ?>">
                                                <button type="submit" name="btn-hapus-keuangan" class="btn-hapus">Hapus</button>
                                            </form>
                                        </td>
                                        <td>
                                            <button
                                                type="button" class="btn btn-warning btn-edit"
                                                data-id="<?= $keuangan['id']; ?>"
                                                data-sumber="<?= htmlspecialchars($keuangan['sumber']); ?>"
                                                data-nominal="<?= htmlspecialchars($keuangan['nominal']); ?>"
                                                data-tanggal="<?= htmlspecialchars($keuangan['tanggal']); ?>"
                                                onclick="editKeuangan(this)">
                                                Ubah
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">Belum ada data keuangan yang ditambahkan</td>
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

        <!-- Modal Edit Keuangan -->
        <div id="modalEditKeuangan" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModalEdit()">&times;</span>
                <h3>Edit Data Keuangan</h3>
                <form method="POST" action="">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="form-group">
                        <label for="edit_sumber">Sumber:</label>
                        <select name="edit_sumber" id="edit_sumber">
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_nominal">Nominal (Rp):</label>
                        <input type="number" id="edit_nominal" name="edit_nominal" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal:</label>
                        <input type="date" id="edit_tanggal" name="edit_tanggal" required>
                    </div>

                    <button type="submit" name="btn-edit-keuangan">Simpan Perubahan</button>
                </form>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                <h4>Tambah Catatan Keuangan</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="sumber">Sumber:</label>
                        <select name="sumber" id="sumber">
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nominal">Nominal (Rp):</label>
                        <input type="number" id="nominal" name="nominal" min="0" required>
                    </div>

                    <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <select name="tanggal" id="tanggal">
                                <?php for ($i = 1; $i <= 31; $i++) : ?>
                                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>

                            <label for="bulan">Bulan:</label>
                            <select name="bulan" id="bulan">
                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>

                            <label for="tahun">Tahun:</label>
                            <select name="tahun" id="tahun">
                                <?php
                                $tahun_sekarang = date('Y');
                                for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 50; $i--) :
                                ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                    </div>

                    <button type="submit" name="tambah_keuangan">Tambah Data Keuangan</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        function editKeuangan(button) {
        const id = button.dataset.id;
        const sumber = button.dataset.sumber;
        const nominal = button.dataset.nominal;
        const tanggal = button.dataset.tanggal;

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_sumber').value = sumber;
        document.getElementById('edit_nominal').value = nominal;
        document.getElementById('edit_tanggal').value = tanggal;

        document.getElementById('modalEditKeuangan').style.display = 'block';
        }

        function closeModalEdit() {
            document.getElementById('modalEditKeuangan').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('modalEditKeuangan');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>