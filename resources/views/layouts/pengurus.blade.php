<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.pwa-meta')

    <title>
        @yield('title', 'Pengurus - MGS')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>


<body class="bg-slate-100 text-slate-800">


    <div class="min-h-screen flex">


        {{-- =========================================================
         MOBILE OVERLAY
    ========================================================== --}}

        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>



        {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

        <aside id="sidebar"
            class="fixed md:static inset-y-0 left-0 z-50
               w-72 md:w-64
               bg-slate-950 text-white
               flex flex-col
               transform -translate-x-full md:translate-x-0
               transition-transform duration-300 ease-in-out
               shadow-2xl md:shadow-none">


            {{-- =====================================================
             BRAND
        ====================================================== --}}

            <div class="px-5 py-5 border-b border-slate-800">

                <div class="flex items-center justify-between">


                    <div class="flex items-center gap-3">

                        {{-- LOGO --}}

                        <div
                            class="w-11 h-11 rounded-xl
                               bg-gradient-to-br from-indigo-500 to-violet-600
                               flex items-center justify-center
                               shadow-lg shadow-indigo-500/20">

                            <span class="text-lg font-black">
                                M
                            </span>

                        </div>


                        <div>

                            <div class="text-lg font-bold tracking-wide">
                                MGS
                            </div>

                            <div class="text-[11px] text-slate-400">
                                Mirai Gresik System
                            </div>

                        </div>

                    </div>


                    {{-- CLOSE MOBILE --}}

                    <button id="closeSidebar" type="button"
                        class="md:hidden w-9 h-9 rounded-lg
                           text-slate-400 hover:text-white
                           hover:bg-slate-800 transition">

                        <i class="fas fa-times"></i>

                    </button>

                </div>


                {{-- PANEL LABEL --}}

                <div
                    class="mt-4 px-3 py-2 rounded-lg
                       bg-indigo-500/10
                       border border-indigo-500/20">

                    <div class="flex items-center gap-2">

                        <span class="w-2 h-2 rounded-full bg-indigo-400"></span>

                        <span
                            class="text-[11px] font-semibold
                               text-indigo-300
                               uppercase tracking-wider">
                            Panel Pengurus
                        </span>

                    </div>

                </div>

            </div>



            {{-- =====================================================
             MENU
        ====================================================== --}}

            <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">


                {{-- DASHBOARD --}}

                <a href="{{ route('pengurus.dashboard') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.dashboard')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center
                        transition

                        {{ request()->routeIs('pengurus.dashboard') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                    ">

                        <i class="fas fa-home text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Dashboard
                    </span>

                </a>



                {{-- =================================================
                 DATA
            ================================================== --}}

                <div class="pt-6 pb-2 px-4">

                    <div
                        class="text-[10px] font-bold
                           text-slate-500
                           uppercase tracking-[0.15em]">
                        Data
                    </div>

                </div>


                {{-- PROGRAM --}}

                <a href="{{ route('pengurus.programs.index') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.programs.*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.programs.*') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                    ">

                        <i class="fas fa-graduation-cap text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Program
                    </span>

                </a>


                {{-- KELAS --}}

                <a href="{{ route('pengurus.classrooms.index') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.classrooms.*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.classrooms.*') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                    ">

                        <i class="fas fa-users text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Kelas
                    </span>

                </a>



                {{-- =================================================
                 AKADEMIK
            ================================================== --}}

                <div class="pt-6 pb-2 px-4">

                    <div
                        class="text-[10px] font-bold
                           text-slate-500
                           uppercase tracking-[0.15em]">
                        Akademik
                    </div>

                </div>


                {{-- ABSENSI --}}

                <a href="{{ route('pengurus.attendances.index') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.attendances.*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.attendances.*') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                    ">

                        <i class="fas fa-calendar-check text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Absensi
                    </span>

                </a>


                {{-- NILAI --}}

                <a href="{{ route('pengurus.scores.index') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.scores.*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.scores.*') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                    ">

                        <i class="fas fa-star text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Nilai
                    </span>

                </a>



                {{-- =================================================
                 KEUANGAN
            ================================================== --}}

                <div class="pt-6 pb-2 px-4">

                    <div
                        class="text-[10px] font-bold
                           text-slate-500
                           uppercase tracking-[0.15em]">
                        Keuangan
                    </div>

                </div>


                {{-- TAGIHAN --}}

                <a href="{{ route('pengurus.invoices.index') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.invoices.*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.invoices.*') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                ">

                        <i class="fas fa-file-invoice text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Tagihan
                    </span>

                </a>


                {{-- PEMBAYARAN --}}

                <a href="{{ route('pengurus.payments.index') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.payments.*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.payments.*') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                ">

                        <i class="fas fa-money-bill-wave text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Pembayaran
                    </span>

                </a>



                {{-- =================================================
                 LAPORAN
            ================================================== --}}

                <div class="pt-6 pb-2 px-4">

                    <div
                        class="text-[10px] font-bold
                           text-slate-500
                           uppercase tracking-[0.15em]">
                        Laporan
                    </div>

                </div>


                {{-- LAPORAN PESERTA --}}

                <a href="{{ route('pengurus.reports.participants') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.reports.participants*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.reports.participants*')
                            ? 'bg-white/15'
                            : 'bg-slate-800 group-hover:bg-slate-700' }}
                ">

                        <i class="fas fa-user-graduate text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Laporan Peserta
                    </span>

                </a>


                {{-- LAPORAN AKADEMIK --}}

                <a href="{{ route('pengurus.reports.academic') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.reports.academic*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.reports.academic*') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                ">

                        <i class="fas fa-chart-line text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Laporan Akademik
                    </span>

                </a>


                {{-- LAPORAN KEUANGAN --}}

                <a href="{{ route('pengurus.reports.finance') }}"
                    class="
                    group flex items-center gap-3
                    px-4 py-3 rounded-xl
                    transition-all duration-200

                    {{ request()->routeIs('pengurus.reports.finance*')
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}
                ">

                    <span
                        class="
                        w-9 h-9 rounded-lg
                        flex items-center justify-center

                        {{ request()->routeIs('pengurus.reports.finance*') ? 'bg-white/15' : 'bg-slate-800 group-hover:bg-slate-700' }}
                ">

                        <i class="fas fa-chart-pie text-sm"></i>

                    </span>


                    <span class="font-medium text-sm">
                        Laporan Keuangan
                    </span>

                </a>


            </nav>



            {{-- =====================================================
             USER PROFILE
        ====================================================== --}}

            <div class="border-t border-slate-800 p-4">


                <div class="rounded-xl bg-slate-900
                       border border-slate-800 p-3">

                    <div class="flex items-center gap-3">


                        {{-- AVATAR --}}

                        <div
                            class="w-10 h-10 rounded-full
                               bg-indigo-500/15
                               border border-indigo-500/20
                               text-indigo-300
                               flex items-center justify-center
                               font-bold">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>


                        {{-- NAME --}}

                        <div class="min-w-0 flex-1">

                            <div class="text-sm font-semibold
                                   text-white truncate">

                                {{ auth()->user()->name }}

                            </div>

                            <div class="text-xs text-slate-500">

                                Pengurus

                            </div>

                        </div>

                    </div>


                    {{-- LOGOUT --}}

                    <form action="{{ route('logout') }}" method="POST" class="mt-3">

                        @csrf

                        <button type="submit"
                            class="
                            w-full flex items-center justify-center gap-2
                            px-3 py-2.5 rounded-lg
                            text-sm font-medium
                            text-slate-400
                            bg-slate-800/60
                            hover:bg-red-500/10
                            hover:text-red-400
                            transition
                        ">

                            <i class="fas fa-sign-out-alt"></i>

                            Keluar

                        </button>

                    </form>

                </div>

            </div>


        </aside>



        {{-- =========================================================
         MAIN
    ========================================================== --}}

        <div class="flex-1 min-w-0">


            {{-- =====================================================
             TOPBAR
        ====================================================== --}}

            <header
                class="
                sticky top-0 z-30
                bg-white/95 backdrop-blur
                border-b border-slate-200
                px-4 sm:px-6 py-3
            ">

                <div class="flex items-center justify-between">


                    {{-- LEFT --}}

                    <div class="flex items-center gap-3">


                        {{-- HAMBURGER MOBILE --}}

                        <button id="openSidebar" type="button"
                            class="
                            md:hidden
                            w-10 h-10
                            rounded-xl
                            bg-slate-100
                            text-slate-700
                            hover:bg-indigo-50
                            hover:text-indigo-600
                            flex items-center justify-center
                            transition
                        ">

                            <i class="fas fa-bars"></i>

                        </button>


                        <div>

                            <h1 class="text-lg sm:text-xl
                                   font-bold text-slate-800">

                                @yield('header', 'Dashboard')

                            </h1>


                            <p class="hidden sm:block text-xs text-slate-400 mt-0.5">

                                Panel Pengurus

                            </p>

                        </div>

                    </div>


                    {{-- RIGHT --}}

                    <div class="flex items-center gap-3">


                        {{-- DATE --}}

                        <div
                            class="
                            hidden sm:flex
                            items-center gap-2
                            px-3 py-2
                            rounded-lg
                            bg-slate-50
                            border border-slate-200
                            text-xs text-slate-500
                        ">

                            <i class="far fa-calendar-alt text-indigo-500"></i>

                            {{ now()->translatedFormat('d F Y') }}

                        </div>


                        {{-- MOBILE USER --}}

                        <div
                            class="
                            md:hidden
                            w-9 h-9 rounded-full
                            bg-indigo-100
                            text-indigo-600
                            flex items-center justify-center
                            font-bold text-sm
                        ">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                    </div>

                </div>

            </header>



            {{-- =====================================================
             CONTENT
        ====================================================== --}}

            <main class="p-4 sm:p-6 lg:p-8">

                @yield('content')

            </main>


        </div>


    </div>



    {{-- =========================================================
     SIDEBAR JAVASCRIPT
========================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const sidebar =
                document.getElementById('sidebar');

            const overlay =
                document.getElementById('sidebarOverlay');

            const openButton =
                document.getElementById('openSidebar');

            const closeButton =
                document.getElementById('closeSidebar');


            function openSidebar() {

                sidebar.classList.remove(
                    '-translate-x-full'
                );

                sidebar.classList.add(
                    'translate-x-0'
                );

                overlay.classList.remove(
                    'hidden'
                );

                document.body.classList.add(
                    'overflow-hidden'
                );

            }


            function closeSidebar() {

                sidebar.classList.remove(
                    'translate-x-0'
                );

                sidebar.classList.add(
                    '-translate-x-full'
                );

                overlay.classList.add(
                    'hidden'
                );

                document.body.classList.remove(
                    'overflow-hidden'
                );

            }


            if (openButton) {

                openButton.addEventListener(
                    'click',
                    openSidebar
                );

            }


            if (closeButton) {

                closeButton.addEventListener(
                    'click',
                    closeSidebar
                );

            }


            if (overlay) {

                overlay.addEventListener(
                    'click',
                    closeSidebar
                );

            }


            /*
            |----------------------------------------------------------
            | Tutup sidebar setelah memilih menu di HP
            |----------------------------------------------------------
            */

            sidebar
                .querySelectorAll('a')
                .forEach(function(link) {

                    link.addEventListener(
                        'click',
                        function() {

                            if (
                                window.innerWidth < 768
                            ) {

                                closeSidebar();

                            }

                        }
                    );

                });


            /*
            |----------------------------------------------------------
            | Jika layar berubah menjadi desktop
            |----------------------------------------------------------
            */

            window.addEventListener(
                'resize',
                function() {

                    if (
                        window.innerWidth >= 768
                    ) {

                        overlay.classList.add(
                            'hidden'
                        );

                        document.body.classList.remove(
                            'overflow-hidden'
                        );

                    }

                }
            );

        });
    </script>


</body>

</html>
