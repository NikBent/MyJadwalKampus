<?php
// mahasiswa_edit.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['nim'])) {
    header("Location: mahasiswa_list.php");
    exit();
}

$nim = $_GET['nim'];
$sql = "SELECT * FROM ms_mahasiswa WHERE nim = '$nim'";
$result = mysqli_query($conn, $sql);
$mahasiswa = mysqli_fetch_assoc($result);

if (!$mahasiswa) {
    echo "Data tidak ditemukan";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $jurusan    = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $no_Hp      = mysqli_real_escape_string($conn, $_POST['no_Hp']);
    $alamat     = mysqli_real_escape_string($conn, $_POST['alamat']);
    $angkatan   = mysqli_real_escape_string($conn, $_POST['angkatan']);
    $user_input = mysqli_real_escape_string($conn, $_SESSION['user']['username']);
    $tgl_input  = date('Y-m-d H:i:s');

    $sql_update = "UPDATE ms_mahasiswa SET 
        nama='$nama', jurusan='$jurusan', email='$email', no_Hp='$no_Hp',
        alamat='$alamat', angkatan='$angkatan', user_input='$user_input', tgl_input='$tgl_input'
        WHERE nim='$nim'";
    if (mysqli_query($conn, $sql_update)) {
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
    <h2>Edit Mahasiswa</h2>
    <form method="post" action="mahasiswa_edit.php?nim=<?php echo $nim; ?>">
    <button class="menu-button" type="button" disabled>Nama:</button><br>
    <input type="text" name="nama" value="<?php echo htmlspecialchars($mahasiswa['nama']); ?>" required><br>

    <button class="menu-button" type="button" disabled>Jurusan:</button><br>
    <input type="text" name="jurusan" value="<?php echo htmlspecialchars($mahasiswa['jurusan']); ?>" required><br>

    <button class="menu-button" type="button" disabled>Email:</button><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($mahasiswa['email']); ?>" required><br>

    <button class="menu-button" type="button" disabled>No HP:</button><br>
    <input type="text" name="no_Hp" value="<?php echo htmlspecialchars($mahasiswa['no_Hp']); ?>" required><br>

    <button class="menu-button" type="button" disabled>Alamat:</button><br>
    <input type="text" name="alamat" value="<?php echo htmlspecialchars($mahasiswa['alamat']); ?>" required><br>

    <button class="menu-button" type="button" disabled>Angkatan:</button><br>
    <input type="number" name="angkatan" value="<?php echo htmlspecialchars($mahasiswa['angkatan']); ?>" required><br><br>

    <button class="menu-button" type="submit">Update</button>
    <button class="signout" type="button" onclick="window.location.href='mahasiswa_list.php'">Batal</button>
</form>

</main>
<?php include '../../footer.php'; ?>
