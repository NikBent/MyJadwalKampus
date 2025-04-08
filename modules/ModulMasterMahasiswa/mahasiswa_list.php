<?php
// mahasiswa_list.php
require '../config/config.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM ms_mahasiswa";
$result = mysqli_query($conn, $sql);
// output halaman
include __DIR__ . '/../header.php';
?>
    <h2>Data Mahasiswa</h2>
    <p><a href="mahasiswa_add.php">Tambah Mahasiswa</a> | <a href="index.php">Menu Utama</a></p>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Angkatan</th>
            <th>User Input</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nim']); ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['no_Hp']); ?></td>
            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
            <td><?php echo htmlspecialchars($row['angkatan']); ?></td>
            <td><?php echo htmlspecialchars($row['user_input']); ?></td>
            <td><?php echo htmlspecialchars($row['tgl_input']); ?></td>
            <td>
                <a href="mahasiswa_edit.php?nim=<?php echo $row['nim']; ?>">Edit</a> |
                <a href="mahasiswa_delete.php?nim=<?php echo $row['nim']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
<?php include __DIR__ . '/../footer.php'; ?>
