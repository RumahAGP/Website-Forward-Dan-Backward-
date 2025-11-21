<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['akses'] != 'user') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda Pasien - Pilih Metode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="bi bi-activity"></i> Sistem Pakar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPasien">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navPasien">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <span class="nav-link disabled">Halo, <?= $_SESSION['nm_lengkap']; ?></span>
        </li>
        <li class="nav-item ms-2">
          <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mb-5">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Pilih Metode Diagnosa</h3>
        <p class="text-muted mb-0">
            Silakan pilih salah satu metode di bawah ini untuk melakukan diagnosa mandiri.
        </p>
    </div>

    <div class="row g-4">
        <!-- KIRI: FORWARD CHAINING -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-down-right-circle"></i> Metode Forward Chaining
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Cocok jika Anda ingin <strong>memasukkan gejala dulu</strong>,
                        kemudian sistem akan <strong>mencari sendiri penyakit yang paling mungkin</strong>.
                    </p>
                    <ul class="small">
                        <li>Anda centang semua gejala yang dirasakan.</li>
                        <li>Sistem membandingkan dengan rule pakar.</li>
                        <li>Hasil: rekomendasi penyakit berdasarkan gejala.</li>
                    </ul>
                </div>
                <div class="card-footer bg-light text-end">
                    <a href="diagnosa.php" class="btn btn-primary">
                        Mulai Forward Chaining <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- KANAN: BACKWARD CHAINING -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-arrow-up-right-circle"></i> Metode Backward Chaining
                    </h5>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Cocok jika Anda ingin <strong>mengujikan satu penyakit tertentu</strong>, 
                        lalu sistem akan <strong>mengecek apakah gejala-gejala penyakit itu Anda alami</strong>.
                    </p>
                    <ul class="small">
                        <li>Pilih penyakit yang ingin diperiksa.</li>
                        <li>Centang gejala yang Anda rasakan dari daftar aturan penyakit tersebut.</li>
                        <li>Hasil: apakah penyakit itu sangat mungkin / belum dapat dipastikan.</li>
                    </ul>
                </div>
                <div class="card-footer bg-light text-end">
                    <a href="diagnosa_backward.php" class="btn btn-success">
                        Mulai Backward Chaining <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>