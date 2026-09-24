<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.pwa-meta')

    <title>Dashboard Peserta - MGS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-gray-100 min-h-screen">

    <div class="max-w-6xl mx-auto px-4 py-6 sm:py-8">

        {{-- HEADER --}}
        <div class="flex items-center justify-between mb-6">

            <div>

                <p class="text-sm text-gray-500">
                    Mirai Gresik System
                </p>

                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
                    Dashboard Peserta
                </h1>

            </div>

            <x-pwa-install />

            <div class="flex items-center gap-3">


                {{-- USER --}}

                <div
                    class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>


                <div class="hidden sm:block">

                    <p class="text-sm font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-500">
                        Peserta
                    </p>

                </div>


                {{-- LOGOUT --}}

                <form method="POST" action="{{ route('logout') }}" class="ml-2">

                    @csrf

                    <button type="submit"
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-xl
                   text-sm font-medium text-red-600
                   bg-red-50 hover:bg-red-100
                   border border-red-100
                   transition"
                        title="Keluar">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">

                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7" />

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 20H6a2 2 0 01-2-2V6a2 2 0 012-2h7" />

                        </svg>

                        <span class="hidden sm:inline">
                            Keluar
                        </span>

                    </button>

                </form>

            </div>

        </div>


        {{-- WELCOME --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 mb-5">

            <p class="text-sm text-indigo-600 font-semibold mb-1">
                Selamat datang 👋
            </p>

            <h2 class="text-2xl font-bold text-gray-800">

                {{ auth()->user()->name }}

            </h2>

            <p class="text-sm text-gray-500 mt-2">

                Pantau informasi pelatihan dan pembayaran Anda
                melalui Mirai Gresik System.

            </p>

        </div>


        {{-- RINGKASAN --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">


            {{-- TOTAL TAGIHAN --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

                <p class="text-sm text-gray-500">
                    Total Tagihan
                </p>

                <p class="text-xl font-bold text-gray-800 mt-2">
                    Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                </p>

            </div>


            {{-- SUDAH DIBAYAR --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

                <p class="text-sm text-gray-500">
                    Sudah Dibayar
                </p>

                <p class="text-xl font-bold text-green-600 mt-2">
                    Rp {{ number_format($sudahDibayar, 0, ',', '.') }}
                </p>

            </div>


            {{-- SISA --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

                <p class="text-sm text-gray-500">
                    Sisa Tagihan
                </p>

                <p class="text-xl font-bold text-indigo-600 mt-2">
                    Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                </p>

            </div>


        </div>


        {{-- STATUS PEMBAYARAN --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6 mb-5">

            <div class="flex items-center justify-between mb-3">

                <div>

                    <p class="text-sm text-gray-500">
                        Status Pembayaran
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $statusPembayaran }}
                    </p>

                </div>
                @if ($statusPembayaran === 'Lunas')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full
                        text-xs font-semibold
                        bg-green-100 text-green-700">

                        Lunas

                    </span>
                @elseif ($statusPembayaran === 'Sebagian')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full
                        text-xs font-semibold
                        bg-yellow-100 text-yellow-700">

                        Belum Lunas

                    </span>
                @elseif ($statusPembayaran === 'Belum Bayar')
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full
                        text-xs font-semibold
                        bg-red-100 text-red-700">

                        Belum Bayar

                    </span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full
                        text-xs font-semibold
                        bg-gray-100 text-gray-600">

                        Belum Ada Tagihan

                    </span>
                @endif

            </div>


            <div class="w-full bg-gray-200 rounded-full h-3">

                <div class="bg-indigo-600 h-3 rounded-full transition-all duration-500"
                    style="width: {{ $persentase }}%">
                </div>

            </div>


            <div class="flex justify-between mt-2 text-xs text-gray-500">

                <span>
                    {{ $persentase }}% sudah dibayar
                </span>
                <span>
                    Rp {{ number_format($sisaTagihan, 0, ',', '.') }} tersisa
                </span>

            </div>

        </div>


        {{-- MENU UTAMA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">


            {{-- TAGIHAN --}}
            <a href="{{ route('participant.invoices.index') }}"
                class="group bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-indigo-200 transition">

                <div class="flex items-start justify-between">

                    <div>

                        <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center text-xl mb-4">

                            💳

                        </div>

                        <h3 class="font-bold text-gray-800 text-lg">

                            Tagihan Saya

                        </h3>

                        <p class="text-sm text-gray-500 mt-1">

                            Lihat rincian tagihan dan lakukan pembayaran.

                        </p>

                    </div>


                    <span class="text-indigo-600 group-hover:translate-x-1 transition">

                        →

                    </span>

                </div>

            </a>


            {{-- PROGRAM --}}
            <a href="{{ route('participant.program.index') }}"
                class="group block bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sm:p-6 hover:shadow-md hover:border-green-200 transition">

                <div class="flex items-start justify-between">

                    <div>

                        <div class="w-11 h-11 rounded-xl bg-green-100 flex items-center justify-center text-xl mb-4">

                            📚

                        </div>

                        <h3 class="font-bold text-gray-800 text-lg">
                            Program Saya
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Lihat program, absensi, dan penilaian.
                        </p>

                    </div>

                    <span class="text-green-600 group-hover:translate-x-1 transition">

                        →

                    </span>

                </div>

            </a>


        </div>


        {{-- FOOTER --}}
        <div class="text-center text-xs text-gray-400 py-4">

            Mirai Gresik System

        </div>


    </div>

</body>

</html>
