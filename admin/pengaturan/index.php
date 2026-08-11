<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../../login.php");
    exit;
}

include "../../config/database.php";

$id_user = $_SESSION['id_user'] ?? 1;


// ======================================================
// AMBIL DATA USER
// ======================================================

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
     WHERE id_user = '$id_user'
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
    Pengaturan Admin
</title>

<script src="https://cdn.tailwindcss.com"></script>


</head>

<body class="bg-slate-100 text-slate-800">

<div class="min-h-screen">


<!-- HEADER -->

<header class="bg-white border-b border-slate-200">

    <div
        class="max-w-7xl mx-auto px-6 py-5"
    >

        <div
            class="flex items-center justify-between"
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
                    Kelola akun dan konfigurasi administrator.
                </p>

            </div>


            <a
                href="../index.php"
                class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"
            >
                ← Kembali
            </a>

        </div>

    </div>

</header>



<!-- CONTENT -->

<main
    class="max-w-7xl mx-auto px-6 py-8"
>


    <!-- PROFILE SUMMARY -->

    <div
        class="bg-white border border-slate-200 rounded-2xl p-6 mb-6 shadow-sm"
    >

        <div
            class="flex flex-col sm:flex-row sm:items-center gap-5"
        >


            <!-- FOTO -->

            <div
                class="w-20 h-20 rounded-2xl overflow-hidden bg-emerald-100 flex items-center justify-center"
            >

                <?php if (!empty($user['foto'])): ?>

                    <img
                        src="../../uploads/profile/<?= htmlspecialchars($user['foto']); ?>"
                        alt="Foto Admin"
                        class="w-full h-full object-cover"
                    >

                <?php else: ?>

                    <span
                        class="text-2xl font-bold text-emerald-700"
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


            <!-- INFO -->

            <div class="flex-1">

                <h2
                    class="text-xl font-bold text-slate-900"
                >

                    <?= htmlspecialchars(
                        $user['nama']
                    ); ?>

                </h2>

                <p
                    class="text-sm text-slate-500"
                >

                    @<?= htmlspecialchars(
                        $user['username']
                    ); ?>

                </p>

                <p
                    class="text-xs text-slate-400 mt-1"
                >

                    Admin Perpustakaan

                </p>

            </div>

        </div>

    </div>



    <!-- SETTINGS GRID -->

    <div
        class="grid grid-cols-1 md:grid-cols-2 gap-5"
    >


        <!-- PROFIL -->

        <a
            href="profil.php"
            class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:border-emerald-300 hover:shadow-md transition"
        >

            <div
                class="flex items-start gap-4"
            >

                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        class="w-6 h-6"
                    >

                        <circle
                            cx="12"
                            cy="8"
                            r="4"
                        />

                        <path
                            d="M4 21a8 8 0 0 1 16 0"
                        />

                    </svg>

                </div>


                <div>

                    <h3
                        class="font-bold text-slate-900 group-hover:text-emerald-700"
                    >
                        Profil Admin
                    </h3>

                    <p
                        class="text-sm text-slate-500 mt-1"
                    >
                        Kelola nama, username, email,
                        nomor HP, dan alamat.
                    </p>

                </div>

            </div>

        </a>



        <!-- PASSWORD -->

        <a
            href="password.php"
            class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:border-amber-300 hover:shadow-md transition"
        >

            <div
                class="flex items-start gap-4"
            >

                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        class="w-6 h-6"
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

                </div>


                <div>

                    <h3
                        class="font-bold text-slate-900 group-hover:text-amber-700"
                    >
                        Keamanan Akun
                    </h3>

                    <p
                        class="text-sm text-slate-500 mt-1"
                    >
                        Ubah password akun administrator.
                    </p>

                </div>

            </div>

        </a>



        <!-- FOTO -->

        <a
            href="foto.php"
            class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition"
        >

            <div
                class="flex items-start gap-4"
            >

                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        class="w-6 h-6"
                    >

                        <rect
                            x="3"
                            y="5"
                            width="18"
                            height="14"
                            rx="2"
                        />

                        <circle
                            cx="8.5"
                            cy="10"
                            r="1.5"
                        />

                        <path
                            d="m21 15-5-5L5 19"
                        />

                    </svg>

                </div>


                <div>

                    <h3
                        class="font-bold text-slate-900 group-hover:text-blue-700"
                    >
                        Foto Profil
                    </h3>

                    <p
                        class="text-sm text-slate-500 mt-1"
                    >
                        Upload atau ganti foto profil admin.
                    </p>

                </div>

            </div>

        </a>



        <!-- SISTEM -->

        <a
            href="sistem.php"
            class="group bg-white border border-slate-200 rounded-2xl p-6 shadow-sm hover:border-purple-300 hover:shadow-md transition"
        >

            <div
                class="flex items-start gap-4"
            >

                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0"
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
                            d="M12 2v4"
                        />

                        <path
                            d="M12 18v4"
                        />

                        <path
                            d="M4.93 4.93l2.83 2.83"
                        />

                        <path
                            d="m16.24 16.24 2.83 2.83"
                        />

                        <path
                            d="M2 12h4"
                        />

                        <path
                            d="M18 12h4"
                        />

                        <path
                            d="m4.93 19.07 2.83-2.83"
                        />

                        <path
                            d="m16.24 7.76 2.83-2.83"
                        />

                        <circle
                            cx="12"
                            cy="12"
                            r="4"
                        />

                    </svg>

                </div>


                <div>

                    <h3
                        class="font-bold text-slate-900 group-hover:text-purple-700"
                    >
                        Informasi Sistem
                    </h3>

                    <p
                        class="text-sm text-slate-500 mt-1"
                    >
                        Informasi aplikasi dan teknologi
                        yang digunakan.
                    </p>

                </div>

            </div>

        </a>

    </div>



    <!-- ACCOUNT INFO -->

    <div
        class="bg-white border border-slate-200 rounded-2xl p-6 mt-6 shadow-sm"
    >

        <h2
            class="font-bold text-slate-900 mb-4"
        >
            Informasi Akun
        </h2>


        <div
            class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5"
        >

            <div>

                <p class="text-xs text-slate-400">
                    Username
                </p>

                <p
                    class="font-semibold text-slate-700 mt-1"
                >

                    <?= htmlspecialchars(
                        $user['username']
                    ); ?>

                </p>

            </div>


            <div>

                <p class="text-xs text-slate-400">
                    Email
                </p>

                <p
                    class="font-semibold text-slate-700 mt-1"
                >

                    <?= !empty($user['email'])
                        ? htmlspecialchars(
                            $user['email']
                        )
                        : '-'
                    ?>

                </p>

            </div>


            <div>

                <p class="text-xs text-slate-400">
                    Akun Dibuat
                </p>

                <p
                    class="font-semibold text-slate-700 mt-1"
                >

                    <?= date(
                        'd F Y',
                        strtotime(
                            $user['created_at']
                        )
                    ); ?>

                </p>

            </div>

        </div>

    </div>

</main>


</div>

</body>

</html>
