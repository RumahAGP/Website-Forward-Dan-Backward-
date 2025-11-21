<?php include 'header.php'; 

// Tambah Data
if(isset($_POST['simpan'])){
    $id = $_POST['id']; $nm = $_POST['nm'];
    $cek = mysqli_query($conn, "SELECT * FROM gejala WHERE kd_gejala='$id'");
    if(mysqli_num_rows($cek) == 0){
        mysqli_query($conn, "INSERT INTO gejala VALUES ('$id', '$nm')");
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "<div class='alert alert-danger'>Kode Gejala sudah ada!</div>";
    }
}

// Hapus Data
if(isset($_GET['hapus'])){
    mysqli_query($conn, "DELETE FROM gejala WHERE kd_gejala='{$_GET['hapus']}'");
    echo "<script>window.location='gejala.php';</script>";
}
?>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card p-3">
            <h5 class="mb-3">Tambah Gejala</h5>
            <form method="POST">
                <div class="mb-2">
                    <label>Kode Gejala</label>
                    <input type="text" name="id" class="form-control" placeholder="Contoh: G01" required>
                </div>
                <div class="mb-2">
                    <label>Nama Gejala</label>
                    <input type="text" name="nm" class="form-control" placeholder="Nama Gejala" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card p-3">
            <h5 class="mb-3">Data Gejala</h5>
            <!-- Agar tabel bisa discroll jika data banyak -->
            <div style="max-height: 500px; overflow-y: auto;">
                <table class="table table-bordered table-hover">
                    <thead class="table-light" style="position: sticky; top: 0;">
                        <tr><th>Kode</th><th>Nama Gejala</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        $q = mysqli_query($conn, "SELECT * FROM gejala ORDER BY kd_gejala ASC");
                        while($r = mysqli_fetch_assoc($q)){
                            echo "<tr>
                                <td width='100'>{$r['kd_gejala']}</td>
                                <td>{$r['nm_gejala']}</td>
                                <td width='80'>
                                    <a href='?hapus={$r['kd_gejala']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus data ini?')\">Hapus</a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>