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
    <link rel="stylesheet" href="/MyJadwalKampus/css/footer.css">
    <link rel="stylesheet" href="/MyJadwalKampus/css/header.css"> 
    <?php
$styles = [
    'login_css' => 'css/login.css',
    'menuAdmin_css' => 'css/menu_admin.css'
];

foreach ($styles as $key => $href) {
    if (isset($$key)) {
        echo "<link rel='stylesheet' href='$href'>\n";
    }
}
?>

</head>
<body>
    <div class="header">
    <h1>MyJadwalKampus</h1>
        <?php date_default_timezone_set('Asia/Jakarta'); // pastikan zona waktu Indonesia
            $hour = date('H');
            if ($hour >= 5 && $hour < 12) {
                $greeting = "Selamat Pagi";
            } elseif ($hour >= 12 && $hour < 15) {
                $greeting = "Selamat Siang";
            } elseif ($hour >= 15 && $hour < 18) {
                $greeting = "Selamat Sore";
            } else {
                $greeting = "Selamat Malam";
            }
            ?>
            <p><?php echo $greeting . ', ' . htmlspecialchars($_SESSION['user']['username']) . '!'; ?></p>
    </div>
