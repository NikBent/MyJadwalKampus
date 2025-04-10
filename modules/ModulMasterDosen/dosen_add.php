<?php 
// dosen_add.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nik       = mysqli_real_escape_string($conn, $_POST['nik']);
    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp     = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $gelar     = mysqli_real_escape_string($conn, $_POST['gelar']);
    $lulusan   = mysqli_real_escape_string($conn, $_POST['lulusan']);
    $user_input= mysqli_real_escape_string($conn, $_SESSION['username']);
    $tgl_input = date('Y-m-d H:i:s');

    $sql = "INSERT INTO ms_dosen (nik, nama, email, no_hp, gelar, lulusan, user_input, tgl_input) VALUES ('$nik', '$nama', '$email', '$no_hp', '$gelar', '$lulusan', '$user_input', '$tgl_input')";
    if (mysqli_query($conn, $sql)) {
        header("Location: dosen_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// output halaman
include 'header.php'; 
?>
<main style="min-height: 80vh;"> 
    <h2>Tambah Dosen</h2>
    <form method="post" action="dosen_add.php">
        <label>NIK:</label><br>
        <input type="text" name="nik" required><br>
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>No HP:</label><br>
        <input type="text" name="no_hp" required><br>
        <label>Gelar:</label><br>
        <input type="text" name="gelar" required><br>
        <label>Lulusan:</label><br>
        <input type="text" name="lulusan" required><br>
        <br>
        <button type="submit">Simpan</button>
        <a href="dosen_list.php">Batal</a>
    </form>
</main>
<?php include 'footer.php'; ?>
