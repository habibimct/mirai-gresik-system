@extends('layouts.pengurus')

@section('title', 'Kelas')

@section('page_title', 'Kelas')

@section('content')

    {{-- HEADER --}}
    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Kelas
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Informasi kelas pelatihan beserta jumlah peserta.
        </p>

    </div>


    {{-- RINGKASAN --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        {{-- TOTAL KELAS --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total Kelas
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-1">
                        {{ $classrooms->count() }}
                    </p>

                </div>

                <div
                    class="w-11 h-11 rounded-xl
                            bg-blue-50 text-blue-600
                            flex items-center justify-center">

                    <i class="fas fa-school"></i>

                </div>

            </div>

        </div>


        {{-- PESERTA AKTIF --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Peserta Aktif
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-1">

                        {{ $classrooms->sum(function ($classroom) {
                            return $classroom->participantClassrooms->filter(function ($pc) {
                                    return optional($pc->participantWaveProgram->participant)->status === 'Aktif';
                                })->count();
                        }) }}

                    </p>

                </div>

                <div
                    class="w-11 h-11 rounded-xl
                            bg-green-50 text-green-600
                            flex items-center justify-center">

                    <i class="fas fa-user-check"></i>

                </div>

            </div>

        </div>


        {{-- PESERTA LULUS --}}
        <div class="bg-white rounded-2xl border border-gray-200
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Peserta Lulus
                    </p>

                    <p class="text-3xl font-bold text-gray-800 mt-1">

                        {{ $classrooms->sum(function ($classroom) {
                            return $classroom->participantClassrooms->filter(function ($pc) {
                                    return optional($pc->participantWaveProgram->participant)->status === 'Lulus';
                                })->count();
                        }) }}

                    </p>

                </div>

                <div
                    class="w-11 h-11 rounded-xl
                            bg-emerald-50 text-emerald-600
                            flex items-center justify-center">

                    <i class="fas fa-user-graduate"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- DAFTAR KELAS --}}
    <div class="bg-white rounded-2xl border border-gray-200
                shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-200">

            <div class="flex items-center justify-between">

                <div>

                    <h3 class="font-semibold text-gray-800">
                        Daftar Kelas
                    </h3>

                    <p class="text-xs text-gray-400 mt-1">
                        Informasi kelas berdasarkan program dan gelombang.
                    </p>

                </div>

                <div
                    class="w-10 h-10 rounded-xl
                            bg-indigo-50 text-indigo-600
                            flex items-center justify-center">

                    <i class="fas fa-users"></i>

                </div>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            No
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Program
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Gelombang
                        </th>

                        <th class="px-5 py-3 text-left font-semibold text-gray-600">
                            Kelas
                        </th>

                        <th class="px-5 py-3 text-center font-semibold text-gray-600">
                            Peserta Aktif
                        </th>

                        <th class="px-5 py-3 text-center font-semibold text-gray-600">
                            Peserta Lulus
                        </th>

                        <th class="px-5 py-3 text-center font-semibold text-gray-600">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-100">

                    @forelse($classrooms as $classroom)
                        @php

                            $activeCount = $classroom->participantClassrooms
                                ->filter(function ($pc) {
                                    return optional($pc->participantWaveProgram->participant)->status === 'Aktif';
                                })
                                ->count();

                            $graduatedCount = $classroom->participantClassrooms
                                ->filter(function ($pc) {
                                    return optional($pc->participantWaveProgram->participant)->status === 'Lulus';
                                })
                                ->count();

                        @endphp


                        <tr class="hover:bg-gray-50">


                            {{-- NO --}}
                            <td class="px-5 py-4 text-gray-500">

                                {{ $loop->iteration }}

                            </td>


                            {{-- PROGRAM --}}
                            <td class="px-5 py-4">

                                <div class="font-semibold text-gray-800">

                                    {{ $classroom->waveProgram->program->name }}

                                </div>

                            </td>


                            {{-- GELOMBANG --}}
                            <td class="px-5 py-4">

                                <span
                                    class="inline-flex items-center
                                             px-2.5 py-1 rounded-lg
                                             bg-gray-100 text-gray-700
                                             text-xs font-medium">

                                    {{ $classroom->waveProgram->wave->name }}

                                </span>

                            </td>


                            {{-- KELAS --}}
                            <td class="px-5 py-4">

                                <div class="font-medium text-gray-800">

                                    {{ $classroom->name }}

                                </div>

                                @if ($classroom->code)
                                    <div class="text-xs text-gray-400 mt-1">

                                        {{ $classroom->code }}

                                    </div>
                                @endif

                            </td>


                            {{-- AKTIF --}}
                            <td class="px-5 py-4 text-center">

                                <span
                                    class="inline-flex items-center
                                             justify-center
                                             min-w-[42px]
                                             px-2.5 py-1 rounded-full
                                             bg-green-50 text-green-700
                                             font-semibold">

                                    {{ $activeCount }}

                                </span>

                            </td>


                            {{-- LULUS --}}
                            <td class="px-5 py-4 text-center">

                                <span
                                    class="inline-flex items-center
                                             justify-center
                                             min-w-[42px]
                                             px-2.5 py-1 rounded-full
                                             bg-emerald-50 text-emerald-700
                                             font-semibold">

                                    {{ $graduatedCount }}

                                </span>

                            </td>

                            <td class="px-5 py-4 text-center">

                                <a href="{{ route('pengurus.classrooms.show', $classroom) }}"
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-50 text-indigo-700
                                        hover:bg-indigo-100
                                        text-xs font-semibold">

                                    <i class="fas fa-users"></i>

                                    Lihat Peserta

                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="6" class="px-5 py-10 text-center text-gray-500">

                                <i
                                    class="fas fa-school text-3xl
                                          text-gray-300 mb-3"></i>

                                <p>
                                    Belum ada data kelas.
                                </p>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
