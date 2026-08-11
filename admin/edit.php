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
// TENTUKAN HALAMAN ASAL
// ======================================================

$from = isset($_GET['from'])
    ? $_GET['from']
    : 'index';


if ($from === 'detail') {

    $back_url = "detail.php?id=$id";

} else {

    $back_url = "index.php";

}


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


// ======================================================
// PROSES UPDATE
// ======================================================

if (isset($_POST['submit'])) {


    $nis = mysqli_real_escape_string(
        $koneksi,
        $_POST['nis']
    );


    $nama = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama']
    );


    $id_kelas = isset($_POST['id_kelas'])
        ? (int) $_POST['id_kelas']
        : 0;


    $keperluan = mysqli_real_escape_string(
        $koneksi,
        $_POST['keperluan']
    );


    // ==============================================
    // VALIDASI KELAS
    // ==============================================

    $cek_kelas = mysqli_query(
        $koneksi,

        "SELECT id_kelas
         FROM kelas
         WHERE id_kelas = '$id_kelas'"
    );


    if (mysqli_num_rows($cek_kelas) === 0) {

        $error = "Kelas yang dipilih tidak valid.";

    } else {


        // ==============================================
        // UPDATE
        // ==============================================

        $update = mysqli_query(
            $koneksi,

            "UPDATE pengunjung

            SET
                nis = '$nis',
                nama = '$nama',
                id_kelas = '$id_kelas',
                keperluan = '$keperluan'

            WHERE id_pengunjung = '$id'"
        );


        if ($update) {


            // ==========================================
            // KEMBALI SESUAI HALAMAN ASAL
            // ==========================================

            if ($from === 'detail') {

                header(
                    "Location: detail.php?id=$id"
                );

            } else {

                header(
                    "Location: index.php"
                );

            }

            exit;


        } else {

            $error = "Data gagal diperbarui.";

        }

    }

}


// ======================================================
// DATA KELAS
// ======================================================

$query_kelas = mysqli_query(
    $koneksi,

    "SELECT
        kelas.*,
        jurusan.nama_jurusan

    FROM kelas

    INNER JOIN jurusan
        ON kelas.id_jurusan = jurusan.id_jurusan

    ORDER BY
        jurusan.id_jurusan,
        kelas.id_kelas"
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
    Edit Kunjungan - Perpustakaan
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


    <!-- Admin -->

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

<main class="max-w-4xl mx-auto px-6 py-8">


    <!-- ================================================== -->
    <!-- BACK -->
    <!-- ================================================== -->

    <a
        href="<?= htmlspecialchars($back_url); ?>"
        class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-emerald-600 transition mb-6"
    >

        <i
            data-lucide="arrow-left"
            class="w-4 h-4"
        ></i>

        Kembali

    </a>


    <!-- ================================================== -->
    <!-- HEADER -->
    <!-- ================================================== -->

    <div class="mb-8">

        <div class="flex items-center gap-3">


            <div
                class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center"
            >

                <i
                    data-lucide="pencil"
                    class="w-5 h-5"
                ></i>

            </div>


            <div>

                <h2
                    class="text-2xl font-bold text-slate-900"
                >
                    Edit Kunjungan
                </h2>

                <p class="text-sm text-slate-500">
                    Perbarui informasi kunjungan perpustakaan.
                </p>

            </div>


        </div>

    </div>


    <!-- ================================================== -->
    <!-- ERROR -->
    <!-- ================================================== -->

    <?php if (isset($error)): ?>

        <div
            class="mb-6 flex items-center gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700"
        >

            <i
                data-lucide="circle-alert"
                class="w-5 h-5"
            ></i>

            <?= htmlspecialchars($error); ?>

        </div>

    <?php endif; ?>


    <!-- ================================================== -->
    <!-- FORM CARD -->
    <!-- ================================================== -->

    <div
        class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
    >


        <!-- Card Header -->

        <div
            class="px-6 py-5 border-b border-slate-200"
        >

            <p
                class="text-xs font-semibold uppercase tracking-wider text-slate-400"
            >
                Informasi Pengunjung
            </p>

            <h3
                class="text-lg font-bold text-slate-900 mt-1"
            >

                <?= htmlspecialchars(
                    $data['nama']
                ); ?>

            </h3>

        </div>


        <!-- ================================================== -->
        <!-- FORM -->
        <!-- ================================================== -->

        <form
            method="POST"
            class="p-6"
        >


            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-6"
            >


                <!-- ================================================== -->
                <!-- NIS -->
                <!-- ================================================== -->

                <div>

                    <label
                        for="nis"
                        class="block text-sm font-medium text-slate-700 mb-2"
                    >
                        NIS
                    </label>


                    <div class="relative">

                        <i
                            data-lucide="id-card"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                        ></i>


                        <input
                            type="text"
                            id="nis"
                            name="nis"
                            value="<?= htmlspecialchars(
                                $data['nis']
                            ); ?>"
                            required
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Masukkan NIS"
                        >

                    </div>

                </div>


                <!-- ================================================== -->
                <!-- NAMA -->
                <!-- ================================================== -->

                <div>

                    <label
                        for="nama"
                        class="block text-sm font-medium text-slate-700 mb-2"
                    >
                        Nama Lengkap
                    </label>


                    <div class="relative">

                        <i
                            data-lucide="user"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                        ></i>


                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="<?= htmlspecialchars(
                                $data['nama']
                            ); ?>"
                            required
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Masukkan nama lengkap"
                        >

                    </div>

                </div>


                <!-- ================================================== -->
                <!-- KELAS -->
                <!-- ================================================== -->

                <div>

                    <label
                        for="id_kelas"
                        class="block text-sm font-medium text-slate-700 mb-2"
                    >
                        Kelas
                    </label>


                    <div class="relative">

                        <i
                            data-lucide="graduation-cap"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 z-10"
                        ></i>


                        <select
                            id="id_kelas"
                            name="id_kelas"
                            required
                            class="appearance-none w-full pl-11 pr-10 py-3 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >


                            <?php while (
                                $kelas = mysqli_fetch_assoc(
                                    $query_kelas
                                )
                            ): ?>


                                <option
                                    value="<?= $kelas['id_kelas']; ?>"
                                    <?= $data['id_kelas'] == $kelas['id_kelas']
                                        ? 'selected'
                                        : ''; ?>
                                >

                                    <?= htmlspecialchars(
                                        $kelas['nama_kelas']
                                    ); ?>

                                    -
                                    <?= htmlspecialchars(
                                        $kelas['nama_jurusan']
                                    ); ?>

                                </option>


                            <?php endwhile; ?>


                        </select>


                        <i
                            data-lucide="chevron-down"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none"
                        ></i>

                    </div>

                </div>


                <!-- ================================================== -->
                <!-- KEPERLUAN -->
                <!-- ================================================== -->

                <div>

                    <label
                        for="keperluan"
                        class="block text-sm font-medium text-slate-700 mb-2"
                    >
                        Keperluan
                    </label>


                    <div class="relative">

                        <i
                            data-lucide="clipboard-list"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                        ></i>


                        <input
                            type="text"
                            id="keperluan"
                            name="keperluan"
                            value="<?= htmlspecialchars(
                                $data['keperluan']
                            ); ?>"
                            required
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Contoh: Membaca buku"
                        >

                    </div>

                </div>


            </div>


            <!-- ================================================== -->
            <!-- INFO WAKTU -->
            <!-- ================================================== -->

            <div
                class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start gap-3"
            >

                <i
                    data-lucide="clock-3"
                    class="w-5 h-5 text-slate-400 mt-0.5"
                ></i>


                <div>

                    <p
                        class="text-sm font-medium text-slate-700"
                    >
                        Waktu Kunjungan
                    </p>


                    <p
                        class="text-sm text-slate-500 mt-1"
                    >

                        <?= htmlspecialchars(
                            $data['waktu_kunjungan']
                        ); ?>

                    </p>


                    <p
                        class="text-xs text-slate-400 mt-1"
                    >
                        Waktu kunjungan tidak diubah saat edit data.
                    </p>

                </div>

            </div>


            <!-- ================================================== -->
            <!-- BUTTON -->
            <!-- ================================================== -->

            <div
                class="mt-8 pt-6 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:justify-end gap-3"
            >


                <!-- BATAL -->

                <a
                    href="<?= htmlspecialchars($back_url); ?>"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 font-medium transition"
                >

                    <i
                        data-lucide="x"
                        class="w-4 h-4"
                    ></i>

                    Batal

                </a>


                <!-- SIMPAN -->

                <button
                    type="submit"
                    name="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium transition"
                >

                    <i
                        data-lucide="save"
                        class="w-4 h-4"
                    ></i>

                    Simpan Perubahan

                </button>


            </div>


        </form>


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
