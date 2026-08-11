<?php

session_start();

include "config/database.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM users
     WHERE username = '$username'"
);

$user = mysqli_fetch_assoc($query);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['nama'] = $user['nama'];

    header("Location: admin/index.php");
    exit;

}

echo "
<script>
    alert('Username atau password salah!');
    window.location='login.php';
</script>
";