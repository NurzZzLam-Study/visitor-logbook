<?php

// ======================================================
// AMBIL DATA ADMIN YANG SEDANG LOGIN
// ======================================================

$id_user = isset($_SESSION['id_user'])
    ? (int) $_SESSION['id_user']
    : 0;


// ======================================================
// DATA DEFAULT
// ======================================================

$admin_nama = $_SESSION['nama'] ?? 'Administrator';
$admin_username = $_SESSION['username'] ?? '';
$admin_foto = '';


// ======================================================
// AMBIL DATA TERBARU DARI DATABASE
// ======================================================

if ($id_user > 0) {

    $query_admin = mysqli_query(
        $koneksi,

        "SELECT
            id_user,
            username,
            nama,
            foto

         FROM users

         WHERE id_user = '$id_user'

         LIMIT 1"
    );


    if ($query_admin) {

        $admin = mysqli_fetch_assoc(
            $query_admin
        );


        if ($admin) {

            $admin_nama =
                $admin['nama'];

            $admin_username =
                $admin['username'];

            $admin_foto =
                $admin['foto'];

        }

    }

}


// ======================================================
// FOTO ADMIN
// ======================================================

$admin_foto_url = '';

if (!empty($admin_foto)) {

    $admin_foto_url =
        "../uploads/profile/" .
        $admin_foto;

}


// ======================================================
// INISIAL NAMA
// ======================================================

$admin_inisial =
    strtoupper(
        substr(
            $admin_nama,
            0,
            1
        )
    );

?>

<header
    class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-10"
>

    <!-- ==================================================
         LOGO
         ================================================== -->

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

            <h1
                class="font-bold text-slate-900"
            >
                Perpustakaan
            </h1>


            <p
                class="text-xs text-slate-500"
            >
                Digital Library
            </p>

        </div>

    </a>


    <!-- ==================================================
         ADMIN PROFILE
         ================================================== -->

    <div class="flex items-center gap-3">


        <div class="hidden sm:block text-right">

            <p
                class="text-sm font-semibold text-slate-800"
            >

                <?= htmlspecialchars(
                    $admin_nama
                ); ?>

            </p>


            <p
                class="text-xs text-slate-500"
            >

                @<?= htmlspecialchars(
                    $admin_username
                ); ?>

            </p>

        </div>


        <!-- FOTO -->

        <?php if ($admin_foto_url): ?>

            <img
                src="<?= htmlspecialchars(
                    $admin_foto_url
                ); ?>"
                alt="Foto Profil"
                class="w-10 h-10 rounded-full object-cover border border-slate-200"
            >

        <?php else: ?>

            <div
                class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold"
            >

                <?= htmlspecialchars(
                    $admin_inisial
                ); ?>

            </div>

        <?php endif; ?>


    </div>

</header>