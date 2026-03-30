<?php
// ================= SESSION =================
// Memulai session untuk menyimpan status login
session_start();

// ================= KONEKSI DATABASE =================
// Menghubungkan ke database
include 'db.php';
?>

<!DOCTYPE html>
<html>

<head>

    <!-- ================= JUDUL ================= -->
    <title>Login | WebAspirasi</title>

    <!-- ================= FONT ================= -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- ================= CSS ================= -->
    <link rel="stylesheet" href="css/login.css">

</head>

<body>

    <div class="login-container">

        <div class="login-box">

            <!-- ================= JUDUL HALAMAN ================= -->
            <h1>WebAspirasi</h1>
            <p class="subtitle">Sistem Pengelolaan Aspirasi Siswa</p>

            <!-- ================= FORM LOGIN ================= -->
            <form method="POST">

                <!-- INPUT USERNAME -->
                <div class="form-group">
                    <input type="text" name="user" placeholder="Username" required>
                </div>

                <!-- INPUT PASSWORD -->
                <div class="form-group">
                    <input type="password" name="pass" placeholder="Password" required>
                </div>

                <!-- TOMBOL LOGIN -->
                <button type="submit" name="submit" class="btn-login">
                    Login
                </button>

            </form>

            <?php
            // ================= PROSES LOGIN =================
            if (isset($_POST['submit'])) {

                // Mengambil input user dan password
                $user = mysqli_real_escape_string($conn, $_POST['user']);
                $pass = mysqli_real_escape_string($conn, $_POST['pass']);

                // ================= CEK DATA KE DATABASE =================
                // Mencocokkan username dan password (password di MD5)
                $cek = mysqli_query($conn, "SELECT * FROM admin
                WHERE Username='$user'
                AND password='" . MD5($pass) . "'");

                // ================= CEK HASIL =================
                if (mysqli_num_rows($cek) > 0) {

                    // Mengambil data admin
                    $d = mysqli_fetch_object($cek);

                    // ================= SIMPAN SESSION =================
                    $_SESSION['status_login'] = true; // tanda sudah login
                    $_SESSION['admin'] = $d; // simpan data admin
                    $_SESSION['id_admin'] = $d->id_admin; // simpan id admin

                    // ================= PINDAH HALAMAN =================
                    echo "<script>window.location='dashboard.php'</script>";

                } else {

                    // ================= JIKA LOGIN GAGAL =================
                    echo "<p class='error'>Username atau Password salah</p>";
                }
            }
            ?>

        </div>

    </div>

</body>

</html>