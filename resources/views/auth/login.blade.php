<x-guest-layout>

    <div class="relative min-h-screen overflow-hidden bg-[#0f172a]">

        {{-- =========================
        BACKGROUND LOGIN
        ========================== --}}

        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            {{-- Background dari internet --}}
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1920&q=80');">
            </div>

            {{-- Lapisan gelap --}}
            <div class="absolute inset-0 bg-slate-950/70"></div>

            {{-- Nuansa biru MGS --}}
            <div class="absolute inset-0 bg-blue-950/20"></div>

        </div>


        {{-- =========================================================
        MAIN CONTAINER
        ========================================================== --}}
        <div
            class="relative flex min-h-screen items-center justify-center px-2 py-4
                   sm:px-6 sm:py-8
                   lg:px-8">

            {{-- =====================================================
            LOGIN CARD

            HP      : sekitar 2/3 lebar layar
            TABLET  : 460px
            DESKTOP : 1024px + 2 kolom
            ====================================================== --}}
            <div
                class="grid
                       w-[66.666vw]
                       max-w-[300px]
                       overflow-hidden
                       rounded-2xl
                       border border-white/10
                       bg-white
                       shadow-2xl

                       sm:w-full
                       sm:max-w-[460px]

                       lg:max-w-5xl
                       lg:grid-cols-2
                       lg:rounded-3xl">


                {{-- =================================================
                LEFT SIDE / BRANDING
                HIDDEN PADA HP & TABLET KECIL
                ================================================== --}}
                <div
                    class="relative hidden flex-col justify-between overflow-hidden
                           bg-gradient-to-br from-blue-700 via-indigo-700 to-violet-800
                           p-8 text-white
                           lg:flex
                           xl:p-12">

                    {{-- Decorative circles --}}
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full border border-white/10">
                    </div>

                    <div class="absolute -bottom-32 -left-32 h-80 w-80 rounded-full border border-white/10">
                    </div>

                    <div class="absolute right-10 top-1/2 h-32 w-32 rounded-full bg-white/5 blur-2xl">
                    </div>


                    {{-- Brand --}}
                    <div class="relative z-10">

                        <div class="flex items-center gap-4">

                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-xl">

                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl
                                           bg-gradient-to-br from-blue-600 to-indigo-600">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">

                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5
                                               S4.168 5.477 3 6.253v13
                                               C4.168 18.477 5.754 18 7.5 18
                                               s3.332.477 4.5 1.253m0-13
                                               C13.168 5.477 14.754 5 16.5 5
                                               c1.746 0 3.332.477 4.5 1.253v13
                                               C19.832 18.477 18.246 18 16.5 18
                                               c-1.746 0-3.332.477-4.5 1.253" />

                                    </svg>

                                </div>

                            </div>

                            <div>

                                <p class="text-xs font-medium uppercase tracking-[0.2em] text-blue-200">

                                    Sistem Informasi

                                </p>

                                <h1 class="mt-1 text-xl font-extrabold tracking-wide">

                                    MIRAI GRESIK

                                </h1>

                            </div>

                        </div>

                    </div>


                    {{-- Main Message --}}
                    <div class="relative z-10 my-auto max-w-md py-12">

                        <div
                            class="mb-6 inline-flex items-center gap-2 rounded-full
                                   border border-white/10 bg-white/10
                                   px-4 py-2 text-xs font-medium
                                   text-blue-100 backdrop-blur">

                            <span
                                class="h-2 w-2 rounded-full bg-emerald-400
                                       shadow-[0_0_10px_rgba(52,211,153,0.8)]">
                            </span>

                            Sistem Terintegrasi

                        </div>


                        <h2 class="text-4xl font-extrabold leading-tight xl:text-5xl">

                            Kelola Sistem

                            <span class="text-blue-200">
                                Lebih Mudah.
                            </span>

                        </h2>


                        <p class="mt-5 max-w-sm text-sm leading-7 text-blue-100/80 xl:text-base">

                            Selamat datang di MIRAI GRESIK SYSTEM.
                            Akses berbagai kebutuhan administrasi dan informasi
                            LPK Mirai Gresik dalam satu sistem terintegrasi.

                        </p>


                        {{-- Features --}}
                        <div class="mt-8 grid grid-cols-2 gap-3">

                            {{-- Aman --}}
                            <div
                                class="rounded-2xl border border-white/10
                                       bg-white/10 p-4 backdrop-blur-sm">

                                <div
                                    class="mb-3 flex h-9 w-9 items-center justify-center
                                           rounded-xl bg-white/10">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6
                                               a2 2 0 00-2-2H6a2 2 0 00-2 2v6
                                               a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v2h8z" />

                                    </svg>

                                </div>

                                <p class="text-sm font-semibold">
                                    Aman
                                </p>

                                <p class="mt-1 text-xs text-blue-100/60">
                                    Akses terlindungi
                                </p>

                            </div>


                            {{-- Efisien --}}
                            <div
                                class="rounded-2xl border border-white/10
                                       bg-white/10 p-4 backdrop-blur-sm">

                                <div
                                    class="mb-3 flex h-9 w-9 items-center justify-center
                                           rounded-xl bg-white/10">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />

                                    </svg>

                                </div>

                                <p class="text-sm font-semibold">
                                    Efisien
                                </p>

                                <p class="mt-1 text-xs text-blue-100/60">
                                    Cepat & terintegrasi
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Left Footer --}}
                    <div class="relative z-10">

                        <p class="text-xs text-blue-100/60">

                            © {{ date('Y') }} LPK Mirai Gresik

                        </p>

                    </div>

                </div>


                {{-- =================================================
                RIGHT SIDE / LOGIN
                ================================================== --}}
                <div
                    class="flex items-center justify-center
                           bg-white
                           px-3 py-4
                           sm:p-10
                           lg:p-12
                           xl:p-16">

                    <div class="w-full max-w-md">


                        {{-- =================================================
                        MOBILE BRAND
                        ================================================== --}}
                        <div class="mb-3 text-center lg:hidden">

                            <div
                                class="mx-auto mb-2 flex h-10 w-10 items-center
                                       justify-center rounded-xl
                                       bg-gradient-to-br from-blue-600 to-indigo-600
                                       shadow-lg shadow-blue-500/20">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">

                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5
                                           S4.168 5.477 3 6.253v13
                                           C4.168 18.477 5.754 18 7.5 18
                                           s3.332.477 4.5 1.253m0-13
                                           C13.168 5.477 14.754 5 16.5 5
                                           c1.746 0 3.332.477 4.5 1.253v13
                                           C19.832 18.477 18.246 18 16.5 18
                                           c-1.746 0-3.332.477-4.5 1.253" />

                                </svg>

                            </div>


                            <h1
                                class="text-lg font-extrabold tracking-tight
                                       text-slate-900
                                       sm:text-2xl">

                                MIRAI GRESIK

                            </h1>


                            <p
                                class="mt-1 text-[10px] font-medium text-slate-500
                                       sm:text-xs">

                                Sistem Informasi Terintegrasi

                            </p>

                        </div>


                        {{-- =================================================
                        LOGIN HEADING
                        ================================================== --}}
                        <div class="mb-4 sm:mb-5">

                            <div
                                class="mb-2 flex h-9 w-9 items-center justify-center
                                       rounded-xl bg-blue-50
                                       sm:mb-3 sm:h-11 sm:w-11">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h12
                                           m-5 4v1a3 3 0 01-3 3H6
                                           a3 3 0 01-3-3V7a3 3 0 013-3h5
                                           a3 3 0 013 3v1" />

                                </svg>

                            </div>


                            <h2
                                class="text-lg font-extrabold tracking-tight
                                       text-slate-900
                                       sm:text-3xl">

                                Selamat Datang

                            </h2>


                            <p
                                class="mt-1 text-[10px] leading-5 text-slate-500
                                       sm:mt-2 sm:text-sm sm:leading-6">

                                Silakan masuk menggunakan akun Anda
                                untuk melanjutkan ke sistem.

                            </p>

                        </div>


                        {{-- =================================================
                        SESSION STATUS
                        ================================================== --}}
                        <x-auth-session-status class="mb-3" :status="session('status')" />


                        {{-- =================================================
                        LOGIN FORM
                        ================================================== --}}
                        <form method="POST" action="{{ route('login') }}" class="space-y-3 sm:space-y-5">

                            @csrf


                            {{-- ================= EMAIL ================= --}}
                            <div>

                                <x-input-label for="email" value="Email"
                                    class="mb-1 text-xs font-semibold text-slate-700 sm:mb-2 sm:text-sm" />

                                <div class="group relative">

                                    {{-- Icon --}}
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0
                                               flex items-center pl-2.5
                                               sm:pl-3.5">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-slate-400 transition
                                                   group-focus-within:text-blue-500
                                                   sm:h-5 sm:w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10
                                                   a2 2 0 01-2 2H5a2 2 0 01-2-2V7
                                                   a2 2 0 012-2z" />

                                        </svg>

                                    </div>


                                    <x-text-input id="email"
                                        class="block min-h-[40px] w-full rounded-xl
                                               border-slate-300 bg-slate-50
                                               py-2 pl-9 pr-3
                                               text-xs text-slate-900
                                               transition
                                               placeholder:text-slate-400
                                               focus:border-blue-500
                                               focus:bg-white
                                               focus:ring-4
                                               focus:ring-blue-500/10

                                               sm:min-h-[50px]
                                               sm:py-3
                                               sm:pl-11
                                               sm:pr-4
                                               sm:text-base"
                                        type="email" name="email" :value="old('email')" required autofocus
                                        autocomplete="username" placeholder="nama@email.com" />

                                </div>


                                <x-input-error :messages="$errors->get('email')" class="mt-1 text-[10px] sm:mt-2 sm:text-sm" />

                            </div>


                            {{-- ================= PASSWORD ================= --}}
                            <div>

                                <x-input-label for="password" value="Password"
                                    class="text-xs font-semibold text-slate-700 sm:text-sm" />


                                <div class="group relative mt-1 sm:mt-2">

                                    {{-- Icon --}}
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0
                                               flex items-center pl-2.5
                                               sm:pl-3.5">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-slate-400 transition
                                                   group-focus-within:text-blue-500
                                                   sm:h-5 sm:w-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6
                                                   a2 2 0 00-2-2H6a2 2 0 00-2 2v6
                                                   a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v2h8z" />

                                        </svg>

                                    </div>


                                    <x-text-input id="password"
                                        class="block min-h-[40px] w-full rounded-xl
                                               border-slate-300 bg-slate-50
                                               py-2 pl-9 pr-3
                                               text-xs text-slate-900
                                               transition
                                               placeholder:text-slate-400
                                               focus:border-blue-500
                                               focus:bg-white
                                               focus:ring-4
                                               focus:ring-blue-500/10

                                               sm:min-h-[50px]
                                               sm:py-3
                                               sm:pl-11
                                               sm:pr-4
                                               sm:text-base"
                                        type="password" name="password" required autocomplete="current-password"
                                        placeholder="Masukkan password" />

                                </div>


                                <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px] sm:mt-2 sm:text-sm" />

                            </div>


                            {{-- =================================================
                            REMEMBER + FORGOT PASSWORD
                            ================================================== --}}
                            <div
                                class="flex items-center justify-between
                                       gap-2 pt-0.5
                                       sm:gap-4 sm:pt-1">

                                <label for="remember_me" class="inline-flex cursor-pointer items-center">

                                    <input id="remember_me" type="checkbox"
                                        class="h-3.5 w-3.5 rounded
                                               border-slate-300
                                               text-blue-600 shadow-sm
                                               focus:ring-2
                                               focus:ring-blue-500/20
                                               sm:h-4 sm:w-4"
                                        name="remember">


                                    <span
                                        class="ms-1.5 text-[10px] text-slate-600
                                               sm:ms-2 sm:text-sm">

                                        Ingat saya

                                    </span>

                                </label>


                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-[10px] font-semibold text-blue-600
                                               transition
                                               hover:text-blue-800
                                               hover:underline
                                               sm:text-sm">

                                        Lupa password?

                                    </a>
                                @endif

                            </div>


                            {{-- =================================================
                            LOGIN BUTTON
                            ================================================== --}}
                            <button type="submit"
                                class="group flex min-h-[44px] w-full
                                       items-center justify-center
                                       gap-1.5 rounded-xl
                                       bg-gradient-to-r from-blue-600 to-indigo-600
                                       px-3 py-2
                                       text-[11px] font-bold text-white
                                       shadow-lg shadow-blue-500/20
                                       transition duration-200
                                       hover:-translate-y-0.5
                                       hover:from-blue-700
                                       hover:to-indigo-700
                                       hover:shadow-xl
                                       hover:shadow-blue-500/25
                                       focus:outline-none
                                       focus:ring-4
                                       focus:ring-blue-500/20
                                       active:translate-y-0

                                       sm:min-h-[52px]
                                       sm:gap-2
                                       sm:px-5
                                       sm:py-3
                                       sm:text-base">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 transition-transform duration-200
                                           group-hover:translate-x-0.5
                                           sm:h-5 sm:w-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h12
                                           m-5 4v1a3 3 0 01-3 3H6
                                           a3 3 0 01-3-3V7a3 3 0 013-3h5
                                           a3 3 0 013 3v1" />

                                </svg>

                                Masuk ke Sistem

                            </button>

                        </form>

                        {{-- =========================
                        LOGIN LINK
                        ========================== --}}

                        <div class="mt-5 text-center">

                            <span class="text-sm text-slate-700">
                                Belum memiliki akun?
                            </span>

                            <a href="{{ route('register') }}"
                                class="ml-1 text-sm font-semibold text-blue-700
                                   hover:text-blue-400 hover:underline">

                                Daftar sekarang

                            </a>

                        </div>

                        {{-- =================================================
                        FOOTER
                        ================================================== --}}
                        <div
                            class="mt-4 border-t border-slate-100 pt-4 text-center
                                   sm:mt-8 sm:pt-6">

                            <p class="text-[9px] text-slate-400
                                       sm:text-xs">

                                © {{ date('Y') }}

                                <span class="font-semibold text-slate-600">
                                    LPK Mirai Gresik
                                </span>

                            </p>


                            <p
                                class="mt-1 text-[8px] font-medium uppercase
                                       tracking-widest text-slate-300
                                       sm:text-[10px]">

                                MIRAI GRESIK SYSTEM

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>
