<?php
// login.php
require_once 'config/config.php';

$error = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    // validasi wajib diisi
    if ($username === '' || $password === '' || $role === '') {
        $error = "Username, Password, dan Role wajib diisi.";
    } else {
        // cek di tabel `login`
        $query = "SELECT * FROM login 
                  WHERE username = ? 
                    AND password = MD5(?) 
                    AND role = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // simpan session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];

            // redirect sesuai role
            if ($user['role'] === 'admin') {
                header("Location: index.php");
            } else {
                // dosen & mahasiswa sama‐sama ke laporan.php
                header("Location: laporan.php");
            }
            exit();
        } else {
            $error = "Login gagal: Username, Password, atau Role tidak sesuai.";
        }
    }
}
// output halaman
include 'header.php';
?>
<link rel="stylesheet" href="assets/css/login.css">
<div class="login-container">
    <h1>Login</h1>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Role:</label>
        <select name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="dosen">Dosen</option>
            <option value="mahasiswa">Mahasiswa</option>
        </select>

        <input type="submit" name="login" value="Login">
    </form>
</div>
<?php include 'footer.php'; ?>