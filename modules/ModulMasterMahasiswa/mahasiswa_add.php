<?php
// mahasiswa_add.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim        = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan    = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $no_Hp      = mysqli_real_escape_string($conn, $_POST['no_Hp']);
    $alamat     = mysqli_real_escape_string($conn, $_POST['alamat']);
    $angkatan   = mysqli_real_escape_string($conn, $_POST['angkatan']);
    $user_input = mysqli_real_escape_string($conn, $_SESSION['username']);
    $tgl_input  = date('Y-m-d H:i:s');

    $sql = "INSERT INTO ms_mahasiswa (nim, nama, jurusan, email, no_Hp, alamat, angkatan, user_input, tgl_input)
            VALUES ('$nim', '$nama', '$jurusan', '$email', '$no_Hp', '$alamat', '$angkatan', '$user_input', '$tgl_input')";
    if (mysqli_query($conn, $sql)) {
        header("Location: mahasiswa_list.php");
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
    <h2>Tambah Mahasiswa</h2>
    <form method="post" action="mahasiswa_add.php">
    <button class="menu-button" type="button" disabled>NIM:</button><br>
    <input type="text" name="nim" required><br>

    <button class="menu-button" type="button" disabled>Nama:</button><br>
    <input type="text" name="nama" required><br>

    <button class="menu-button" type="button" disabled>Jurusan:</button><br>
    <input type="text" name="jurusan" required><br>

    <button class="menu-button" type="button" disabled>Email:</button><br>
    <input type="email" name="email" required><br>

    <button class="menu-button" type="button" disabled>No HP:</button><br>
    <input type="text" name="no_Hp" required><br>

    <button class="menu-button" type="button" disabled>Alamat:</button><br>
    <input type="text" name="alamat" required><br>

    <button class="menu-button" type="button" disabled>Angkatan:</button><br>
    <input type="number" name="angkatan" required><br><br>

    <button class="menu-button" type="submit">Simpan</button>
    <button class="signout" type="button" onclick="window.location.href='mahasiswa_list.php'">Batal</button>
</form>

</main>
<?php include '../../footer.php'; ?>
