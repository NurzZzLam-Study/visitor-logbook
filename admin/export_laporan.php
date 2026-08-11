<?php

include "../config/database.php";


// ======================================================
// AMBIL FILTER
// ======================================================

$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

$id_kelas = $_GET['id_kelas'] ?? '';
$keperluan = $_GET['keperluan'] ?? '';

$keyword = trim($_GET['keyword'] ?? '');


// ======================================================
// SORTING
// ======================================================

$allowed_sort = [
    'nama' => 'p.nama',
    'nis' => 'p.nis',
    'kelas' => 'k.nama_kelas',
    'keperluan' => 'p.keperluan',
    'waktu' => 'p.waktu_kunjungan'
];

$sort = $_GET['sort'] ?? 'waktu';

if (!array_key_exists($sort, $allowed_sort)) {
    $sort = 'waktu';
}


$order = strtoupper($_GET['order'] ?? 'DESC');

if (!in_array($order, ['ASC', 'DESC'])) {
    $order = 'DESC';
}


// ======================================================
// QUERY
// ======================================================

$sql = "

    SELECT
        p.nis,
        p.nama,
        k.nama_kelas,
        p.keperluan,
        p.waktu_kunjungan

    FROM pengunjung p

    LEFT JOIN kelas k
        ON p.id_kelas = k.id_kelas

    WHERE 1=1

";


// ======================================================
// FILTER TANGGAL MULAI
// ======================================================

if (!empty($tanggal_mulai)) {

    $tanggal_mulai_safe = mysqli_real_escape_string(
        $koneksi,
        $tanggal_mulai
    );

    $sql .= "
        AND DATE(p.waktu_kunjungan)
        >= '$tanggal_mulai_safe'
    ";
}


// ======================================================
// FILTER TANGGAL SELESAI
// ======================================================

if (!empty($tanggal_selesai)) {

    $tanggal_selesai_safe = mysqli_real_escape_string(
        $koneksi,
        $tanggal_selesai
    );

    $sql .= "
        AND DATE(p.waktu_kunjungan)
        <= '$tanggal_selesai_safe'
    ";
}


// ======================================================
// FILTER KELAS
// ======================================================

if (!empty($id_kelas)) {

    $id_kelas_safe = (int) $id_kelas;

    $sql .= "
        AND p.id_kelas = $id_kelas_safe
    ";
}


// ======================================================
// FILTER KEPERLUAN
// ======================================================

if (!empty($keperluan)) {

    $keperluan_safe = mysqli_real_escape_string(
        $koneksi,
        $keperluan
    );

    $sql .= "
        AND p.keperluan = '$keperluan_safe'
    ";
}


// ======================================================
// FILTER NAMA / NIS
// ======================================================

if (!empty($keyword)) {

    $keyword_safe = mysqli_real_escape_string(
        $koneksi,
        $keyword
    );

    $sql .= "

        AND (
            p.nama LIKE '%$keyword_safe%'
            OR
            p.nis LIKE '%$keyword_safe%'
        )

    ";
}


// ======================================================
// SORTING
// ======================================================

$sql .= "

    ORDER BY
    {$allowed_sort[$sort]}
    $order

";


$result = mysqli_query(
    $koneksi,
    $sql
);


// ======================================================
// NAMA FILE
// ======================================================

$filename =
    'laporan_kunjungan_' .
    date('Y-m-d_H-i-s') .
    '.csv';


// ======================================================
// HEADER DOWNLOAD
// ======================================================

header(
    'Content-Type: text/csv; charset=UTF-8'
);

header(
    'Content-Disposition: attachment; filename="' .
    $filename .
    '"'
);

header(
    'Pragma: no-cache'
);

header(
    'Expires: 0'
);


// ======================================================
// OUTPUT CSV
// ======================================================

$output = fopen('php://output', 'w');


// BOM UNTUK EXCEL
fwrite(
    $output,
    "\xEF\xBB\xBF"
);


// ======================================================
// JUDUL
// ======================================================

fputcsv(
    $output,
    [
        'LAPORAN KUNJUNGAN PERPUSTAKAAN'
    ]
);

fputcsv(
    $output,
    []
);


// ======================================================
// INFORMASI FILTER
// ======================================================

fputcsv(
    $output,
    [
        'Periode',
        (!empty($tanggal_mulai)
            ? $tanggal_mulai
            : 'Semua')
        . ' s/d ' .
        (!empty($tanggal_selesai)
            ? $tanggal_selesai
            : 'Sekarang')
    ]
);

fputcsv(
    $output,
    [
        'Kelas',
        !empty($id_kelas)
            ? $id_kelas
            : 'Semua Kelas'
    ]
);

fputcsv(
    $output,
    [
        'Keperluan',
        !empty($keperluan)
            ? $keperluan
            : 'Semua Keperluan'
    ]
);

fputcsv(
    $output,
    [
        'Pencarian',
        !empty($keyword)
            ? $keyword
            : '-'
    ]
);

fputcsv(
    $output,
    []
);


// ======================================================
// HEADER DATA
// ======================================================

fputcsv(
    $output,
    [
        'No',
        'NIS',
        'Nama',
        'Kelas',
        'Keperluan',
        'Waktu Kunjungan'
    ]
);


// ======================================================
// DATA
// ======================================================

$no = 1;

while (
    $row = mysqli_fetch_assoc($result)
) {

    fputcsv(
        $output,
        [
            $no++,
            $row['nis'],
            $row['nama'],
            $row['nama_kelas'],
            $row['keperluan'],
            date(
                'd/m/Y H:i',
                strtotime(
                    $row['waktu_kunjungan']
                )
            )
        ]
    );

}


fclose($output);

exit;

?>
