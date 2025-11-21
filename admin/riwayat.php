<?php include 'header.php'; 

// Hapus Log (Opsional)
if(isset($_GET['hapus'])){
    mysqli_query($conn, "DELETE FROM diagnosa WHERE id_diag='{$_GET['hapus']}'");
    echo "<script>window.location='riwayat.php';</script>";
}
?>

<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Laporan Hasil Diagnosa</h3>
        <button class="btn btn-success" onclick="window.print()">Cetak Laporan</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pasien</th>
                <th>Penyakit Terdeteksi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $q = mysqli_query($conn, "SELECT * FROM diagnosa ORDER BY tgl_diag DESC");
            while($r = mysqli_fetch_assoc($q)){
                echo "<tr>
                    <td>$no</td>
                    <td>{$r['tgl_diag']}</td>
                    <td>{$r['nm_pasien']}</td>
                    <td><span class='badge bg-primary'>{$r['nm_penyakit']}</span></td>
                    <td>
                        <a href='?hapus={$r['id_diag']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus riwayat ini?')\">Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>