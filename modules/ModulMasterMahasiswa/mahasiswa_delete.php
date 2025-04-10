<?php
// mahasiswa_delete.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];
    $sql = "DELETE FROM ms_mahasiswa WHERE nim='$nim'";
    mysqli_query($conn, $sql);
}
header("Location: mahasiswa_list.php");
exit();
?>
