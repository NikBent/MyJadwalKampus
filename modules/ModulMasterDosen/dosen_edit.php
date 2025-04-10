<?php
// dosen_edit.php
require '../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_GET['nik'])) {
    header("Location: dosen_list.php");
    exit();
}

$nik = $_GET['nik'];
// Ambil data dosen
$sql = "SELECT * FROM ms_dosen WHERE nik = '$nik'";
$result = mysqli_query($conn, $sql);
$dosen = mysqli_fetch_assoc($result);

if (!$dosen) {
    echo "Data tidak ditemukan";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama      = mysqli_real_escape_string($conn, $_POST['nama']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp     = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $gelar     = mysqli_real_escape_string($conn, $_POST['gelar']);
    $lulusan   = mysqli_real_escape_string($conn, $_POST['lulusan']);
    $user_input= mysqli_real_escape_string($conn, $_SESSION['username']);
    $tgl_input = date('Y-m-d H:i:s');

    $sql_update = "UPDATE ms_dosen SET 
        nama='$nama', email='$email', no_hp='$no_hp', gelar='$gelar', lulusan='$lulusan',
        user_input='$user_input', tgl_input='$tgl_input'
        WHERE nik='$nik'";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: dosen_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// output halaman
include 'header.php';
?>
    <h2>Edit Dosen</h2>
    <form method="post" action="dosen_edit.php?nik=<?php echo $nik; ?>">
        <label>Nama:</label><br>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($dosen['nama']); ?>" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo htmlspecialchars($dosen['email']); ?>" required><br>
        <label>No HP:</label><br>
        <input type="text" name="no_hp" value="<?php echo htmlspecialchars($dosen['no_hp']); ?>" required><br>
        <label>Gelar:</label><br>
        <input type="text" name="gelar" value="<?php echo htmlspecialchars($dosen['gelar']); ?>" required><br>
        <label>Lulusan:</label><br>
        <input type="text" name="lulusan" value="<?php echo htmlspecialchars($dosen['lulusan']); ?>" required><br>
        <br>
        <button type="submit">Update</button>
        <a href="dosen_list.php">Batal</a>
    </form>
<?php include 'footer.php'; ?>
