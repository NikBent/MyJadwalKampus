<?php
// matkul_delete.php
require 'config.php';
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['kode_mk'])) {
    $kode_mk = $_GET['kode_mk'];
    $sql = "DELETE FROM ms_matkul WHERE kode_mk='$kode_mk'";
    mysqli_query($conn, $sql);
}
header("Location: matkul_list.php");
exit();
?>
