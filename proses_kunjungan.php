<?php

include "config/database.php";


// ======================================================
// CEK REQUEST
// ======================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header("Location: index.php");
    exit;

}


// ======================================================
// AMBIL DATA FORM
// ======================================================

$nis = trim($_POST['nis'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$kelas = trim($_POST['kelas'] ?? '');
$keperluan = trim($_POST['keperluan'] ?? '');


// ======================================================
// VALIDASI
// ======================================================

if (
    empty($nis) ||
    empty($nama) ||
    empty($kelas) ||
    empty($keperluan)
) {

    echo "
        <script>
            alert('Semua data wajib diisi!');
            window.location='index.php';
        </script>
    ";

    exit;

}


// ======================================================
// CARI ID KELAS
// ======================================================

$kelas_safe = mysqli_real_escape_string(
    $koneksi,
    $kelas
);

$query_kelas = mysqli_query(
    $koneksi,

    "SELECT id_kelas
     FROM kelas
     WHERE nama_kelas = '$kelas_safe'
     LIMIT 1"
);


if (!$query_kelas || mysqli_num_rows($query_kelas) === 0) {

    echo "
        <script>
            alert('Kelas tidak ditemukan di database!');
            window.location='index.php';
        </script>
    ";

    exit;

}


$data_kelas = mysqli_fetch_assoc(
    $query_kelas
);

$id_kelas = (int) $data_kelas['id_kelas'];


// ======================================================
// ESCAPE DATA
// ======================================================

$nis = mysqli_real_escape_string(
    $koneksi,
    $nis
);

$nama = mysqli_real_escape_string(
    $koneksi,
    $nama
);

$keperluan = mysqli_real_escape_string(
    $koneksi,
    $keperluan
);


// ======================================================
// SIMPAN KUNJUNGAN
// ======================================================

$query = "

    INSERT INTO pengunjung
    (
        nis,
        nama,
        id_kelas,
        keperluan
    )

    VALUES
    (
        '$nis',
        '$nama',
        '$id_kelas',
        '$keperluan'
    )

";


$result = mysqli_query(
    $koneksi,
    $query
);


// ======================================================
// HASIL
// ======================================================

if ($result) {

    echo "

        <script>

            alert(
                'Data kunjungan berhasil disimpan!'
            );

            window.location='index.php';

        </script>

    ";

} else {

    echo "

        <script>

            alert(
                'Data gagal disimpan: " .
                mysqli_real_escape_string(
                    $koneksi,
                    mysqli_error($koneksi)
                )
                . "'
            );

            window.location='index.php';

        </script>

    ";

}
?>
