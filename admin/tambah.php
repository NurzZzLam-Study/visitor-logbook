<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/database.php";


// ======================================================
// PROSES SIMPAN
// ======================================================

if (isset($_POST['simpan'])) {

    $nis = trim($_POST['nis']);
    $nama = trim($_POST['nama']);
    $id_kelas = (int) $_POST['id_kelas'];
    $keperluan = $_POST['keperluan'];


    // Validasi sederhana

    if (
        $nis == '' ||
        $nama == '' ||
        $id_kelas <= 0 ||
        $keperluan == ''
    ) {

        $error = "Semua field wajib diisi.";

    } else {

        $nis_safe = mysqli_real_escape_string(
            $koneksi,
            $nis
        );

        $nama_safe = mysqli_real_escape_string(
            $koneksi,
            $nama
        );

        $keperluan_safe = mysqli_real_escape_string(
            $koneksi,
            $keperluan
        );


        $query = mysqli_query(
            $koneksi,

            "INSERT INTO pengunjung
            (
                nis,
                nama,
                id_kelas,
                keperluan
            )

            VALUES
            (
                '$nis_safe',
                '$nama_safe',
                '$id_kelas',
                '$keperluan_safe'
            )"
        );


        if ($query) {

            header("Location: index.php");

            exit;

        } else {

            $error = "Data gagal ditambahkan.";

        }

    }

}


// ======================================================
// AMBIL DATA KELAS
// ======================================================

$query_kelas = mysqli_query(
    $koneksi,

    "SELECT
        kelas.id_kelas,
        kelas.nama_kelas,
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
        Tambah Kunjungan
    </title>


    <!-- Tailwind -->

    <script src="https://cdn.tailwindcss.com"></script>


    <!-- Lucide -->

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
    <!-- HEADER -->
    <!-- ================================================== -->

    <header
        class="h-20 bg-white border-b border-slate-200 flex items-center"
    >

        <div
            class="max-w-4xl mx-auto w-full px-6 flex items-center justify-between"
        >


            <a
                href="index.php"
                class="inline-flex items-center gap-2 text-slate-600 hover:text-emerald-600 transition"
            >

                <i
                    data-lucide="arrow-left"
                    class="w-5 h-5"
                ></i>

                Kembali

            </a>


            <div
                class="flex items-center gap-2"
            >

                <div
                    class="w-9 h-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center"
                >

                    <i
                        data-lucide="book-open"
                        class="w-5 h-5"
                    ></i>

                </div>

                <span
                    class="font-bold text-slate-900"
                >
                    Perpustakaan
                </span>

            </div>


        </div>

    </header>


    <!-- ================================================== -->
    <!-- CONTENT -->
    <!-- ================================================== -->

    <main class="max-w-4xl mx-auto px-6 py-10">


        <!-- Heading -->

        <div class="mb-8">

            <p
                class="text-sm font-medium text-emerald-600 mb-2"
            >
                Data Kunjungan
            </p>

            <h1
                class="text-3xl font-bold text-slate-900"
            >
                Tambah Kunjungan
            </h1>

            <p
                class="text-slate-500 mt-2"
            >
                Catat aktivitas pengunjung perpustakaan.
            </p>

        </div>


        <!-- ================================================== -->
        <!-- ERROR -->
        <!-- ================================================== -->

        <?php if (isset($error)): ?>

            <div
                class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700"
            >

                <i
                    data-lucide="circle-alert"
                    class="w-5 h-5 mt-0.5"
                ></i>

                <p>
                    <?= htmlspecialchars($error); ?>
                </p>

            </div>

        <?php endif; ?>


        <!-- ================================================== -->
        <!-- FORM CARD -->
        <!-- ================================================== -->

        <div
            class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
        >


            <form
                method="POST"
            >


                <!-- Form Body -->

                <div class="p-6 lg:p-8">


                    <!-- NIS -->

                    <div class="mb-6">

                        <label
                            for="nis"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >

                            NIS

                        </label>


                        <input
                            type="text"
                            id="nis"
                            name="nis"
                            value="<?= isset($_POST['nis'])
                                ? htmlspecialchars($_POST['nis'])
                                : ''; ?>"
                            placeholder="Masukkan NIS siswa"
                            autocomplete="off"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                        >

                    </div>


                    <!-- Nama -->

                    <div class="mb-6">

                        <label
                            for="nama"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >

                            Nama Lengkap

                        </label>


                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="<?= isset($_POST['nama'])
                                ? htmlspecialchars($_POST['nama'])
                                : ''; ?>"
                            placeholder="Masukkan nama lengkap"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                        >

                    </div>


                    <!-- Kelas & Keperluan -->

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-6"
                    >


                        <!-- Kelas -->

                        <div>

                            <label
                                for="id_kelas"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >

                                Kelas

                            </label>


                            <select
                                id="id_kelas"
                                name="id_kelas"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            >

                                <option value="">
                                    Pilih kelas
                                </option>


                                <?php while (
                                    $kelas = mysqli_fetch_assoc(
                                        $query_kelas
                                    )
                                ): ?>

                                    <option
                                        value="<?= $kelas['id_kelas']; ?>"
                                        <?= isset($_POST['id_kelas'])
                                            && $_POST['id_kelas']
                                            == $kelas['id_kelas']
                                            ? 'selected'
                                            : ''; ?>
                                    >

                                        <?= htmlspecialchars(
                                            $kelas['nama_kelas']
                                        ); ?>

                                        —

                                        <?= htmlspecialchars(
                                            $kelas['nama_jurusan']
                                        ); ?>

                                    </option>

                                <?php endwhile; ?>


                            </select>

                        </div>


                        <!-- Keperluan -->

                        <div>

                            <label
                                for="keperluan"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >

                                Keperluan

                            </label>


                            <select
                                id="keperluan"
                                name="keperluan"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            >

                                <option value="">
                                    Pilih keperluan
                                </option>


                                <option
                                    value="Membaca"
                                    <?= isset($_POST['keperluan'])
                                        && $_POST['keperluan']
                                        == 'Membaca'
                                        ? 'selected'
                                        : ''; ?>
                                >
                                    Membaca
                                </option>


                                <option
                                    value="Meminjam Buku"
                                    <?= isset($_POST['keperluan'])
                                        && $_POST['keperluan']
                                        == 'Meminjam Buku'
                                        ? 'selected'
                                        : ''; ?>
                                >
                                    Meminjam Buku
                                </option>


                                <option
                                    value="Mengembalikan Buku"
                                    <?= isset($_POST['keperluan'])
                                        && $_POST['keperluan']
                                        == 'Mengembalikan Buku'
                                        ? 'selected'
                                        : ''; ?>
                                >
                                    Mengembalikan Buku
                                </option>


                                <option
                                    value="Belajar"
                                    <?= isset($_POST['keperluan'])
                                        && $_POST['keperluan']
                                        == 'Belajar'
                                        ? 'selected'
                                        : ''; ?>
                                >
                                    Belajar
                                </option>


                                <option
                                    value="Lainnya"
                                    <?= isset($_POST['keperluan'])
                                        && $_POST['keperluan']
                                        == 'Lainnya'
                                        ? 'selected'
                                        : ''; ?>
                                >
                                    Lainnya
                                </option>


                            </select>

                        </div>


                    </div>


                </div>


                <!-- ================================================== -->
                <!-- FORM FOOTER -->
                <!-- ================================================== -->

                <div
                    class="px-6 lg:px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-3"
                >


                    <a
                        href="index.php"
                        class="px-5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-100 font-medium transition"
                    >

                        Batal

                    </a>


                    <button
                        type="submit"
                        name="simpan"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-medium transition"
                    >

                        <i
                            data-lucide="save"
                            class="w-4 h-4"
                        ></i>

                        Simpan Kunjungan

                    </button>


                </div>


            </form>


        </div>


        <!-- Information -->

        <div
            class="mt-6 flex gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800"
        >

            <i
                data-lucide="info"
                class="w-5 h-5 mt-0.5 flex-shrink-0"
            ></i>

            <p class="text-sm">

                Waktu kunjungan akan dicatat otomatis
                oleh sistem ketika data disimpan.

            </p>

        </div>


    </main>


</div>


<script>

    lucide.createIcons();

</script>


</body>

</html>