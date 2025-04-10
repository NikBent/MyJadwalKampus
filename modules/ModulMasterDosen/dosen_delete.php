<?php
// mahasiswa_delete.php
require '../../config/config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $sql = "DELETE FROM ms_dosen WHERE nik='$nik'";
    mysqli_query($conn, $sql);
}
header("Location: dosen_list.php");
exit();
?>
