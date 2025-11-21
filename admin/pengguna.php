<?php include 'header.php'; 

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    // Cegah hapus admin sendiri
    if($id != $_SESSION['id_user']){
        mysqli_query($conn, "DELETE FROM pengguna WHERE id_user='$id'");
    }
    echo "<script>window.location='pengguna.php';</script>";
}
?>

<div class="card p-4">
    <h3>Data Pengguna Terdaftar</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Akses</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $q = mysqli_query($conn, "SELECT * FROM pengguna ORDER BY akses ASC, nm_lengkap ASC");
            while($r = mysqli_fetch_assoc($q)){
                $btn = ($r['akses'] == 'admin') ? "<span class='badge bg-success'>Admin</span>" : 
                       "<a href='?hapus={$r['id_user']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Hapus user ini?')\">Hapus</a>";
                
                echo "<tr>
                    <td>$no</td>
                    <td>{$r['nm_lengkap']}</td>
                    <td>{$r['nm_user']}</td>
                    <td>{$r['akses']}</td>
                    <td>$btn</td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>