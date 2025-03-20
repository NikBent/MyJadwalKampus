<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/database.php';

$user = $_SESSION['user'];
$role = $user['role'];

// Laporan disesuaikan dengan role
if ($role == 'dosen') {
    // Contoh: Laporan jadwal mengajar dosen tersebut
    $nik = $user['username']; // atau field lain yang sesuai
    $query = "SELECT k.*, m.nama_matkul, m.sks FROM krs k 
              JOIN matakuliah m ON k.kode_matkul = m.kode_matkul 
              WHERE k.nik_dosen = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();
} elseif ($role == 'mahasiswa') {
    // Contoh: Laporan jadwal kuliah mahasiswa tersebut
    $nim = $user['username']; // atau field lain yang sesuai
    $query = "SELECT k.*, m.nama_matkul, m.sks, d.nama AS nama_dosen FROM krs k 
              JOIN matakuliah m ON k.kode_matkul = m.kode_matkul 
              JOIN dosen d ON k.nik_dosen = d.nik 
              WHERE k.nim_mahasiswa = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Role lain atau admin dapat menampilkan semua data
    $query = "SELECT * FROM krs";
    $result = $db->query($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Jadwal</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Laporan Jadwal</h1>
    <table border="1" cellpadding="5">
        <tr>
            <!-- Kolom header disesuaikan dengan data yang ditampilkan -->
            <?php if ($role == 'dosen'): ?>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Hari</th>
                <th>Ruangan</th>
            <?php elseif ($role == 'mahasiswa'): ?>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Dosen Pengajar</th>
                <th>Hari</th>
                <th>Ruangan</th>
            <?php else: ?>
                <th>ID</th>
                <th>Kode Matkul</th>
                <th>NIK Dosen</th>
                <th>NIM Mahasiswa</th>
                <th>Hari</th>
                <th>Ruangan</th>
            <?php endif; ?>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <?php if ($role == 'dosen'): ?>
                    <td><?php echo htmlspecialchars($row['nama_matkul']); ?></td>
                    <td><?php echo htmlspecialchars($row['sks']); ?></td>
                    <td><?php echo htmlspecialchars($row['hari_matkul']); ?></td>
                    <td><?php echo htmlspecialchars($row['ruangan']); ?></td>
                <?php elseif ($role == 'mahasiswa'): ?>
                    <td><?php echo htmlspecialchars($row['nama_matkul']); ?></td>
                    <td><?php echo htmlspecialchars($row['sks']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_dosen']); ?></td>
                    <td><?php echo htmlspecialchars($row['hari_matkul']); ?></td>
                    <td><?php echo htmlspecialchars($row['ruangan']); ?></td>
                <?php else: ?>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['kode_matkul']); ?></td>
                    <td><?php echo htmlspecialchars($row['nik_dosen']); ?></td>
                    <td><?php echo htmlspecialchars($row['nim_mahasiswa']); ?></td>
                    <td><?php echo htmlspecialchars($row['hari_matkul']); ?></td>
                    <td><?php echo htmlspecialchars($row['ruangan']); ?></td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="menu_utama.php">Kembali ke Menu Utama</a>
</body>
</html>
