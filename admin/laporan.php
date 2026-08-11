<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";


// ======================================================
// AMBIL PARAMETER FILTER
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
// QUERY DASAR
// ======================================================

$sql = "

    SELECT
        p.id_pengunjung,
        p.nis,
        p.nama,
        p.id_kelas,
        k.nama_kelas,
        p.keperluan,
        p.waktu_kunjungan

    FROM pengunjung p

    LEFT JOIN kelas k
        ON p.id_kelas = k.id_kelas

    WHERE 1=1

";


// ======================================================
// FILTER TANGGAL
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
// SEARCH NAMA / NIS
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


// ======================================================
// EKSEKUSI
// ======================================================

$result = mysqli_query(
    $koneksi,
    $sql
);


// ======================================================
// DATA KELAS
// ======================================================

$query_kelas = mysqli_query(
    $koneksi,

    "
        SELECT
            id_kelas,
            nama_kelas

        FROM kelas

        ORDER BY nama_kelas ASC
    "
);


// ======================================================
// STATISTIK LAPORAN
// ======================================================

$total_laporan = 0;

if ($result) {

    $total_laporan =
        mysqli_num_rows($result);

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Laporan Kunjungan
    </title>


    <script src="https://cdn.tailwindcss.com"></script>


    <script>

        tailwind.config = {

            theme: {

                extend: {

                    fontFamily: {

                        sans: [
                            'Inter',
                            'ui-sans-serif',
                            'system-ui'
                        ]

                    }

                }

            }

        }

    </script>

</head>


<body class="bg-slate-100 text-slate-800">


<div class="min-h-screen">


    <!-- ==================================================
         HEADER
         ================================================== -->

    <header
        class="bg-white border-b border-slate-200"
    >

        <div
            class="max-w-7xl mx-auto px-6 py-5"
        >

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
            >

                <div>

                    <div
                        class="flex items-center gap-3"
                    >

                        <div
                            class="w-11 h-11 rounded-xl bg-emerald-600 text-white flex items-center justify-center"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                class="w-5 h-5"
                            >

                                <path
                                    d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"
                                />

                                <path
                                    d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"
                                />

                            </svg>

                        </div>


                        <div>

                            <h1
                                class="text-xl font-bold text-slate-900"
                            >
                                Laporan Kunjungan
                            </h1>

                            <p
                                class="text-sm text-slate-500"
                            >
                                Buku Kunjungan Digital Perpustakaan
                            </p>

                        </div>

                    </div>

                </div>


                <div
                    class="flex items-center gap-2"
                >

                    <a
                        href="index.php"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-600 hover:bg-slate-50 transition"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="w-4 h-4"
                        >

                            <path d="m15 18-6-6 6-6"/>

                        </svg>

                        Dashboard

                    </a>


                    <button
                        onclick="window.print()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="w-4 h-4"
                        >

                            <path
                                d="M6 9V2h12v7"
                            />

                            <path
                                d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"
                            />

                            <path
                                d="M6 14h12v8H6z"
                            />

                        </svg>

                        Cetak

                    </button>

                    <a
href="export_laporan.php?<?= http_build_query($_GET); ?>"
class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition"

>

<svg
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="2"
    class="w-4 h-4"
>

    <path
        d="M12 3v12"
    />

    <path
        d="m7 10 5 5 5-5"
    />

    <path
        d="M5 21h14"
    />

</svg>

Export CSV

</a>


                </div>

            </div>

        </div>

    </header>



    <!-- ==================================================
         MAIN
         ================================================== -->

    <main
        class="max-w-7xl mx-auto px-6 py-8"
    >


        <!-- ==================================================
             FILTER CARD
             ================================================== -->

        <section
            class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-6"
        >

            <div
                class="px-6 py-5 border-b border-slate-100"
            >

                <div
                    class="flex items-center gap-3"
                >

                    <div
                        class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="w-5 h-5"
                        >

                            <path
                                d="M4 6h16"
                            />

                            <path
                                d="M7 12h10"
                            />

                            <path
                                d="M10 18h4"
                            />

                        </svg>

                    </div>


                    <div>

                        <h2
                            class="font-bold text-slate-900"
                        >
                            Atur Laporan
                        </h2>

                        <p
                            class="text-xs text-slate-500"
                        >
                            Sesuaikan data yang ingin ditampilkan.
                        </p>

                    </div>

                </div>

            </div>


            <form
                method="GET"
                class="p-6"
            >

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5"
                >


                    <!-- TANGGAL MULAI -->

                    <div>

                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Tanggal Mulai
                        </label>

                        <input
                            type="date"
                            name="tanggal_mulai"
                            value="<?= htmlspecialchars($tanggal_mulai); ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >

                    </div>


                    <!-- TANGGAL SELESAI -->

                    <div>

                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Tanggal Selesai
                        </label>

                        <input
                            type="date"
                            name="tanggal_selesai"
                            value="<?= htmlspecialchars($tanggal_selesai); ?>"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >

                    </div>


                    <!-- KELAS -->

                    <div>

                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Kelas
                        </label>

                        <select
                            name="id_kelas"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >

                            <option value="">
                                Semua Kelas
                            </option>


                            <?php while (
                                $kelas_data =
                                mysqli_fetch_assoc($query_kelas)
                            ): ?>

                                <option
                                    value="<?= $kelas_data['id_kelas']; ?>"
                                    <?= (
                                        $id_kelas ==
                                        $kelas_data['id_kelas']
                                    )
                                        ? 'selected'
                                        : ''
                                    ?>
                                >

                                    <?= htmlspecialchars(
                                        $kelas_data['nama_kelas']
                                    ); ?>

                                </option>

                            <?php endwhile; ?>

                        </select>

                    </div>


                    <!-- KEPERLUAN -->

                    <div>

                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Keperluan
                        </label>

                        <select
                            name="keperluan"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >

                            <option value="">
                                Semua Keperluan
                            </option>

                            <option
                                value="Membaca"
                                <?= $keperluan === 'Membaca'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Membaca
                            </option>

                            <option
                                value="Meminjam Buku"
                                <?= $keperluan === 'Meminjam Buku'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Meminjam Buku
                            </option>

                            <option
                                value="Mengembalikan Buku"
                                <?= $keperluan === 'Mengembalikan Buku'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Mengembalikan Buku
                            </option>

                            <option
                                value="Belajar"
                                <?= $keperluan === 'Belajar'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Belajar
                            </option>

                            <option
                                value="Lainnya"
                                <?= $keperluan === 'Lainnya'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Lainnya
                            </option>

                        </select>

                    </div>


                    <!-- SEARCH -->

                    <div class="md:col-span-2">

                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Cari Nama / NIS
                        </label>

                        <input
                            type="text"
                            name="keyword"
                            value="<?= htmlspecialchars($keyword); ?>"
                            placeholder="Contoh: Muhammad Nur Alam atau 12345"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >

                    </div>


                    <!-- URUTKAN -->

                    <div>

                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Urutkan Berdasarkan
                        </label>

                        <select
                            name="sort"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >

                            <option
                                value="waktu"
                                <?= $sort === 'waktu'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Waktu Kunjungan
                            </option>

                            <option
                                value="nama"
                                <?= $sort === 'nama'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Nama
                            </option>

                            <option
                                value="nis"
                                <?= $sort === 'nis'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                NIS
                            </option>

                            <option
                                value="kelas"
                                <?= $sort === 'kelas'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Kelas
                            </option>

                            <option
                                value="keperluan"
                                <?= $sort === 'keperluan'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Keperluan
                            </option>

                        </select>

                    </div>


                    <!-- URUTAN -->

                    <div>

                        <label
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Urutan
                        </label>

                        <select
                            name="order"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >

                            <option
                                value="DESC"
                                <?= $order === 'DESC'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Terbaru / Z-A
                            </option>

                            <option
                                value="ASC"
                                <?= $order === 'ASC'
                                    ? 'selected'
                                    : ''
                                ?>
                            >
                                Terlama / A-Z
                            </option>

                        </select>

                    </div>

                </div>


                <!-- BUTTON -->

                <div
                    class="flex flex-col sm:flex-row gap-3 mt-6 pt-5 border-t border-slate-100"
                >

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="w-4 h-4"
                        >

                            <path
                                d="m21 21-4.35-4.35"
                            />

                            <circle
                                cx="11"
                                cy="11"
                                r="7"
                            />

                        </svg>

                        Terapkan Filter

                    </button>


                    <a
                        href="laporan.php"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-semibold hover:bg-slate-50 transition"
                    >

                        Reset

                    </a>

                </div>

            </form>

        </section>



        <!-- ==================================================
             SUMMARY
             ================================================== -->

        <div
            class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6"
        >

            <div
                class="bg-white border border-slate-200 rounded-2xl p-5"
            >

                <p
                    class="text-sm text-slate-500"
                >
                    Total Data
                </p>

                <p
                    class="mt-1 text-3xl font-bold text-slate-900"
                >

                    <?= number_format(
                        $total_laporan
                    ); ?>

                </p>

            </div>


            <div
                class="bg-white border border-slate-200 rounded-2xl p-5"
            >

                <p
                    class="text-sm text-slate-500"
                >
                    Kelas
                </p>

                <p
                    class="mt-1 text-lg font-bold text-slate-900"
                >

                    <?= !empty($id_kelas)
                        ? 'Terpilih'
                        : 'Semua Kelas'
                    ?>

                </p>

            </div>


            <div
                class="bg-white border border-slate-200 rounded-2xl p-5"
            >

                <p
                    class="text-sm text-slate-500"
                >
                    Periode
                </p>

                <p
                    class="mt-1 text-sm font-bold text-slate-900"
                >

                    <?= !empty($tanggal_mulai)
                        ? date(
                            'd/m/Y',
                            strtotime($tanggal_mulai)
                        )
                        : 'Semua waktu'
                    ?>

                    -

                    <?= !empty($tanggal_selesai)
                        ? date(
                            'd/m/Y',
                            strtotime($tanggal_selesai)
                        )
                        : 'Sekarang'
                    ?>

                </p>

            </div>

        </div>



        <!-- ==================================================
             TABLE
             ================================================== -->

        <section
            class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden"
        >

            <div
                class="px-6 py-5 border-b border-slate-100 flex items-center justify-between"
            >

                <div>

                    <h2
                        class="font-bold text-slate-900"
                    >
                        Hasil Laporan
                    </h2>

                    <p
                        class="text-xs text-slate-500 mt-1"
                    >
                        <?= number_format(
                            $total_laporan
                        ); ?>
                        data ditemukan
                    </p>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table
                    class="w-full text-sm"
                >

                    <thead>

                        <tr
                            class="bg-slate-50 border-b border-slate-200"
                        >

                            <th
                                class="px-6 py-4 text-left font-semibold text-slate-600"
                            >
                                #
                            </th>

                            <th
                                class="px-6 py-4 text-left font-semibold text-slate-600"
                            >
                                NIS
                            </th>

                            <th
                                class="px-6 py-4 text-left font-semibold text-slate-600"
                            >
                                Nama
                            </th>

                            <th
                                class="px-6 py-4 text-left font-semibold text-slate-600"
                            >
                                Kelas
                            </th>

                            <th
                                class="px-6 py-4 text-left font-semibold text-slate-600"
                            >
                                Keperluan
                            </th>

                            <th
                                class="px-6 py-4 text-left font-semibold text-slate-600"
                            >
                                Waktu
                            </th>

                        </tr>

                    </thead>


                    <tbody
                        class="divide-y divide-slate-100"
                    >

                        <?php

                        $no = 1;

                        if ($result):

                            while (
                                $row =
                                mysqli_fetch_assoc($result)
                            ):

                        ?>

                            <tr
                                class="hover:bg-slate-50 transition"
                            >

                                <td
                                    class="px-6 py-4 text-slate-400"
                                >
                                    <?= $no++; ?>
                                </td>


                                <td
                                    class="px-6 py-4 font-medium text-slate-700"
                                >

                                    <?= htmlspecialchars(
                                        $row['nis']
                                    ); ?>

                                </td>


                                <td
                                    class="px-6 py-4"
                                >

                                    <p
                                        class="font-semibold text-slate-800"
                                    >

                                        <?= htmlspecialchars(
                                            $row['nama']
                                        ); ?>

                                    </p>

                                </td>


                                <td
                                    class="px-6 py-4"
                                >

                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold"
                                    >

                                        <?= htmlspecialchars(
                                            $row['nama_kelas']
                                        ); ?>

                                    </span>

                                </td>


                                <td
                                    class="px-6 py-4"
                                >

                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-medium"
                                    >

                                        <?= htmlspecialchars(
                                            $row['keperluan']
                                        ); ?>

                                    </span>

                                </td>


                                <td
                                    class="px-6 py-4 text-slate-500 whitespace-nowrap"
                                >

                                    <?= date(
                                        'd/m/Y H:i',
                                        strtotime(
                                            $row['waktu_kunjungan']
                                        )
                                    ); ?>

                                </td>

                            </tr>


                        <?php

                            endwhile;

                        endif;

                        ?>


                        <?php if ($total_laporan === 0): ?>

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-16 text-center"
                                >

                                    <div
                                        class="flex flex-col items-center"
                                    >

                                        <div
                                            class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4"
                                        >

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.6"
                                                class="w-7 h-7 text-slate-400"
                                            >

                                                <path
                                                    d="M3 6h18"
                                                />

                                                <path
                                                    d="M8 6V4h8v2"
                                                />

                                                <path
                                                    d="M19 6l-1 14H6L5 6"
                                                />

                                                <path
                                                    d="M10 11v5"
                                                />

                                                <path
                                                    d="M14 11v5"
                                                />

                                            </svg>

                                        </div>


                                        <p
                                            class="font-semibold text-slate-700"
                                        >
                                            Tidak ada data
                                        </p>


                                        <p
                                            class="text-sm text-slate-400 mt-1"
                                        >
                                            Tidak ada kunjungan yang sesuai
                                            dengan filter.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>


<!-- ==================================================
     PRINT STYLE
     ================================================== -->

<style>

@media print {

    body {
        background: white !important;
    }

    header {
        border: none !important;
    }

    header a,
    header button,
    form,
    .no-print {
        display: none !important;
    }

    main {
        max-width: none !important;
        padding: 0 !important;
    }

    section {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }

    .grid {
        display: none !important;
    }

    table {
        font-size: 11px;
    }

}

</style>


</body>

</html>