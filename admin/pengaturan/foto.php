<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include "../../config/database.php";

$id_user = (int) ($_SESSION['id_user'] ?? 0);

if ($id_user <= 0) {
    echo "Session admin tidak ditemukan.";
    exit;
}


// ======================================================
// AMBIL DATA ADMIN
// ======================================================

$query = mysqli_query(
    $koneksi,

    "SELECT
        id_user,
        nama,
        username,
        foto
     FROM users
     WHERE id_user = $id_user
     LIMIT 1"
);

$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "Data admin tidak ditemukan.";
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
    Foto Profil - Pengaturan Admin
</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100 text-slate-800">

<div class="min-h-screen">

<!-- HEADER -->

<header
    class="bg-white border-b border-slate-200"
>

    <div
        class="max-w-4xl mx-auto px-6 py-5"
    >

        <div
            class="flex items-center justify-between gap-4"
        >

            <div>

                <p
                    class="text-xs font-semibold text-blue-600 uppercase tracking-wider"
                >
                    Pengaturan
                </p>

                <h1
                    class="text-xl font-bold text-slate-900 mt-1"
                >
                    Foto Profil
                </h1>

                <p
                    class="text-sm text-slate-500 mt-1"
                >
                    Kelola foto profil administrator.
                </p>

            </div>


            <a
                href="index.php"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"
            >
                ← Pengaturan
            </a>

        </div>

    </div>

</header>



<!-- CONTENT -->

<main
    class="max-w-4xl mx-auto px-6 py-8"
>

    <div
        class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden"
    >


        <!-- TITLE -->

        <div
            class="px-6 py-5 border-b border-slate-100"
        >

            <h2
                class="font-bold text-slate-900"
            >
                Kelola Foto Profil
            </h2>

            <p
                class="text-sm text-slate-500 mt-1"
            >
                Gunakan gambar JPG, JPEG, atau PNG dengan ukuran maksimal 2 MB.
            </p>

        </div>



        <div class="p-6">


            <!-- CURRENT PROFILE -->

            <div
                class="flex flex-col items-center"
            >

                <div
                    class="w-40 h-40 rounded-3xl overflow-hidden bg-slate-100 border border-slate-200 flex items-center justify-center"
                >

                    <?php if (!empty($user['foto'])): ?>

                        <img
                            id="preview"
                            src="../../uploads/profile/<?= htmlspecialchars($user['foto']); ?>"
                            alt="Foto Profil"
                            class="w-full h-full object-cover"
                        >

                    <?php else: ?>

                        <div
                            id="preview-placeholder"
                            class="w-full h-full flex items-center justify-center bg-emerald-50"
                        >

                            <span
                                class="text-5xl font-bold text-emerald-600"
                            >

                                <?= strtoupper(
                                    substr(
                                        $user['nama'],
                                        0,
                                        1
                                    )
                                ); ?>

                            </span>

                        </div>

                        <img
                            id="preview"
                            src=""
                            alt="Preview Foto"
                            class="hidden w-full h-full object-cover"
                        >

                    <?php endif; ?>

                </div>


                <h3
                    class="text-lg font-bold text-slate-900 mt-5"
                >

                    <?= htmlspecialchars(
                        $user['nama']
                    ); ?>

                </h3>


                <p
                    class="text-sm text-slate-500 mt-1"
                >

                    @<?= htmlspecialchars(
                        $user['username']
                    ); ?>

                </p>

            </div>



            <!-- UPLOAD FORM -->

            <form
                action="proses_foto.php"
                method="POST"
                enctype="multipart/form-data"
                class="mt-8"
            >

                <div
                    class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-blue-300 transition"
                >

                    <div
                        class="w-12 h-12 mx-auto rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="w-6 h-6"
                        >

                            <path
                                d="M12 16V4"
                            />

                            <path
                                d="m7 9 5-5 5 5"
                            />

                            <path
                                d="M5 20h14"
                            />

                        </svg>

                    </div>


                    <h3
                        class="font-semibold text-slate-800 mt-4"
                    >
                        Upload foto baru
                    </h3>


                    <p
                        class="text-sm text-slate-500 mt-1"
                    >
                        JPG, JPEG, atau PNG • Maksimal 2 MB
                    </p>


                    <label
                        for="foto"
                        class="inline-flex items-center justify-center px-5 py-2.5 mt-5 rounded-xl bg-blue-600 text-white text-sm font-semibold cursor-pointer hover:bg-blue-700 transition"
                    >
                        Pilih Foto
                    </label>


                    <input
                        type="file"
                        id="foto"
                        name="foto"
                        accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                        class="hidden"
                        required
                    >


                    <p
                        id="nama-file"
                        class="text-xs text-slate-400 mt-3"
                    >
                        Belum ada file dipilih.
                    </p>

                </div>



                <!-- BUTTON -->

                <div
                    class="flex flex-col sm:flex-row justify-end gap-3 mt-6"
                >

                    <a
                        href="index.php"
                        class="inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-5 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition"
                    >
                        Simpan Foto
                    </button>

                </div>

            </form>



            <?php if (!empty($user['foto'])): ?>

                <!-- DELETE -->

                <div
                    class="mt-8 pt-6 border-t border-slate-100"
                >

                    <div
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
                    >

                        <div>

                            <h3
                                class="font-semibold text-slate-800"
                            >
                                Hapus Foto Profil
                            </h3>

                            <p
                                class="text-sm text-slate-500 mt-1"
                            >
                                Foto akan dihapus dan profil kembali menggunakan inisial nama.
                            </p>

                        </div>


                        <form
                            action="proses_foto.php"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus foto profil?');"
                        >

                            <input
                                type="hidden"
                                name="aksi"
                                value="hapus"
                            >

                            <button
                                type="submit"
                                class="px-5 py-2.5 rounded-xl border border-red-200 bg-red-50 text-red-600 text-sm font-semibold hover:bg-red-100 transition"
                            >
                                Hapus Foto
                            </button>

                        </form>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</main>
```

</div>

<script>

const inputFoto = document.getElementById('foto');
const namaFile = document.getElementById('nama-file');
const preview = document.getElementById('preview');
const placeholder = document.getElementById('preview-placeholder');


inputFoto.addEventListener('change', function () {

    const file = this.files[0];

    if (!file) {
        namaFile.textContent = 'Belum ada file dipilih.';
        return;
    }


    namaFile.textContent = file.name;


    // Preview gambar

    const reader = new FileReader();

    reader.onload = function (event) {

        preview.src = event.target.result;

        preview.classList.remove('hidden');

        if (placeholder) {
            placeholder.classList.add('hidden');
        }

    };

    reader.readAsDataURL(file);

});

</script>

</body>

</html>
