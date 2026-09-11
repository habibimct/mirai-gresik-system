@extends('layouts.pengurus')

@section('title', 'Detail Nilai')

@section('page_title', 'Detail Nilai')

@section('content')

    {{-- HEADER --}}

    <div class="mb-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <h2 class="text-2xl font-bold text-gray-800">
                    Detail Nilai
                </h2>

                <p class="text-gray-500 mt-1">
                    Rekapitulasi nilai peserta berdasarkan sesi penilaian.
                </p>

            </div>

            <a href="{{ route('pengurus.scores.index') }}"
                class="inline-flex items-center justify-center
                       px-4 py-2 rounded-lg
                       bg-gray-600 text-white
                       hover:bg-gray-700 transition">

                <i class="fas fa-arrow-left mr-2"></i>

                Kembali

            </a>

        </div>

    </div>


    {{-- INFORMASI KELAS --}}

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">

        <div class="p-5">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>

                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Kelas
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $classroom->name }}
                    </p>

                </div>

                <div>

                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Program
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $classroom->waveProgram->program->name ?? '-' }}
                    </p>

                </div>

                <div>

                    <p class="text-xs text-gray-500 uppercase tracking-wide">
                        Gelombang
                    </p>

                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $classroom->waveProgram->wave->name ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- DAFTAR SESI PENILAIAN --}}

    @forelse($scoreSessions as $session)

        @php

            /*
             * Jenis nilai yang digunakan pada sesi ini.
             */
            $scoreTypes = $session->sessionTypes
                ->map(fn($sessionType) => $sessionType->type)
                ->filter();

        @endphp


        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">

            {{-- HEADER SESI --}}

            <div class="px-5 py-4 border-b">

                <div class="flex flex-col md:flex-row
                            md:items-center md:justify-between gap-3">

                    <div>

                        <h3 class="font-semibold text-gray-800">

                            {{ $session->title }}

                        </h3>

                        <p class="text-sm text-gray-500 mt-1">

                            Minggu {{ $session->week }}

                            @if ($session->assessment_date)
                                ·
                                {{ $session->assessment_date->format('d-m-Y') }}
                            @endif

                        </p>

                    </div>


                    @if ($session->is_active)

                        <span class="inline-flex items-center
                                     px-3 py-1 rounded-full
                                     text-xs font-medium
                                     bg-green-100 text-green-700">

                            <i class="fas fa-check-circle mr-1"></i>

                            Aktif

                        </span>

                    @else

                        <span class="inline-flex items-center
                                     px-3 py-1 rounded-full
                                     text-xs font-medium
                                     bg-gray-100 text-gray-600">

                            <i class="fas fa-lock mr-1"></i>

                            Tidak Aktif

                        </span>

                    @endif

                </div>

            </div>


            {{-- TABEL NILAI --}}

            <div class="p-5">

                @if ($scoreTypes->count())

                    <div class="overflow-x-auto">

                        <table class="min-w-full text-sm">

                            <thead>

                                <tr class="bg-gray-50 border-b">

                                    <th class="px-4 py-3 text-left whitespace-nowrap">
                                        No
                                    </th>

                                    <th class="px-4 py-3 text-left whitespace-nowrap">
                                        Peserta
                                    </th>

                                    @foreach ($scoreTypes as $type)

                                        <th class="px-4 py-3 text-center whitespace-nowrap">

                                            {{ $type->name }}

                                        </th>

                                    @endforeach

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($classroom->participantClassrooms as $participantClassroom)

                                    @php

                                        $participant =
                                            $participantClassroom
                                                ->participantWaveProgram
                                                ->participant;

                                        $scores = $participantClassroom->scores
                                            ->where('score_session_id', $session->id)
                                            ->keyBy('score_type_id');

                                    @endphp


                                    <tr class="border-b hover:bg-gray-50">

                                        <td class="px-4 py-3">

                                            {{ $loop->iteration }}

                                        </td>


                                        <td class="px-4 py-3 font-medium text-gray-800">

                                            {{ $participant->user->name ?? '-' }}

                                        </td>


                                        @foreach ($scoreTypes as $type)

                                            @php
                                                $score = $scores->get($type->id);
                                            @endphp

                                            <td class="px-4 py-3 text-center">

                                                @if ($score)

                                                    <span class="inline-flex items-center
                                                        justify-center
                                                        min-w-[48px]
                                                        px-2 py-1
                                                        rounded-lg
                                                        bg-indigo-50
                                                        text-indigo-700
                                                        font-semibold">

                                                        {{ number_format($score->score, 2, ',', '.') }}

                                                    </span>

                                                @else

                                                    <span class="text-gray-400">
                                                        -
                                                    </span>

                                                @endif

                                            </td>

                                        @endforeach

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="{{ 2 + $scoreTypes->count() }}"
                                            class="px-4 py-8 text-center text-gray-500">

                                            Belum ada peserta dalam kelas ini.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="text-center py-8 text-gray-500">

                        <i class="fas fa-clipboard-list text-3xl mb-3"></i>

                        <p>
                            Belum ada jenis penilaian pada sesi ini.
                        </p>

                    </div>

                @endif

            </div>

        </div>

    @empty

        <div class="bg-white rounded-xl shadow-sm border
                    border-gray-200">

            <div class="py-12 text-center text-gray-500">

                <i class="fas fa-star text-4xl mb-3"></i>

                <p class="font-medium">
                    Belum ada sesi penilaian.
                </p>

                <p class="text-sm mt-1">
                    Belum terdapat data penilaian untuk kelas ini.
                </p>

            </div>

        </div>

    @endforelse

@stop