<?php
// krs_delete.php
require 'config.php';
if (!isset($_SESSION['user']['username']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['krs_id'])) {
    $krs_id = $_GET['krs_id'];
    $sql = "DELETE FROM krs WHERE krs_id='$krs_id'";
    mysqli_query($conn, $sql);
}
header("Location: krs_list.php");
exit();
?>
