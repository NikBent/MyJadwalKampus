<?php
// config.php
session_start();
$host = 'localhost';
$user = 'root';
$password = ''; 
$database = 'uts_s4';

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
