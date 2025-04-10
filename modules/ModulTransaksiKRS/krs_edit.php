<?php
// krs_edit.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}
// Add Logs
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mk  = mysqli_real_escape_string($conn, $_POST['kode_mk']);
    $nik      = mysqli_real_escape_string($conn, $_POST['nik']);
    $nim      = mysqli_real_escape_string($conn, $_POST['nim']);
    $hari     = mysqli_real_escape_string($conn, $_POST['hari']);
    $ruang    = mysqli_real_escape_string($conn, $_POST['ruang']);
    $user_input = mysqli_real_escape_string($conn, $_SESSION['user']['username']);
    $tgl_input  = date('Y-m-d H:i:s');

    $sql_update = "UPDATE krs SET 
        kode_mk='$kode_mk', nik='$nik', nim='$nim', hari='$hari', ruang='$ruang',
        user_input='$user_input', tgl_input='$tgl_input'
        WHERE krs_id='$krs_id'";
    if (mysqli_query($conn, $sql_update)) {
        // Log update
        $log_sql = "INSERT INTO logs (user, action, krs_id, tgl_log) VALUES ('$user_input', 'Update KRS', '$krs_id', '$tgl_input')";
        header("Location: krs_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


if (!isset($_GET['krs_id'])) {
    header("Location: krs_list.php");
    exit();
}

$krs_id = $_GET['krs_id'];
$sql = "SELECT * FROM krs WHERE krs_id = '$krs_id'";
$result = mysqli_query($conn, $sql);
$krs = mysqli_fetch_assoc($result);

if (!$krs) {
    echo "Data tidak ditemukan";
    exit();
}

// Ambil data dropdown untuk mata kuliah, dosen, dan mahasiswa
$matkul = mysqli_query($conn, "SELECT * FROM ms_matkul");
$dosen  = mysqli_query($conn, "SELECT * FROM ms_dosen");
$mahasiswa = mysqli_query($conn, "SELECT * FROM ms_mahasiswa");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mk  = mysqli_real_escape_string($conn, $_POST['kode_mk']);
    $nik      = mysqli_real_escape_string($conn, $_POST['nik']);
    $nim      = mysqli_real_escape_string($conn, $_POST['nim']);
    $hari     = mysqli_real_escape_string($conn, $_POST['hari']);
    $ruang    = mysqli_real_escape_string($conn, $_POST['ruang']);
    $user_input = mysqli_real_escape_string($conn, $_SESSION['user']['username']);
    $tgl_input  = date('Y-m-d H:i:s');

    $sql_update = "UPDATE krs SET 
        kode_mk='$kode_mk', nik='$nik', nim='$nim', hari='$hari', ruang='$ruang',
        user_input='$user_input', tgl_input='$tgl_input'
        WHERE krs_id='$krs_id'";
    if (mysqli_query($conn, $sql_update)) {
        header("Location: krs_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
$master_css = true;
include '../../header.php';
?>
<main style="min-height: 80vh;"> 
    <h2>Edit KRS</h2>
    <form method="post" action="krs_edit.php?krs_id=<?php echo $krs_id; ?>">
    <button class="menu-button" type="button" disabled>Mata Kuliah:</button><br>
    <select name="kode_mk" required>
        <?php
        mysqli_data_seek($matkul, 0);
        while($row = mysqli_fetch_assoc($matkul)):
        ?>
            <option value="<?php echo $row['kode_mk']; ?>" <?php echo ($row['kode_mk'] == $krs['kode_mk']) ? 'selected' : ''; ?>>
                <?php echo $row['nama_mk']; ?>
            </option>
        <?php endwhile; ?>
    </select><br>

    <button class="menu-button" type="button" disabled>Dosen:</button><br>
    <select name="nik" required>
        <?php
        mysqli_data_seek($dosen, 0);
        while($row = mysqli_fetch_assoc($dosen)):
        ?>
            <option value="<?php echo $row['nik']; ?>" <?php echo ($row['nik'] == $krs['nik']) ? 'selected' : ''; ?>>
                <?php echo $row['nama']; ?>
            </option>
        <?php endwhile; ?>
    </select><br>

    <button class="menu-button" type="button" disabled>Mahasiswa:</button><br>
    <select name="nim" required>
        <?php
        mysqli_data_seek($mahasiswa, 0);
        while($row = mysqli_fetch_assoc($mahasiswa)):
        ?>
            <option value="<?php echo $row['nim']; ?>" <?php echo ($row['nim'] == $krs['nim']) ? 'selected' : ''; ?>>
                <?php echo $row['nama']; ?>
            </option>
        <?php endwhile; ?>
    </select><br>

    <button class="menu-button" type="button" disabled>Hari:</button><br>
    <select name="hari" required>
        <?php 
        $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        foreach($hari_list as $h):
        ?>
            <option value="<?php echo $h; ?>" <?php echo ($h == $krs['hari']) ? 'selected' : ''; ?>>
                <?php echo $h; ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <button class="menu-button" type="button" disabled>Ruang:</button><br>
    <input type="text" name="ruang" value="<?php echo htmlspecialchars($krs['ruang']); ?>" required><br><br>

    <button class="menu-button" type="submit">Update</button>
    <button class="signout" type="button" onclick="window.location.href='krs_list.php'">Batal</button>
</form>
</main>
<?php include '../../footer.php'; ?>
