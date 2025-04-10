<?php
// matkul_list.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

$sql = "SELECT * FROM ms_matkul";
$result = mysqli_query($conn, $sql);
// output halaman
include '../../header.php';
?>
<main style="min-height: 80vh;"> 
    <h2>Data Mata Kuliah</h2>
    <p><a href="matkul_add.php">Tambah Mata Kuliah</a> | <a href="../../menu_admin.php">Menu Utama</a></p>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Kode MK</th>
            <th>Nama MK</th>
            <th>SKS</th>
            <th>User Input</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['kode_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_mk']); ?></td>
            <td><?php echo htmlspecialchars($row['sks']); ?></td>
            <td><?php echo htmlspecialchars($row['user_input']); ?></td>
            <td><?php echo htmlspecialchars($row['tgl_input']); ?></td>
            <td>
                <a href="matkul_edit.php?kode_mk=<?php echo $row['kode_mk']; ?>">Edit</a> |
                <a href="matkul_delete.php?kode_mk=<?php echo $row['kode_mk']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    </body>
<?php include '../../footer.php'; ?>
