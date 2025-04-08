<?php
session_start();

// Jika user sudah login, langsung redirect ke mainmenu.php
if (isset($_SESSION['user'])) {
    header("Location: mainmenu.php");
    exit();
}
// output halaman
include 'header.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - Selamat Datang</title>
    <!-- Pastikan path file CSS sudah sesuai dengan struktur folder kamu -->
    <link rel="stylesheet" href="assets/css/home.css">
    <style>
        /* Contoh styling dasar internal, bisa digantikan dengan file eksternal */
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Portal Akademik</h1>
        <p>Silakan login atau register untuk melanjutkan ke sistem.</p>
        <a class="btn btn-login" href="login.php">Login</a>
        <a class="btn btn-register" href="register.php">Register</a>
    </div>
</body>
</html>
<?php include 'footer.php'; ?>