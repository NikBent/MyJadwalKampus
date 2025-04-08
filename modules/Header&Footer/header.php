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
    <title>Aplikasi Kampus</title>
    <!-- Tambahkan CSS/JS jika diperlukan -->
</head>
<body>
    <div class="header">
        <h1>Aplikasi Kampus</h1>
        <?php if(isset($_SESSION['username'])): ?>
            <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?> | <a href="logout.php">Sign Out</a></p>
        <?php endif; ?>
    </div>
