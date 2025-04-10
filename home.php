<?php
session_start();
// output halaman
include 'header.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - Selamat Datang</title>
    <link rel="stylesheet" href="./css/home.css">
    <style>
        
    </style>
</head>
<body>
<main style="min-height: 80vh;"> 
    <div class="container">
        <h1>Selamat Datang di Portal Akademik</h1>
        <p>Silakan login atau register untuk melanjutkan ke sistem.</p>
        <a class="btn btn-login" href="login.php">Login</a>
        <a class="btn btn-register" href="register.php">Register</a>
    </div>
</main>
</body>
</html>
<?php include 'footer.php'; ?>