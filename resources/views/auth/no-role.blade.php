<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-slate-900 px-4">

        <div class="w-full max-w-md">

            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">

                {{-- Icon --}}
                <div class="mx-auto mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100">
                    <svg class="h-8 w-8 text-amber-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14A2 2 0 003.82 21h16.36a2 2 0 001.71-3.14l-8.18-14a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>

                {{-- Title --}}
                <h2 class="text-xl font-semibold text-gray-800">
                    Akun Belum Memiliki Akses
                </h2>

                {{-- Message --}}
                <p class="mt-3 text-sm leading-6 text-gray-600">
                    Akun Anda berhasil dibuat dan berhasil login,
                    tetapi akun ini belum memiliki role atau hak akses.
                </p>

                <div class="mt-5 rounded-lg bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-800">
                    Silakan hubungi <strong>Administrator</strong>
                    untuk mendapatkan role dan akses ke sistem.
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="mt-6">
                    @csrf

                    <button type="submit"
                        class="w-full rounded-lg bg-gray-800 px-4 py-3 text-sm font-medium text-white transition hover:bg-gray-700">
                        Logout
                    </button>
                </form>

            </div>

            <p class="mt-5 text-center text-xs text-gray-400">
                Mirai Gresik System
            </p>

        </div>

    </div>

</x-guest-layout>
