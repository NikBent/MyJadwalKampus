<?php
// dosen_list.php
require '../../config/config.php';
// Pastikan hanya user dengan role admin yang dapat mengakses
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

// Ambil data dosen
$sql = "SELECT * FROM ms_dosen";
$result = mysqli_query($conn, $sql);
// output halaman
$master_css = true;
include '../../header.php';
?>
    <main style="min-height: 80vh;"> 
    <h2>Data Dosen</h2>
    <p><a href="dosen_add.php">Tambah Dosen</a> | <a href="../../menu_admin.php">Menu Utama</a></p>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Gelar</th>
            <th>Lulusan</th>
            <th>User Input</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nik']); ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
            <td><?php echo htmlspecialchars($row['gelar']); ?></td>
            <td><?php echo htmlspecialchars($row['lulusan']); ?></td>
            <td><?php echo htmlspecialchars($row['user_input']); ?></td>
            <td><?php echo htmlspecialchars($row['tgl_input']); ?></td>
            <td>
                <a href="dosen_edit.php?nik=<?php echo $row['nik']; ?>">Edit</a> |
                <a href="dosen_delete.php?nik=<?php echo $row['nik']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    </main>
<?php include '../../footer.php'; ?>