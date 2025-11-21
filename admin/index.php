<?php
// Dashboard Admin
include 'header.php';

// =================== FILTER RENTANG WAKTU ===================
$range = isset($_GET['range']) ? $_GET['range'] : 'month'; // default: bulanan

switch ($range) {
    case 'day':
        $whereClause = "DATE(tgl_diag) = CURDATE()";
        $rangeText   = "Hari ini";
        break;
    case 'week':
        $whereClause = "tgl_diag >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        $rangeText   = "7 Hari Terakhir";
        break;
    case 'all':
        $whereClause = "";
        $rangeText   = "Semua Waktu";
        break;
    case 'month':
    default:
        $whereClause = "tgl_diag >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
        $rangeText   = "30 Hari Terakhir";
        $range       = 'month';
        break;
}
$whereSql  = $whereClause ? "WHERE $whereClause" : "";
$chartType = ($range == 'month') ? 'doughnut' : 'bar'; // Bulanan = donut

// =================== STATISTIK UTAMA (TOTAL GLOBAL) ===================
$total_penyakit = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM penyakit"));
$total_gejala   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM gejala"));
$total_pasien   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pengguna WHERE akses='user'"));
$total_diag     = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM diagnosa"));

// =================== DATA GRAFIK (SESUIAI RANGE WAKTU) ===================
$chartLabels = [];
$chartData   = [];

$qChart = mysqli_query(
    $conn,
    "SELECT nm_penyakit, COUNT(*) AS jumlah 
     FROM diagnosa 
     $whereSql
     GROUP BY nm_penyakit 
     ORDER BY jumlah DESC"
);
while ($c = mysqli_fetch_assoc($qChart)) {
    $chartLabels[] = $c['nm_penyakit'];
    $chartData[]   = $c['jumlah'];
}

// =================== UPDATE TERAKHIR (GLOBAL) ===================
$qLast = mysqli_query($conn, "SELECT MAX(tgl_diag) AS tgl FROM diagnosa");
$rLast = mysqli_fetch_assoc($qLast);
$last_update = $rLast['tgl'] ? date('d M Y H:i', strtotime($rLast['tgl'])) . ' WIB' : 'Belum ada diagnosa';

?>

<!-- ========== HEADING + FILTER RANGE ========== -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Dashboard Admin</h3>
        <p class="text-muted mb-0">
            Ringkasan aktivitas sistem pakar &mdash; <span class="fw-semibold"><?= date('d M Y'); ?></span>
        </p>
    </div>

    <div class="text-end">
        <div class="mb-1 small text-muted">
            <i class="bi bi-clock"></i> <?= date('H:i'); ?> WIB &nbsp;|&nbsp;
            <i class="bi bi-arrow-repeat"></i> Update terakhir: <?= $last_update; ?>
        </div>

        <div class="btn-group btn-group-sm" role="group">
            <a href="index.php?range=day"
               class="btn <?= ($range=='day')?'btn-primary':'btn-outline-primary'; ?>">Harian</a>
            <a href="index.php?range=week"
               class="btn <?= ($range=='week')?'btn-primary':'btn-outline-primary'; ?>">Mingguan</a>
            <a href="index.php?range=month"
               class="btn <?= ($range=='month')?'btn-primary':'btn-outline-primary'; ?>">Bulanan</a>
            <a href="index.php?range=all"
               class="btn <?= ($range=='all')?'btn-primary':'btn-outline-primary'; ?>">Semua</a>
        </div>
    </div>
</div>
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Laporan Hasil Diagnosa</h3>
        <button class="btn btn-success" onclick="window.print()">Cetak Laporan</button>
    </div>
<!-- ========== KARTU STATISTIK TOTAL (GLOBAL) ========== -->
<div class="row g-3 mb-4">

    <!-- Penyakit -->
    <div class="col-md-3">
        <div class="card card-stat p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1 small">Data Penyakit</h6>
                    <h2 class="fw-bold mb-0 display-6"><?= $total_penyakit; ?></h2>
                    <small class="text-muted">Jumlah jenis penyakit</small>
                </div>
                <i class="bi bi-virus stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Gejala -->
    <div class="col-md-3">
        <div class="card card-stat p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1 small">Data Gejala</h6>
                    <h2 class="fw-bold mb-0 display-6"><?= $total_gejala; ?></h2>
                    <small class="text-muted">Total gejala di basis data</small>
                </div>
                <i class="bi bi-clipboard-pulse stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Pasien -->
    <div class="col-md-3">
        <div class="card card-stat p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1 small">Total Pasien</h6>
                    <h2 class="fw-bold mb-0 display-6"><?= $total_pasien; ?></h2>
                    <small class="text-muted">User terdaftar</small>
                </div>
                <i class="bi bi-people-fill stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Diagnosa -->
    <div class="col-md-3">
        <div class="card card-stat p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-1 small">Total Diagnosa</h6>
                    <h2 class="fw-bold mb-0 display-6"><?= $total_diag; ?></h2>
                    <small class="text-muted">Semua riwayat pemeriksaan</small>
                </div>
                <i class="bi bi-file-earmark-medical stat-icon"></i>
            </div>
        </div>
    </div>

</div>
<!-- ========== GRAFIK & DIAGNOSA TERBARU (BY RANGE) ========== -->
<div class="row g-4 mb-5">
    <!-- Grafik -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">
                    <?php
                    if     ($range == 'month') echo "Proporsi Penyakit (Donut)";
                    elseif ($range == 'week')  echo "Distribusi Penyakit Mingguan";
                    elseif ($range == 'day')   echo "Distribusi Penyakit Harian";
                    else                       echo "Distribusi Penyakit (Semua Waktu)";
                    ?>
                </span>
                <small class="text-muted"><?= $rangeText; ?></small>
            </div>
            <div class="card-body">
                <?php if (empty($chartLabels)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-emoji-neutral fs-1 d-block mb-2"></i>
                        Belum ada data diagnosa pada rentang waktu ini.
                    </div>
                <?php else: ?>
                    <canvas id="chartPenyakit" style="max-height:320px;"></canvas>

                    <?php if ($range == 'month'): ?>
                        <?php $totalChart = array_sum($chartData); ?>
                        <hr>
                        <h6 class="fw-bold small mb-2">Persentase tiap penyakit (<?= $rangeText; ?>):</h6>
                        <ul class="small mb-0">
                            <?php for ($i=0; $i < count($chartLabels); $i++): 
                                $persen = $totalChart ? ($chartData[$i] / $totalChart * 100) : 0;
                            ?>
                                <li>
                                    <strong><?= $chartLabels[$i]; ?></strong> :
                                    <?= $chartData[$i]; ?> kasus
                                    (<?= number_format($persen, 1); ?>%)
                                </li>
                            <?php endfor; ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Diagnosa Terbaru -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white fw-bold">
                Diagnosa Terbaru <span class="text-muted small">(&nbsp;<?= $rangeText; ?>&nbsp;)</span>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php
                    $qLastDiag = mysqli_query(
                        $conn,
                        "SELECT * FROM diagnosa 
                         $whereSql
                         ORDER BY tgl_diag DESC 
                         LIMIT 7"
                    );
                    if (mysqli_num_rows($qLastDiag) > 0) {
                        while ($r = mysqli_fetch_assoc($qLastDiag)) {
                            $tgl = date('d/m H:i', strtotime($r['tgl_diag']));
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                    <div>
                                        <div class='fw-semibold'>{$r['nm_pasien']}</div>
                                        <small class='text-muted'>$tgl</small>
                                    </div>
                                    <span class='badge bg-secondary'>{$r['nm_penyakit']}</span>
                                  </li>";
                        }
                    } else {
                        echo "<li class='list-group-item text-center text-muted py-4'>Tidak ada diagnosa pada rentang ini.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ========== FOOTER ========== -->
<footer class="pt-3 border-top text-center small text-muted">
    &copy; <?= date('Y'); ?> Sistem Pakar Diagnosa Penyakit Umum &mdash; Metode Forward Chaining.
</footer>

<!-- ========== SCRIPT GRAFIK ========== -->
<?php if (!empty($chartLabels)): ?>
<script>
const ctx = document.getElementById('chartPenyakit').getContext('2d');

// Data dari PHP
const dataLabels = <?= json_encode($chartLabels); ?>;
const dataValues = <?= json_encode($chartData); ?>;
const totalValue = dataValues.reduce((a, b) => a + b, 0);

// Palet warna lembut
const baseColors = [
  'rgba(78, 115, 223, 0.8)',
  'rgba(28, 200, 138, 0.8)',
  'rgba(246, 194, 62, 0.8)',
  'rgba(231, 74, 59, 0.8)',
  'rgba(90, 92, 105, 0.8)',
  'rgba(54, 185, 204, 0.8)',
  'rgba(151, 107, 190, 0.8)',
  'rgba(133, 135, 150, 0.8)'
];

const bgColors = [];
for (let i = 0; i < dataValues.length; i++) {
    bgColors.push(baseColors[i % baseColors.length]);
}

const chartType = '<?= $chartType; ?>';
const isDonut   = chartType === 'doughnut';

new Chart(ctx, {
    type: chartType,
    data: {
        labels: dataLabels,
        datasets: [{
            label: 'Jumlah Kasus',
            data: dataValues,
            backgroundColor: bgColors,
            borderColor: isDonut ? '#ffffff' : 'rgba(78, 115, 223, 1)',
            borderWidth: isDonut ? 2 : 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: isDonut }, // Legend hanya di donut (bulanan)
            tooltip: {
                enabled: true,
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed;
                        if (isDonut && totalValue > 0) {
                            const percent = (value / totalValue) * 100;
                            return `${label}: ${value} kasus (${percent.toFixed(1)}%)`;
                        } else {
                            return `${label}: ${value} kasus`;
                        }
                    }
                }
            }
        },
        scales: isDonut ? {} : {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
<?php endif; ?>

</div> <!-- penutup .container dari header.php -->
</body>
</html>