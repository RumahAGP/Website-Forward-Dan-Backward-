<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['akses']) || $_SESSION['akses'] != 'admin') {
    header("Location: ../login.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- PANGGIL CSS (Mundur satu folder ../) -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-admin mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-hospital"></i> ADMIN PANEL</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="penyakit.php">Penyakit</a></li>
        <li class="nav-item"><a class="nav-link" href="gejala.php">Gejala</a></li>
        <li class="nav-item"><a class="nav-link" href="rule.php">Rules</a></li>
        <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
        <li class="nav-item"><a class="nav-link text-danger fw-bold ms-3" href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container pb-5">