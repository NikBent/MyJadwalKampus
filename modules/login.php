<?php
session_start();
require_once '../config/config.php';

$error = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    if (empty($username) || empty($password)) {
        $error = "Username dan password wajib diisi.";
    } else {
        // Pastikan tabel users memiliki kolom: username, password, role, dan nama (untuk tampilan)
        $query = "SELECT * FROM users WHERE username = ? AND password = md5(?) AND role = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $error = "Login gagal, pastikan username, password, dan role yang dipilih benar.";
        }
    }
}
// output halaman
include 'header.php';
?>
    <div class="login-container">
        <h1>Login</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <br>
            <label>Password:</label>
            <input type="password" name="password" required>
            <br>
            <label>Role:</label>
            <select name="role" required>
                <option value="">-- Pilih Role --</option>
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>
            <br>
            <input type="submit" name="login" value="Login">
        </form>
    </div>
<?php include 'footer.php'; ?>