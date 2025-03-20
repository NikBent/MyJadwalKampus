<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
require_once '../config/database.php';

// Proses input data
if (isset($_POST['submit'])) {
    $kode_matkul = $_POST['kode_matkul'];
    $nama_matkul = $_POST['nama_matkul'];
    $sks         = $_POST['sks'];
    $semester    = $_POST['semester'];
    $user_input  = $_SESSION['user']['username'];
    $tanggal_input = date("Y-m-d H:i:s");

    $query = "INSERT INTO matakuliah (kode_matkul, nama_matkul, sks, semester, user_input, tanggal_input) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssisss", $kode_matkul, $nama_matkul, $sks, $semester, $user_input, $tanggal_input);
    $stmt->execute();
    header("Location: master_matakuliah.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Master Mata Kuliah</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Master Mata Kuliah</h1>
    <h2>Tambah Mata Kuliah</h2>
    <form method="post" action="">
        <label>Kode Mata Kuliah:</label>
        <input type="text" name="kode_matkul" required>
        <br>
        <label>Nama Mata Kuliah:</label>
        <input type="text" name="nama_matkul" required>
        <br>
        <label>SKS:</label>
        <input type="number" name="sks" required>
        <br>
        <label>Semester:</label>
        <input type="text" name="semester" required>
        <br>
        <input type="submit" name="submit" value="Tambah">
    </form>
    
    <h2>Daftar Mata Kuliah</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Kode Matkul</th>
            <th>Nama Matkul</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>User Input</th>
            <th>Tanggal Input</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = "SELECT * FROM matakuliah";
        $result = $db->query($query);
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['kode_matkul']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_matkul']); ?></td>
            <td><?php echo htmlspecialchars($row['sks']); ?></td>
            <td><?php echo htmlspecialchars($row['semester']); ?></td>
            <td><?php echo htmlspecialchars($row['user_input']); ?></td>
            <td><?php echo htmlspecialchars($row['tanggal_input']); ?></td>
            <td>
                <a href="edit_matakuliah.php?kode_matkul=<?php echo $row['kode_matkul']; ?>">Edit</a> | 
                <a href="delete_matakuliah.php?kode_matkul=<?php echo $row['kode_matkul']; ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="menu_utama.php">Kembali ke Menu Utama</a>
</body>
</html>
