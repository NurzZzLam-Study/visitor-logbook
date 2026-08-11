<?php

session_start();


// Jika sudah login, langsung ke dashboard

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {

    header("Location: admin/index.php");
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
    Login Admin - Buku Kunjungan
</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body
    class="min-h-screen bg-slate-100 flex items-center justify-center px-6"
>

<div class="w-full max-w-md">


<!-- LOGO / BRAND -->

<div class="text-center mb-8">

    <div
        class="w-16 h-16 mx-auto rounded-2xl bg-emerald-600 text-white flex items-center justify-center shadow-lg shadow-emerald-600/20"
    >

        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.8"
            class="w-8 h-8"
        >

            <path
                d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"
            />

            <path
                d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"
            />

        </svg>

    </div>


    <h1
        class="text-2xl font-bold text-slate-900 mt-5"
    >
        Buku Kunjungan
    </h1>


    <p
        class="text-sm text-slate-500 mt-1"
    >
        Perpustakaan Digital
    </p>

</div>



<!-- LOGIN CARD -->

<div
    class="bg-white rounded-2xl border border-slate-200 shadow-xl shadow-slate-900/5 p-7"
>

    <div class="mb-6">

        <h2
            class="text-xl font-bold text-slate-900"
        >
            Login Admin
        </h2>

        <p
            class="text-sm text-slate-500 mt-1"
        >
            Masuk untuk mengelola sistem perpustakaan.
        </p>

    </div>



    <!-- FORM -->

    <form
        action="proses_login.php"
        method="POST"
        class="space-y-5"
    >


        <!-- USERNAME -->

        <div>

            <label
                for="username"
                class="block text-sm font-semibold text-slate-700 mb-2"
            >
                Username
            </label>

            <div class="relative">

                <div
                    class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
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

                </div>


                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Masukkan username"
                    autocomplete="username"
                    required
                    autofocus
                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition"
                >

            </div>

        </div>



        <!-- PASSWORD -->

        <div>

            <div
                class="flex items-center justify-between mb-2"
            >

                <label
                    for="password"
                    class="block text-sm font-semibold text-slate-700"
                >
                    Password
                </label>

            </div>


            <div class="relative">

                <div
                    class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
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

                </div>


                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                    class="w-full pl-12 pr-12 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition"
                >


                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 px-4 text-slate-400 hover:text-slate-600"
                >

                    <svg
                        id="eyeIcon"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        class="w-5 h-5"
                    >

                        <path
                            d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                        />

                        <circle
                            cx="12"
                            cy="12"
                            r="2.5"
                        />

                    </svg>

                </button>

            </div>

        </div>



        <!-- BUTTON -->

        <button
            type="submit"
            class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 active:bg-emerald-800 transition shadow-lg shadow-emerald-600/20"
        >

            Masuk ke Dashboard

            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                class="w-4 h-4"
            >

                <path
                    d="M5 12h14"
                />

                <path
                    d="m13 6 6 6-6 6"
                />

            </svg>

        </button>


    </form>


</div>



<!-- FOOTER -->

<p
    class="text-center text-xs text-slate-400 mt-6"
>
    © <?= date('Y'); ?> Buku Kunjungan Perpustakaan
</p>

</div>

<script>

function togglePassword() {

    const password =
        document.getElementById('password');

    if (password.type === 'password') {

        password.type = 'text';

    } else {

        password.type = 'password';

    }

}

</script>

</body>

</html>
