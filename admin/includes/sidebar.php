<?php

$current_page = basename($_SERVER['PHP_SELF']);
$current_dir  = basename(dirname($_SERVER['PHP_SELF']));

?>

<aside
    id="sidebar"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-950 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col"
>

    <!-- ================================================== -->
    <!-- LOGO -->
    <!-- ================================================== -->

    <div class="h-20 px-5 flex items-center border-b border-white/10">

        <a
            href="/perpustakaan/admin/dashboard.php"
            class="flex items-center gap-3"
        >

            <div
                class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center"
            >

                <i
                    data-lucide="book-open"
                    class="w-5 h-5"
                ></i>

            </div>

            <div>

                <h1 class="font-bold text-white">
                    Perpustakaan
                </h1>

                <p class="text-[11px] text-slate-400">
                    Digital Library
                </p>

            </div>

        </a>

    </div>


    <!-- ================================================== -->
    <!-- NAVIGATION -->
    <!-- ================================================== -->

    <nav
        class="flex-1 overflow-y-auto px-3 py-5 space-y-1"
    >

        <!-- Dashboard -->

        <a
            href="/perpustakaan/admin/dashboard.php"
            class="
                flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                transition
                <?= $current_page === 'dashboard.php'
                    ? 'bg-emerald-500 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>
            "
        >

            <i
                data-lucide="layout-dashboard"
                class="w-5 h-5"
            ></i>

            <span>Dashboard</span>

        </a>


        <!-- ================================================== -->
        <!-- SECTION: KUNJUNGAN -->
        <!-- ================================================== -->

        <div class="pt-5 pb-2 px-3">

            <p
                class="text-[10px] font-bold uppercase tracking-widest text-slate-600"
            >
                Aktivitas
            </p>

        </div>


        <!-- Semua Kunjungan -->

        <a
            href="/perpustakaan/admin/index.php"
            class="
                flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                transition
                <?= in_array(
                    $current_page,
                    ['index.php', 'detail.php', 'edit.php', 'hapus.php']
                )
                    ? 'bg-white/10 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>
            "
        >

            <i
                data-lucide="clipboard-list"
                class="w-5 h-5"
            ></i>

            <span class="flex-1">
                Data Kunjungan
            </span>

        </a>


        <!-- Tambah Kunjungan -->

        <a
            href="/perpustakaan/admin/tambah.php"
            class="
                flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                transition
                <?= $current_page === 'tambah.php'
                    ? 'bg-white/10 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>
            "
        >

            <i
                data-lucide="plus-circle"
                class="w-5 h-5"
            ></i>

            <span>Tambah Kunjungan</span>

        </a>


        <!-- ================================================== -->
        <!-- SECTION: MASTER DATA -->
        <!-- ================================================== -->

        <div class="pt-5 pb-2 px-3">

            <p
                class="text-[10px] font-bold uppercase tracking-widest text-slate-600"
            >
                Master Data
            </p>

        </div>


        <!-- Siswa -->

        <a
            href="/perpustakaan/admin/siswa/index.php"
            class="
                flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                transition
                <?= $current_dir === 'siswa'
                    ? 'bg-white/10 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>
            "
        >

            <i
                data-lucide="users"
                class="w-5 h-5"
            ></i>

            <span>Siswa</span>

        </a>


        <!-- Kelas -->

        <a
            href="/perpustakaan/admin/kelas/index.php"
            class="
                flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                transition
                <?= $current_dir === 'kelas'
                    ? 'bg-white/10 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>
            "
        >

            <i
                data-lucide="school"
                class="w-5 h-5"
            ></i>

            <span>Kelas</span>

        </a>


        <!-- Jurusan -->

        <a
            href="/perpustakaan/admin/jurusan/index.php"
            class="
                flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                transition
                <?= $current_dir === 'jurusan'
                    ? 'bg-white/10 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>
            "
        >

            <i
                data-lucide="graduation-cap"
                class="w-5 h-5"
            ></i>

            <span>Jurusan</span>

        </a>


        <!-- ================================================== -->
        <!-- SECTION: LAPORAN -->
        <!-- ================================================== -->

        <div class="pt-5 pb-2 px-3">

            <p
                class="text-[10px] font-bold uppercase tracking-widest text-slate-600"
            >
                Analisis
            </p>

        </div>


        <!-- Laporan -->

        <a
            href="/perpustakaan/admin/laporan/index.php"
            class="
                flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                transition
                <?= $current_dir === 'laporan'
                    ? 'bg-white/10 text-white'
                    : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>"
        >

            <i
                data-lucide="chart-column"
                class="w-5 h-5"
            ></i>

            <span>Laporan</span>

        </a>


        <!-- ================================================== -->
        <!-- SECTION: SISTEM -->
        <!-- ================================================== -->

        <div class="pt-5 pb-2 px-3">

            <p
                class="text-[10px] font-bold uppercase tracking-widest text-slate-600"
            >
                Sistem
            </p>

        </div>


        <!-- Pengaturan -->

        <a
            href="/perpustakaan/admin/pengaturan.php"
            class="
                flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm
                text-slate-400 hover:bg-white/5 hover:text-white transition
            "
        >

            <i
                data-lucide="settings"
                class="w-5 h-5"
            ></i>

            <span>Pengaturan</span>

        </a>

    </nav>


    <!-- ================================================== -->
    <!-- USER -->
    <!-- ================================================== -->

    <div
        class="p-3 border-t border-white/10"
    >

        <div
            class="flex items-center gap-3 p-3 rounded-xl bg-white/5"
        >

            <div
                class="w-9 h-9 rounded-full bg-emerald-500 flex items-center justify-center font-bold text-sm"
            >

                <?= strtoupper(
                    substr(
                        $_SESSION['nama'],
                        0,
                        1
                    )
                ); ?>

            </div>


            <div class="min-w-0 flex-1">

                <p
                    class="text-sm font-semibold text-white truncate"
                >

                    <?= htmlspecialchars(
                        $_SESSION['nama']
                    ); ?>

                </p>

                <p class="text-xs text-slate-500">
                    Administrator
                </p>

            </div>


            <a
                href="/perpustakaan/logout.php"
                class="text-slate-500 hover:text-red-400 transition"
                title="Logout"
            >

                <i
                    data-lucide="log-out"
                    class="w-4 h-4"
                ></i>

            </a>

        </div>

    </div>

</aside>


<!-- ====================================================== -->
<!-- MOBILE OVERLAY -->
<!-- ====================================================== -->

<div
    id="sidebar-overlay"
    class="fixed inset-0 z-30 bg-black/50 hidden lg:hidden"
></div>