@extends('layouts.pengurus')

@section('title', 'Dashboard Pengurus')

@section('page_title', 'Dashboard')

@section('content')

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Dashboard Pengurus
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Ringkasan informasi LPK Mirai Gresik.
        </p>

    </div>


    {{-- =========================================================
         STATISTIK
    ========================================================== --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">


        {{-- PROGRAM --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Program
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalPrograms }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Program tersedia
                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl
                            bg-indigo-50 text-indigo-600
                            flex items-center justify-center">

                    <i class="fas fa-graduation-cap text-xl"></i>

                </div>

            </div>

        </div>


        {{-- KELAS --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Kelas
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalClassrooms }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Kelas pelatihan
                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl
                            bg-blue-50 text-blue-600
                            flex items-center justify-center">

                    <i class="fas fa-school text-xl"></i>

                </div>

            </div>

        </div>


        {{-- PESERTA AKTIF --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Peserta Aktif
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalActiveParticipants }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Sedang mengikuti pelatihan
                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl
                            bg-green-50 text-green-600
                            flex items-center justify-center">

                    <i class="fas fa-user-check text-xl"></i>

                </div>

            </div>

        </div>


        {{-- PESERTA LULUS --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-gray-500">
                        Peserta Lulus
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $totalGraduatedParticipants }}
                    </p>

                    <p class="text-xs text-gray-400 mt-1">
                        Telah menyelesaikan pelatihan
                    </p>

                </div>

                <div class="w-12 h-12 rounded-xl
                            bg-emerald-50 text-emerald-600
                            flex items-center justify-center">

                    <i class="fas fa-user-graduate text-xl"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         INFORMASI PENGURUS
    ========================================================== --}}

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mt-6">


        {{-- AKSES --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-200">

                <div class="flex items-center gap-3">

                    <div class="w-9 h-9 rounded-lg
                                bg-blue-50 text-blue-600
                                flex items-center justify-center">

                        <i class="fas fa-shield-alt"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-gray-800">
                            Akses Pengurus
                        </h3>

                        <p class="text-xs text-gray-400">
                            Hak akses sistem
                        </p>

                    </div>

                </div>

            </div>

            <div class="p-5">

                <p class="text-sm text-gray-600 leading-relaxed">

                    Pengurus dapat melihat informasi mengenai
                    program, kelas, akademik, keuangan, dan laporan
                    tanpa dapat mengubah data sistem.

                </p>

                <div class="mt-4 flex items-start gap-3
                            bg-blue-50 border border-blue-100
                            rounded-xl p-4 text-sm text-blue-700">

                    <i class="fas fa-info-circle mt-0.5"></i>

                    <div>

                        <p class="font-semibold">
                            Mode Read-Only
                        </p>

                        <p class="text-blue-600 mt-1">
                            Data hanya dapat dilihat dan tidak dapat
                            ditambah, diubah, atau dihapus.

                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- INFORMASI SISTEM --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-200">

                <div class="flex items-center gap-3">

                    <div class="w-9 h-9 rounded-lg
                                bg-indigo-50 text-indigo-600
                                flex items-center justify-center">

                        <i class="fas fa-cogs"></i>

                    </div>

                    <div>

                        <h3 class="font-semibold text-gray-800">
                            Informasi Sistem
                        </h3>

                        <p class="text-xs text-gray-400">
                            Informasi akses Anda
                        </p>

                    </div>

                </div>

            </div>

            <div class="p-5">

                <div class="flex items-center justify-between
                            py-3 border-b border-gray-100">

                    <span class="text-sm text-gray-500">
                        Sistem
                    </span>

                    <span class="text-sm font-semibold text-gray-800">
                        Mirai Gresik System
                    </span>

                </div>

                <div class="flex items-center justify-between
                            py-3">

                    <span class="text-sm text-gray-500">
                        Role
                    </span>

                    <span class="inline-flex items-center
                                 px-3 py-1 rounded-full
                                 bg-indigo-50 text-indigo-700
                                 text-xs font-semibold">

                        <i class="fas fa-user-tie mr-1.5"></i>

                        Pengurus

                    </span>

                </div>

            </div>

        </div>

    </div>

@endsection