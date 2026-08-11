<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include "../../config/database.php";

$id_user = $_SESSION['id_user'] ?? 0;

if ($id_user <= 0) {
    echo "Session user tidak ditemukan.";
    exit;
}


// ======================================================
// AMBIL DATA ADMIN
// ======================================================

$id_user_safe = (int) $id_user;

$query = mysqli_query(
    $koneksi,

    "SELECT
        id_user,
        username,
        nama,
        email,
        no_hp,
        alamat,
        foto,
        created_at
     FROM users
     WHERE id_user = $id_user_safe
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
    Profil Admin
</title>

<script src="https://cdn.tailwindcss.com"></script>

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
        class="max-w-5xl mx-auto px-6 py-5"
    >

        <div
            class="flex items-center justify-between gap-4"
        >

            <div>

                <p
                    class="text-xs font-semibold text-emerald-600 uppercase tracking-wider"
                >
                    Pengaturan
                </p>

                <h1
                    class="text-xl font-bold text-slate-900 mt-1"
                >
                    Profil Admin
                </h1>

                <p
                    class="text-sm text-slate-500 mt-1"
                >
                    Kelola informasi pribadi akun administrator.
                </p>

            </div>


            <a
                href="index.php"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"
            >

                ←
                Kembali

            </a>

        </div>

    </div>

</header>



<!-- ==================================================
     MAIN
     ================================================== -->

<main
    class="max-w-5xl mx-auto px-6 py-8"
>


    <div
        class="grid grid-cols-1 lg:grid-cols-3 gap-6"
    >


        <!-- ==================================================
             PROFILE CARD
             ================================================== -->

        <aside
            class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 h-fit"
        >

            <div
                class="flex flex-col items-center text-center"
            >

                <!-- FOTO -->

                <div
                    class="w-28 h-28 rounded-3xl overflow-hidden bg-emerald-100 flex items-center justify-center mb-4"
                >

                    <?php if (!empty($user['foto'])): ?>

                        <img
                            src="../../uploads/profile/<?= htmlspecialchars($user['foto']); ?>"
                            alt="Foto Admin"
                            class="w-full h-full object-cover"
                        >

                    <?php else: ?>

                        <span
                            class="text-4xl font-bold text-emerald-700"
                        >

                            <?= strtoupper(
                                substr(
                                    $user['nama'],
                                    0,
                                    1
                                )
                            ); ?>

                        </span>

                    <?php endif; ?>

                </div>


                <h2
                    class="text-lg font-bold text-slate-900"
                >

                    <?= htmlspecialchars(
                        $user['nama']
                    ); ?>

                </h2>


                <p
                    class="text-sm text-slate-500 mt-1"
                >

                    @<?= htmlspecialchars(
                        $user['username']
                    ); ?>

                </p>


                <span
                    class="inline-flex mt-3 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold"
                >
                    Administrator
                </span>

            </div>


            <div
                class="border-t border-slate-100 mt-6 pt-5"
            >

                <a
                    href="foto.php"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"
                >

                    Kelola Foto Profil

                </a>

            </div>

        </aside>



        <!-- ==================================================
             FORM PROFIL
             ================================================== -->

        <section
            class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl shadow-sm"
        >

            <div
                class="px-6 py-5 border-b border-slate-100"
            >

                <h2
                    class="font-bold text-slate-900"
                >
                    Informasi Pribadi
                </h2>

                <p
                    class="text-sm text-slate-500 mt-1"
                >
                    Perubahan akan disimpan ke akun administrator.
                </p>

            </div>


            <form
                action="proses_profil.php"
                method="POST"
                class="p-6"
            >

                <input
                    type="hidden"
                    name="id_user"
                    value="<?= $user['id_user']; ?>"
                >


                <!-- NAMA -->

                <div class="mb-5">

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
                        value="<?= htmlspecialchars(
                            $user['nama']
                        ); ?>"
                        maxlength="100"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition"
                    >

                </div>



                <!-- USERNAME -->

                <div class="mb-5">

                    <label
                        for="username"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="<?= htmlspecialchars(
                            $user['username']
                        ); ?>"
                        maxlength="50"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition"
                    >

                    <p
                        class="text-xs text-slate-400 mt-2"
                    >
                        Username digunakan untuk login ke sistem.
                    </p>

                </div>



                <!-- EMAIL -->

                <div class="mb-5">

                    <label
                        for="email"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars(
                            $user['email'] ?? ''
                        ); ?>"
                        maxlength="100"
                        placeholder="admin@example.com"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition"
                    >

                </div>



                <!-- NO HP -->

                <div class="mb-5">

                    <label
                        for="no_hp"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Nomor HP
                    </label>

                    <input
                        type="tel"
                        id="no_hp"
                        name="no_hp"
                        value="<?= htmlspecialchars(
                            $user['no_hp'] ?? ''
                        ); ?>"
                        maxlength="20"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition"
                    >

                </div>



                <!-- ALAMAT -->

                <div class="mb-6">

                    <label
                        for="alamat"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="4"
                        placeholder="Masukkan alamat..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 outline-none resize-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition"
                    ><?= htmlspecialchars(
                        $user['alamat'] ?? ''
                    ); ?></textarea>

                </div>



                <!-- BUTTON -->

                <div
                    class="flex flex-col sm:flex-row sm:justify-end gap-3 pt-5 border-t border-slate-100"
                >

                    <a
                        href="index.php"
                        class="inline-flex items-center justify-center px-5 py-3 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"
                    >
                        Batal
                    </a>


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
                                d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"
                            />

                            <path
                                d="M17 21v-8H7v8"
                            />

                            <path
                                d="M7 3v5h8"
                            />

                        </svg>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </section>

    </div>

</main>

</div>

</body>

</html>
