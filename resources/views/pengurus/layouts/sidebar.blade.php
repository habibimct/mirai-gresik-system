<aside id="pengurusSidebar"
    class="fixed inset-y-0 left-0 z-50
           w-64 bg-slate-900 text-white
           transform -translate-x-full
           lg:translate-x-0
           transition-transform duration-300
           flex flex-col">


    {{-- =====================================================
         HEADER SIDEBAR
         ===================================================== --}}

    <div class="h-16 px-5
                flex items-center justify-between
                border-b border-slate-700
                flex-shrink-0">


        <div class="flex items-center gap-3">

            <div class="w-9 h-9 rounded-lg
                        bg-indigo-600
                        flex items-center justify-center">

                <i class="fas fa-building"></i>

            </div>

            <div>

                <div class="font-bold text-lg leading-none">

                    MGS

                </div>

                <div class="text-xs text-slate-400 mt-1">

                    Mirai Gresik System

                </div>

            </div>

        </div>


        {{-- CLOSE MOBILE --}}

        <button id="sidebarClose"
            class="lg:hidden text-slate-400
                   hover:text-white">

            <i class="fas fa-times"></i>

        </button>

    </div>


    {{-- =====================================================
         NAVIGATION
         ===================================================== --}}

    <nav class="flex-1 overflow-y-auto px-3 py-5">


        {{-- DASHBOARD --}}

        <a href="{{ route('pengurus.dashboard') }}"
            class="flex items-center gap-3
                   px-3 py-2.5 mb-2
                   rounded-lg
                   transition

                   {{ request()->routeIs('pengurus.dashboard')
                       ? 'bg-indigo-600 text-white'
                       : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <i class="fas fa-home w-5 text-center"></i>

            <span>
                Dashboard
            </span>

        </a>


        {{-- =================================================
             DATA
             ================================================= --}}

        <div class="mt-6 mb-2 px-3">

            <p class="text-xs font-semibold
                      uppercase tracking-wider
                      text-slate-500">

                Data

            </p>

        </div>


        <a href="#"
            class="menu-item">

            <i class="fas fa-graduation-cap w-5 text-center"></i>

            <span>
                Program
            </span>

        </a>


        <a href="#"
            class="menu-item">

            <i class="fas fa-chalkboard w-5 text-center"></i>

            <span>
                Kelas
            </span>

        </a>


        {{-- =================================================
             AKADEMIK
             ================================================= --}}

        <div class="mt-6 mb-2 px-3">

            <p class="text-xs font-semibold
                      uppercase tracking-wider
                      text-slate-500">

                Akademik

            </p>

        </div>


        <a href="#"
            class="menu-item">

            <i class="fas fa-calendar-check w-5 text-center"></i>

            <span>
                Absensi
            </span>

        </a>


        <a href="#"
            class="menu-item">

            <i class="fas fa-star w-5 text-center"></i>

            <span>
                Nilai
            </span>

        </a>


        {{-- =================================================
             KEUANGAN
             ================================================= --}}

        <div class="mt-6 mb-2 px-3">

            <p class="text-xs font-semibold
                      uppercase tracking-wider
                      text-slate-500">

                Keuangan

            </p>

        </div>


        <a href="#"
            class="menu-item">

            <i class="fas fa-file-invoice-dollar w-5 text-center"></i>

            <span>
                Tagihan
            </span>

        </a>


        <a href="#"
            class="menu-item">

            <i class="fas fa-money-bill-wave w-5 text-center"></i>

            <span>
                Pembayaran
            </span>

        </a>


        {{-- =================================================
             LAPORAN
             ================================================= --}}

        <div class="mt-6 mb-2 px-3">

            <p class="text-xs font-semibold
                      uppercase tracking-wider
                      text-slate-500">

                Laporan

            </p>

        </div>


        <a href="#"
            class="menu-item">

            <i class="fas fa-users w-5 text-center"></i>

            <span>
                Laporan Peserta
            </span>

        </a>


        <a href="#"
            class="menu-item">

            <i class="fas fa-chart-line w-5 text-center"></i>

            <span>
                Laporan Akademik
            </span>

        </a>


        <a href="#"
            class="menu-item">

            <i class="fas fa-chart-pie w-5 text-center"></i>

            <span>
                Laporan Keuangan
            </span>

        </a>

    </nav>


    {{-- =====================================================
         LOGOUT
         ===================================================== --}}

    <div class="p-3 border-t border-slate-700
                flex-shrink-0">

        <form action="{{ route('logout') }}"
            method="POST">

            @csrf

            <button type="submit"
                class="w-full flex items-center gap-3
                       px-3 py-2.5
                       rounded-lg
                       text-slate-300
                       hover:bg-red-600
                       hover:text-white
                       transition">

                <i class="fas fa-sign-out-alt w-5 text-center"></i>

                <span>
                    Keluar
                </span>

            </button>

        </form>

    </div>

</aside>


{{-- =========================================================
     STYLE MENU
     ========================================================= --}}

<style>

    .menu-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.625rem 0.75rem;
        margin-bottom: 0.25rem;
        border-radius: 0.5rem;
        color: rgb(203 213 225);
        transition: all 0.2s;
    }

    .menu-item:hover {
        background-color: rgb(30 41 59);
        color: white;
    }

</style>