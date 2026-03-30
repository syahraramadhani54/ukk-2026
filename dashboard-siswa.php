<?php
// Memulai session untuk menyimpan data login
session_start();

// Menghubungkan file ke database
include 'db.php';

// Mengecek apakah tombol login ditekan (form dikirim)
if (isset($_POST['login'])) {

    // Mengambil input username dari form
    $user = $_POST['username'];

    // Mengambil input password dari form
    $pass = $_POST['password'];

    // Query untuk mengecek apakah username dan password cocok di tabel admin
    $cek = mysqli_query($conn, "SELECT * FROM admin 
                                WHERE username='$user' 
                                AND password='$pass'");

    // Mengecek apakah data ditemukan (artinya login berhasil)
    if (mysqli_num_rows($cek) > 0) {

        // Membuat session sebagai tanda bahwa admin sudah login
        $_SESSION['status_login'] = true;

        // Mengarahkan ke halaman dashboard admin
        header("Location: dashboard_admin.php");
        exit; // Menghentikan eksekusi agar tidak lanjut ke bawah

    } else {

        // Jika login gagal maka muncul alert
        echo "<script>alert('Login gagal!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Judul halaman -->
    <title>Dashboard Siswa | Web Aspirasi</title>

    <!-- Menghubungkan font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Menghubungkan file CSS khusus halaman siswa -->
    <link rel="stylesheet" type="text/css" href="css/siswa.css">
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">

        <!-- Logo atau nama website -->
        <div class="logo">
            Web Aspirasi
        </div>

        <!-- Bagian kanan navbar -->
        <div class="nav-right">

            <!-- Tombol menuju halaman login -->
            <a href="login.php" class="btn-login">Login</a>
        </div>
    </div>

    <!-- HERO SECTION (Bagian sambutan utama) -->
    <div class="hero">

        <!-- Judul besar -->
        <h1>Sampaikan Aspirasi Anda</h1>

        <!-- Deskripsi singkat -->
        <p>Platform resmi siswa untuk menyampaikan saran, laporan, dan aspirasi kepada sekolah.</p>
    </div>

    <!-- MENU UTAMA -->
    <div class="menu-container">

        <!-- Card menu untuk input aspirasi -->
        <div class="menu-card">

            <!-- Icon -->
            <div class="icon">📩</div>

            <!-- Judul fitur -->
            <h3>Input Aspirasi</h3>

            <!-- Penjelasan fitur -->
            <p>Kirimkan aspirasi atau laporan Anda dengan mudah.</p>

            <!-- Tombol menuju halaman input aspirasi -->
            <a href="input-aspirasi-siswa.php" class="btn-main">Mulai Sekarang</a>
        </div>

        <!-- Card menu untuk cek status -->
        <div class="menu-card">

            <!-- Icon -->
            <div class="icon">📊</div>

            <!-- Judul fitur -->
            <h3>Lihat Status</h3>

            <!-- Penjelasan fitur -->
            <p>Periksa perkembangan aspirasi yang sudah dikirim.</p>

            <!-- Tombol menuju halaman cek status -->
            <a href="status-siswa.php" class="btn-main">Cek Status</a>
        </div>

    </div>

</body>
<footer class="footer">
    <p>© 2026 <b>WebAspirasi</b> | Sistem Aspirasi Siswa</p>
</footer>

</html>