<?php
// matkul_edit.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['kode_mk'])) {
    header("Location: matkul_list.php");
    exit();
}

$kode_mk = $_GET['kode_mk'];
$sql = "SELECT * FROM ms_matkul WHERE kode_mk = '$kode_mk'";
$result = mysqli_query($conn, $sql);
$matkul = mysqli_fetch_assoc($result);

if (!$matkul) {
    echo "Data tidak ditemukan";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_mk      = mysqli_real_escape_string($conn, $_POST['nama_mk']);
    $sks       = mysqli_real_escape_string($conn, $_POST['sks']);
    $user_input= mysqli_real_escape_string($conn, $_SESSION['user']['username']);
    $tgl_input = date('Y-m-d H:i:s');

    $sql_update = "UPDATE ms_matkul SET 
        nama_mk='$nama_mk', sks='$sks',  user_input='$user_input', tgl_input='$tgl_input'
        WHERE kode_mk='$kode_mk'";
    if (mysqli_query($conn, $sql_update)) {
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
    <h2>Edit Mata Kuliah</h2>
    <form method="post" action="matkul_edit.php?kode_mk=<?php echo $kode_mk; ?>">
    <button class="menu-button" type="button" disabled>Nama Mata Kuliah:</button><br>
    <input type="text" name="nama_mk" value="<?php echo htmlspecialchars($matkul['nama_mk']); ?>" required><br>

    <button class="menu-button" type="button" disabled>SKS:</button><br>
    <input type="number" name="sks" value="<?php echo htmlspecialchars($matkul['sks']); ?>" required><br><br>

    <button class="menu-button" type="submit">Update</button>
    <button class="signout" type="button" onclick="window.location.href='matkul_list.php'">Batal</button>
</form>
</main>
<?php include '../../footer.php'; ?>
