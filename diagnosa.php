<?php
session_start();
include 'koneksi.php';

// Hanya boleh diakses user/pasien
if (!isset($_SESSION['id_user']) || $_SESSION['akses'] != 'user') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Diagnosa Penyakit - Forward Chaining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- NAVBAR PASIEN -->
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
        <li class="nav-item">
            <a class="nav-link" href="pasien_home.php">Beranda</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="diagnosa.php">Forward</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="diagnosa_backward.php">Backward</a>
        </li>
        <li class="nav-item ms-2">
            <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mb-5">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-stethoscope"></i> Diagnosa Penyakit (Metode Forward Chaining)
        </div>
        <div class="card-body">
            <p class="small text-muted">
                Forward chaining dimulai dari <strong>data gejala</strong>. 
                Silakan centang gejala yang Anda rasakan, kemudian sistem akan 
                <strong>mencari penyakit yang paling sesuai</strong> berdasarkan basis aturan pakar.
            </p>

            <form method="POST">
                <!-- Kolom Pencarian Gejala -->
                <div class="mb-3">
                    <label class="fw-bold">Cari Gejala:</label>
                    <input type="text" id="cari" onkeyup="filterGejala()" class="form-control"
                           placeholder="Ketik gejala... (misal: Demam, Batuk)">
                </div>

                <!-- Daftar Gejala (scroll) -->
                <label class="fw-bold mb-2">Pilih gejala yang Anda rasakan:</label>
                <div class="scroll-area mb-3" id="listGejala">
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM gejala ORDER BY kd_gejala ASC");
                    while ($r = mysqli_fetch_assoc($q)) {
                        echo "<div class='gejala-item'>
                                <div class='form-check'>
                                    <input class='form-check-input' type='checkbox' name='gejala[]'
                                           value='{$r['kd_gejala']}' id='{$r['kd_gejala']}'>
                                    <label class='form-check-label' for='{$r['kd_gejala']}'>
                                        <span class='badge bg-secondary'>{$r['kd_gejala']}</span>
                                        <span class='nama-gejala'>{$r['nm_gejala']}</span>
                                    </label>
                                </div>
                              </div>";
                    }
                    ?>
                </div>

                <button type="submit" name="proses" class="btn btn-success w-100 btn-lg">
                    <i class="bi bi-search"></i> Proses Diagnosa (Forward)
                </button>
            </form>
        </div>
    </div>

    <!-- HASIL DIAGNOSA -->
    <?php
    if (isset($_POST['proses'])) {

        $input_gejala = $_POST['gejala'] ?? [];

        if (empty($input_gejala)) {
            echo "<div class='alert alert-warning'>Silakan pilih minimal satu gejala terlebih dahulu.</div>";
        } else {
            // 1. Ambil aturan (rule) dari database
            $rules = [];
            $qR = mysqli_query($conn, "SELECT * FROM rule");
            while ($r = mysqli_fetch_assoc($qR)) {
                $rules[$r['id_penyakit']][] = $r['kd_gejala'];
            }

            if (empty($rules)) {
                echo "<div class='alert alert-danger mt-3'>Basis aturan masih kosong. Hubungi administrator.</div>";
            } else {
                // 2. Ambil nama penyakit
                $nama_penyakit = [];
                $qP = mysqli_query($conn, "SELECT * FROM penyakit");
                while ($p = mysqli_fetch_assoc($qP)) {
                    $nama_penyakit[$p['id_penyakit']] = $p['nm_penyakit'];
                }

                // 3. Mesin inferensi Forward Chaining
                $best_penyakit = null;
                $best_percent  = 0;

                foreach ($rules as $id_p => $gejala_wajib) {
                    $cocok  = array_intersect($gejala_wajib, $input_gejala);
                    $j_cocok = count($cocok);
                    $j_wajib = count($gejala_wajib);

                    if ($j_wajib > 0) {
                        $percent = ($j_cocok / $j_wajib) * 100;
                        if ($percent > $best_percent) {
                            $best_percent  = $percent;
                            $best_penyakit = $id_p;
                        }
                    }
                }

                if ($best_penyakit !== null && $best_percent > 0) {
                    // 4. Ambil nama penyakit & nama gejala yang dipilih user
                    $nama_final = $nama_penyakit[$best_penyakit];

                    // Ambil daftar nama gejala dari kode yang dipilih user
                    $kode_str = "'" . implode("','", $input_gejala) . "'";
                    $qG2 = mysqli_query($conn, "SELECT kd_gejala, nm_gejala FROM gejala WHERE kd_gejala IN ($kode_str)");
                    $list_gejala_user = [];
                    while ($g = mysqli_fetch_assoc($qG2)) {
                        $list_gejala_user[] = $g['nm_gejala'];
                    }

                    // 5. Tampilkan ke user (tanpa persentase angka)
                    echo "<div class='result-box shadow-sm mt-3'>
                            <h4 class='text-primary'>Hasil Diagnosa Forward Chaining</h4>
                            <h2 class='fw-bold mb-3'>$nama_final</h2>
                            <p class='text-muted mb-2'>
                                Berdasarkan gejala yang Anda pilih, sistem menyimpulkan bahwa
                                penyakit yang paling sesuai adalah <strong>$nama_final</strong>.
                            </p>
                            <hr>
                            <h6 class='fw-bold text-muted'>Gejala yang Anda laporkan:</h6>
                            <ul class='list-group list-group-flush'>";
                    foreach ($list_gejala_user as $nm_g) {
                        echo "<li class='list-group-item bg-transparent py-1'>
                                <i class='bi bi-check-circle-fill text-success'></i> $nm_g
                              </li>";
                    }
                    echo "  </ul>
                            <div class='mt-3 alert alert-light border small'>
                                <i class='bi bi-info-circle'></i>
                                Hasil ini merupakan bantuan sistem pakar. 
                                Untuk kepastian diagnosis, segera konsultasikan dengan dokter.
                            </div>
                          </div>";

                    // 6. Simpan ke tabel diagnosa (riwayat)
                    $id_user   = $_SESSION['id_user'];
                    $nm_pasien = $_SESSION['nm_lengkap'];
                    $g_str     = implode(",", $input_gejala);
                    $info_db   = round($best_percent) . "%"; // hanya untuk admin/laporan

                    mysqli_query($conn, "INSERT INTO diagnosa 
                            (id_user, nm_pasien, nm_penyakit, gejala_dipilih, persentase)
                            VALUES 
                            ('$id_user', '$nm_pasien', '$nama_final', '$g_str', '$info_db')");
                } else {
                    echo "<div class='alert alert-danger mt-3'>
                            Sistem tidak dapat menentukan penyakit berdasarkan kombinasi gejala yang dipilih.
                         </div>";
                }
            }
        }
    }
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Fungsi filter gejala di daftar (search realtime)
function filterGejala() {
    let input   = document.getElementById('cari');
    let filter  = input.value.toUpperCase();
    let parent  = document.getElementById('listGejala');
    let items   = parent.getElementsByClassName('gejala-item');

    for (let i = 0; i < items.length; i++) {
        let span = items[i].getElementsByClassName('nama-gejala')[0];
        let txt  = span.textContent || span.innerText;
        items[i].style.display = (txt.toUpperCase().indexOf(filter) > -1) ? "" : "none";
    }
}
</script>

</body>
</html>