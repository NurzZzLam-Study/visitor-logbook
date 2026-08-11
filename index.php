<?php
include "config/database.php";
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
    Buku Kunjungan Perpustakaan
</title>


<!-- Tailwind CSS -->

<script src="https://cdn.tailwindcss.com"></script>


<script>

    tailwind.config = {

        theme: {

            extend: {

                fontFamily: {

                    sans: [
                        'Inter',
                        'ui-sans-serif',
                        'system-ui',
                        'sans-serif'
                    ]

                },

                boxShadow: {

                    soft: '0 20px 50px rgba(15, 23, 42, 0.08)'

                }

            }

        }

    }

</script>

</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

<!-- ==================================================
     BACKGROUND DECORATION
     ================================================== -->

<div class="fixed inset-0 -z-10 overflow-hidden">

    <div
        class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-emerald-100/60 blur-3xl"
    ></div>

    <div
        class="absolute -bottom-40 -right-32 w-[28rem] h-[28rem] rounded-full bg-amber-100/50 blur-3xl"
    ></div>

</div>


<!-- ==================================================
     NAVBAR
     ================================================== -->

<header
    class="border-b border-slate-200/80 bg-white/80 backdrop-blur-xl"
>

    <div
        class="max-w-6xl mx-auto px-5 sm:px-6 lg:px-8"
    >

        <div
            class="h-20 flex items-center justify-between"
        >


            <!-- BRAND -->

            <div class="flex items-center gap-3">

                <div
                    class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-600/20"
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
                            d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"
                        />

                        <path
                            d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"
                        />

                        <path
                            d="M8 6h8"
                        />

                        <path
                            d="M8 10h6"
                        />

                    </svg>

                </div>


                <div>

                    <h1
                        class="font-bold text-slate-900 leading-tight"
                    >
                        Perpustakaan
                    </h1>

                    <p
                        class="text-xs text-slate-500"
                    >
                        Buku Kunjungan Digital
                    </p>

                </div>

            </div>


            <!-- STATUS -->

            <div
                class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-full bg-emerald-50 border border-emerald-100"
            >

                <span
                    class="relative flex w-2.5 h-2.5"
                >

                    <span
                        class="absolute inline-flex w-full h-full rounded-full bg-emerald-400 opacity-75 animate-ping"
                    ></span>

                    <span
                        class="relative inline-flex w-2.5 h-2.5 rounded-full bg-emerald-500"
                    ></span>

                </span>


                <span
                    class="text-xs font-medium text-emerald-700"
                >
                    Sistem aktif
                </span>

            </div>


        </div>

    </div>

</header>


<!-- ==================================================
     MAIN
     ================================================== -->

<main
    class="max-w-6xl mx-auto px-5 sm:px-6 lg:px-8 py-10 sm:py-14"
>


    <div
        class="grid grid-cols-1 lg:grid-cols-[1fr_460px] gap-10 lg:gap-16 items-center"
    >


        <!-- ==================================================
             HERO
             ================================================== -->

        <section>

            <div
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-semibold mb-5"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="w-3.5 h-3.5"
                >

                    <path
                        d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z"
                    />

                    <path
                        d="m9 12 2 2 4-4"
                    />

                </svg>

                Sistem Kunjungan Perpustakaan

            </div>


            <h2
                class="text-4xl sm:text-5xl lg:text-[3.4rem] font-bold tracking-tight leading-[1.08] text-slate-900"
            >

                Catat kunjunganmu
                <span class="text-emerald-600">
                    dengan mudah.
                </span>

            </h2>


            <p
                class="mt-5 max-w-xl text-base sm:text-lg leading-relaxed text-slate-500"
            >

                Silakan isi data kunjungan sebelum menggunakan
                fasilitas perpustakaan. Hanya membutuhkan waktu
                kurang dari satu menit.

            </p>


            <!-- BENEFITS -->

            <div
                class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-xl"
            >


                <div
                    class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm"
                >

                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3"
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
                                d="M12 3v18"
                            />

                            <path
                                d="M3 12h18"
                            />

                        </svg>

                    </div>


                    <p
                        class="text-sm font-semibold text-slate-800"
                    >
                        Cepat
                    </p>


                    <p
                        class="mt-1 text-xs leading-relaxed text-slate-500"
                    >
                        Isi data dalam beberapa langkah.
                    </p>

                </div>


                <div
                    class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm"
                >

                    <div
                        class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3"
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
                                d="M20 7 10 17l-5-5"
                            />

                        </svg>

                    </div>


                    <p
                        class="text-sm font-semibold text-slate-800"
                    >
                        Praktis
                    </p>


                    <p
                        class="mt-1 text-xs leading-relaxed text-slate-500"
                    >
                        Tanpa perlu mengisi buku manual.
                    </p>

                </div>


                <div
                    class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm"
                >

                    <div
                        class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3"
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
                                d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z"
                            />

                            <path
                                d="M12 6v6l4 2"
                            />

                        </svg>

                    </div>


                    <p
                        class="text-sm font-semibold text-slate-800"
                    >
                        Tersimpan
                    </p>


                    <p
                        class="mt-1 text-xs leading-relaxed text-slate-500"
                    >
                        Data tercatat secara digital.
                    </p>

                </div>


            </div>


        </section>


        <!-- ==================================================
             FORM CARD
             ================================================== -->

        <section>

            <div
                class="bg-white rounded-3xl border border-slate-200 shadow-soft overflow-hidden"
            >


                <!-- CARD HEADER -->

                <div
                    class="px-6 sm:px-8 pt-7 pb-6 border-b border-slate-100"
                >

                    <div
                        class="flex items-center gap-3"
                    >

                        <div
                            class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center"
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
                                    d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                />

                                <circle
                                    cx="9"
                                    cy="7"
                                    r="4"
                                />

                                <path
                                    d="M22 21v-2a4 4 0 0 0-3-3.87"
                                />

                                <path
                                    d="M16 3.13a4 4 0 0 1 0 7.75"
                                />

                            </svg>

                        </div>


                        <div>

                            <h3
                                class="text-lg font-bold text-slate-900"
                            >
                                Form Kunjungan
                            </h3>

                            <p
                                class="text-xs text-slate-500 mt-0.5"
                            >
                                Lengkapi data diri Anda.
                            </p>

                        </div>

                    </div>

                </div>


                <!-- FORM -->

                <form
                    action="proses_kunjungan.php"
                    method="POST"
                    class="p-6 sm:p-8 space-y-5"
                >


                    <!-- NIS -->

                    <div>

                        <label
                            for="nis"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            NIS
                        </label>


                        <div class="relative">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                            >

                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="16"
                                    rx="2"
                                />

                                <path
                                    d="M8 9h8"
                                />

                                <path
                                    d="M8 13h5"
                                />

                            </svg>


                            <input
                                type="text"
                                id="nis"
                                name="nis"
                                placeholder="Masukkan NIS"
                                required
                                autocomplete="off"
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/70 text-sm text-slate-800 placeholder:text-slate-400 outline-none transition focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                        </div>

                    </div>


                    <!-- NAMA -->

                    <div>

                        <label
                            for="nama"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Nama Lengkap
                        </label>


                        <div class="relative">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
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


                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                placeholder="Masukkan nama lengkap"
                                required
                                autocomplete="name"
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/70 text-sm text-slate-800 placeholder:text-slate-400 outline-none transition focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                            >

                        </div>

                    </div>


                    <!-- KELAS -->

                    <div>

                        <label
                            for="kelas"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Kelas
                        </label>


                        <div class="relative">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none"
                            >

                                <path
                                    d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"
                                />

                                <path
                                    d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"
                                />

                            </svg>


                            <select
                                id="kelas"
                                name="kelas"
                                required
                                class="w-full pl-11 pr-10 py-3.5 rounded-xl border border-slate-200 bg-slate-50/70 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 appearance-none cursor-pointer"
                            >

                                <option value="">
                                    -- Pilih Kelas --
                                </option>

                                <option value="X RPL">
                                    X RPL
                                </option>

                                <option value="XI RPL">
                                    XI RPL
                                </option>

                                <option value="XII RPL">
                                    XII RPL
                                </option>

                                <option value="X AK">
                                    X AK
                                </option>

                                <option value="XI AK">
                                    XI AK
                                </option>

                                <option value="XII AK">
                                    XII AK
                                </option>

                                <option value="X TSM">
                                    X TSM
                                </option>

                                <option value="XI TSM">
                                    XI TSM
                                </option>

                                <option value="XII TSM">
                                    XII TSM
                                </option>

                            </select>


                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            >

                                <path
                                    d="m6 9 6 6 6-6"
                                />

                            </svg>

                        </div>

                    </div>


                    <!-- KEPERLUAN -->

                    <div>

                        <label
                            for="keperluan"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Keperluan
                        </label>


                        <div class="relative">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400 pointer-events-none"
                            >

                                <path
                                    d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"
                                />

                                <path
                                    d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"
                                />

                            </svg>


                            <select
                                id="keperluan"
                                name="keperluan"
                                required
                                class="w-full pl-11 pr-10 py-3.5 rounded-xl border border-slate-200 bg-slate-50/70 text-sm text-slate-800 outline-none transition focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 appearance-none cursor-pointer"
                            >

                                <option value="">
                                    -- Pilih Keperluan --
                                </option>

                                <option value="Membaca">
                                    Membaca
                                </option>

                                <option value="Meminjam Buku">
                                    Meminjam Buku
                                </option>

                                <option value="Mengembalikan Buku">
                                    Mengembalikan Buku
                                </option>

                                <option value="Belajar">
                                    Belajar
                                </option>

                                <option value="Lainnya">
                                    Lainnya
                                </option>

                            </select>


                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            >

                                <path
                                    d="m6 9 6 6 6-6"
                                />

                            </svg>

                        </div>

                    </div>


                    <!-- BUTTON -->

                    <button
                        type="submit"
                        class="w-full mt-2 inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-semibold shadow-lg shadow-emerald-600/20 transition duration-200"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            class="w-5 h-5"
                        >

                            <path
                                d="M12 5v14"
                            />

                            <path
                                d="M5 12h14"
                            />

                        </svg>

                        Simpan Kunjungan

                    </button>


                    <!-- PRIVACY -->

                    <div
                        class="flex items-start gap-2.5 pt-1"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0"
                        >

                            <path
                                d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"
                            />

                            <path
                                d="m9 12 2 2 4-4"
                            />

                        </svg>


                        <p
                            class="text-[11px] leading-relaxed text-slate-400"
                        >

                            Data kunjungan digunakan untuk keperluan
                            administrasi dan statistik perpustakaan.

                        </p>

                    </div>


                </form>

            </div>

        </section>


    </div>

</main>


<!-- ==================================================
     FOOTER
     ================================================== -->

<footer
    class="border-t border-slate-200/80 mt-4"
>

    <div
        class="max-w-6xl mx-auto px-5 sm:px-6 lg:px-8 py-6"
    >

        <div
            class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-400"
        >

            <p>
                © <?= date('Y'); ?> Perpustakaan Sekolah.
                Buku Kunjungan Digital.
            </p>


            <p>
                Sistem Informasi Perpustakaan
            </p>

        </div>

    </div>

</footer>

</body>

</html>
