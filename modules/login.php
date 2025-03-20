<?php
session_start();
require_once '../config/database.php';

$error = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Username dan password wajib diisi.";
    } else {
        // Contoh query, pastikan tabel users sudah ada dan simpan password secara hash
        $query = "SELECT * FROM users WHERE username = ? AND password = md5(?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;
            header("Location: menu_utama.php");
            exit();
        } else {
            $error = "Login gagal, username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Akademik</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Login</h1>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>Username:</label>
        <input type="text" name="username" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
