<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
// output halaman
include 'header.php';
?>
    <div class="container">
        <h1>Menu Utama</h1>
        <div class="user-info">
            Selamat datang, <?php echo htmlspecialchars($user['nama']); ?>
        </div>
        <ul class="menu-list">
            <?php if ($user['role'] == 'admin'): ?>
                <li><a href="master_dosen.php">Master Dosen</a></li>
                <li><a href="master_mahasiswa.php">Master Mahasiswa</a></li>
                <li><a href="master_matakuliah.php">Master Mata Kuliah</a></li>
                <li><a href="transaksi_krs.php">Transaksi KRS</a></li>
            <?php elseif ($user['role'] == 'dosen'): ?>
                <li><a href="laporan.php">Jadwal Mengajar</a></li>
            <?php elseif ($user['role'] == 'mahasiswa'): ?>
                <li><a href="laporan.php">Jadwal Kuliah</a></li>
            <?php endif; ?>
        </ul>
        <a class="signout" href="logout.php">Sign Out</a>
    </div>
<?php include 'footer.php'; ?>