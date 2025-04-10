<?php
// register.php
require_once 'config/config.php';

// Jika user sudah login, alihkan ke mainmenu
if (isset($_SESSION['user'])) {
    header("Location: mainmenu.php");
    exit();
}

// Inisialisasi pesan error
$error = '';
$success = '';

if (isset($_POST['register'])) {
    // Ambil nilai input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    // Validasi sederhana
    if (empty($username) || empty($password) || empty($role)) {
        $error = "Semua field wajib diisi!";
    } else {
        // Cek apakah username sudah ada
        $queryCheck = "SELECT * FROM login WHERE username = ?";
        $stmtCheck = $conn->prepare($queryCheck);
        $stmtCheck->bind_param("s", $username);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $error = "Username sudah terdaftar, silakan gunakan username lain.";
        } else {
            // Jika belum ada, lakukan INSERT ke tabel login
            $query = "INSERT INTO login (username, password, role) VALUES (?, md5(?), ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $username, $password, $role);
            if ($stmt->execute()) {
                // Registrasi berhasil, buat session dan redirect ke mainmenu
                $_SESSION['user'] = [
                    'username' => $username,
                    'role' => $role
                ];
                header("Location: menu_utama.php");
                exit();
            } else {
                $error = "Registrasi gagal, silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Daftar Akun</title>
    <!-- Jika ada file CSS global -->
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
<?php include 'header.php'; // output halaman?>
    <div class="register-container">
        <h1>Daftar Akun</h1>
        
        <?php if (!empty($error)) : ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)) : ?>
            <div class="message success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>

            <input type="submit" name="register" value="Register">
        </form>
        <a class="link-login" href="login.php">Sudah punya akun? Login di sini</a>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
