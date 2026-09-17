<?php

session_start();

include 'config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$username = mysqli_real_escape_string($koneksi, $username);

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

        echo "Password salah!";
        echo "<br>";
        echo "<a href='login.php'>Kembali ke Login</a>";

    }

} else {

    echo "Username tidak ditemukan!";
    echo "<br>";
    echo "<a href='login.php'>Kembali ke Login</a>";

}

?>