<?php
// krs_add.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
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

    $sql = "INSERT INTO krs (kode_mk, nik, nim, hari, ruang, user_input, tgl_input)
            VALUES ('$kode_mk', '$nik', '$nim', '$hari', '$ruang', '$user_input', '$tgl_input')";
    if (mysqli_query($conn, $sql)) {
        header("Location: krs_list.php");
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
    <h2>Tambah KRS</h2>
    <form method="post" action="krs_add.php">
    <button class="menu-button" type="button" disabled>Mata Kuliah:</button><br>
    <select name="kode_mk" required>
        <option value="">-- Pilih Mata Kuliah --</option>
        <?php while($row = mysqli_fetch_assoc($matkul)): ?>
            <option value="<?php echo $row['kode_mk']; ?>"><?php echo $row['nama_mk']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <button class="menu-button" type="button" disabled>Dosen:</button><br>
    <select name="nik" required>
        <option value="">-- Pilih Dosen --</option>
        <?php while($row = mysqli_fetch_assoc($dosen)): ?>
            <option value="<?php echo $row['nik']; ?>"><?php echo $row['nama']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <button class="menu-button" type="button" disabled>Mahasiswa:</button><br>
    <select name="nim" required>
        <option value="">-- Pilih Mahasiswa --</option>
        <?php while($row = mysqli_fetch_assoc($mahasiswa)): ?>
            <option value="<?php echo $row['nim']; ?>"><?php echo $row['nama']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <button class="menu-button" type="button" disabled>Hari:</button><br>
    <select name="hari" required>
        <option value="">-- Pilih Hari --</option>
        <option value="Senin">Senin</option>
        <option value="Selasa">Selasa</option>
        <option value="Rabu">Rabu</option>
        <option value="Kamis">Kamis</option>
        <option value="Jumat">Jumat</option>
        <option value="Sabtu">Sabtu</option>
        <option value="Minggu">Minggu</option>
    </select><br>

    <button class="menu-button" type="button" disabled>Ruang:</button><br>
    <input type="text" name="ruang" required><br><br>

    <button class="menu-button" type="submit">Simpan</button>
    <button class="signout" type="button" onclick="window.location.href='krs_list.php'">Batal</button>
</form>
</main>
<?php include '../../footer.php'; ?>