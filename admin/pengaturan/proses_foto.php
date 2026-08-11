<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include "../../config/database.php";


// ======================================================
// CEK SESSION
// ======================================================

$id_user = (int) ($_SESSION['id_user'] ?? 0);

if ($id_user <= 0) {

    echo "
        <script>
            alert('Session admin tidak ditemukan.');
            window.location='foto.php';
        </script>
    ";

    exit;
}


// ======================================================
// FOLDER UPLOAD
// ======================================================

$folder = "../../uploads/profile/";


// Buat folder jika belum ada

if (!is_dir($folder)) {

    mkdir(
        $folder,
        0755,
        true
    );

}


// ======================================================
// AMBIL FOTO LAMA
// ======================================================

$query_user = mysqli_query(
    $koneksi,

    "SELECT foto
     FROM users
     WHERE id_user = $id_user
     LIMIT 1"
);

$user = mysqli_fetch_assoc($query_user);

if (!$user) {

    echo "
        <script>
            alert('Data admin tidak ditemukan.');
            window.location='foto.php';
        </script>
    ";

    exit;
}


$foto_lama = $user['foto'];


// ======================================================
// AKSI HAPUS
// ======================================================

$aksi = $_POST['aksi'] ?? '';


if ($aksi === 'hapus') {


    // Hapus file fisik

    if (
        !empty($foto_lama)
        &&
        file_exists($folder . $foto_lama)
    ) {

        unlink(
            $folder . $foto_lama
        );

    }


    // Kosongkan database

    $update = mysqli_query(
        $koneksi,

        "UPDATE users
         SET foto = NULL
         WHERE id_user = $id_user"
    );


    if ($update) {

        echo "
            <script>
                alert('Foto profil berhasil dihapus.');
                window.location='foto.php';
            </script>
        ";

    } else {

        echo "
            <script>
                alert('Foto profil gagal dihapus.');
                window.location='foto.php';
            </script>
        ";

    }

    exit;
}


// ======================================================
// CEK FILE
// ======================================================

if (
    !isset($_FILES['foto'])
    ||
    $_FILES['foto']['error'] !== UPLOAD_ERR_OK
) {

    echo "
        <script>
            alert('Silakan pilih foto terlebih dahulu.');
            window.location='foto.php';
        </script>
    ";

    exit;
}


$file = $_FILES['foto'];


// ======================================================
// BATAS UKURAN
// ======================================================

$max_size = 2 * 1024 * 1024;


if ($file['size'] > $max_size) {

    echo "
        <script>
            alert('Ukuran foto maksimal 2 MB.');
            window.location='foto.php';
        </script>
    ";

    exit;
}


// ======================================================
// VALIDASI MIME TYPE
// ======================================================

$finfo = finfo_open(FILEINFO_MIME_TYPE);

$mime = finfo_file(
    $finfo,
    $file['tmp_name']
);

finfo_close($finfo);


$allowed_mime = [
    'image/jpeg',
    'image/png'
];


if (!in_array($mime, $allowed_mime, true)) {

    echo "
        <script>
            alert('Format foto harus JPG, JPEG, atau PNG.');
            window.location='foto.php';
        </script>
    ";

    exit;
}


// ======================================================
// EKSTENSI FILE
// ======================================================

$extension = match ($mime) {

    'image/jpeg' => 'jpg',

    'image/png' => 'png',

    default => ''

};


if ($extension === '') {

    echo "
        <script>
            alert('Format foto tidak valid.');
            window.location='foto.php';
        </script>
    ";

    exit;
}


// ======================================================
// BUAT NAMA FILE RANDOM
// ======================================================

$nama_file = 'profile_' .
    $id_user .
    '_' .
    bin2hex(random_bytes(8)) .
    '.' .
    $extension;


$target = $folder . $nama_file;


// ======================================================
// PINDAHKAN FILE
// ======================================================

if (!move_uploaded_file(
    $file['tmp_name'],
    $target
)) {

    echo "
        <script>
            alert('Foto gagal diupload.');
            window.location='foto.php';
        </script>
    ";

    exit;
}


// ======================================================
// UPDATE DATABASE
// ======================================================

$nama_file_db = mysqli_real_escape_string(
    $koneksi,
    $nama_file
);


$update = mysqli_query(
    $koneksi,

    "UPDATE users
     SET foto = '$nama_file_db'
     WHERE id_user = $id_user"
);


// ======================================================
// JIKA DATABASE GAGAL
// ======================================================

if (!$update) {

    // Hapus file yang baru saja diupload

    if (file_exists($target)) {
        unlink($target);
    }


    echo "
        <script>
            alert('Database gagal diperbarui.');
            window.location='foto.php';
        </script>
    ";

    exit;
}


// ======================================================
// HAPUS FOTO LAMA
// ======================================================

if (
    !empty($foto_lama)
    &&
    file_exists($folder . $foto_lama)
) {

    unlink(
        $folder . $foto_lama
    );

}


// ======================================================
// BERHASIL
// ======================================================

echo "
    <script>
        alert('Foto profil berhasil diperbarui.');
        window.location='foto.php';
    </script>
";

exit;

?>
