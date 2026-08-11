<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";


// ======================================================
// AMBIL ID
// ======================================================

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;


// ======================================================
// AMBIL DATA PENGUNJUNG
// ======================================================

$query = mysqli_query(
    $koneksi,

    "SELECT
        pengunjung.*,
        kelas.nama_kelas,
        jurusan.nama_jurusan

    FROM pengunjung

    INNER JOIN kelas
        ON pengunjung.id_kelas = kelas.id_kelas

    INNER JOIN jurusan
        ON kelas.id_jurusan = jurusan.id_jurusan

    WHERE pengunjung.id_pengunjung = '$id'"
);


$data = mysqli_fetch_assoc($query);


// ======================================================
// CEK DATA
// ======================================================

if (!$data) {

    header("Location: index.php");

    exit;
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
        Detail Kunjungan - Perpustakaan
    </title>


    <!-- Tailwind CSS -->

    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Lucide Icons -->

    <script src="https://unpkg.com/lucide@latest"></script>


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


    <!-- ================================================== -->
    <!-- TOPBAR -->
    <!-- ================================================== -->

    <header
        class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-20"
    >


        <!-- Logo -->

        <a
            href="index.php"
            class="flex items-center gap-3"
        >

            <div
                class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center"
            >

                <i
                    data-lucide="book-open"
                    class="w-5 h-5"
                ></i>

            </div>


            <div class="hidden sm:block">

                <h1 class="font-bold text-slate-900">
                    Perpustakaan
                </h1>

                <p class="text-xs text-slate-500">
                    Digital Library
                </p>

            </div>

        </a>


        <!-- Admin -->

        <div class="flex items-center gap-3">


            <div class="hidden sm:block text-right">

                <p class="text-sm font-semibold text-slate-800">

                    <?= htmlspecialchars($_SESSION['nama']); ?>

                </p>

                <p class="text-xs text-slate-500">
                    Administrator
                </p>

            </div>


            <div
                class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold"
            >

                <?= strtoupper(
                    substr(
                        $_SESSION['nama'],
                        0,
                        1
                    )
                ); ?>

            </div>


        </div>


    </header>


    <!-- ================================================== -->
    <!-- CONTENT -->
    <!-- ================================================== -->

    <main class="max-w-5xl mx-auto px-6 py-8">


        <!-- Breadcrumb / Back -->

        <a
            href="index.php"
            class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-emerald-600 transition mb-6"
        >

            <i
                data-lucide="arrow-left"
                class="w-4 h-4"
            ></i>

            Kembali ke Data Kunjungan

        </a>


        <!-- Header -->

        <div class="mb-8">

            <div class="flex items-center gap-3 mb-2">

                <div
                    class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center"
                >

                    <i
                        data-lucide="user-round"
                        class="w-5 h-5"
                    ></i>

                </div>


                <div>

                    <h2
                        class="text-2xl font-bold text-slate-900"
                    >
                        Detail Kunjungan
                    </h2>

                    <p class="text-sm text-slate-500">
                        Informasi lengkap data kunjungan perpustakaan.
                    </p>

                </div>

            </div>

        </div>


        <!-- ================================================== -->
        <!-- DETAIL CARD -->
        <!-- ================================================== -->

        <div
            class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
        >


            <!-- Card Header -->

            <div
                class="px-6 py-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
            >


                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Data Pengunjung
                    </p>

                    <h3
                        class="text-lg font-bold text-slate-900 mt-1"
                    >

                        <?= htmlspecialchars($data['nama']); ?>

                    </h3>

                </div>


                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 text-sm font-medium w-fit"
                >

                    <i
                        data-lucide="graduation-cap"
                        class="w-4 h-4"
                    ></i>

                    <?= htmlspecialchars($data['nama_kelas']); ?>

                </span>


            </div>


            <!-- Data -->

            <div class="p-6">


                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-5"
                >


                    <!-- NIS -->

                    <div
                        class="rounded-xl bg-slate-50 border border-slate-200 p-5"
                    >

                        <div class="flex items-center gap-3 mb-3">

                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center"
                            >

                                <i
                                    data-lucide="id-card"
                                    class="w-4 h-4 text-slate-500"
                                ></i>

                            </div>

                            <p class="text-sm text-slate-500">
                                NIS
                            </p>

                        </div>


                        <p
                            class="font-semibold text-slate-900"
                        >

                            <?= htmlspecialchars($data['nis']); ?>

                        </p>

                    </div>


                    <!-- Nama -->

                    <div
                        class="rounded-xl bg-slate-50 border border-slate-200 p-5"
                    >

                        <div class="flex items-center gap-3 mb-3">

                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center"
                            >

                                <i
                                    data-lucide="user"
                                    class="w-4 h-4 text-slate-500"
                                ></i>

                            </div>

                            <p class="text-sm text-slate-500">
                                Nama Lengkap
                            </p>

                        </div>


                        <p
                            class="font-semibold text-slate-900"
                        >

                            <?= htmlspecialchars($data['nama']); ?>

                        </p>

                    </div>


                    <!-- Kelas -->

                    <div
                        class="rounded-xl bg-slate-50 border border-slate-200 p-5"
                    >

                        <div class="flex items-center gap-3 mb-3">

                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center"
                            >

                                <i
                                    data-lucide="school"
                                    class="w-4 h-4 text-slate-500"
                                ></i>

                            </div>

                            <p class="text-sm text-slate-500">
                                Kelas
                            </p>

                        </div>


                        <p
                            class="font-semibold text-slate-900"
                        >

                            <?= htmlspecialchars($data['nama_kelas']); ?>

                        </p>

                    </div>


                    <!-- Jurusan -->

                    <div
                        class="rounded-xl bg-slate-50 border border-slate-200 p-5"
                    >

                        <div class="flex items-center gap-3 mb-3">

                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center"
                            >

                                <i
                                    data-lucide="briefcase-business"
                                    class="w-4 h-4 text-slate-500"
                                ></i>

                            </div>

                            <p class="text-sm text-slate-500">
                                Jurusan
                            </p>

                        </div>


                        <p
                            class="font-semibold text-slate-900"
                        >

                            <?= htmlspecialchars($data['nama_jurusan']); ?>

                        </p>

                    </div>


                    <!-- Keperluan -->

                    <div
                        class="rounded-xl bg-slate-50 border border-slate-200 p-5"
                    >

                        <div class="flex items-center gap-3 mb-3">

                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center"
                            >

                                <i
                                    data-lucide="clipboard-list"
                                    class="w-4 h-4 text-slate-500"
                                ></i>

                            </div>

                            <p class="text-sm text-slate-500">
                                Keperluan
                            </p>

                        </div>


                        <p
                            class="font-semibold text-slate-900"
                        >

                            <?= htmlspecialchars($data['keperluan']); ?>

                        </p>

                    </div>


                    <!-- Waktu -->

                    <div
                        class="rounded-xl bg-slate-50 border border-slate-200 p-5"
                    >

                        <div class="flex items-center gap-3 mb-3">

                            <div
                                class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center"
                            >

                                <i
                                    data-lucide="clock-3"
                                    class="w-4 h-4 text-slate-500"
                                ></i>

                            </div>

                            <p class="text-sm text-slate-500">
                                Waktu Kunjungan
                            </p>

                        </div>


                        <p
                            class="font-semibold text-slate-900"
                        >

                            <?= htmlspecialchars(
                                $data['waktu_kunjungan']
                            ); ?>

                        </p>

                    </div>


                </div>


            </div>


            <!-- ================================================== -->
            <!-- ACTION -->
            <!-- ================================================== -->

            <div
                class="px-6 py-5 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row sm:justify-end gap-3"
            >


                <a
                    href="index.php"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium transition"
                >

                    <i
                        data-lucide="arrow-left"
                        class="w-4 h-4"
                    ></i>

                    Kembali

                </a>


                <a
    href="edit.php?id=<?= $data['id_pengunjung']; ?>&from=detail"
    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium transition"
>
    <i
        data-lucide="pencil"
        class="w-4 h-4"
    ></i>

    Edit Data
</a>

            </div>


        </div>


    </main>


</div>


<script>

    lucide.createIcons();

</script>


</body>

</html>