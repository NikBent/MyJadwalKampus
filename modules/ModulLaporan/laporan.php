<?php 
// laporan.php
require 'config.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$username = $_SESSION['username'];

if ($role == 'dosen') {
    // Ambil jadwal mengajar dosen
    // Misalnya, pencocokan berdasarkan nik di tabel ms_dosen (anda harus memastikan bahwa username login sama dengan nama atau nik)
    // Untuk contoh, anggap username login adalah nik dosen.
    $nik = $username;
    $sql = "SELECT k.*, m.nama AS nama_mk, m.sks, k.hari
            FROM krs k
            LEFT JOIN ms_matkul m ON k.kode_mk = m.kode_mk
            WHERE k.nik = '$nik'";
    $result = mysqli_query($conn, $sql);
} elseif ($role == 'mahasiswa') {
    // Ambil jadwal kuliah mahasiswa
    // Anggap username login adalah nim mahasiswa
    $nim = $username;
    $sql = "SELECT k.*, m.nama AS nama_mk, m.sks, k.hari, d.nama AS nama_dosen
            FROM krs k
            LEFT JOIN ms_matkul m ON k.kode_mk = m.kode_mk
            LEFT JOIN ms_dosen d ON k.nik = d.nik
            WHERE k.nim = '$nim'";
    $result = mysqli_query($conn, $sql);
} else {
    // Untuk admin, tampilkan seluruh laporan
    $sql = "SELECT k.*, m.nama AS nama_mk, m.sks, k.hari, d.nama AS nama_dosen, s.nama AS nama_mhs
            FROM krs k
            LEFT JOIN ms_matkul m ON k.kode_mk = m.kode_mk
            LEFT JOIN ms_dosen d ON k.nik = d.nik
            LEFT JOIN ms_mahasiswa s ON k.nim = s.nim";
}
$result = mysqli_query($conn, $sql);
// output halaman
include 'header.php';
?>
    <h2>Laporan Jadwal</h2>
    <p><a href="index.php">Menu Utama</a></p>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <?php if ($role == 'admin'): ?>
                <th>ID</th>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Mahasiswa</th>
            <?php elseif ($role == 'dosen'): ?>
                <th>Mata Kuliah</th>
            <?php elseif ($role == 'mahasiswa'): ?>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
            <?php endif; ?>
            <th>SKS</th>
            <th>Hari</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <?php if ($role == 'admin'): ?>
                <td><?php echo $row['krs_id']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_mk']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_dosen']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_mhs']); ?></td>
            <?php elseif ($role == 'dosen'): ?>
                <td><?php echo htmlspecialchars($row['nama_mk']); ?></td>
            <?php elseif ($role == 'mahasiswa'): ?>
                <td><?php echo htmlspecialchars($row['nama_mk']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_dosen']); ?></td>
            <?php endif; ?>
            <td><?php echo htmlspecialchars($row['sks']); ?></td>
            <td><?php echo htmlspecialchars($row['hari']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php include 'footer.php'; ?>
