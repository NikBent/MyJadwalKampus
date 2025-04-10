<?php
// matkul_add.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mk   = mysqli_real_escape_string($conn, $_POST['kode_mk']);
    $nama_mk      = mysqli_real_escape_string($conn, $_POST['nama_mk']);
    $sks       = mysqli_real_escape_string($conn, $_POST['sks']);
    $user_input= mysqli_real_escape_string($conn, $_SESSION['user']['username']);
    $tgl_input = date('Y-m-d H:i:s');

    $sql = "INSERT INTO ms_matkul (kode_mk, nama_mk, sks, user_input, tgl_input)
            VALUES ('$kode_mk', '$nama_mk', '$sks', '$user_input', '$tgl_input')";
    if (mysqli_query($conn, $sql)) {
        header("Location: matkul_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// output halaman
$master_css = true;
include '../../header.php';
?>
<main style="min-height: 80vh;"> 
    <h2>Tambah Mata Kuliah</h2>
    <form method="post" action="matkul_add.php">
    <button class="menu-button" type="button" disabled>Kode Mata Kuliah:</button><br>
    <input type="text" name="kode_mk" required><br>

    <button class="menu-button" type="button" disabled>Nama Mata Kuliah:</button><br>
    <input type="text" name="nama_mk" required><br>

    <button class="menu-button" type="button" disabled>SKS:</button><br>
    <input type="number" name="sks" required><br><br>

    <button class="menu-button" type="submit">Simpan</button>
    <button class="signout" type="button" onclick="window.location.href='matkul_list.php'">Batal</button>
</form>

</main>
<?php include '../../footer.php'; ?>
