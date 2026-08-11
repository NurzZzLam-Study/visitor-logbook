<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include "../../config/database.php";


// ======================================================
// CEK METHOD
// ======================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: profil.php");
    exit;
}


// ======================================================
// AMBIL ID USER DARI SESSION
// ======================================================

$id_user = (int) ($_SESSION['id_user'] ?? 0);

if ($id_user <= 0) {

    echo "
        <script>
            alert('Session admin tidak ditemukan.');
            window.location='profil.php';
        </script>
    ";

    exit;
}


// ======================================================
// AMBIL DATA FORM
// ======================================================

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');


// ======================================================
// VALIDASI
// ======================================================

if ($nama === '' || $username === '') {

    echo "
        <script>
            alert('Nama dan username wajib diisi.');
            window.location='profil.php';
        </script>
    ";

    exit;
}


if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo "
        <script>
            alert('Format email tidak valid.');
            window.location='profil.php';
        </script>
    ";

    exit;
}


// ======================================================
// ESCAPE DATA
// ======================================================

$nama = mysqli_real_escape_string(
    $koneksi,
    $nama
);

$username = mysqli_real_escape_string(
    $koneksi,
    $username
);

$email = mysqli_real_escape_string(
    $koneksi,
    $email
);

$no_hp = mysqli_real_escape_string(
    $koneksi,
    $no_hp
);

$alamat = mysqli_real_escape_string(
    $koneksi,
    $alamat
);


// ======================================================
// CEK USERNAME
// ======================================================

$cek_username = mysqli_query(
    $koneksi,

    "SELECT id_user
     FROM users
     WHERE username = '$username'
     AND id_user != $id_user
     LIMIT 1"
);


if (mysqli_num_rows($cek_username) > 0) {

    echo "
        <script>
            alert('Username sudah digunakan admin lain.');
            window.location='profil.php';
        </script>
    ";

    exit;
}


// ======================================================
// UPDATE DATA
// ======================================================

$query = "

    UPDATE users

    SET
        nama = '$nama',
        username = '$username',
        email = NULLIF('$email', ''),
        no_hp = NULLIF('$no_hp', ''),
        alamat = NULLIF('$alamat', '')

    WHERE id_user = $id_user

";


$result = mysqli_query(
    $koneksi,
    $query
);


// ======================================================
// HASIL
// ======================================================

if ($result) {

    // Update username di session jika session menyimpannya
    $_SESSION['username'] = $username;

    echo "
        <script>
            alert('Profil berhasil diperbarui.');
            window.location='profil.php';
        </script>
    ";

} else {

    echo "
        <script>
            alert('Profil gagal diperbarui: " .
            mysqli_real_escape_string(
                $koneksi,
                mysqli_error($koneksi)
            )
            . "');
            window.location='profil.php';
        </script>
    ";

}

?>
