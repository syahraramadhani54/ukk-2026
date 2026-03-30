<?php
// ================= MULAI SESSION =================
// Untuk menyimpan status login admin
session_start();

// ================= KONEKSI DATABASE =================
// Menghubungkan ke database
include 'db.php';


// ================= CEK LOGIN =================
// Kalau belum login → balik ke login
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}


// ================= TAMBAH DATA =================
if (isset($_POST['tambah'])) {

    // Ambil data dari form
    $nis   = $_POST['nis'];
    $kelas = $_POST['kelas'];

    // Query tambah data ke tabel siswa
    mysqli_query($conn, "INSERT INTO siswa (nis,kelas) VALUES ('$nis','$kelas')");

    // Notifikasi + reload
    echo '<script>alert("Data siswa berhasil ditambahkan");window.location="siswa.php";</script>';
}


// ================= UPDATE DATA =================
if (isset($_POST['update'])) {

    // Ambil data dari popup edit
    $nis   = $_POST['nis'];
    $kelas = $_POST['kelas'];

    // Query update
    mysqli_query($conn, "UPDATE siswa SET kelas='$kelas' WHERE nis='$nis'");

    // Reload halaman
    echo '<script>alert("Data siswa berhasil diupdate");window.location="siswa.php";</script>';
}


// ================= AMBIL DATA =================
// Ambil semua data siswa
$data = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nis ASC");

?>
<!DOCTYPE html>
<html>

<head>

    <title>Data Siswa</title>

    <!-- ================= CSS ================= -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* ================= POPUP ================= */
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

        .modal-content input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <div class="navbar-admin">

        <div class="logo">
            <b>Dashboard Admin</b>
        </div>

        <ul class="menu">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="data-aspirasi.php">Data Aspirasi</a></li>
            <li><a href="kategori.php">Kategori</a></li>
            <li><a href="siswa.php">Siswa</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>

    </div>


    <div class="container">

        <!-- Tombol kembali -->
        <a href="dashboard.php" class="btn-back">← Kembali</a>

        <h2>Data Siswa</h2>


        <!-- ================= FORM TAMBAH ================= -->
        <div class="form-card">

            <form method="POST">

                <!-- Input NIS -->
                <input type="text" name="nis" placeholder="NIS" required>

                <!-- Input kelas -->
                <input type="text" name="kelas" placeholder="Kelas" required>

                <!-- Tombol tambah -->
                <button type="submit" name="tambah">Tambah</button>

            </form>

        </div>


        <!-- ================= TABEL DATA ================= -->
        <div class="table-wrapper">

            <table>

                <tr>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>

                <!-- Loop data siswa -->
                <?php while ($row = mysqli_fetch_assoc($data)) { ?>

                    <tr>

                        <!-- Tampilkan NIS -->
                        <td><?= $row['nis']; ?></td>

                        <!-- Tampilkan kelas -->
                        <td><?= $row['kelas']; ?></td>

                        <td>

                            <!-- Tombol edit -->
                            <button class="btn-edit"
                                onclick="editData('<?= $row['nis']; ?>','<?= $row['kelas']; ?>')">
                                Edit
                            </button>



                        </td>

                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>


    <!-- ================= POPUP EDIT ================= -->
    <div class="modal" id="popupEdit">

        <div class="modal-content">

            <h3>Edit Data Siswa</h3>

            <form method="POST">

                <!-- NIS tidak bisa diubah -->
                <input type="text" name="nis" id="edit_nis" readonly>

                <!-- Edit kelas -->
                <input type="text" name="kelas" id="edit_kelas">

                <!-- Tombol update -->
                <button type="submit" name="update">Update</button>

                <!-- Tombol batal -->
                <button type="button" onclick="tutupPopup()">Batal</button>

            </form>

        </div>

    </div>


    <script>
        // ================= FUNCTION EDIT =================
        function editData(nis, kelas) {

            // Isi data ke popup
            document.getElementById("edit_nis").value = nis;
            document.getElementById("edit_kelas").value = kelas;

            // Tampilkan popup
            document.getElementById("popupEdit").style.display = "flex";
        }

        // ================= TUTUP POPUP =================
        function tutupPopup() {
            document.getElementById("popupEdit").style.display = "none";
        }
    </script>

</body>
<footer class="footer">
    <p>© 2026 <b>WebAspirasi</b> | Sistem Aspirasi Siswa</p>
</footer>

</html>