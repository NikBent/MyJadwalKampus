<?php
// login.php

require_once './config/config.php';

$error = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // validasi wajib diisi
    if ($username === '' || $password === '' || $role === '') {
        $error = "Username, Password, dan Role wajib diisi.";
    } else {
        // cek di tabel `login`
        $query = "SELECT * FROM login 
                  WHERE username = ? 
                    AND password = MD5(?) 
                    AND role = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // simpan session sebagai array
            $_SESSION['user'] = [
                'username' => $user['username'],
                'role' => strtolower($user['role']),
            ];
        
            // redirect sesuai role
            if ($_SESSION['user']['role'] === 'admin') {
                header("Location: menu_admin.php");
            } else {
                header("Location: ./modules/ModulLaporan/laporan.php");
            }
            exit();

        } else {
            $error = "Login gagal: Username, Password, atau Role tidak sesuai.";
        }
    }
}
// output halaman
$login_css = true;
include 'headerlogin.php';
?>
<main style="min-height: 80vh;">
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
</main>
<?php include 'footer.php'; ?>
