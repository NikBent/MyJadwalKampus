<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/database.php';

// Proses input data KRS
if (isset($_POST['submit'])) {
    $kode_matkul = $_POST['kode_matkul'];
    $nik_dosen   = $_POST['nik_dosen'];
    $nim_mahasiswa = $_POST['nim_mahasiswa'];
    $hari_matkul = $_POST['hari_matkul'];
    $ruangan     = $_POST['ruangan'];
    $user_input  = $_SESSION['user']['username'];
    $tanggal_input = date("Y-m-d H:i:s");

    // Perhatikan: 1 mata kuliah diampu oleh 1 dosen, namun dapat diambil oleh banyak mahasiswa
    $query = "INSERT INTO krs (kode_matkul, nik_dosen, nim_mahasiswa, hari_matkul, ruangan, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssssss", $kode_matkul, $nik_dosen, $nim_mahasiswa, $hari_matkul, $ruangan, $user_input, $tanggal_input);
    $stmt->execute();
    header("Location: transaksi_krs.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaksi KRS</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Transaksi KRS</h1>
    <h2>Setting Mata Kuliah</h2>
    <form method="post" action="">
        <label>Kode Mata Kuliah:</label>
        <input type="text" name="kode_matkul" required>
        <br>
        <label>NIK Dosen:</label>
        <input type="text" name="nik_dosen" required>
        <br>
        <label>NIM Mahasiswa:</label>
        <input type="text" name="nim_mahasiswa" required>
        <br>
        <label>Hari Matkul:</label>
        <input type="text" name="hari_matkul" required>
        <br>
        <label>Ruangan:</label>
        <input type="text" name="ruangan" required>
        <br>
        <input type="submit" name="submit" value="Simpan">
    </form>
    
    <h2>Daftar Transaksi KRS</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Kode Matkul</th>
            <th>NIK Dosen</th>
            <th>NIM Mahasiswa</th>
            <th>Hari Matkul</th>
            <th>Ruangan</th>
            <th>User Input</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = "SELECT * FROM krs";
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['kode_matkul']); ?></td>
            <td><?php echo htmlspecialchars($row['nik_dosen']); ?></td>
            <td><?php echo htmlspecialchars($row['nim_mahasiswa']); ?></td>
            <td><?php echo htmlspecialchars($row['hari_matkul']); ?></td>
            <td><?php echo htmlspecialchars($row['ruangan']); ?></td>
            <td><?php echo htmlspecialchars($row['user_input']); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal_input']); ?></td>
            <td>
                <a href="edit_krs.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                <a href="delete_krs.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="menu_utama.php">Kembali ke Menu Utama</a>
</body>
</html>
