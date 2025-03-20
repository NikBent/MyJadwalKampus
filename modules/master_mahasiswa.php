<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/database.php';

// Proses input data
if (isset($_POST['submit'])) {
    $nim         = $_POST['nim'];
    $nama        = $_POST['nama'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $alamat      = $_POST['alamat'];
    $telp        = $_POST['telp'];
    $user_input  = $_SESSION['user']['username'];
    $tanggal_input = date("Y-m-d H:i:s");

    $query = "INSERT INTO mahasiswa (nim, nama, tahun_masuk, alamat, telp, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssssss", $nim, $nama, $tahun_masuk, $alamat, $telp, $user_input, $tanggal_input);
    $stmt->execute();
    header("Location: master_mahasiswa.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Master Mahasiswa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Master Mahasiswa</h1>
    <h2>Tambah Mahasiswa</h2>
    <form method="post" action="">
        <label>NIM:</label>
        <input type="text" name="nim" required>
        <br>
        <label>Nama:</label>
        <input type="text" name="nama" required>
        <br>
        <label>Tahun Masuk:</label>
        <input type="text" name="tahun_masuk" required>
        <br>
        <label>Alamat:</label>
        <textarea name="alamat" required></textarea>
        <br>
        <label>Telp:</label>
        <input type="text" name="telp">
        <br>
        <input type="submit" name="submit" value="Tambah">
    </form>
    
    <h2>Daftar Mahasiswa</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Tahun Masuk</th>
            <th>Alamat</th>
            <th>Telp</th>
            <th>User Input</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = "SELECT * FROM mahasiswa";
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nim']); ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['tahun_masuk']); ?></td>
            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
            <td><?php echo htmlspecialchars($row['telp']); ?></td>
            <td><?php echo htmlspecialchars($row['user_input']); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal_input']); ?></td>
            <td>
                <a href="edit_mahasiswa.php?nim=<?php echo $row['nim']; ?>">Edit</a> | 
                <a href="delete_mahasiswa.php?nim=<?php echo $row['nim']; ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="menu_utama.php">Kembali ke Menu Utama</a>
</body>
</html>
