<?php
session_start();
include 'config/koneksi.php';

if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, 
        "SELECT * FROM tb_user WHERE username = '$username'"
    );

    if (mysqli_num_rows($query) > 0) {

        $data = mysqli_fetch_assoc($query);

        if (password_verify($password, $data['password'])) {

            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
            $_SESSION['level'] = $data['level'];

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Username atau password salah!";
        }

    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Pembayaran SPP</title>
</head>

<body>

    <h1>Sistem Pembayaran SPP</h1>
    <p>Silakan login untuk melanjutkan.</p>

    <?php if ($error != ""): ?>
        <p><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">

        <p>
            <label>Username</label><br>
            <input type="text" name="username" required>
        </p>

        <p>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </p>

        <p>
            <button type="submit">Login</button>
        </p>

    </form>

    <p>© 2026 Sistem Pembayaran SPP</p>

</body>
</html>