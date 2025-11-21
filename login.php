<?php
// TAMPILKAN ERROR BIAR KETAHUAN KALAU ADA SALAH
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['nm_user']);
    $pass = $_POST['nm_passwd'];

    $sql  = "SELECT * FROM pengguna WHERE nm_user = '$user' LIMIT 1";
    $cek  = mysqli_query($conn, $sql);

    if ($cek && mysqli_num_rows($cek) === 1) {
        $d = mysqli_fetch_assoc($cek);

        // Login pakai password plain (atau hash kalau kamu ubah nanti)
        if ($pass === $d['nm_passwd'] || password_verify($pass, $d['nm_passwd'])) {

            $_SESSION['id_user']    = $d['id_user'];
            $_SESSION['nm_lengkap'] = $d['nm_lengkap'];
            $_SESSION['akses']      = $d['akses'];

            if ($d['akses'] === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: pasien_home.php"); // halaman pilihan forward/backward
            }
            exit;
        }
    }

    // Kalau sampai sini, berarti gagal
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Pakar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css"><!-- bg-login & card-login -->
</head>
<body class="bg-login">

<div class="card-login">
    <h3 class="text-center mb-3">LOGIN SISTEM PAKAR</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger py-2"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-floating mb-3">
            <input type="text" name="nm_user" class="form-control" id="user" placeholder="Username" required>
            <label for="user">Username</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" name="nm_passwd" class="form-control" id="pass" placeholder="Password" required>
            <label for="pass">Password</label>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100 py-2 mb-2">MASUK</button>
        <div class="text-center small mt-2">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </div>
    </form>
</div>

</body>
</html>