<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";

// ======================================================
// DATA ADMIN LOGIN
// ======================================================

$id_user = isset($_SESSION['id_user'])
    ? (int) $_SESSION['id_user']
    : 0;

$admin_nama = $_SESSION['nama'] ?? 'Administrator';
$admin_username = $_SESSION['username'] ?? '';
$admin_foto = '';

if ($id_user > 0) {

    $query_admin = mysqli_query(
        $koneksi,
        "SELECT id_user, username, nama, foto
         FROM users
         WHERE id_user = '$id_user'
         LIMIT 1"
    );

    if ($query_admin && mysqli_num_rows($query_admin) > 0) {

        $admin = mysqli_fetch_assoc($query_admin);

        $admin_nama = $admin['nama'];
        $admin_username = $admin['username'];
        $admin_foto = $admin['foto'];

    }
}

$admin_foto_url = '';

if (!empty($admin_foto)) {

    $admin_foto_url =
        "../uploads/profile/" . $admin_foto;

}

$admin_inisial = strtoupper(
    substr($admin_nama, 0, 1)
);


// ======================================================
// STATISTIK
// ======================================================

// Total kunjungan
$query_total = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM pengunjung"
);

$data_total = mysqli_fetch_assoc($query_total);

$total_kunjungan = $data_total['total'];


// Kunjungan hari ini
$query_hari_ini = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM pengunjung
     WHERE DATE(waktu_kunjungan) = CURDATE()"
);

$data_hari_ini = mysqli_fetch_assoc($query_hari_ini);

$kunjungan_hari_ini = $data_hari_ini['total'];


// Kunjungan bulan ini
$query_bulan_ini = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM pengunjung
     WHERE MONTH(waktu_kunjungan) = MONTH(CURDATE())
     AND YEAR(waktu_kunjungan) = YEAR(CURDATE())"
);

$data_bulan_ini = mysqli_fetch_assoc($query_bulan_ini);

$kunjungan_bulan_ini = $data_bulan_ini['total'];


// ======================================================
// STATISTIK JURUSAN
// ======================================================

$query_jurusan = mysqli_query(
    $koneksi,
    "SELECT
        jurusan.nama_jurusan,
        COUNT(pengunjung.id_pengunjung) AS total

     FROM pengunjung

     INNER JOIN kelas
        ON pengunjung.id_kelas = kelas.id_kelas

     INNER JOIN jurusan
        ON kelas.id_jurusan = jurusan.id_jurusan

     GROUP BY jurusan.id_jurusan

     ORDER BY jurusan.id_jurusan"
);


// Simpan statistik jurusan ke array
$statistik_jurusan = [];

while ($data_jurusan = mysqli_fetch_assoc($query_jurusan)) {

    $statistik_jurusan[] = $data_jurusan;

}


// ======================================================
// FILTER
// ======================================================

$keyword = isset($_GET['keyword'])
    ? $_GET['keyword']
    : '';

$id_kelas = isset($_GET['kelas'])
    ? $_GET['kelas']
    : '';

$tanggal = isset($_GET['tanggal'])
    ? $_GET['tanggal']
    : '';


// ======================================================
// WHERE
// ======================================================

$where = [];

if ($keyword != '') {

    $keyword_safe = mysqli_real_escape_string(
        $koneksi,
        $keyword
    );

    $where[] = "
        (
            pengunjung.nis LIKE '%$keyword_safe%'
            OR pengunjung.nama LIKE '%$keyword_safe%'
        )
    ";
}


if ($id_kelas != '') {

    $id_kelas_safe = (int) $id_kelas;

    $where[] = "
        pengunjung.id_kelas = $id_kelas_safe
    ";
}


if ($tanggal != '') {

    $tanggal_safe = mysqli_real_escape_string(
        $koneksi,
        $tanggal
    );

    $where[] = "
        DATE(pengunjung.waktu_kunjungan) = '$tanggal_safe'
    ";
}


// ======================================================
// PAGINATION
// ======================================================

$jumlah_data = 10;

$halaman = isset($_GET['halaman'])
    ? (int) $_GET['halaman']
    : 1;

if ($halaman < 1) {
    $halaman = 1;
}

$offset = ($halaman - 1) * $jumlah_data;


// ======================================================
// TOTAL DATA
// ======================================================

$sql_count = "
    SELECT COUNT(*) AS total
    FROM pengunjung
";

if (count($where) > 0) {

    $sql_count .= "
        WHERE " . implode(" AND ", $where);
}

$result_count = mysqli_query(
    $koneksi,
    $sql_count
);

$data_count = mysqli_fetch_assoc(
    $result_count
);

$total_data = $data_count['total'];

$total_halaman = ceil(
    $total_data / $jumlah_data
);


// ======================================================
// DATA KUNJUNGAN
// ======================================================

$sql = "
    SELECT
        pengunjung.*,
        kelas.nama_kelas,
        jurusan.nama_jurusan

    FROM pengunjung

    INNER JOIN kelas
        ON pengunjung.id_kelas = kelas.id_kelas

    INNER JOIN jurusan
        ON kelas.id_jurusan = jurusan.id_jurusan
";


if (count($where) > 0) {

    $sql .= "
        WHERE " . implode(" AND ", $where);
}


$sql .= "
    ORDER BY pengunjung.waktu_kunjungan DESC

    LIMIT $offset, $jumlah_data
";


$query = mysqli_query(
    $koneksi,
    $sql
);


// ======================================================
// DATA KELAS
// ======================================================

$query_kelas = mysqli_query(
    $koneksi,
    "SELECT *
     FROM kelas
     ORDER BY id_jurusan, id_kelas"
);

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
        Dashboard Perpustakaan
    </title>


    <!-- Tailwind CSS -->

    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Lucide Icons -->

    <script src="https://unpkg.com/lucide@latest"></script>


    <!-- Chart.js -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


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
    <style>

:root {

    /* Golden Ratio */
    --phi: 1.618;

    /* Base spacing */
    --space-xs: 8px;
    --space-sm: 13px;
    --space-md: 21px;
    --space-lg: 34px;
    --space-xl: 55px;

    /* Radius */
    --radius-sm: 8px;
    --radius-md: 13px;
    --radius-lg: 21px;

    /* Colors */
    --ink: #17201d;
    --muted: #718078;
    --paper: #f7f8f6;
    --surface: #ffffff;
    --line: #e5e9e6;

    --green: #176b4d;
    --green-dark: #10543c;
    --green-soft: #eaf4ef;

    --gold: #c59a45;
    --gold-soft: #f8f1df;

}


body {

    font-family:
        Inter,
        ui-sans-serif,
        system-ui,
        sans-serif;

    background: var(--paper);

    color: var(--ink);

}


/* ================================================
   GOLDEN RATIO LAYOUT
   ================================================ */

.golden-layout {

    display: grid;

    grid-template-columns:
        minmax(230px, 38.2%)
        minmax(0, 61.8%);

}


/* ================================================
   GOLDEN RATIO CARD
   ================================================ */

.golden-card {

    background: var(--surface);

    border:
        1px solid
        var(--line);

    border-radius:
        var(--radius-lg);

    box-shadow:
        0 8px 24px
        rgba(23, 32, 29, 0.045);

}


/* ================================================
   GOLDEN RATIO TYPOGRAPHY
   ================================================ */

.display-title {

    font-size: 34px;

    line-height: 1.15;

    letter-spacing: -0.035em;

    font-weight: 700;

}


.section-title {

    font-size: 21px;

    line-height: 1.3;

    font-weight: 650;

    letter-spacing: -0.02em;

}


.body-text {

    font-size: 13px;

    line-height: 1.618;

    color: var(--muted);

}


/* ================================================
   GOLDEN BORDER
   ================================================ */

.gold-accent {

    position: relative;

}


.gold-accent::before {

    content: "";

    position: absolute;

    left: 0;

    top: 21px;

    bottom: 21px;

    width: 3px;

    background: var(--gold);

    border-radius: 999px;

}


/* ================================================
   STATISTIC NUMBER
   ================================================ */

.stat-number {

    font-size: 34px;

    line-height: 1;

    font-weight: 700;

    letter-spacing: -0.04em;

}


/* ================================================
   MOBILE
   ================================================ */

@media (max-width: 1024px) {

    .golden-layout {

        grid-template-columns: 1fr;

    }

}

</style>

</head>


<body class="bg-slate-100 text-slate-800">


<div class="min-h-screen flex">


    <!-- ================================================== -->
    <!-- SIDEBAR -->
    <!-- ================================================== -->

 <aside
    class="hidden lg:flex w-[260px] xl:w-[280px] 2xl:w-[300px]
           bg-white border-r border-slate-200
           flex-col fixed inset-y-0 left-0"
>


        <!-- Logo -->

        <div class="h-20 flex items-center px-6 border-b border-slate-200">

            <div
                class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center"
            >

                <i data-lucide="book-open"></i>

            </div>


            <div class="ml-3">

                <h1 class="font-bold text-slate-900">
                    Perpustakaan
                </h1>

                <p class="text-xs text-slate-500">
                    Digital Library
                </p>

            </div>

        </div>


        <!-- Navigation -->

        <nav class="flex-1 px-4 py-6">


            <p
                class="text-xs font-semibold uppercase tracking-wider text-slate-400 px-3 mb-3"
            >
                Menu
            </p>


            <a
                href="index.php"
                class="flex items-center gap-3 px-3 py-3 rounded-xl bg-emerald-50 text-emerald-700 font-medium"
            >

                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>

                Dashboard

            </a>

            <a
                href="#statistik"
                class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 hover:bg-slate-100 mt-1"
            >

                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>

                Statistik

            </a>

            <a
                href="#kunjungan"
                class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 hover:bg-slate-100 mt-1"
            >

                <i data-lucide="book-open-check" class="w-5 h-5"></i>

                Data Kunjungan

            </a>

            <a
    href="laporan.php"
    class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 transition"
>

    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.8"
        class="w-5 h-5"
    >

        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>

        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/>

        <path d="M8 12h8"/>

        <path d="M8 8h8"/>

    </svg>

    <span>Laporan</span>

</a>



            <p
                class="text-xs font-semibold uppercase tracking-wider text-slate-400 px-3 mt-8 mb-3"
            >
                Sistem
            </p>


            <a
                href="pengaturan/index.php"
                class="flex items-center gap-3 px-3 py-3 rounded-xl text-slate-600 hover:bg-slate-100"
            >

                <i data-lucide="settings" class="w-5 h-5"></i>

                Pengaturan

            </a>


        </nav>


        <!-- Logout -->

        <div class="p-4 border-t border-slate-200">

            <a
                href="../logout.php"
                class="flex items-center gap-3 px-3 py-3 rounded-xl text-red-600 hover:bg-red-50"
            >

                <i data-lucide="log-out" class="w-5 h-5"></i>

                Logout

            </a>

        </div>


    </aside>


    <!-- ================================================== -->
    <!-- MAIN -->
    <!-- ================================================== -->

    <main class="flex-1 lg:ml-[260px] xl:ml-[280px] 2xl:ml-[300px]">


        <!-- ================================================== -->
        <!-- TOPBAR -->
        <!-- ================================================== -->

        <header
            class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 sticky top-0 z-20"
        >


            <div>

                <h2 class="text-xl font-bold text-slate-900">
                    Dashboard
                </h2>

                <p class="text-sm text-slate-500">
                    Ringkasan aktivitas perpustakaan
                </p>

            </div>


            <div class="flex items-center gap-3">

    <div class="hidden sm:block text-right">

        <p class="text-sm font-semibold text-slate-800">

            <?= htmlspecialchars($admin_nama); ?>

        </p>

        <p class="text-xs text-slate-500">

            @<?= htmlspecialchars($admin_username); ?>

        </p>

    </div>


    <?php if (!empty($admin_foto_url)): ?>

        <img
            src="<?= htmlspecialchars($admin_foto_url); ?>"
            alt="Foto Profil"
            class="w-10 h-10 rounded-full object-cover border border-slate-200"
        >

    <?php else: ?>

        <div
            class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold"
        >

            <?= htmlspecialchars($admin_inisial); ?>

        </div>

    <?php endif; ?>


</div>

        </header>


        <!-- ================================================== -->
        <!-- CONTENT -->
        <!-- ================================================== -->

        <div class="p-6 lg:p-8">


            <!-- Welcome -->

            <div class="mb-8">

                <h2
                    class="text-2xl font-bold text-slate-900"
                >

                    Selamat datang kembali 👋

                </h2>

                <p class="text-slate-500 mt-1">

                    Pantau aktivitas kunjungan perpustakaan
                    hari ini.

                </p>

            </div>


            <!-- ================================================== -->
            <!-- STATISTIC CARDS -->
            <!-- ================================================== -->

            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8"
            >


                <!-- Total -->

                <div
                    class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm text-slate-500">
                                Total Kunjungan
                            </p>

                            <h3
                                class="text-3xl font-bold text-slate-900 mt-2"
                            >

                                <?= $total_kunjungan; ?>

                            </h3>

                        </div>


                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center"
                        >

                            <i data-lucide="users"></i>

                        </div>

                    </div>

                </div>


                <!-- Hari Ini -->

                <div
                    class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm text-slate-500">
                                Kunjungan Hari Ini
                            </p>

                            <h3
                                class="text-3xl font-bold text-slate-900 mt-2"
                            >

                                <?= $kunjungan_hari_ini; ?>

                            </h3>

                        </div>


                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"
                        >

                            <i data-lucide="calendar-days"></i>

                        </div>

                    </div>

                </div>


                <!-- Bulan -->

                <div
                    class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm text-slate-500">
                                Kunjungan Bulan Ini
                            </p>

                            <h3
                                class="text-3xl font-bold text-slate-900 mt-2"
                            >

                                <?= $kunjungan_bulan_ini; ?>

                            </h3>

                        </div>


                        <div
                            class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center"
                        >

                            <i data-lucide="calendar-range"></i>

                        </div>

                    </div>

                </div>


            </div>


            <!-- ================================================== -->
            <!-- CHART -->
            <!-- ================================================== -->

            <div
                id="statistik"
                class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm mb-8"
            >

                <div class="mb-6">

                    <h3 class="text-lg font-bold text-slate-900">
                        Kunjungan Berdasarkan Jurusan
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Perbandingan aktivitas kunjungan setiap jurusan.
                    </p>

                </div>


                <div class="h-72">

                    <canvas id="jurusanChart"></canvas>

                </div>

            </div>


            <!-- ================================================== -->
            <!-- DATA KUNJUNGAN -->
            <!-- ================================================== -->

            <div
                id="kunjungan"
                class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
            >


                <!-- Header -->

                <div
                    class="p-6 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4"
                >

                    <div>

                        <h3
                            class="text-lg font-bold text-slate-900"
                        >
                            Data Kunjungan
                        </h3>

                        <p class="text-sm text-slate-500 mt-1">

                            Total <?= $total_data; ?> data ditemukan.

                        </p>

                    </div>


                    <a
                        href="tambah.php"
                        class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl font-medium transition"
                    >

                        <i
                            data-lucide="plus"
                            class="w-5 h-5"
                        ></i>

                        Tambah Kunjungan

                    </a>

                </div>


                <!-- Filter -->

                <div
                    class="p-6 bg-slate-50 border-b border-slate-200"
                >

                    <form
                        method="GET"
                        class="grid grid-cols-1 md:grid-cols-4 gap-3"
                    >


                        <!-- Search -->

                        <div class="relative">

                            <i
                                data-lucide="search"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                            ></i>

                            <input
                                type="text"
                                name="keyword"
                                placeholder="Cari NIS atau nama..."
                                value="<?= htmlspecialchars($keyword); ?>"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >

                        </div>


                        <!-- Kelas -->

                        <select
                            name="kelas"
                            class="px-4 py-2.5 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >

                            <option value="">
                                Semua Kelas
                            </option>


                            <?php while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>

                                <option
                                    value="<?= $kelas['id_kelas']; ?>"
                                    <?= $id_kelas == $kelas['id_kelas']
                                        ? 'selected'
                                        : ''; ?>
                                >

                                    <?= htmlspecialchars($kelas['nama_kelas']); ?>

                                </option>

                            <?php endwhile; ?>

                        </select>


                        <!-- Tanggal -->

                        <input
                            type="date"
                            name="tanggal"
                            value="<?= htmlspecialchars($tanggal); ?>"
                            class="px-4 py-2.5 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >


                        <!-- Buttons -->

                        <div class="flex gap-2">

                            <button
                                type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-4 py-2.5 rounded-xl font-medium"
                            >

                                <i
                                    data-lucide="search"
                                    class="w-4 h-4"
                                ></i>

                                Cari

                            </button>


                            <a
                                href="index.php"
                                class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-100"
                            >

                                <i
                                    data-lucide="rotate-ccw"
                                    class="w-4 h-4"
                                ></i>

                            </a>

                        </div>


                    </form>

                </div>


                <!-- Table -->

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">


                        <thead class="bg-slate-50 border-b border-slate-200">

                            <tr>

                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    No
                                </th>

                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    NIS
                                </th>

                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Nama
                                </th>

                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Kelas
                                </th>

                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Keperluan
                                </th>

                                <th class="text-left px-6 py-4 font-semibold text-slate-600">
                                    Waktu
                                </th>

                                <th class="text-right px-6 py-4 font-semibold text-slate-600">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">


                        <?php if (mysqli_num_rows($query) > 0): ?>


                            <?php

                            $no = $offset + 1;

                            while (
                                $data = mysqli_fetch_assoc($query)
                            ):

                            ?>


                                <tr
                                    class="hover:bg-slate-50 transition"
                                >


                                    <td class="px-6 py-4 text-slate-500">

                                        <?= $no++; ?>

                                    </td>


                                    <td class="px-6 py-4 font-medium text-slate-700">

                                        <?= htmlspecialchars(
                                            $data['nis']
                                        ); ?>

                                    </td>


                                    <td class="px-6 py-4">

                                        <div class="font-medium text-slate-900">

                                            <?= htmlspecialchars(
                                                $data['nama']
                                            ); ?>

                                        </div>

                                    </td>


                                    <td class="px-6 py-4">

                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-medium"
                                        >

                                            <?= htmlspecialchars(
                                                $data['nama_kelas']
                                            ); ?>

                                        </span>

                                    </td>


                                    <td class="px-6 py-4 text-slate-600">

                                        <?= htmlspecialchars(
                                            $data['keperluan']
                                        ); ?>

                                    </td>


                                    <td class="px-6 py-4 text-slate-500">

                                        <?= htmlspecialchars(
                                            $data['waktu_kunjungan']
                                        ); ?>

                                    </td>


                                    <td class="px-6 py-4">

                                        <div
                                            class="flex justify-end gap-2"
                                        >


                                            <a
                                                href="detail.php?id=<?= $data['id_pengunjung']; ?>"
                                                class="w-9 h-9 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center"
                                                title="Detail"
                                            >

                                                <i
                                                    data-lucide="eye"
                                                    class="w-4 h-4"
                                                ></i>

                                            </a>


                                            <a
    href="edit.php?id=<?= $data['id_pengunjung']; ?>&from=index"
    class="w-9 h-9 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 flex items-center justify-center"
    title="Edit"
>
    <i data-lucide="pencil" class="w-4 h-4"></i>
</a>


<a
    href="hapus.php?id=<?= $data['id_pengunjung']; ?>"
    class="w-9 h-9 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 flex items-center justify-center"
    title="Hapus"
>
    <i data-lucide="trash-2" class="w-4 h-4"></i>
</a>


                                        </div>

                                    </td>


                                </tr>


                            <?php endwhile; ?>


                        <?php else: ?>


                            <tr>

                                <td
                                    colspan="7"
                                    class="px-6 py-12 text-center"
                                >

                                    <div
                                        class="flex flex-col items-center"
                                    >

                                        <div
                                            class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3"
                                        >

                                            <i
                                                data-lucide="search-x"
                                                class="w-6 h-6 text-slate-400"
                                            ></i>

                                        </div>

                                        <p class="font-medium text-slate-700">
                                            Data tidak ditemukan
                                        </p>

                                        <p class="text-sm text-slate-400 mt-1">
                                            Coba ubah kata kunci atau filter.
                                        </p>

                                    </div>

                                </td>

                            </tr>


                        <?php endif; ?>


                        </tbody>


                    </table>

                </div>


                <!-- Pagination -->

                <?php if ($total_halaman > 1): ?>

                    <div
                        class="p-6 border-t border-slate-200 flex items-center justify-between"
                    >


                        <p class="text-sm text-slate-500">

                            Halaman
                            <strong><?= $halaman; ?></strong>
                            dari
                            <strong><?= $total_halaman; ?></strong>

                        </p>


                        <div class="flex gap-2">


                            <?php if ($halaman > 1): ?>

                                <a
                                    href="?halaman=<?= $halaman - 1; ?>&keyword=<?= urlencode($keyword); ?>&kelas=<?= urlencode($id_kelas); ?>&tanggal=<?= urlencode($tanggal); ?>"
                                    class="px-4 py-2 rounded-lg border border-slate-300 hover:bg-slate-100"
                                >

                                    ←

                                </a>

                            <?php endif; ?>


                            <?php if ($halaman < $total_halaman): ?>

                                <a
                                    href="?halaman=<?= $halaman + 1; ?>&keyword=<?= urlencode($keyword); ?>&kelas=<?= urlencode($id_kelas); ?>&tanggal=<?= urlencode($tanggal); ?>"
                                    class="px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-slate-800"
                                >

                                    →

                                </a>

                            <?php endif; ?>


                        </div>


                    </div>

                <?php endif; ?>


            </div>


        </div>


    </main>

</div>


<!-- ================================================== -->
<!-- CHART -->
<!-- ================================================== -->

<script>

    const jurusanLabels = <?= json_encode(
        array_column(
            $statistik_jurusan,
            'nama_jurusan'
        )
    ); ?>;


    const jurusanData = <?= json_encode(
        array_map(
            'intval',
            array_column(
                $statistik_jurusan,
                'total'
            )
        )
    ); ?>;


    const ctx = document
        .getElementById('jurusanChart');


    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: jurusanLabels,

            datasets: [{

                label: 'Jumlah Kunjungan',

                data: jurusanData,

                borderRadius: 8,

                maxBarThickness: 60

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    display: false

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0

                    }

                }

            }

        }

    });


    // Aktifkan Lucide Icons

    lucide.createIcons();

</script>


</body>

</html>