<?php
require_once 'config/config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /MyJadwalKampus/login.php");
    exit();
}
$user = $_SESSION['user'];


// output halaman
$menuAdmin_css = true;
include 'header.php';
?>
    <main style="min-height: 80vh;">
        <div class="container">
            <h1>Menu Utama</h1>
            <div class="user-info">
                Selamat datang, <?php echo htmlspecialchars($user['username']); ?>
            </div>
            <div class="menu-list">
                <?php if ($user['role'] == 'admin'): ?>
                    <a class="menu-button" href="modules/ModulMasterDosen/dosen_list.php">Master Dosen</a>
                    <a class="menu-button" href="modules/ModulMasterMahasiswa/mahasiswa_list.php">Master Mahasiswa</a>
                    <a class="menu-button" href="modules/ModulMasterMataKuliah/matkul_list.php">Master Mata Kuliah</a>
                    <a class="menu-button" href="modules/ModulTransaksiKRS/krs_list.php">Transaksi KRS</a>
                <?php elseif ($user['role'] == 'dosen'): ?>
                    <a class="menu-button" href="modules/ModulLaporan/laporan.php">Jadwal Mengajar</a>
                <?php elseif ($user['role'] == 'mahasiswa'): ?>
                    <a class="menu-button" href="modules/ModulLaporan/laporan.php">Jadwal Kuliah</a>
                <?php endif; ?>
            </div>
            <a class="signout" href="logout.php">Sign Out</a>
        </div>
    </main>
<?php include 'footer.php'; ?>