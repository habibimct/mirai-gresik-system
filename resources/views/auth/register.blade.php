<x-guest-layout>

    <div class="relative min-h-screen overflow-hidden bg-slate-950">

        {{-- =========================
            BACKGROUND
        ========================== --}}

        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            {{-- Background image --}}
            <div
                class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1920&q=80');">
            </div>

            {{-- Dark overlay --}}
            <div class="absolute inset-0 bg-slate-950/65"></div>

            {{-- Blue MGS tone --}}
            <div class="absolute inset-0 bg-blue-950/20"></div>

        </div>


        {{-- =========================
            REGISTER CARD
        ========================== --}}

        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8">

            <div
                class="w-full max-w-md rounded-2xl border border-white/10
                       bg-slate-100/100 p-6 shadow-2xl backdrop-blur-md
                       sm:p-8">

                {{-- =========================
                    LOGO / HEADER
                ========================== --}}

                <div class="mb-6 text-center">

                    <div class="mb-3 flex justify-center">

                        <div
                            class="flex h-14 w-14 items-center justify-center
                                   rounded-xl bg-blue-600/20
                                   ring-1 ring-blue-400/20">

                            <span class="text-2xl font-bold text-blue-700">
                                MGS
                            </span>

                        </div>

                    </div>

                    <h1 class="text-xl font-bold tracking-wide text-dark">
                        MIRAI GRESIK SYSTEM
                    </h1>

                    <p class="mt-1 text-sm text-slate-800">
                        Buat akun baru
                    </p>

                </div>


                {{-- =========================
                    FORM
                ========================== --}}

                <form method="POST" action="{{ route('register') }}">

                    @csrf


                    {{-- NAME --}}

                    <div>

                        <x-input-label
                            for="name"
                            :value="__('Name')"
                            class="text-slate-800"
                        />

                        <x-text-input
                            id="name"
                            class="mt-1 block w-full
                                   border-slate-800 bg-slate-200/70
                                   text-dark placeholder-slate-400
                                   focus:border-blue-500 focus:ring-blue-500"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Nama lengkap"
                        />

                        <x-input-error
                            :messages="$errors->get('name')"
                            class="mt-2"
                        />

                    </div>


                    {{-- EMAIL --}}

                    <div class="mt-4">

                        <x-input-label
                            for="email"
                            :value="__('Email')"
                            class="text-slate-800"
                        />

                        <x-text-input
                            id="email"
                            class="mt-1 block w-full
                                   border-slate-700 bg-slate-200/70
                                   text-dark placeholder-slate-400
                                   focus:border-blue-500 focus:ring-blue-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                            placeholder="nama@email.com"
                        />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2"
                        />

                    </div>


                    {{-- PASSWORD --}}

                    <div class="mt-4">

                        <x-input-label
                            for="password"
                            :value="__('Password')"
                            class="text-slate-800"
                        />

                        <x-text-input
                            id="password"
                            class="mt-1 block w-full
                                   border-slate-700 bg-slate-200/70
                                   text-dark placeholder-slate-400
                                   focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            placeholder="Masukkan password"
                        />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2"
                        />

                    </div>


                    {{-- CONFIRM PASSWORD --}}

                    <div class="mt-4">

                        <x-input-label
                            for="password_confirmation"
                            :value="__('Confirm Password')"
                            class="text-slate-800"
                        />

                        <x-text-input
                            id="password_confirmation"
                            class="mt-1 block w-full
                                   border-slate-700 bg-slate-200/70
                                   text-dark placeholder-slate-400
                                   focus:border-blue-500 focus:ring-blue-500"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Ulangi password"
                        />

                        <x-input-error
                            :messages="$errors->get('password_confirmation')"
                            class="mt-2"
                        />

                    </div>


                    {{-- =========================
                        ACTION
                    ========================== --}}

                    <div class="mt-6">

                        <x-primary-button
                            class="w-full justify-center
                                   bg-blue-100 py-3 text-sm font-semibold
                                   hover:bg-blue-500
                                   focus:bg-blue-500
                                   active:bg-blue-300">

                            {{ __('Register') }}

                        </x-primary-button>

                    </div>


                    {{-- =========================
                        LOGIN LINK
                    ========================== --}}

                    <div class="mt-5 text-center">

                        <span class="text-sm text-slate-700">
                            Sudah memiliki akun?
                        </span>

                        <a
                            href="{{ route('login') }}"
                            class="ml-1 text-sm font-semibold text-blue-700
                                   hover:text-blue-400 hover:underline">

                            Masuk sekarang

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-guest-layout>