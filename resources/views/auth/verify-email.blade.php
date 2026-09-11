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
            VERIFICATION CARD
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

                    {{-- Email Icon --}}
                    <div class="mb-4 flex justify-center">

                        <div
                            class="flex h-14 w-14 items-center justify-center
                                   rounded-xl bg-blue-50
                                   ring-1 ring-blue-100">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                class="h-7 w-7 text-blue-600">

                                <rect
                                    x="3"
                                    y="5"
                                    width="18"
                                    height="14"
                                    rx="2" />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m3 7 7.94 5.293a2 2 0 0 0 2.12 0L21 7" />

                            </svg>

                        </div>

                    </div>


                    <h1 class="text-xl font-bold tracking-wide text-slate-800">
                        Verifikasi Email
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Terima kasih telah mendaftar.
                        Silakan periksa email Anda untuk melakukan verifikasi
                        sebelum melanjutkan menggunakan sistem.
                    </p>

                </div>


                {{-- =========================
                    INFORMATION
                ========================== --}}

                <div
                    class="mb-5 rounded-xl border border-blue-100
                           bg-blue-50 px-4 py-3">

                    <p class="text-sm leading-5 text-blue-700">
                        Jika Anda belum menerima email verifikasi,
                        silakan kirim ulang tautan verifikasi di bawah ini.
                    </p>

                </div>


                {{-- =========================
                    SUCCESS MESSAGE
                ========================== --}}

                @if (session('status') == 'verification-link-sent')

                    <div
                        class="mb-5 rounded-xl border border-green-200
                               bg-green-50 px-4 py-3">

                        <p class="text-sm leading-5 text-green-700">
                            Tautan verifikasi baru telah dikirim ke alamat
                            email yang Anda gunakan saat mendaftar.
                        </p>

                    </div>

                @endif


                {{-- =========================
                    RESEND VERIFICATION
                ========================== --}}

                <form method="POST" action="{{ route('verification.send') }}">

                    @csrf

                    <x-primary-button
                        class="w-full justify-center
                               bg-blue-600 py-3
                               text-sm font-semibold
                               hover:bg-blue-500
                               focus:bg-blue-500
                               active:bg-blue-700">

                        Kirim Ulang Email Verifikasi

                    </x-primary-button>

                </form>


                {{-- =========================
                    LOGOUT
                ========================== --}}

                <div class="mt-5 text-center">

                    <form method="POST" action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="text-sm font-semibold
                                   text-slate-500
                                   hover:text-slate-700
                                   hover:underline
                                   focus:outline-none">

                            Keluar dari Akun

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>