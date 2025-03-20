<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/database.php';

// Proses input data
if (isset($_POST['submit'])) {
    $nik         = $_POST['nik'];
    $nama        = $_POST['nama'];
    $gelar       = $_POST['gelar'];
    $lulusan     = $_POST['lulusan'];
    $telp        = $_POST['telp'];
    $user_input  = $_SESSION['user']['username'];
    $tanggal_input = date("Y-m-d H:i:s");

    $query = "INSERT INTO dosen (nik, nama, gelar, lulusan, telp, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssssss", $nik, $nama, $gelar, $lulusan, $telp, $user_input, $tanggal_input);
    $stmt->execute();
    header("Location: master_dosen.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Master Dosen</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Master Dosen</h1>
    <h2>Tambah Dosen</h2>
    <form method="post" action="">
        <label>NIK:</label>
        <input type="text" name="nik" required>
        <br>
        <label>Nama:</label>
        <input type="text" name="nama" required>
        <br>
        <label>Gelar:</label>
        <input type="text" name="gelar">
        <br>
        <label>Lulusan:</label>
        <input type="text" name="lulusan">
        <br>
        <label>Telp:</label>
        <input type="text" name="telp">
        <br>
        <input type="submit" name="submit" value="Tambah">
    </form>
    
    <h2>Daftar Dosen</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>Gelar</th>
            <th>Lulusan</th>
            <th>Telp</th>
            <th>User Input</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = "SELECT * FROM dosen";
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nik']); ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['gelar']); ?></td>
            <td><?php echo htmlspecialchars($row['lulusan']); ?></td>
            <td><?php echo htmlspecialchars($row['telp']); ?></td>
            <td><?php echo htmlspecialchars($row['user_input']); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal_input']); ?></td>
            <td>
                <a href="edit_dosen.php?nik=<?php echo $row['nik']; ?>">Edit</a> | 
                <a href="delete_dosen.php?nik=<?php echo $row['nik']; ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="menu_utama.php">Kembali ke Menu Utama</a>
</body>
</html>
