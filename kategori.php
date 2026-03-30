<?php
// ================= SESSION =================
// Memulai session untuk mengecek login admin
session_start();

// ================= KONEKSI DATABASE =================
// Menghubungkan ke database
include 'db.php';


// ================= CEK LOGIN =================
// Jika belum login maka diarahkan ke login.php
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}


/* ================= TAMBAH DATA ================= */
if (isset($_POST['tambah'])) {

    // Mengambil input dari form
    $nama = $_POST['ket_kategori'];

    // Query tambah data ke tabel kategori
    $insert = mysqli_query($conn, "INSERT INTO kategori VALUES (NULL,'$nama')");

    // Cek berhasil atau tidak
    if ($insert) {
        echo '<script>alert("Data berhasil ditambahkan!");window.location="kategori.php";</script>';
    } else {
        echo '<script>alert("Data gagal ditambahkan!");</script>';
    }
}


/* ================= EDIT DATA ================= */
if (isset($_POST['update'])) {

    // Ambil data dari popup edit
    $id = $_POST['id_kategori'];
    $nama = $_POST['ket_kategori'];

    // Query update data
    mysqli_query($conn, "UPDATE kategori SET ket_kategori='$nama' WHERE id_kategori='$id'");

    // Reload halaman
    echo '<script>alert("Data berhasil diubah!");window.location="kategori.php";</script>';
}


/* ================= HAPUS DATA ================= */
if (isset($_GET['hapus'])) {

    // Ambil ID dari URL
    $id = $_GET['hapus'];

    // Query hapus data
    mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori='$id'");

    echo '<script>alert("Data berhasil dihapus!");window.location="kategori.php";</script>';
}


/* ================= AMBIL DATA ================= */
// Mengambil semua data kategori
$data = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");

?>
<!DOCTYPE html>
<html>

<head>

    <title>Data Kategori</title>

    <!-- ================= CSS ================= -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* ================= POPUP MODAL ================= */
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

        <!-- Tombol kembali -->
        <a href="dashboard.php" class="btn-back">← Kembali</a>

        <h2>Data Kategori</h2>


        <!-- ================= FORM TAMBAH ================= -->
        <div class="form-card">

            <form method="POST">

                <!-- Input nama kategori -->
                <input type="text" name="ket_kategori" placeholder="Nama Kategori" required>

                <!-- Tombol tambah -->
                <button type="submit" name="tambah">Tambah</button>

            </form>

        </div>


        <!-- ================= TABEL DATA ================= -->
        <div class="table-wrapper">

            <table>

                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>

                <!-- Perulangan data -->
                <?php while ($row = mysqli_fetch_array($data)) { ?>

                    <tr>

                        <!-- Menampilkan ID -->
                        <td><?= $row['Id_kategori']; ?></td>

                        <!-- Menampilkan nama -->
                        <td><?= $row['ket_kategori']; ?></td>

                        <td>

                            <!-- Tombol edit -->
                            <button class="btn-edit"
                                onclick="editData('<?= $row['Id_kategori']; ?>','<?= $row['ket_kategori']; ?>')">
                                Edit
                            </button>

                            <!-- Tombol hapus -->
                            <a href="?hapus=<?= $row['Id_kategori']; ?>"
                                onclick="return confirm('Yakin hapus data ini?')"
                                class="btn-hapus">
                                Hapus
                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>


    <!-- ================= POPUP EDIT ================= -->
    <div class="modal" id="popupEdit">

        <div class="modal-content">

            <h3>Edit Kategori</h3>

            <form method="POST">

                <!-- ID disembunyikan -->
                <input type="hidden" name="id_kategori" id="edit_id">

                <!-- Nama kategori -->
                <input type="text" name="ket_kategori" id="edit_nama">

                <!-- Tombol update -->
                <button type="submit" name="update">Update</button>

                <!-- Tombol batal -->
                <button type="button" onclick="tutupPopup()">Batal</button>

            </form>

        </div>

    </div>


    <script>
        // ================= FUNCTION EDIT =================
        function editData(id, nama) {

            // Isi input popup dengan data
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_nama").value = nama;

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