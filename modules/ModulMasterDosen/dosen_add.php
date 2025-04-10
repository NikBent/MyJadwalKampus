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
$master_css = true;
include '../../header.php'; 
?>
<link rel="stylesheet" href="dosen.css">
<main style="min-height: 80vh;"> 
    <h2>Tambah Dosen</h2>
    <form method="post" action="dosen_add.php">
        <button class="menu-button" type="button" disabled>NIK:</button><br>
        <input type="text" name="nik" required><br>

        <button class="menu-button" type="button" disabled>Nama:</button><br>
        <input type="text" name="nama" required><br>

        <button class="menu-button" type="button" disabled>Email:</button><br>
        <input type="email" name="email" required><br>

        <button class="menu-button" type="button" disabled>No HP:</button><br>
        <input type="text" name="no_hp" required><br>

        <button class="menu-button" type="button" disabled>Gelar:</button><br>
        <input type="text" name="gelar" required><br>

        <button class="menu-button" type="button" disabled>Lulusan:</button><br>
        <input type="text" name="lulusan" required><br><br>

        <button class="menu-button" type="submit">Simpan</button>
        <button class="signout" type="button" onclick="window.location.href='dosen_list.php'">Batal</button>
    </form>
</main>
<?php include '../../footer.php'; ?>
