<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menu Utama</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Selamat Datang, <?php echo htmlspecialchars($user['nama']); ?></h1>
    <ul>
        <!-- Tampilkan menu sesuai role user (sesuaikan logika role jika diperlukan) -->
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
        <li><a href="logout.php">Sign Out</a></li>
    </ul>
</body>
</html>
