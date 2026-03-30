<?php
// =====================================================
// MEMULAI SESSION
// =====================================================
session_start();

// =====================================================
// MENGHUBUNGKAN DATABASE
// =====================================================
include 'db.php';


// =====================================================
// CEK LOGIN ADMINPending. 
// =====================================================
// Jika admin belum login maka diarahkan ke halaman login
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}


// =====================================================
// FITUR PENCARIAN DATA
// =====================================================
// Mengambil keyword dari input search
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';


// =====================================================
// PROSES UPDATE DATA ASPIRASI
// =====================================================
// Jika tombol update dari popup ditekan
if (isset($_POST['update'])) {

    // Mengambil data dari form popup
    $id       = $_POST['id_aspirasi'];
    $status   = $_POST['status'];
    $feedback = $_POST['feedback'];

    // Query update data aspirasi
    mysqli_query($conn, "UPDATE aspirasi 
        SET status='$status', feedback='$feedback'
        WHERE id_aspirasi='$id'
    ");

    // Reload halaman
    echo "<script>
            alert('Data aspirasi berhasil diupdate');
            window.location='data-aspirasi.php';
          </script>";
}


// =====================================================
// QUERY MENAMPILKAN DATA ASPIRASI
// =====================================================
$query = mysqli_query($conn, "
SELECT 
    aspirasi.id_aspirasi,
    DATE(input_aspirasi.created_at) AS tanggal,
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

WHERE
    siswa.nis LIKE '%$keyword%' OR
    DATE(input_aspirasi.created_at) LIKE '%$keyword%' OR
    kategori.ket_kategori LIKE '%$keyword%'

ORDER BY aspirasi.id_aspirasi ASC
");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Data Aspirasi</title>

    <link rel="stylesheet" href="css/style.css">

    <style>
        /* ================= POPUP STYLE ================= */

        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 25px;
            border-radius: 8px;
            width: 350px;
        }

        .modal-content input,
        .modal-content select,
        .modal-content textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
    </style>

</head>


<!-- ================= NAVBAR ================= -->
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


<body>

    <div class="container">


        <!-- ================= TOMBOL KEMBALI ================= -->
        <a href="dashboard.php" class="btn-back">
            <span class="arrow">←</span>
            <span>Kembali</span>
        </a>


        <h2>Data Aspirasi</h2>



        <!-- ================= FORM PENCARIAN ================= -->
        <form method="GET" class="form-search">

            <input type="text"
                name="keyword"
                placeholder="Cari berdasarkan NIS, Tanggal, atau Kategori..."
                value="<?= $keyword ?>">

            <button type="submit" class="btn-search">Cari</button>

            <a href="data-aspirasi.php" class="btn-reset">Reset</a>

        </form>



        <!-- ================= TABEL DATA ================= -->
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
                <th>Aksi</th>
            </tr>



            <?php while ($row = mysqli_fetch_array($query)) { ?>

                <tr>

                    <td><?= $row['id_aspirasi']; ?></td>

                    <td><?= $row['tanggal']; ?></td>

                    <td><?= $row['nis']; ?></td>

                    <td><?= $row['kelas']; ?></td>

                    <td><?= $row['ket_kategori']; ?></td>

                    <td><?= $row['lokasi']; ?></td>

                    <td><?= $row['ket']; ?></td>


                    <!-- STATUS -->
                    <td class="<?= strtolower($row['status']); ?>">
                        <?= $row['status']; ?>
                    </td>


                    <td><?= $row['feedback']; ?></td>



                    <td>

                        <!-- TOMBOL EDIT (POPUP) -->
                        <button class="btn-edit"
                            onclick="editData(
'<?= $row['id_aspirasi']; ?>',
'<?= $row['status']; ?>',
'<?= $row['feedback']; ?>'
)">
                            Edit
                        </button>





                    </td>

                </tr>

            <?php } ?>

        </table>

    </div>



    <!-- ================= POPUP EDIT ================= -->
    <div class="modal" id="popupEdit">

        <div class="modal-content">

            <h3>Edit Data Aspirasi</h3>

            <form method="POST">

                <input type="hidden" name="id_aspirasi" id="edit_id">

                <label>Status</label>

                <select name="status" id="edit_status">

                    <option value="Menunggu">Menunggu</option>
                    <option value="Proses">Proses</option>
                    <option value="Selesai">Selesai</option>

                </select>


                <label>Feedback</label>

                <textarea name="feedback" id="edit_feedback"></textarea>


                <button type="submit" name="update">Update</button>

                <button type="button" onclick="tutupPopup()">Batal</button>

            </form>

        </div>

    </div>



    <script>
        // =====================================================
        // FUNCTION MENAMPILKAN POPUP EDIT
        // =====================================================
        function editData(id, status, feedback) {

            document.getElementById("edit_id").value = id;
            document.getElementById("edit_status").value = status;
            document.getElementById("edit_feedback").value = feedback;

            document.getElementById("popupEdit").style.display = "flex";

        }


        // =====================================================
        // FUNCTION MENUTUP POPUP
        // =====================================================
        function tutupPopup() {

            document.getElementById("popupEdit").style.display = "none";

        }
    </script>

</body>
<footer class="footer">
    <p>© 2026 <b>WebAspirasi</b> | Sistem Aspirasi Siswa</p>
</footer>

</html>