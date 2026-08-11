<?php

$page_title = $page_title ?? 'Perpustakaan';

?>

<header
    class="fixed top-0 right-0 left-0 lg:left-64 h-20 z-20 bg-white border-b border-slate-200"
>

    <div
        class="h-full px-5 lg:px-8 flex items-center justify-between"
    >

        <!-- MOBILE MENU -->

        <button
            id="sidebar-toggle"
            type="button"
            class="lg:hidden w-10 h-10 rounded-xl hover:bg-slate-100 flex items-center justify-center"
        >

            <i
                data-lucide="menu"
                class="w-5 h-5"
            ></i>

        </button>


        <!-- PAGE TITLE -->

        <div class="hidden lg:block">

            <h2 class="font-bold text-slate-900">
                <?= htmlspecialchars($page_title); ?>
            </h2>

            <p class="text-xs text-slate-500">
                Sistem Informasi Perpustakaan
            </p>

        </div>


        <!-- RIGHT -->

        <div class="flex items-center gap-3">


            <!-- Notification -->

            <button
                class="relative w-10 h-10 rounded-xl hover:bg-slate-100 flex items-center justify-center text-slate-500"
            >

                <i
                    data-lucide="bell"
                    class="w-5 h-5"
                ></i>

                <span
                    class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"
                ></span>

            </button>


            <!-- User -->

            <div
                class="hidden sm:flex items-center gap-3 pl-3 border-l border-slate-200"
            >

                <div
                    class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm"
                >

                    <?= strtoupper(
                        substr(
                            $_SESSION['nama'],
                            0,
                            1
                        )
                    ); ?>

                </div>


                <div>

                    <p class="text-sm font-semibold text-slate-800">

                        <?= htmlspecialchars(
                            $_SESSION['nama']
                        ); ?>

                    </p>

                    <p class="text-xs text-slate-500">
                        Administrator
                    </p>

                </div>

            </div>

        </div>

    </div>

</header>