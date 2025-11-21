<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $nama = $_POST['nm_lengkap'];
    $user = $_POST['nm_user'];
    $pass = $_POST['nm_passwd']; // Di real project sebaiknya di-hash

    // Cek username duplikat
    $cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE nm_user = '$user'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah dipakai, pilih yang lain!');</script>";
    } else {
        // Insert sebagai 'user'
        $q = "INSERT INTO pengguna (nm_lengkap, nm_user, nm_passwd, akses) VALUES ('$nama', '$user', '$pass', 'user')";
        if (mysqli_query($conn, $q)) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Pasien Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card p-4 shadow" style="width: 400px;">
        <h3 class="text-center mb-3">Registrasi Pasien</h3>
        <form method="POST">
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nm_lengkap" class="form-control" required placeholder="Misal: Budi Santoso">
            </div>
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="nm_user" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="nm_passwd" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-primary w-100">Daftar Sekarang</button>
            <div class="text-center mt-3">
                Sudah punya akun? <a href="login.php">Login disini</a>
            </div>
        </form>
    </div>
</body>
</html>