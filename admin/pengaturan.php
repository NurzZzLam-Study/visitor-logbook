<?php session_start(); include "../config/database.php"; // ====================================================== // CEK LOGIN // ====================================================== if (!isset($_SESSION['login'])) { header("Location: ../login.php"); exit; } // ====================================================== // AMBIL ID USER // ====================================================== $id_user = $_SESSION['id_user'] ?? 0; $id_user = (int) $id_user; // ====================================================== // AMBIL DATA USER // ====================================================== $query_user = mysqli_query( $koneksi, "SELECT id_user, username, nama, email, no_hp, alamat, foto, created_at FROM users WHERE id_user = $id_user LIMIT 1" ); if (!$query_user || mysqli_num_rows($query_user) === 0) { echo " <script> alert('Data admin tidak ditemukan!'); window.location='index.php'; </script> "; exit; } $user = mysqli_fetch_assoc($query_user); // ====================================================== // PESAN // ====================================================== $success = $_GET['success'] ?? ''; $error = $_GET['error'] ?? ''; ?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    Pengaturan Admin
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
        class="max-w-7xl mx-auto px-6 py-5"
    >

        <div
            class="flex items-center justify-between gap-4"
        >

            <div>

                <h1
                    class="text-xl font-bold text-slate-900"
                >
                    Pengaturan Admin
                </h1>

                <p
                    class="text-sm text-slate-500 mt-1"
                >
                    Kelola informasi akun dan keamanan
                </p>

            </div>


            <a
                href="index.php"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"
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
                        d="m15 18-6-6 6-6"
                    />

                </svg>

                Kembali

            </a>

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
         ALERT
         ================================================== -->

    <?php if ($success): ?>

        <div
            class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700"
        >

            <?= htmlspecialchars($success); ?>

        </div>

    <?php endif; ?>


    <?php if ($error): ?>

        <div
            class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700"
        >

            <?= htmlspecialchars($error); ?>

        </div>

    <?php endif; ?>



    <div
        class="grid grid-cols-1 lg:grid-cols-4 gap-6"
    >


        <!-- ==================================================
             SIDEBAR
             ================================================== -->

        <aside
            class="bg-white border border-slate-200 rounded-2xl shadow-sm p-3 h-fit"
        >

            <div
                class="px-4 py-4 mb-2"
            >

                <p
                    class="text-xs font-semibold uppercase tracking-wider text-slate-400"
                >
                    Pengaturan
                </p>

            </div>


            <a
                href="#profil"
                class="flex items-center gap-3 px-4 py-3 rounded-xl bg-emerald-50 text-emerald-700 font-semibold text-sm"
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
                        d="M20 21a8 8 0 0 0-16 0"
                    />

                    <circle
                        cx="12"
                        cy="7"
                        r="4"
                    />

                </svg>

                Profil Admin

            </a>


            <a
                href="#keamanan"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition text-sm"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    class="w-5 h-5"
                >

                    <rect
                        x="4"
                        y="10"
                        width="16"
                        height="11"
                        rx="2"
                    />

                    <path
                        d="M8 10V7a4 4 0 0 1 8 0v3"
                    />

                </svg>

                Keamanan

            </a>


            <a
                href="#sistem"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition text-sm"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    class="w-5 h-5"
                >

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path
                        d="M12 11v5"
                    />

                    <path
                        d="M12 8h.01"
                    />

                </svg>

                Informasi Sistem

            </a>

        </aside>



        <!-- ==================================================
             CONTENT
             ================================================== -->

        <div
            class="lg:col-span-3 space-y-6"
        >


            <!-- ==================================================
                 PROFIL
                 ================================================== -->

            <section
                id="profil"
                class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden"
            >

                <div
                    class="px-6 py-5 border-b border-slate-100"
                >

                    <h2
                        class="font-bold text-slate-900"
                    >
                        Profil Admin
                    </h2>

                    <p
                        class="text-sm text-slate-500 mt-1"
                    >
                        Perbarui informasi pribadi akun admin.
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


                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-5"
                    >


                        <!-- NAMA -->

                        <div>

                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="nama"
                                value="<?= htmlspecialchars($user['nama']); ?>"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none text-sm focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                        </div>


                        <!-- USERNAME -->

                        <div>

                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Username
                            </label>

                            <input
                                type="text"
                                name="username"
                                value="<?= htmlspecialchars($user['username']); ?>"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none text-sm focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                        </div>


                        <!-- EMAIL -->

                        <div>

                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="<?= htmlspecialchars($user['email'] ?? ''); ?>"
                                placeholder="admin@example.com"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none text-sm focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                        </div>


                        <!-- NO HP -->

                        <div>

                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Nomor HP
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                value="<?= htmlspecialchars($user['no_hp'] ?? ''); ?>"
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none text-sm focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                        </div>


                        <!-- ALAMAT -->

                        <div
                            class="md:col-span-2"
                        >

                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                rows="4"
                                placeholder="Masukkan alamat..."
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none text-sm resize-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            ><?= htmlspecialchars($user['alamat'] ?? ''); ?></textarea>

                        </div>

                    </div>


                    <div
                        class="flex justify-end mt-6 pt-5 border-t border-slate-100"
                    >

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition"
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
                                    d="M5 12l4 4L19 6"
                                />

                            </svg>

                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </section>



            <!-- ==================================================
                 KEAMANAN
                 ================================================== -->

            <section
                id="keamanan"
                class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden"
            >

                <div
                    class="px-6 py-5 border-b border-slate-100"
                >

                    <h2
                        class="font-bold text-slate-900"
                    >
                        Keamanan Akun
                    </h2>

                    <p
                        class="text-sm text-slate-500 mt-1"
                    >
                        Ganti password akun administrator.
                    </p>

                </div>


                <form
                    action="proses_password.php"
                    method="POST"
                    class="p-6"
                >

                    <input
                        type="hidden"
                        name="id_user"
                        value="<?= $user['id_user']; ?>"
                    >


                    <div
                        class="space-y-5"
                    >


                        <!-- PASSWORD LAMA -->

                        <div>

                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Password Lama
                            </label>

                            <input
                                type="password"
                                name="password_lama"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none text-sm focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                        </div>


                        <!-- PASSWORD BARU -->

                        <div>

                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Password Baru
                            </label>

                            <input
                                type="password"
                                name="password_baru"
                                required
                                minlength="6"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none text-sm focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                            <p
                                class="text-xs text-slate-400 mt-2"
                            >
                                Minimal 6 karakter.
                            </p>

                        </div>


                        <!-- KONFIRMASI -->

                        <div>

                            <label
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Konfirmasi Password Baru
                            </label>

                            <input
                                type="password"
                                name="konfirmasi_password"
                                required
                                minlength="6"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 outline-none text-sm focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                        </div>

                    </div>


                    <div
                        class="flex justify-end mt-6 pt-5 border-t border-slate-100"
                    >

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 transition"
                        >

                            Ubah Password

                        </button>

                    </div>

                </form>

            </section>



            <!-- ==================================================
                 INFORMASI SISTEM
                 ================================================== -->

            <section
                id="sistem"
                class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden"
            >

                <div
                    class="px-6 py-5 border-b border-slate-100"
                >

                    <h2
                        class="font-bold text-slate-900"
                    >
                        Informasi Sistem
                    </h2>

                    <p
                        class="text-sm text-slate-500 mt-1"
                    >
                        Informasi teknis aplikasi.
                    </p>

                </div>


                <div
                    class="p-6"
                >

                    <div
                        class="divide-y divide-slate-100"
                    >


                        <div
                            class="flex items-center justify-between py-4"
                        >

                            <span
                                class="text-sm text-slate-500"
                            >
                                Nama Aplikasi
                            </span>

                            <span
                                class="text-sm font-semibold text-slate-800"
                            >
                                Buku Kunjungan Perpustakaan
                            </span>

                        </div>


                        <div
                            class="flex items-center justify-between py-4"
                        >

                            <span
                                class="text-sm text-slate-500"
                            >
                                Versi
                            </span>

                            <span
                                class="text-sm font-semibold text-slate-800"
                            >
                                1.0.0
                            </span>

                        </div>


                        <div
                            class="flex items-center justify-between py-4"
                        >

                            <span
                                class="text-sm text-slate-500"
                            >
                                Backend
                            </span>

                            <span
                                class="text-sm font-semibold text-slate-800"
                            >
                                PHP Procedural
                            </span>

                        </div>


                        <div
                            class="flex items-center justify-between py-4"
                        >

                            <span
                                class="text-sm text-slate-500"
                            >
                                Database
                            </span>

                            <span
                                class="text-sm font-semibold text-slate-800"
                            >
                                MySQL / MariaDB
                            </span>

                        </div>


                        <div
                            class="flex items-center justify-between py-4"
                        >

                            <span
                                class="text-sm text-slate-500"
                            >
                                Dibuat
                            </span>

                            <span
                                class="text-sm font-semibold text-slate-800"
                            >

                                <?= date(
                                    'd F Y',
                                    strtotime(
                                        $user['created_at']
                                    )
                                ); ?>

                            </span>

                        </div>

                    </div>

                </div>

            </section>

        </div>

    </div>

</main>

</div>

</body>

</html>