<?php
include '../koneksi.php';
include '../includes/auth.php';
include '../includes/header.php';
include '../includes/sidebar.php';
include '../controllers/keuangan.php'; 
include '../includes/footer.php'; 
?>

<?php
    
    // Ambil filter bulan & tahun dari URL
    $bulan_filter = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('m');
    $tahun_filter = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

    // Ambil data untuk bar chart: Group per bulan dan tahun
    $query_chart_bulan = "SELECT 
                            YEAR(tanggal) as tahun,
                            MONTH(tanggal) as bulan, 
                            SUM(Rugi) as total_rugi, 
                            SUM(Laba) as total_laba 
                        FROM view_rugi_laba 
                        GROUP BY YEAR(tanggal), MONTH(tanggal)
                        ORDER BY tahun, bulan";
    $result_chart_bulan = mysqli_query($koneksi, $query_chart_bulan);

    $label_bulan = [];
    $rugi_bulanan = [];
    $laba_bulanan = [];

    while ($row = mysqli_fetch_assoc($result_chart_bulan)) {
        $label_bulan[] = date('F', mktime(0, 0, 0, $row['bulan'], 10)) . ' ' . $row['tahun'];
        $rugi_bulanan[] = $row['total_rugi'];
        $laba_bulanan[] = $row['total_laba'];
    }

    // Ambil data untuk line chart per minggu sesuai filter
    $query_chart_minggu = "SELECT 
                            WEEK(tanggal) as minggu, 
                            SUM(Rugi) as total_rugi, 
                            SUM(Laba) as total_laba 
                        FROM view_rugi_laba 
                        WHERE MONTH(tanggal) = $bulan_filter AND YEAR(tanggal) = $tahun_filter
                        GROUP BY WEEK(tanggal)
                        ORDER BY minggu";
    $result_chart_minggu = mysqli_query($koneksi, $query_chart_minggu);

    $minggu = [];
    $rugi_mingguan = [];
    $laba_mingguan = [];

    while ($row = mysqli_fetch_assoc($result_chart_minggu)) {
        $minggu[] = 'Minggu ' . $row['minggu'];
        $rugi_mingguan[] = $row['total_rugi'];
        $laba_mingguan[] = $row['total_laba'];
    }

    // Ambil tahun-tahun unik untuk filter
    $result_tahun = mysqli_query($koneksi, "SELECT DISTINCT YEAR(tanggal) as tahun FROM view_rugi_laba ORDER BY tahun DESC");

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
            <?php
                // Query dari view
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 10; // Jumlah data per halaman
                $offset = ($page - 1) * $limit;
                $query_total = "SELECT COUNT(*) as total FROM view_rugi_laba";
                $result_total = mysqli_query($koneksi, $query_total);
                $row_total = mysqli_fetch_assoc($result_total);
                $total_data = $row_total['total'];
                $total_pages = ceil($total_data / $limit);
                $query_rugi_laba = "SELECT * FROM view_rugi_laba ORDER BY tanggal DESC LIMIT $limit OFFSET $offset";
                $result_rugi_laba = mysqli_query($koneksi, $query_rugi_laba);
                ?>

                <!-- Tabel Rugi Laba -->
                <div class="card">
                    <div class="card-header">
                        <h4>Laporan Rugi Laba</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Rugi</th>
                                        <th>Laba</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(mysqli_num_rows($result_rugi_laba) > 0): ?>
                                        <?php $no = ($page - 1) * $limit + 1; ?>
                                        <?php while($row = mysqli_fetch_assoc($result_rugi_laba)): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                                <td><?php echo getBulanIndonesia($row['tanggal']); ?></td>
                                                <td><?php echo date('Y', strtotime($row['tanggal'])); ?></td>
                                                <td><?php echo number_format($row['Rugi'], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format($row['Laba'], 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="4">Belum ada data rugi/laba</td>
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
                        <span class="sr-only">Previous</span>
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
                        <span class="sr-only">Next</span>
                    </a>
                    </li>
                </ul>
            </nav>


            <!-- Filter Form -->
            <form method="GET" style="text-align:center; margin-bottom:20px;">
                <label for="bulan">Bulan:</label>
                <select name="bulan">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= ($i == $bulan_filter) ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                        </option>
                    <?php endfor; ?>
                </select>

                <label for="tahun">Tahun:</label>
                <select name="tahun">
                    <?php while($row = mysqli_fetch_assoc($result_tahun)): ?>
                        <option value="<?= $row['tahun'] ?>" <?= ($row['tahun'] == $tahun_filter) ? 'selected' : '' ?>>
                            <?= $row['tahun'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit">Tampilkan</button>
            </form>


            <!-- Chart Containers -->
            <div class="chart-container" style="max-width:800px; margin:auto;">
                <canvas id="barChart"></canvas>
            </div>

            <div class="chart-container" style="max-width:800px; margin:auto; margin-top:50px;">
                <canvas id="lineChart"></canvas>
            </div>


        </div>
        
        <script>
            const bulanLabels = <?= json_encode($label_bulan) ?>;
            const rugiBulanan = <?= json_encode($rugi_bulanan) ?>;
            const labaBulanan = <?= json_encode($laba_bulanan) ?>;

            const mingguLabels = <?= json_encode($minggu) ?>;
            const rugiMingguan = <?= json_encode($rugi_mingguan) ?>;
            const labaMingguan = <?= json_encode($laba_mingguan) ?>;

            // Bar Chart - Rugi dan Laba per Bulan
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: bulanLabels,
                    datasets: [
                        {
                            label: 'Rugi',
                            data: rugiBulanan,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)'
                        },
                        {
                            label: 'Laba',
                            data: labaBulanan,
                            backgroundColor: 'rgba(54, 162, 235, 0.7)'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Rugi dan Laba per Bulan & Tahun'
                        }
                    }
                }
            });

            // Line Chart - Rugi dan Laba per Minggu (Filter)
            new Chart(document.getElementById('lineChart'), {
                type: 'line',
                data: {
                    labels: mingguLabels,
                    datasets: [
                        {
                            label: 'Rugi',
                            data: rugiMingguan,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            fill: false,
                            tension: 0.3
                        },
                        {
                            label: 'Laba',
                            data: labaMingguan,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            fill: false,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Rugi dan Laba per Minggu - <?= date('F', mktime(0, 0, 0, $bulan_filter, 10)) ?> <?= $tahun_filter ?>'
                        }
                    }
                }
            });
        </script>
    </body>
</html>