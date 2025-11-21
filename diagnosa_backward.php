<?php
session_start();
include 'koneksi.php';

// Hanya boleh diakses user
if (!isset($_SESSION['id_user']) || $_SESSION['akses'] != 'user') {
    header("Location: login.php");
    exit;
}

// Ambil semua penyakit untuk dropdown
$penyakit_list = [];
$qP = mysqli_query($conn, "SELECT * FROM penyakit ORDER BY id_penyakit ASC");
while ($p = mysqli_fetch_assoc($qP)) {
    $penyakit_list[] = $p;
}

// Baca input
$selected_penyakit = $_POST['id_penyakit'] ?? '';
$jawaban_user      = $_POST['gejala'] ?? [];

// Ambil gejala rule untuk penyakit yang dipilih
$gejala_rules = [];
if ($selected_penyakit != '') {
    $qG = mysqli_query(
        $conn,
        "SELECT g.kd_gejala, g.nm_gejala
         FROM rule r
         JOIN gejala g ON r.kd_gejala = g.kd_gejala
         WHERE r.id_penyakit = '$selected_penyakit'
         ORDER BY g.kd_gejala ASC"
    );
    while ($g = mysqli_fetch_assoc($qG)) {
        $gejala_rules[] = $g;
    }
}

// Flag untuk menampilkan hasil
$show_result = isset($_POST['proses']) && $selected_penyakit != '' && count($gejala_rules) > 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Diagnosa Backward Chaining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="pasien_home.php">
        <i class="bi bi-activity"></i> Sistem Pakar
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navPasien">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navPasien">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="pasien_home.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="diagnosa.php">Forward</a></li>
        <li class="nav-item"><a class="nav-link active" href="diagnosa_backward.php">Backward</a></li>
        <li class="nav-item ms-2"><a class="btn btn-danger btn-sm" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mb-5">

    <!-- STEP 1: PILIH PENYAKIT -->
    <div class="card shadow-sm border-0 card-step mb-4">
        <div class="card-header bg-success text-white">
            <span class="step-badge bg-white text-success">1</span>
            <span class="step-title text-white">Pilih Penyakit (Goal) - Backward Chaining</span>
        </div>
        <div class="card-body">
            <p class="small text-muted">
                Metode backward chaining memulai penalaran dari <strong>hipotesis penyakit</strong>.
                Silakan pilih penyakit yang ingin Anda uji terlebih dahulu.
            </p>

            <form method="POST" class="row g-3">
                <div class="col-md-8">
                    <label class="fw-bold mb-1">Penyakit yang ingin diperiksa:</label>
                    <select name="id_penyakit" class="form-select" required>
                        <option value="">-- Pilih Penyakit --</option>
                        <?php foreach ($penyakit_list as $p): ?>
                            <option value="<?= $p['id_penyakit']; ?>"
                                <?= ($selected_penyakit == $p['id_penyakit']) ? 'selected' : ''; ?>>
                                <?= $p['id_penyakit']; ?> - <?= $p['nm_penyakit']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-arrow-right-circle"></i> Lanjut ke Gejala
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- STEP 2: TAMPIL GEJALA DAN INPUT JAWABAN -->
    <?php if ($selected_penyakit != '' && count($gejala_rules) > 0): ?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">
                <span class="step-badge">2</span>
                <span class="step-title">Konfirmasi Gejala untuk Penyakit Terpilih</span>
            </div>
            <div class="card-body">
                <?php
                // Ambil nama penyakit
                $qNama = mysqli_query($conn, "SELECT nm_penyakit FROM penyakit WHERE id_penyakit='$selected_penyakit'");
                $rowP  = mysqli_fetch_assoc($qNama);
                $nama_penyakit = $rowP['nm_penyakit'];
                ?>
                <p class="small text-muted">
                    Penyakit yang sedang diuji: <strong><?= $nama_penyakit; ?> (<?= $selected_penyakit; ?>)</strong>.<br>
                    Silakan centang gejala berikut yang benar-benar Anda rasakan.
                </p>

                <form method="POST">
                    <input type="hidden" name="id_penyakit" value="<?= $selected_penyakit; ?>">

                    <div class="scroll-area mb-3">
                        <?php foreach ($gejala_rules as $g): 
                            $cek = in_array($g['kd_gejala'], $jawaban_user) ? 'checked' : '';
                        ?>
                            <div class="gejala-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="gejala[]" value="<?= $g['kd_gejala']; ?>"
                                           id="g<?= $g['kd_gejala']; ?>" <?= $cek; ?>>
                                    <label class="form-check-label" for="g<?= $g['kd_gejala']; ?>">
                                        <span class="badge bg-secondary"><?= $g['kd_gejala']; ?></span>
                                        <span class="txt"><?= $g['nm_gejala']; ?></span>
                                    </label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="submit" name="proses" class="btn btn-success w-100">
                        <i class="bi bi-search"></i> Proses Diagnosa (Backward)
                    </button>
                </form>
            </div>
        </div>
    <?php elseif ($selected_penyakit != '' && count($gejala_rules) == 0): ?>
        <div class="alert alert-warning">
            Penyakit yang dipilih belum memiliki aturan/gejala di basis pengetahuan. 
            Silakan hubungi admin untuk melengkapi rule.
        </div>
    <?php endif; ?>

    <!-- STEP 3: HASIL BACKWARD -->
    <?php
    if ($show_result) {
        // Hitung cocokan rule
        $kode_rule = array_column($gejala_rules, 'kd_gejala');
        $terpenuhi = count(array_intersect($kode_rule, $jawaban_user));
        $total     = count($kode_rule);

        ?>
        <div class="result-box shadow-sm">
            <h4 class="text-success mb-2">Kesimpulan Backward Chaining</h4>
            <p class="mb-1">
                Penyakit yang diuji: <strong><?= $nama_penyakit; ?> (<?= $selected_penyakit; ?>)</strong>
            </p>
            <p class="mb-3">
                Gejala terpenuhi: <strong><?= $terpenuhi; ?> dari <?= $total; ?></strong> gejala yang disyaratkan.
            </p>

            <?php if ($terpenuhi == $total && $total > 0): ?>
                <div class="alert alert-success mb-3">
                    Semua gejala yang menjadi premis penyakit <strong><?= $nama_penyakit; ?></strong> terpenuhi.
                    Hipotesis penyakit ini <strong>kuat didukung</strong> oleh gejala Anda.
                </div>
            <?php else: ?>
                <div class="alert alert-warning mb-3">
                    Tidak semua gejala penyakit <strong><?= $nama_penyakit; ?></strong> terpenuhi.
                    Hipotesis ini <strong>belum bisa dipastikan</strong>. 
                    Pertimbangkan kemungkinan penyakit lain dan konsultasikan dengan dokter.
                </div>
            <?php endif; ?>

            <h6 class="fw-bold">Rincian Gejala:</h6>
            <ul class="list-group list-group-flush mb-3">
                <?php foreach ($gejala_rules as $g): 
                    $ada = in_array($g['kd_gejala'], $jawaban_user);
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= $g['nm_gejala']; ?></span>
                        <?php if ($ada): ?>
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> Ya
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary">
                                <i class="bi bi-x-circle"></i> Tidak
                            </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="alert alert-light border small mb-0">
                <i class="bi bi-info-circle"></i>
                Pada backward chaining, sistem memulai dari <strong>hipotesis penyakit</strong> kemudian 
                menurunkan ke <strong>gejala-gejala penyusunnya</strong>. Semakin banyak gejala yang cocok,
                semakin kuat dukungan terhadap hipotesis tersebut.
            </div>
        </div>
        <?php

        // Simpan ke riwayat diagnosa (opsional, tapi konsisten)
        $id_user   = $_SESSION['id_user'];
        $nm_pasien = $_SESSION['nm_lengkap'];
        $g_str     = implode(",", $jawaban_user);
        $info_db   = "Backward: $terpenuhi/$total gejala";

        mysqli_query(
            $conn,
            "INSERT INTO diagnosa (id_user, nm_pasien, nm_penyakit, gejala_dipilih, persentase)
             VALUES ('$id_user', '$nm_pasien', '$nama_penyakit', '$g_str', '$info_db')"
        );
    }
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>