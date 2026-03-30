    <?php
    // =====================================================
    // 1. MEMULAI SESSION
    // =====================================================
    // session_start() dipakai supaya kita bisa simpan data login
    // misalnya: admin sudah login atau belum
    session_start();


    // =====================================================
    // 2. KONEKSI DATABASE
    // =====================================================
    // Menghubungkan ke file db.php (isi koneksi MySQL)
    include 'db.php';


    // =====================================================
    // 3. CEK LOGIN ADMIN
    // =====================================================
    // Kalau belum login → langsung lempar ke login.php
    if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
        echo "<script>window.location='login.php'</script>";
        exit;
    }


    // =====================================================
    // 4. MENGHITUNG DATA UNTUK DASHBOARD (CARD)
    // =====================================================

    // Hitung jumlah siswa
    $jml_siswa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM siswa"));

    // Hitung jumlah kategori
    $jml_kategori = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM kategori"));

    // Hitung jumlah semua aspirasi
    $jml_aspirasi = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM aspirasi"));

    // Hitung jumlah aspirasi yang selesai
    $jml_selesai = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM aspirasi WHERE status='Selesai'"));


    // =====================================================
    // 5. AMBIL DATA FILTER DARI FORM
    // =====================================================

    // Ambil nilai dari URL (method GET)
    $bulan    = isset($_GET['bulan']) ? $_GET['bulan'] : '';
    $tanggal  = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';
    $nis      = isset($_GET['nis']) ? $_GET['nis'] : '';
    $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';


    // =====================================================
    // 6. LOGIKA FILTER (WHERE)
    // =====================================================

    // WHERE 1=1 artinya kondisi awal selalu benar
    $where = "WHERE 1=1";

    // Filter bulan
    if ($bulan != "") {
        $where .= " AND MONTH(input_aspirasi.created_at) = '$bulan'";
    }

    // Filter tanggal
    if ($tanggal != "") {
        $where .= " AND DATE(input_aspirasi.created_at) = '$tanggal'";
    }

    // Filter siswa
    if ($nis != "") {
        $where .= " AND siswa.nis = '$nis'";
    }

    // Filter kategori
    if ($kategori != "") {
        $where .= " AND kategori.id_kategori = '$kategori'";
    }


    // =====================================================
    // 7. QUERY DATA (JOIN BEBERAPA TABEL)
    // =====================================================
    $query = mysqli_query($conn, "
    SELECT
        aspirasi.id_aspirasi,
        input_aspirasi.created_at,
        siswa.nis,
        siswa.kelas,
        kategori.ket_kategori,
        input_aspirasi.lokasi,
        input_aspirasi.ket,
        aspirasi.status,
        aspirasi.feedback

    FROM aspirasi

    JOIN input_aspirasi
    ON aspirasi.id_pelaporan = input_aspirasi.id_pelaporan

    JOIN siswa
    ON input_aspirasi.nis = siswa.nis

    JOIN kategori
    ON input_aspirasi.id_kategori = kategori.id_kategori

    $where

    ORDER BY aspirasi.id_aspirasi ASC
    ");


    // =====================================================
    // 8. DATA UNTUK DROPDOWN FILTER
    // =====================================================

    // Ambil semua siswa
    $data_siswa = mysqli_query($conn, "SELECT * FROM siswa");

    // Ambil semua kategori
    $data_kategori = mysqli_query($conn, "SELECT * FROM kategori");

    ?>


    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard Admin</title>

        <!-- Menghubungkan ke CSS -->
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>

        <!-- =====================================================
    9. NAVBAR
    ===================================================== -->
        <div class="navbar-admin">
            <div class="logo"><b>Dashboard Admin</b></div>

            <ul class="menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="data-aspirasi.php">Data Aspirasi</a></li>
                <li><a href="kategori.php">Kategori</a></li>
                <li><a href="siswa.php">Siswa</a></li>
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </div>


        <div class="container">

            <!-- =====================================================
    10. CARD STATISTIK
    ===================================================== -->
            <div class="cards">

                <div class="card">
                    <h3>Total Siswa</h3>
                    <p><?= $jml_siswa ?></p>
                </div>

                <div class="card">
                    <h3>Total Kategori</h3>
                    <p><?= $jml_kategori ?></p>
                </div>

                <div class="card">
                    <h3>Total Aspirasi</h3>
                    <p><?= $jml_aspirasi ?></p>
                </div>

                <div class="card">
                    <h3>Aspirasi Selesai</h3>
                    <p><?= $jml_selesai ?></p>
                </div>

            </div>


            <!-- =====================================================
    11. FILTER DATA
    ===================================================== -->
            <h2>Filter Aspirasi</h2>

            <form method="GET" class="filter">

                <!-- Filter bulan -->
                <select name="bulan">
                    <option value="">Semua Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>

                <!-- Filter tanggal -->
                <input type="date" name="tanggal">

                <!-- Filter siswa -->
                <select name="nis">
                    <option value="">Semua Siswa</option>

                    <?php while ($s = mysqli_fetch_array($data_siswa)) { ?>
                        <option value="<?= $s['nis'] ?>">
                            <?= $s['nis'] ?> - <?= $s['kelas'] ?>
                        </option>
                    <?php } ?>
                </select>

                <!-- Filter kategori -->
                <select name="kategori">
                    <option value="">Semua Kategori</option>

                    <?php while ($k = mysqli_fetch_array($data_kategori)) { ?>
                        <option value="<?= $k['Id_kategori'] ?>">
                            <?= $k['ket_kategori'] ?>
                        </option>
                    <?php } ?>
                </select>

                <button type="submit">Filter</button>

            </form>


            <!-- =====================================================
    12. TABEL DATA
    ===================================================== -->
            <h2>Data Aspirasi</h2>

            <div class="table-box">
                <table>

                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Feedback</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_array($query)) {

                        // Menentukan warna status
                        $statusClass = "";

                        if ($row['status'] == "Menunggu") {
                            $statusClass = "menunggu";
                        } elseif ($row['status'] == "Proses") {
                            $statusClass = "proses";
                        } elseif ($row['status'] == "Selesai") {
                            $statusClass = "selesai";
                        }
                    ?>

                        <tr>
                            <td><?= $row['id_aspirasi'] ?></td>
                            <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                            <td><?= $row['nis'] ?></td>
                            <td><?= $row['kelas'] ?></td>
                            <td><?= $row['ket_kategori'] ?></td>
                            <td><?= $row['lokasi'] ?></td>
                            <td><?= $row['ket'] ?></td>

                            <td class="<?= $statusClass ?>"><?= $row['status'] ?></td>

                            <td><?= $row['feedback'] ?></td>
                        </tr>

                    <?php } ?>

                </table>
            </div>

        </div>
        <footer class="footer">
            <p>© 2026 <b>WebAspirasi</b> | Sistem Aspirasi Siswa</p>
        </footer>
    </body>

    </html>
