<?php include 'header.php'; 

// Tambah Data
if(isset($_POST['simpan'])){
    $id = $_POST['id']; $nm = $_POST['nm'];
    $cek = mysqli_query($conn, "SELECT * FROM penyakit WHERE id_penyakit='$id'");
    if(mysqli_num_rows($cek) == 0){
        mysqli_query($conn, "INSERT INTO penyakit VALUES ('$id', '$nm')");
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "<div class='alert alert-danger'>Kode Penyakit sudah ada!</div>";
    }
}

// Hapus Data
if(isset($_GET['hapus'])){
    mysqli_query($conn, "DELETE FROM penyakit WHERE id_penyakit='{$_GET['hapus']}'");
    echo "<script>window.location='penyakit.php';</script>";
}
?>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card p-3">
            <h5 class="mb-3">Tambah Penyakit</h5>
            <form method="POST">
                <div class="mb-2">
                    <label>Kode Penyakit</label>
                    <input type="text" name="id" class="form-control" placeholder="Contoh: P01" required>
                </div>
                <div class="mb-2">
                    <label>Nama Penyakit</label>
                    <input type="text" name="nm" class="form-control" placeholder="Nama Penyakit" required>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card p-3">
            <h5 class="mb-3">Data Penyakit</h5>
            <table class="table table-bordered table-hover">
                <thead class="table-light"><tr><th>Kode</th><th>Nama Penyakit</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php 
                    $q = mysqli_query($conn, "SELECT * FROM penyakit ORDER BY id_penyakit ASC");
                    while($r = mysqli_fetch_assoc($q)){
                        echo "<tr>
                            <td width='100'>{$r['id_penyakit']}</td>
                            <td>{$r['nm_penyakit']}</td>
                            <td width='80'>
                                <a href='?hapus={$r['id_penyakit']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus data ini?')\">Hapus</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>