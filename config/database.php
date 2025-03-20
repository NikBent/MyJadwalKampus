<?php
// config/database.php
require_once 'config.php';

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'UTS_S4';

$db = new mysqli($host, $user, $password, $database);

if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
