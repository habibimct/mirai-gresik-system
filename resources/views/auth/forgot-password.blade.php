<x-guest-layout>

    <div class="relative min-h-screen overflow-hidden bg-slate-950">

        {{-- =========================
            BACKGROUND
        ========================== --}}

        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            {{-- Background image --}}
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1920&q=80');">
            </div>

            {{-- Dark overlay --}}
            <div class="absolute inset-0 bg-slate-950/65"></div>

            {{-- Blue MGS tone --}}
            <div class="absolute inset-0 bg-blue-950/20"></div>

        </div>


        {{-- =========================
            FORGOT PASSWORD CARD
        ========================== --}}

        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8">

            <div
                class="w-full max-w-md rounded-2xl
                       bg-white p-6 shadow-2xl
                       sm:p-8">

                {{-- =========================
                    HEADER
                ========================== --}}

                <div class="mb-6 text-center">

                    <div class="mb-4 flex justify-center">

                        <div
                            class="flex h-14 w-14 items-center justify-center
                            rounded-xl bg-blue-50
                            ring-1 ring-blue-100">

                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8" class="h-7 w-7 text-blue-600">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V7.75a4.5 4.5 0 0 0-9 0v2.75m-1.25 0h11.5A1.25 1.25 0 0 1 19 11.75v7A1.25 1.25 0 0 1 17.75 20H6.25A1.25 1.25 0 0 1 5 18.75v-7a1.25 1.25 0 0 1 1.25-1.25Z" />

                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14.25v2" />

                            </svg>

                        </div>

                    </div>

                    <h1 class="text-xl font-bold tracking-wide text-slate-800">
                        Lupa Password?
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Tidak masalah. Masukkan alamat email Anda dan kami akan
                        mengirimkan tautan untuk membuat password baru.
                    </p>

                </div>


                {{-- =========================
                    SESSION STATUS
                ========================== --}}

                <x-auth-session-status class="mb-4" :status="session('status')" />


                {{-- =========================
                    FORM
                ========================== --}}

                <form method="POST" action="{{ route('password.email') }}">

                    @csrf


                    {{-- EMAIL --}}

                    <div>

                        <x-input-label for="email" :value="__('Email')" class="text-slate-700" />

                        <x-text-input id="email"
                            class="mt-1 block w-full
                                   border-slate-300 bg-white
                                   text-slate-800
                                   placeholder-slate-400
                                   focus:border-blue-500
                                   focus:ring-blue-500"
                            type="email" name="email" :value="old('email')" required autofocus
                            placeholder="nama@email.com" />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    </div>


                    {{-- =========================
                        BUTTON
                    ========================== --}}

                    <div class="mt-6">

                        <x-primary-button
                            class="w-full justify-center
                                   bg-blue-600 py-3
                                   text-sm font-semibold
                                   hover:bg-blue-500
                                   focus:bg-blue-500
                                   active:bg-blue-700">

                            <i class="fas fa-paper-plane mr-2"></i>

                            Kirim Link Reset Password

                        </x-primary-button>

                    </div>


                    {{-- =========================
                        BACK TO LOGIN
                    ========================== --}}

                    <div class="mt-5 text-center">

                        <a href="{{ route('login') }}"
                            class="text-sm font-semibold text-blue-600
                                   hover:text-blue-700 hover:underline">

                            <i class="fas fa-arrow-left mr-1"></i>

                            Kembali ke Login

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-guest-layout>
