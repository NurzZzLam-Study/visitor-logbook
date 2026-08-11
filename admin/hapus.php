<?php

session_start();


// ======================================================
// CEK LOGIN
// ======================================================

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}


// ======================================================
// DATABASE
// ======================================================

include "../config/database.php";


// ======================================================
// AMBIL ID
// ======================================================

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;


// ======================================================
// VALIDASI ID
// ======================================================

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


// ======================================================
// AMBIL DATA
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


// ======================================================
// PROSES HAPUS
// ======================================================

if (isset($_POST['hapus'])) {

    $hapus = mysqli_query(
        $koneksi,

        "DELETE FROM pengunjung
         WHERE id_pengunjung = '$id'"
    );


    if ($hapus) {

        header(
            "Location: index.php?status=hapus_sukses"
        );

        exit;

    } else {

        $error = "Data gagal dihapus.";

    }

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
        Hapus Kunjungan - Perpustakaan
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
        class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-10"
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


        <!-- ADMIN -->

        <div class="flex items-center gap-3">


            <div class="hidden sm:block text-right">

                <p class="text-sm font-semibold text-slate-800">

                    <?= htmlspecialchars(
                        $_SESSION['nama']
                    ); ?>

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

    <main
        class="min-h-[calc(100vh-80px)] flex items-center justify-center px-6 py-10"
    >


        <div class="w-full max-w-lg">


            <!-- ================================================== -->
            <!-- BACK -->
            <!-- ================================================== -->

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


            <!-- ================================================== -->
            <!-- CARD -->
            <!-- ================================================== -->

            <div
                class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
            >


                <!-- ================================================== -->
                <!-- WARNING -->
                <!-- ================================================== -->

                <div class="p-8 text-center">


                    <!-- ICON -->

                    <div
                        class="mx-auto w-16 h-16 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center mb-5"
                    >

                        <i
                            data-lucide="trash-2"
                            class="w-7 h-7"
                        ></i>

                    </div>


                    <!-- TITLE -->

                    <h2
                        class="text-2xl font-bold text-slate-900"
                    >

                        Hapus Data Kunjungan?

                    </h2>


                    <p
                        class="text-sm text-slate-500 mt-2 leading-relaxed"
                    >

                        Data kunjungan yang sudah dihapus
                        tidak dapat dikembalikan.

                    </p>


                    <!-- ================================================== -->
                    <!-- DATA -->
                    <!-- ================================================== -->

                    <div
                        class="mt-6 p-5 rounded-xl bg-slate-50 border border-slate-200 text-left"
                    >


                        <!-- NAMA -->

                        <div
                            class="flex items-start justify-between gap-4 pb-4 border-b border-slate-200"
                        >

                            <div>

                                <p
                                    class="text-xs text-slate-400 uppercase tracking-wider font-semibold"
                                >
                                    Nama
                                </p>

                                <p
                                    class="font-semibold text-slate-900 mt-1"
                                >

                                    <?= htmlspecialchars(
                                        $data['nama']
                                    ); ?>

                                </p>

                            </div>


                            <i
                                data-lucide="user"
                                class="w-5 h-5 text-slate-400"
                            ></i>

                        </div>


                        <!-- KELAS -->

                        <div
                            class="flex items-start justify-between gap-4 pt-4"
                        >

                            <div>

                                <p
                                    class="text-xs text-slate-400 uppercase tracking-wider font-semibold"
                                >
                                    Kelas
                                </p>

                                <p
                                    class="font-semibold text-slate-900 mt-1"
                                >

                                    <?= htmlspecialchars(
                                        $data['nama_kelas']
                                    ); ?>

                                    -

                                    <?= htmlspecialchars(
                                        $data['nama_jurusan']
                                    ); ?>

                                </p>

                            </div>


                            <i
                                data-lucide="graduation-cap"
                                class="w-5 h-5 text-slate-400"
                            ></i>

                        </div>


                    </div>


                    <!-- ================================================== -->
                    <!-- ERROR -->
                    <!-- ================================================== -->

                    <?php if (isset($error)): ?>

                        <div
                            class="mt-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-3"
                        >

                            <i
                                data-lucide="circle-alert"
                                class="w-5 h-5 flex-shrink-0"
                            ></i>

                            <?= htmlspecialchars($error); ?>

                        </div>

                    <?php endif; ?>


                    <!-- ================================================== -->
                    <!-- ACTION -->
                    <!-- ================================================== -->

                    <form
                        method="POST"
                        class="mt-6"
                    >

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-3"
                        >


                            <!-- BATAL -->

                            <a
                                href="index.php"
                                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium transition"
                            >

                                <i
                                    data-lucide="x"
                                    class="w-4 h-4"
                                ></i>

                                Batal

                            </a>


                            <!-- HAPUS -->

                            <button
                                type="submit"
                                name="hapus"
                                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-medium transition"
                            >

                                <i
                                    data-lucide="trash-2"
                                    class="w-4 h-4"
                                ></i>

                                Ya, Hapus Data

                            </button>


                        </div>

                    </form>


                </div>


                <!-- ================================================== -->
                <!-- FOOTER WARNING -->
                <!-- ================================================== -->

                <div
                    class="px-6 py-4 bg-red-50 border-t border-red-100"
                >

                    <div
                        class="flex items-start gap-3"
                    >

                        <i
                            data-lucide="triangle-alert"
                            class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0"
                        ></i>

                        <p
                            class="text-xs text-red-600 leading-relaxed"
                        >

                            Pastikan data yang dipilih benar
                            sebelum melanjutkan proses penghapusan.

                        </p>

                    </div>

                </div>


            </div>


        </div>


    </main>


</div>


<!-- ================================================== -->
<!-- LUCIDE -->
<!-- ================================================== -->

<script>

    lucide.createIcons();

</script>


</body>

</html>