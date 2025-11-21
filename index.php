<?php
// 1. NYALAKAN PELAPORAN ERROR (Agar ketahuan kalau ada salah koding)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// 2. CEK KONEKSI DATABASE MANUAL DISINI
// Pastikan path koneksi benar. Jika di folder admin, berarti mundur satu langkah (../)
$path_koneksi = '../koneksi.php';

if (file_exists($path_koneksi)) {
    include $path_koneksi;
} else {
    die("<h1 style='color:red; text-align:center; margin-top:50px;'>FATAL ERROR: File koneksi.php tidak ditemukan di folder utama! <br> Cek struktur folder kamu.</h1>");
}

// 3. CEK VARIABEL KONEKSI
if (!$conn) {
    die("<h1 style='color:red;'>Database Gagal Connect: " . mysqli_connect_error() . "</h1>");
}

// 4. CEK LOGIN
if (!isset($_SESSION['akses']) || $_SESSION['akses'] != 'admin') {
    die("<script>alert('Bukan Admin!'); window.location='../login.php';</script>");
}

// --- AMBIL DATA UNTUK DASHBOARD (PHP) ---
// Hitung Penyakit
$qP = mysqli_query($conn, "SELECT COUNT(*) as total FROM penyakit");
$dP = mysqli_fetch_assoc($qP);
$total_penyakit = $dP['total'];

// Hitung Gejala
$qG = mysqli_query($conn, "SELECT COUNT(*) as total FROM gejala");
$dG = mysqli_fetch_assoc($qG);
$total_gejala = $dG['total'];

// Hitung Pasien
$qU = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengguna WHERE akses='user'");
$dU = mysqli_fetch_assoc($qU);
$total_pasien = $dU['total'];

// Hitung Diagnosa
$qD = mysqli_query($conn, "SELECT COUNT(*) as total FROM diagnosa");
$dD = mysqli_fetch_assoc($qD);
$total_diagnosa = $dD['total'];

// Data Grafik
$labels = [];
$totals = [];
$qChart = mysqli_query($conn, "SELECT nm_penyakit, COUNT(*) as jumlah FROM diagnosa GROUP BY nm_penyakit ORDER BY jumlah DESC");
while($row = mysqli_fetch_assoc($qChart)){
    $labels[] = $row['nm_penyakit'];
    $totals[] = $row['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Debug Mode</title>
    
    <!-- CDN LENGKAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background: #f4f6f9; }
        .card-stat { transition: .3s; border: none; border-radius: 10px; }
        .card-stat:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .icon-box { font-size: 3rem; opacity: 0.3; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">ADMINISTRATOR</a>
    <div class="d-flex">
        <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- MENU SEDERHANA -->
<div class="bg-white shadow-sm py-2 mb-4">
    <div class="container">
        <a href="index.php" class="btn btn-primary btn-sm me-2">Dashboard</a>
        <a href="penyakit.php" class="btn btn-outline-secondary btn-sm me-2">Penyakit</a>
        <a href="gejala.php" class="btn btn-outline-secondary btn-sm me-2">Gejala</a>
        <a href="rule.php" class="btn btn-outline-secondary btn-sm me-2">Rule</a>
        <a href="riwayat.php" class="btn btn-outline-secondary btn-sm me-2">Riwayat</a>
    </div>
</div>

<div class="container">

    <!-- PESAN DEBUG -->
    <?php if($total_penyakit == 0 || $total_gejala == 0): ?>
    <div class="alert alert-danger">
        <strong>PERINGATAN:</strong> Database kamu masih kosong! Silakan jalankan SQL Insert dulu di phpMyAdmin.
    </div>
    <?php endif; ?>

    <!-- KARTU STATISTIK -->
    <div class="row g-4 mb-4">
        <!-- Penyakit -->
        <div class="col-md-3">
            <div class="card card-stat bg-primary text-white h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-0">Total Penyakit</h6>
                        <h2 class="fw-bold mb-0"><?= $total_penyakit ?></h2>
                    </div>
                    <i class="bi bi-virus icon-box"></i>
                </div>
            </div>
        </div>
        <!-- Gejala -->
        <div class="col-md-3">
            <div class="card card-stat bg-success text-white h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-0">Total Gejala</h6>
                        <h2 class="fw-bold mb-0"><?= $total_gejala ?></h2>
                    </div>
                    <i class="bi bi-activity icon-box"></i>
                </div>
            </div>
        </div>
        <!-- Pasien -->
        <div class="col-md-3">
            <div class="card card-stat bg-warning text-dark h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-0">Total Pasien</h6>
                        <h2 class="fw-bold mb-0"><?= $total_pasien ?></h2>
                    </div>
                    <i class="bi bi-people-fill icon-box"></i>
                </div>
            </div>
        </div>
        <!-- Diagnosa -->
        <div class="col-md-3">
            <div class="card card-stat bg-danger text-white h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-0">Riwayat Diagnosa</h6>
                        <h2 class="fw-bold mb-0"><?= $total_diagnosa ?></h2>
                    </div>
                    <i class="bi bi-file-medical icon-box"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- GRAFIK & TABEL -->
    <div class="row">
        <!-- Grafik -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-bold">Grafik Penyakit</div>
                <div class="card-body">
                    <?php if(empty($labels)): ?>
                        <div class="text-center py-5 text-muted">Belum ada data diagnosa untuk ditampilkan di grafik.</div>
                    <?php else: ?>
                        <canvas id="chartPenyakit"></canvas>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tabel Mini -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-bold">5 Diagnosa Terakhir</div>
                <ul class="list-group list-group-flush">
                    <?php
                    $qList = mysqli_query($conn, "SELECT * FROM diagnosa ORDER BY tgl_diag DESC LIMIT 5");
                    if(mysqli_num_rows($qList) > 0){
                        while($r = mysqli_fetch_assoc($qList)){
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                    <div>
                                        <strong>{$r['nm_pasien']}</strong><br>
                                        <small class='text-muted'>{$r['nm_penyakit']}</small>
                                    </div>
                                    <span class='badge bg-secondary rounded-pill'>Done</span>
                                  </li>";
                        }
                    } else {
                        echo "<li class='list-group-item text-center text-muted'>Kosong</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT CHART JS -->
<?php if(!empty($labels)): ?>
<script>
    const ctx = document.getElementById('chartPenyakit');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Jumlah Kasus',
                data: <?= json_encode($totals) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
<?php endif; ?>

</body>
</html>