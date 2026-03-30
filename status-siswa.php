<?php
// ================= SESSION =================
// Memulai session (biasanya untuk login)
session_start();

// ================= KONEKSI DATABASE =================
// Menghubungkan ke database
include 'db.php';
?>

<!DOCTYPE html>
<html>

<head>
    <!-- ================= JUDUL ================= -->
    <title>Cek Status Aspirasi</title>

    <!-- ================= CSS ================= -->
    <link rel="stylesheet" href="css/status.css">
</head>

<body>

    <div class="container">

        <!-- ================= TOMBOL KEMBALI ================= -->
        <div class="top-bar">
            <a href="dashboard-siswa.php" class="btn-back">← Kembali</a>
        </div>

        <h2>Cek Status Aspirasi</h2>


        <!-- ================= FORM SEARCH ================= -->
        <form method="GET" class="search-box">

            <!-- Input NIS -->
            <input type="text"
                name="nis"
                placeholder="Masukkan NIS Anda"
                value="<?= isset($_GET['nis']) ? htmlspecialchars($_GET['nis']) : '' ?>">

            <!-- Tombol cari -->
            <button type="submit">Cari</button>

            <!-- Reset -->
            <a href="status-siswa.php" class="btn-reset">
                Tampilkan Semua
            </a>

        </form>


        <?php

        // ================= AMBIL FILTER =================
        $nis_filter = "";

        // Jika ada input NIS
        if (isset($_GET['nis']) && $_GET['nis'] != "") {
            $nis_filter = $_GET['nis'];
        }


        // ================= QUERY DATA =================
        if ($nis_filter != "") {

            // Jika user mencari berdasarkan NIS
            $query = mysqli_query($conn, "
        SELECT 
        aspirasi.id_aspirasi,
        kategori.ket_kategori,
        input_aspirasi.lokasi,
        input_aspirasi.ket,
        aspirasi.status,
        aspirasi.feedback,
        input_aspirasi.nis
        FROM aspirasi
        JOIN input_aspirasi
        ON aspirasi.id_pelaporan = input_aspirasi.id_pelaporan
        JOIN kategori
        ON input_aspirasi.id_kategori = kategori.id_kategori
        WHERE input_aspirasi.nis='$nis_filter'
        ORDER BY aspirasi.id_aspirasi ASC
        ");
        } else {

            // Jika tidak pakai filter → tampilkan semua
            $query = mysqli_query($conn, "
        SELECT 
        aspirasi.id_aspirasi,
        kategori.ket_kategori,
        input_aspirasi.lokasi,
        input_aspirasi.ket,
        aspirasi.status,
        aspirasi.feedback,
        input_aspirasi.nis
        FROM aspirasi
        JOIN input_aspirasi
        ON aspirasi.id_pelaporan = input_aspirasi.id_pelaporan
        JOIN kategori
        ON input_aspirasi.id_kategori = kategori.id_kategori
        ORDER BY aspirasi.id_aspirasi ASC
        ");
        }


        // ================= CEK DATA =================
        if (mysqli_num_rows($query) > 0) {

            echo "<div class='table-wrapper'>";
            echo "<table>";

            // HEADER TABEL
            echo "<thead>
        <tr>
            <th>ID</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Feedback</th>
        </tr>
        </thead>";

            echo "<tbody>";

            // ================= LOOP DATA =================
            while ($row = mysqli_fetch_array($query)) {

                // ================= WARNA STATUS =================
                $statusClass = "";

                if ($row['status'] == "Menunggu") {
                    $statusClass = "menunggu";
                } elseif ($row['status'] == "Proses") {
                    $statusClass = "proses";
                } elseif ($row['status'] == "Selesai") {
                    $statusClass = "selesai";
                }

                // ================= HIGHLIGHT =================
                $highlight = "";
                if ($nis_filter != "" && $row['nis'] == $nis_filter) {
                    $highlight = "highlight-row";
                }

                // ================= TAMPIL DATA =================
                echo "<tr class='$highlight'>
                <td>{$row['id_aspirasi']}</td>
                <td>{$row['ket_kategori']}</td>
                <td>{$row['lokasi']}</td>
                <td>{$row['ket']}</td>
                <td><span class='$statusClass'>{$row['status']}</span></td>
                <td>{$row['feedback']}</td>
            </tr>";
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {

            // ================= JIKA DATA TIDAK ADA =================
            echo "<p class='notfound'>Data tidak ditemukan</p>";
        }

        ?>

    </div>
    <!-- ================= FOOTER ================= -->
    <footer class="footer">
        <p>© 2026 <b>WebAspirasi</b> | Sistem Aspirasi Siswa</p>
    </footer>
</body>

</html>