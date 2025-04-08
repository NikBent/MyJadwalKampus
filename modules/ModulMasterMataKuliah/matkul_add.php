<?php
// matkul_add.php
require 'config.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mk   = mysqli_real_escape_string($conn, $_POST['kode_mk']);
    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $sks       = mysqli_real_escape_string($conn, $_POST['sks']);
    $sem       = mysqli_real_escape_string($conn, $_POST['sem']);
    $user_input= mysqli_real_escape_string($conn, $_SESSION['username']);
    $tgl_input = date('Y-m-d H:i:s');

    $sql = "INSERT INTO ms_matkul (kode_mk, nama, sks, sem, user_input, tgl_input)
            VALUES ('$kode_mk', '$nama', '$sks', '$sem', '$user_input', '$tgl_input')";
    if (mysqli_query($conn, $sql)) {
        header("Location: matkul_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// output halaman
include 'header.php';
?>
    <h2>Tambah Mata Kuliah</h2>
    <form method="post" action="matkul_add.php">
        <label>Kode Mata Kuliah:</label><br>
        <input type="text" name="kode_mk" required><br>
        <label>Nama Mata Kuliah:</label><br>
        <input type="text" name="nama" required><br>
        <label>SKS:</label><br>
        <input type="number" name="sks" required><br>
        <label>Semester:</label><br>
        <input type="number" name="sem" required><br>
        <br>
        <button type="submit">Simpan</button>
        <a href="matkul_list.php">Batal</a>
    </form>
<?php include 'footer.php'; ?>
