<?php
// krs_list.php
require '../../config/config.php';
// Hanya admin yang dapat mengelola transaksi KRS
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

$sql = "SELECT k.*, m.nama_mk AS nama_mk, d.nama AS nama_dosen, s.nama AS nama_mhs
        FROM krs k
        LEFT JOIN ms_matkul m ON k.kode_mk = m.kode_mk
        LEFT JOIN ms_dosen d ON k.nik = d.nik
        LEFT JOIN ms_mahasiswa s ON k.nim = s.nim";
$result = mysqli_query($conn, $sql);
// output halaman
include '../../header.php';
?>
<main style="min-height: 80vh;"> 
    <h2>Transaksi KRS</h2>
    <p><a href="krs_add.php">Tambah KRS</a> | <a href="../../menu_admin.php">Menu Utama</a></p>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Mata Kuliah</th>
            <th>Dosen</th>
            <th>Mahasiswa</th>
            <th>Hari</th>
            <th>Ruang</th>
            <th>User Input</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['krs_id']; ?></td>
            <td><?php echo htmlspecialchars($row['nama_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_dosen']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_mhs']); ?></td>
            <td><?php echo htmlspecialchars($row['hari']); ?></td>
            <td><?php echo htmlspecialchars($row['ruang']); ?></td>
            <td><?php echo htmlspecialchars($row['user_input']); ?></td>
            <td><?php echo htmlspecialchars($row['tgl_input']); ?></td>
            <td>
                <a href="krs_edit.php?krs_id=<?php echo $row['krs_id']; ?>">Edit</a> |
                <a href="krs_delete.php?krs_id=<?php echo $row['krs_id']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</main>
<?php include '../../footer.php'; ?>
