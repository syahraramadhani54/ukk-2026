<?php
// ================= MEMULAI SESSION =================
// Digunakan untuk menyimpan data sementara (misalnya login user)
session_start();

// ================= KONEKSI DATABASE =================
// Menghubungkan ke file db.php (isi koneksi database)
include 'db.php';


// ================= PROSES SUBMIT FORM =================
// Mengecek apakah tombol "submit" ditekan
if (isset($_POST['submit'])) {

    // ================= AMBIL DATA DARI FORM =================
    // Mengambil nilai input dari form
    $nis = $_POST['nis']; // NIS siswa
    $id_kategori = $_POST['id_kategori']; // kategori aspirasi
    $lokasi = $_POST['lokasi']; // lokasi kejadian
    $ket = $_POST['ket']; // keterangan aspirasi

    // ================= VALIDASI =================
    // Mengecek apakah semua input sudah diisi
    if (empty($nis) || empty($id_kategori) || empty($lokasi) || empty($ket)) {
        echo "<script>alert('Semua field harus diisi!');</script>";
        exit; // menghentikan program
    }

    // ================= INSERT KE TABEL input_aspirasi =================
    // Menyimpan data aspirasi ke database
    $insert = mysqli_query($conn, "INSERT INTO input_aspirasi
        (nis, id_kategori, lokasi, ket)
        VALUES ('$nis', '$id_kategori', '$lokasi', '$ket')");

    // ================= CEK BERHASIL ATAU TIDAK =================
    if ($insert) {

        // ================= AMBIL ID TERAKHIR =================
        // Mengambil ID terakhir dari data yang baru saja dimasukkan
        $id_pelaporan = mysqli_insert_id($conn);

        // ================= INSERT KE TABEL aspirasi =================
        // Menambahkan status awal dan feedback
        mysqli_query($conn, "INSERT INTO aspirasi
            (id_pelaporan, status, feedback)
            VALUES ('$id_pelaporan', 'Menunggu', '-')");

        // ================= NOTIFIKASI BERHASIL =================
        echo "<script>
            alert('Aspirasi berhasil dikirim!');
            window.location='status-siswa.php';
        </script>";
    } else {
        // ================= NOTIFIKASI GAGAL =================
        echo "<script>alert('Gagal mengirim aspirasi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Input Aspirasi</title>

    <!-- ================= MENGHUBUNGKAN CSS ================= -->
    <link rel="stylesheet" href="css/siswa.css">
</head>

<body>

    <div class="container">

        <!-- ================= TOMBOL KEMBALI ================= -->
        <a href="dashboard-siswa.php" class="btn-back">← Kembali</a>

        <h2>Form Input Aspirasi</h2>

        <!-- ================= FORM INPUT ================= -->
        <form method="POST">

            <!-- ================= PILIH NIS ================= -->
            <label>Pilih NIS</label>
            <select name="nis" required>
                <option value="" disabled selected>-- Pilih NIS --</option>

                <?php
                // Mengambil data siswa dari database
                $siswa = mysqli_query($conn, "SELECT * FROM siswa");

                // Menampilkan data ke dalam dropdown
                while ($data_siswa = mysqli_fetch_assoc($siswa)) {
                    echo "<option value='" . $data_siswa['nis'] . "'>
                        " . $data_siswa['nis'] . "
                      </option>";
                }
                ?>
            </select>


            <!-- ================= PILIH KATEGORI ================= -->
            <label>Pilih Kategori</label>
            <select name="id_kategori" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>

                <?php
                // Mengambil data kategori dari database
                $kategori = mysqli_query($conn, "SELECT * FROM kategori");

                // Menampilkan ke dropdown
                while ($data_kategori = mysqli_fetch_assoc($kategori)) {
                    echo "<option value='" . $data_kategori['Id_kategori'] . "'>
                        " . $data_kategori['Id_kategori'] . " - " . $data_kategori['ket_kategori'] . "
                      </option>";
                }
                ?>
            </select>


            <!-- ================= INPUT LOKASI ================= -->
            <label>Lokasi</label>
            <input type="text" name="lokasi" required>


            <!-- ================= INPUT KETERANGAN ================= -->
            <label>Keterangan</label>
            <textarea name="ket" rows="4" required></textarea>


            <!-- ================= TOMBOL SUBMIT ================= -->
            <button type="submit" name="submit">Kirim Aspirasi</button>

        </form>

    </div>

</body>
<footer class="footer">
    <p>© 2026 <b>WebAspirasi</b> | Sistem Aspirasi Siswa</p>
</footer>

</html>