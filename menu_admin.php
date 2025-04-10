<?php
require_once 'config/config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /MyJadwalKampus/login.php");
    exit();
}
$user = $_SESSION['user'];

echo $user['role'];

// output halaman
include 'header.php';
?>
    <div class="container">
        <h1>Menu Utama</h1>
        <div class="user-info">
            Selamat datang, <?php echo htmlspecialchars($user['username']); ?>
        </div>
        <ul class="menu-list">
            <?php if ($user['role'] == 'admin'): ?>
                <li><a href="modules/ModulMasterDosen/dosen_list.php">Master Dosen</a></li>
                <li><a href="modules/ModulMasterMahasiswa/mahasiswa_list.php">Master Mahasiswa</a></li>
                <li><a href="modules/ModulMasterMataKuliah/matkul_list.php">Master Mata Kuliah</a></li>
                <li><a href="modules/ModulTransaksiKRS/krs_list.php">Transaksi KRS</a></li>
            <?php elseif ($user['role'] == 'dosen'): ?>
                <li><a href="modules/ModulLaporan/laporan.php">Jadwal Mengajar</a></li>
            <?php elseif ($user['role'] == 'mahasiswa'): ?>
                <li><a href="modules/ModulLaporan/laporan.php">Jadwal Kuliah</a></li>
            <?php endif; ?>
        </ul>
        <a class="signout" href="logout.php">Sign Out</a>
    </div>
<?php include 'footer.php'; ?>