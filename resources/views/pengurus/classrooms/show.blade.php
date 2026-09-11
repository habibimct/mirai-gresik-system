@extends('layouts.pengurus')

@section('title', 'Detail Kelas')

@section('page_title', 'Detail Kelas')

@section('content')

    <div class="mb-6 flex items-start justify-between">

        <div>

            <h2 class="text-2xl font-bold text-gray-800">
                {{ $classroom->name }}
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                {{ $classroom->waveProgram->program->name }}
                ·
                {{ $classroom->waveProgram->wave->name }}
            </p>

        </div>

        <a href="{{ route('pengurus.classrooms.index') }}"
           class="inline-flex items-center gap-2
                  px-4 py-2 rounded-lg
                  border border-gray-300
                  text-gray-700
                  hover:bg-gray-50
                  text-sm font-medium">

            <i class="fas fa-arrow-left"></i>

            Kembali

        </a>

    </div>


    @php

        $activeCount = $classroom->participantClassrooms
            ->filter(fn ($pc) =>
                optional($pc->participantWaveProgram->participant)->status === 'Aktif'
            )
            ->count();

        $graduatedCount = $classroom->participantClassrooms
            ->filter(fn ($pc) =>
                optional($pc->participantWaveProgram->participant)->status === 'Lulus'
            )
            ->count();

    @endphp


    {{-- Statistik --}}

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

            <p class="text-sm text-gray-500">
                Total Peserta
            </p>

            <p class="text-3xl font-bold text-gray-800 mt-2">
                {{ $classroom->participantClassrooms->count() }}
            </p>

        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

            <p class="text-sm text-gray-500">
                Aktif
            </p>

            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ $activeCount }}
            </p>

        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

            <p class="text-sm text-gray-500">
                Lulus
            </p>

            <p class="text-3xl font-bold text-emerald-600 mt-2">
                {{ $graduatedCount }}
            </p>

        </div>

    </div>


    {{-- Daftar Peserta --}}

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-200">

            <h3 class="font-semibold text-gray-800">
                Daftar Peserta
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-3 text-left">
                            No
                        </th>

                        <th class="px-5 py-3 text-left">
                            Nama Peserta
                        </th>

                        <th class="px-5 py-3 text-left">
                            NIK
                        </th>

                        <th class="px-5 py-3 text-left">
                            Alamat
                        </th>

                        <th class="px-5 py-3 text-center">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($classroom->participantClassrooms as $pc)

                        @php
                            $participant = $pc->participantWaveProgram->participant;
                        @endphp

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-5 py-4">

                                <div class="font-semibold text-gray-800">
                                    {{ $participant->user->name }}
                                </div>

                            </td>

                            <td class="px-5 py-4 text-gray-600">
                                {{ $participant->nik ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-gray-600">
                                {{ $participant->address ?? '-' }}
                            </td>

                            <td class="px-5 py-4 text-center">

                                @if($participant->status === 'Aktif')

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 bg-green-50 text-green-700
                                                 text-xs font-semibold">

                                        Aktif

                                    </span>

                                @elseif($participant->status === 'Lulus')

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 bg-emerald-50 text-emerald-700
                                                 text-xs font-semibold">

                                        Lulus

                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1 rounded-full
                                                 bg-gray-100 text-gray-700
                                                 text-xs font-semibold">

                                        {{ $participant->status }}

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4"
                                class="px-5 py-10 text-center text-gray-500">

                                Belum ada peserta di kelas ini.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection