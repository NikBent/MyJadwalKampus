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
        <h1>Menu Admin</h1>
        <div class="user-info">
            Selamat datang, <?php echo htmlspecialchars($user['username']); ?>
        </div>
        <div class="menu-section">
        <div class="menu-list">
            <?php if ($user['role'] == 'admin'): ?>
                <button class="menu-button" type="button" onclick="window.location.href='modules/ModulMasterDosen/dosen_list.php'">Master Dosen</button>
                <button class="menu-button" type="button" onclick="window.location.href='modules/ModulMasterMahasiswa/mahasiswa_list.php'">Master Mahasiswa</button>
                <button class="menu-button" type="button" onclick="window.location.href='modules/ModulMasterMataKuliah/matkul_list.php'">Master Mata Kuliah</button>
                <button class="menu-button" type="button" onclick="window.location.href='modules/ModulTransaksiKRS/krs_list.php'">Transaksi KRS</button>
            <?php elseif ($user['role'] == 'dosen'): ?>
                <button class="menu-button" type="button" onclick="window.location.href='modules/ModulLaporan/laporan.php'">Jadwal Mengajar</button>
            <?php elseif ($user['role'] == 'mahasiswa'): ?>
                <button class="menu-button" type="button" onclick="window.location.href='modules/ModulLaporan/laporan.php'">Jadwal Kuliah</button>
            <?php endif; ?>
            <button class="signout" type="button" onclick="window.location.href='logout.php'">Sign Out</button>
        </div>   
    </div>
    </div>
</main>

<?php include 'footer.php'; ?>