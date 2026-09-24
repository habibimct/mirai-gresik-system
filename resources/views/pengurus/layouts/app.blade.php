<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.pwa-meta')

    <title>
        @yield('title', 'Pengurus') - MGS
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @stack('styles')

</head>

<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex">

        {{-- =====================================================
             SIDEBAR
             ===================================================== --}}

        @include('pengurus.layouts.sidebar')


        {{-- =====================================================
             AREA UTAMA
             ===================================================== --}}

        <div class="flex-1 min-w-0 lg:ml-0">


            {{-- =================================================
                 TOPBAR
                 ================================================= --}}

            <header class="h-16 bg-white border-b border-gray-200
                           sticky top-0 z-30">

                <div class="h-full px-4 sm:px-6
                            flex items-center justify-between">


                    {{-- MOBILE MENU --}}

                    <button type="button"
                        id="sidebarOpen"
                        class="lg:hidden w-10 h-10
                               flex items-center justify-center
                               rounded-lg text-gray-600
                               hover:bg-gray-100">

                        <i class="fas fa-bars"></i>

                    </button>


                    {{-- PAGE TITLE --}}

                    <div class="hidden lg:block">

                        <h2 class="font-semibold text-gray-800">

                            @yield('page_title', 'Dashboard')

                        </h2>

                    </div>


                    {{-- USER --}}

                    <div class="flex items-center gap-3 ml-auto">

                        <div class="hidden sm:block text-right">

                            <p class="text-sm font-semibold text-gray-800">

                                {{ auth()->user()->name }}

                            </p>

                            <p class="text-xs text-gray-500">

                                Pengurus

                            </p>

                        </div>


                        <div class="w-10 h-10 rounded-full
                                    bg-indigo-600 text-white
                                    flex items-center justify-center">

                            <i class="fas fa-user"></i>

                        </div>

                    </div>

                </div>

            </header>


            {{-- =================================================
                 CONTENT
                 ================================================= --}}

            <main class="p-4 sm:p-6 lg:p-8">

                @yield('content')

            </main>


        </div>

    </div>


    {{-- =========================================================
         MOBILE OVERLAY
         ========================================================= --}}

    <div id="sidebarOverlay"
        class="fixed inset-0 bg-black/50 z-40
               hidden lg:hidden">
    </div>


    {{-- =========================================================
         SIDEBAR JAVASCRIPT
         ========================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const sidebar =
                document.getElementById('pengurusSidebar');

            const sidebarOpen =
                document.getElementById('sidebarOpen');

            const sidebarClose =
                document.getElementById('sidebarClose');

            const overlay =
                document.getElementById('sidebarOverlay');


            function openSidebar() {

                sidebar.classList.remove('-translate-x-full');

                overlay.classList.remove('hidden');

            }


            function closeSidebar() {

                sidebar.classList.add('-translate-x-full');

                overlay.classList.add('hidden');

            }


            if (sidebarOpen) {

                sidebarOpen.addEventListener(
                    'click',
                    openSidebar
                );

            }


            if (sidebarClose) {

                sidebarClose.addEventListener(
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

        });

    </script>


    @stack('scripts')

</body>

</html>
