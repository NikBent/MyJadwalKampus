<?php
// header.php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MyJadwalKampus</title>
    <link rel="stylesheet" href="assets/css/header.css"> <!-- sesuaikan path sesuai struktur folder -->
    <!-- Tambahkan CSS/JS lainnya jika diperlukan -->
</head>
<body>
    <div class="header">
        <h1>MyJadwalKampus</h1>
        <?php if(isset($_SESSION['user'])): ?>
            <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['user']['username']); ?> | <a href="./logout.php">Sign Out</a></p>
        <?php endif; ?>
    </div>
