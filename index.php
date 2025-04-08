<?php
// index.php
require 'config/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Definisikan menu sesuai role
$role = $_SESSION['role'];
$menu = [];

// Contoh menu berdasarkan role, sesuaikan dengan kebutuhan Anda.
if ($role == 'admin') {
    $menu = [
        ['label' => 'Master Dosen', 'link' => 'dosen_list.php'],
        ['label' => 'Master Mahasiswa', 'link' => 'mahasiswa_list.php'],
        ['label' => 'Master Mata Kuliah', 'link' => 'matkul_list.php'],
        ['label' => 'Transaksi KRS', 'link' => 'krs_list.php'],
        ['label' => 'Laporan', 'link' => 'laporan.php']
    ];
} elseif ($role == 'dosen') {
    $menu = [
        ['label' => 'Laporan Jadwal Mengajar', 'link' => 'laporan.php']
    ];
} elseif ($role == 'mahasiswa') {
    $menu = [
        ['label' => 'Laporan Jadwal Kuliah', 'link' => 'laporan.php']
    ];
}
// output halaman
include 'header.php';
?>
    <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <ul>
        <?php foreach ($menu as $m): ?>
            <li><a href="<?php echo $m['link']; ?>"><?php echo $m['label']; ?></a></li>
        <?php endforeach; ?>
        <li><a href="logout.php">Sign Out</a></li>
    </ul>
<?php include 'footer.php'; ?>
