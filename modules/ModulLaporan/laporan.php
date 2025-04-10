<?php 
require('../../config/config.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['user']['role']; 
$username = $_SESSION['user']['username'];

if ($role == 'dosen') {
    $nama_dosen = $username;

    // Ambil nik berdasarkan nama dosen
    $queryDosen = mysqli_query($conn, "SELECT nik FROM ms_dosen WHERE nama = '$nama_dosen'");
    $dosen = mysqli_fetch_assoc($queryDosen);
    $nik = $dosen['nik'];
    
    $sql = "SELECT k.*, m.kode_mk, m.nama_mk, m.sks, k.hari, d.nama AS nama_dosen
            FROM krs k
            LEFT JOIN ms_matkul m ON k.kode_mk = m.kode_mk
            LEFT JOIN ms_dosen d ON k.nik = d.nik
            WHERE k.nik = '$nik'";

} elseif ($role == 'mahasiswa') {
    $nama_mhs = $username;
    $queryMhs = mysqli_query($conn, "SELECT nim FROM ms_mahasiswa WHERE nama = '$nama_mhs'");
    $mhs = mysqli_fetch_assoc($queryMhs);
    $nim = $mhs['nim'];

    $sql = "SELECT k.*, m.kode_mk, m.nama_mk, m.sks, k.hari, d.nama AS nama_dosen, s.nama AS nama_mhs
            FROM krs k
            LEFT JOIN ms_matkul m ON k.kode_mk = m.kode_mk
            LEFT JOIN ms_dosen d ON k.nik = d.nik
            LEFT JOIN ms_mahasiswa s ON k.nim = s.nim
            WHERE k.nim = '$nim'";

} else { // Admin
    $sql = "SELECT k.*, m.kode_mk, m.nama_mk, m.sks, k.hari, d.nama AS nama_dosen, s.nama AS nama_mhs
            FROM krs k
            LEFT JOIN ms_matkul m ON k.kode_mk = m.kode_mk
            LEFT JOIN ms_dosen d ON k.nik = d.nik
            LEFT JOIN ms_mahasiswa s ON k.nim = s.nim";
}

$result = mysqli_query($conn, $sql);

// Debug jika query error
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}

// Cek apakah ada data
if (mysqli_num_rows($result) == 0) {
    echo "<p>Tidak ada data yang ditemukan.</p>";
    exit();
}

include './header.php';
?>

<h2>Laporan Jadwal</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <?php if ($role == 'admin'): ?>
            <th>ID</th>
            <th>Mata Kuliah</th>
            <th>Kode MK</th>
            <th>Dosen</th>
            <th>Mahasiswa</th>
            <th>SKS</th>
            <th>Hari</th>
        <?php elseif ($role == 'dosen'): ?>
            <th>Mata Kuliah</th>
            <th>Kode MK</th>
            <th>SKS</th>
            <th>Hari</th>
        <?php elseif ($role == 'mahasiswa'): ?>
            <th>Mata Kuliah</th>
            <th>Kode MK</th>
            <th>Dosen</th>
            <th>SKS</th>
            <th>Hari</th>
        <?php endif; ?>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <?php if ($role == 'admin'): ?>
            <td><?php echo $row['krs_id']; ?></td>
            <td><?php echo htmlspecialchars($row['nama_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['kode_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_dosen']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_mhs']); ?></td>
            <td><?php echo htmlspecialchars($row['sks']); ?></td>
            <td><?php echo htmlspecialchars($row['hari']); ?></td>
        <?php elseif ($role == 'dosen'): ?>
            <td><?php echo htmlspecialchars($row['nama_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['kode_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['sks']); ?></td>
            <td><?php echo htmlspecialchars($row['hari']); ?></td>
        <?php elseif ($role == 'mahasiswa'): ?>
            <td><?php echo htmlspecialchars($row['nama_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['kode_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_dosen']); ?></td>
            <td><?php echo htmlspecialchars($row['sks']); ?></td>
            <td><?php echo htmlspecialchars($row['hari']); ?></td>
        <?php endif; ?>
    </tr>
    <?php endwhile; ?>
</table>

<?php include '../../footer.php'; ?>
