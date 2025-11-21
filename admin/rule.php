<?php include 'header.php'; 

// Simpan Rule Baru
if(isset($_POST['simpan'])){
    $id_penyakit = $_POST['id_penyakit'];
    $gejala = isset($_POST['gejala']) ? $_POST['gejala'] : [];

    if(empty($id_penyakit) || empty($gejala)){
        echo "<div class='alert alert-warning'>Pilih penyakit dan minimal 1 gejala!</div>";
    } else {
        // 1. Hapus rule lama untuk penyakit ini (Reset)
        mysqli_query($conn, "DELETE FROM rule WHERE id_penyakit='$id_penyakit'");

        // 2. Masukkan rule baru satu per satu
        foreach($gejala as $kd_gejala){
            mysqli_query($conn, "INSERT INTO rule (id_penyakit, kd_gejala) VALUES ('$id_penyakit', '$kd_gejala')");
        }
        echo "<div class='alert alert-success'>Aturan berhasil disimpan!</div>";
    }
}
?>

<div class="card p-4 mb-4">
    <h3>Setting Aturan (Rule)</h3>
    <p class="text-muted">Pilih penyakit, lalu centang gejala-gejala yang sesuai dengan jurnal.</p>
    
    <form method="POST">
        <div class="mb-3">
            <label class="fw-bold">1. Pilih Penyakit:</label>
            <select name="id_penyakit" class="form-select" required>
                <option value="">-- Pilih --</option>
                <?php 
                $qP = mysqli_query($conn, "SELECT * FROM penyakit");
                while($p = mysqli_fetch_assoc($qP)){
                    echo "<option value='{$p['id_penyakit']}'>{$p['id_penyakit']} - {$p['nm_penyakit']}</option>";
                }
                ?>
            </select>
        </div>

        <label class="fw-bold">2. Centang Gejala yang sesuai:</label>
        <div class="border p-3 rounded" style="max-height: 300px; overflow-y: auto; background: #fff;">
            <div class="row">
                <?php 
                $qG = mysqli_query($conn, "SELECT * FROM gejala ORDER BY kd_gejala ASC");
                while($g = mysqli_fetch_assoc($qG)){
                    echo "<div class='col-md-6'>
                            <div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='gejala[]' value='{$g['kd_gejala']}' id='g_{$g['kd_gejala']}'>
                                <label class='form-check-label' for='g_{$g['kd_gejala']}'>
                                    <span class='badge bg-secondary'>{$g['kd_gejala']}</span> {$g['nm_gejala']}
                                </label>
                            </div>
                          </div>";
                }
                ?>
            </div>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary w-100 mt-3">Simpan Aturan</button>
    </form>
</div>

<div class="card p-4">
    <h5>Daftar Aturan Tersimpan:</h5>
    <table class="table table-striped table-bordered">
        <thead><tr><th>Penyakit</th><th>Gejala Terkait</th></tr></thead>
        <tbody>
            <?php
            // Query canggih untuk menggabungkan nama gejala dalam satu kolom
            $sql = "SELECT p.nm_penyakit, GROUP_CONCAT(CONCAT(g.kd_gejala, ': ', g.nm_gejala) SEPARATOR '<br>') as daftar_gejala 
                    FROM rule r 
                    JOIN penyakit p ON r.id_penyakit = p.id_penyakit 
                    JOIN gejala g ON r.kd_gejala = g.kd_gejala 
                    GROUP BY p.id_penyakit";
            $qR = mysqli_query($conn, $sql);
            
            if(mysqli_num_rows($qR) > 0){
                while($row = mysqli_fetch_assoc($qR)){
                    echo "<tr>
                        <td width='25%' class='fw-bold align-top'>{$row['nm_penyakit']}</td>
                        <td class='align-top'>{$row['daftar_gejala']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='2' class='text-center'>Belum ada rule yang diatur.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>