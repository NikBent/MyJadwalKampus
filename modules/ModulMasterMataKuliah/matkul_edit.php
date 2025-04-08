<?php
// matkul_edit.php
require 'config.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
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
    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $sks       = mysqli_real_escape_string($conn, $_POST['sks']);
    $sem       = mysqli_real_escape_string($conn, $_POST['sem']);
    $user_input= mysqli_real_escape_string($conn, $_SESSION['username']);
    $tgl_input = date('Y-m-d H:i:s');

    $sql_update = "UPDATE ms_matkul SET 
        nama='$nama', sks='$sks', sem='$sem', user_input='$user_input', tgl_input='$tgl_input'
        WHERE kode_mk='$kode_mk'";
    if (mysqli_query($conn, $sql_update)) {
        header("Location: matkul_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// output halaman
include 'header.php';
?>
    <h2>Edit Mata Kuliah</h2>
    <form method="post" action="matkul_edit.php?kode_mk=<?php echo $kode_mk; ?>">
        <label>Nama Mata Kuliah:</label><br>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($matkul['nama']); ?>" required><br>
        <label>SKS:</label><br>
        <input type="number" name="sks" value="<?php echo htmlspecialchars($matkul['sks']); ?>" required><br>
        <label>Semester:</label><br>
        <input type="number" name="sem" value="<?php echo htmlspecialchars($matkul['sem']); ?>" required><br>
        <br>
        <button type="submit">Update</button>
        <a href="matkul_list.php">Batal</a>
    </form>
<?php include 'footer.php'; ?>
