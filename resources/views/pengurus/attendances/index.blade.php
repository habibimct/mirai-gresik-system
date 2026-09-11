@extends('layouts.pengurus')

@section('title', 'Absensi')

@section('page_title', 'Absensi')

@section('content')

    {{-- HEADER --}}
    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800">
            Absensi Peserta
        </h2>

        <p class="text-gray-500 mt-1">
            Rekap kehadiran peserta berdasarkan kelas.
        </p>

    </div>


    {{-- FILTER --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">

        <div class="px-5 py-4 border-b">

            <h3 class="font-semibold text-gray-800">

                <i class="fas fa-filter mr-2 text-indigo-600"></i>

                Filter Absensi

            </h3>

        </div>


        <form method="GET" class="p-5">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


                {{-- GELOMBANG --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">

                        Gelombang

                    </label>

                    <select name="wave_id"
                        onchange="this.form.submit()"
                        class="w-full rounded-lg border-gray-300
                               focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="">
                            -- Pilih Gelombang --
                        </option>

                        @foreach ($waves as $wave)

                            <option value="{{ $wave->id }}"
                                @selected(request('wave_id') == $wave->id)>

                                {{ $wave->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- KELAS --}}
                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">

                        Kelas

                    </label>

                    <select name="classroom_id"
                        class="w-full rounded-lg border-gray-300
                               focus:border-indigo-500 focus:ring-indigo-500">

                        <option value="">
                            -- Pilih Kelas --
                        </option>

                        @foreach ($classrooms as $classroom)

                            <option value="{{ $classroom->id }}"
                                @selected(request('classroom_id') == $classroom->id)>

                                {{ $classroom->name }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- BUTTON --}}
                <div class="flex items-end">

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700
                               text-white font-medium py-2.5 px-4
                               rounded-lg transition">

                        <i class="fas fa-search mr-1"></i>

                        Tampilkan

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- INFORMASI KELAS --}}
    @if ($selectedClassroom)

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">

            <div class="p-5">

                <div class="flex flex-col md:flex-row
                            md:items-center md:justify-between gap-4">

                    <div>

                        <h3 class="text-xl font-bold text-gray-800">

                            {{ $selectedClassroom->name }}

                        </h3>

                        <p class="text-gray-500 mt-1">

                            {{ $selectedClassroom->waveProgram->program->name }}

                            &bull;

                            {{ $selectedClassroom->waveProgram->wave->name }}

                        </p>

                    </div>


                    <div class="flex items-center gap-2">

                        <span class="px-3 py-1 rounded-full
                                     bg-indigo-100 text-indigo-700
                                     text-sm font-medium">

                            <i class="fas fa-users mr-1"></i>

                            {{ $selectedClassroom->participantClassrooms->count() }}
                            Peserta

                        </span>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- DATA ABSENSI --}}
    @if ($selectedClassroom)

        <div class="bg-white rounded-xl shadow-sm border border-gray-200">

            <div class="px-5 py-4 border-b">

                <h3 class="font-semibold text-gray-800">

                    <i class="fas fa-calendar-check
                              mr-2 text-green-600"></i>

                    Riwayat Absensi

                </h3>

            </div>


            <div class="p-5">

                @forelse ($sessions as $session)

                    @php

                        $total = $session->attendances->count();

                        $hadir = $session->attendances
                            ->where('status', 'Hadir')
                            ->count();

                        $izin = $session->attendances
                            ->where('status', 'Izin')
                            ->count();

                        $sakit = $session->attendances
                            ->where('status', 'Sakit')
                            ->count();

                        $alpha = $session->attendances
                            ->where('status', 'Alpha')
                            ->count();

                    @endphp


                    {{-- SESSION --}}
                    <div class="border border-gray-200
                                rounded-xl mb-5 overflow-hidden">


                        {{-- HEADER SESSION --}}
                        <div class="bg-gray-50 px-4 py-3
                                    border-b flex flex-col md:flex-row
                                    md:items-center md:justify-between gap-3">

                            <div>

                                <p class="font-semibold text-gray-800">

                                    {{ $session->attendance_date->format('d-m-Y') }}

                                </p>

                                <p class="text-sm text-gray-500">

                                    {{ optional($session->schedule)->subject ?? 'Materi' }}

                                </p>

                            </div>


                            {{-- RINGKASAN --}}
                            <div class="flex flex-wrap gap-2">

                                <span class="px-2 py-1 rounded
                                             bg-green-100 text-green-700
                                             text-xs">

                                    Hadir {{ $hadir }}

                                </span>

                                <span class="px-2 py-1 rounded
                                             bg-blue-100 text-blue-700
                                             text-xs">

                                    Izin {{ $izin }}

                                </span>

                                <span class="px-2 py-1 rounded
                                             bg-yellow-100 text-yellow-700
                                             text-xs">

                                    Sakit {{ $sakit }}

                                </span>

                                <span class="px-2 py-1 rounded
                                             bg-red-100 text-red-700
                                             text-xs">

                                    Alpha {{ $alpha }}

                                </span>

                            </div>

                        </div>


                        {{-- TABLE --}}
                        <div class="overflow-x-auto">

                            <table class="min-w-full text-sm">

                                <thead class="bg-gray-50">

                                    <tr>

                                        <th class="px-4 py-3 text-left
                                                   font-semibold text-gray-600">

                                            No

                                        </th>

                                        <th class="px-4 py-3 text-left
                                                   font-semibold text-gray-600">

                                            Peserta

                                        </th>

                                        <th class="px-4 py-3 text-center
                                                   font-semibold text-gray-600">

                                            Status

                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-100">

                                    @forelse ($session->attendances as $attendance)

                                        @php

                                            $participant =
                                                $attendance
                                                    ->participantClassroom
                                                    ->participantWaveProgram
                                                    ->participant
                                                    ->user;

                                        @endphp

                                        <tr class="hover:bg-gray-50">

                                            <td class="px-4 py-3">

                                                {{ $loop->iteration }}

                                            </td>

                                            <td class="px-4 py-3 font-medium
                                                       text-gray-800">

                                                {{ $participant->name }}

                                            </td>

                                            <td class="px-4 py-3 text-center">

                                                @if ($attendance->status === 'Hadir')

                                                    <span class="px-3 py-1 rounded-full
                                                                 bg-green-100 text-green-700
                                                                 text-xs font-medium">

                                                        Hadir

                                                    </span>

                                                @elseif ($attendance->status === 'Izin')

                                                    <span class="px-3 py-1 rounded-full
                                                                 bg-blue-100 text-blue-700
                                                                 text-xs font-medium">

                                                        Izin

                                                    </span>

                                                @elseif ($attendance->status === 'Sakit')

                                                    <span class="px-3 py-1 rounded-full
                                                                 bg-yellow-100 text-yellow-700
                                                                 text-xs font-medium">

                                                        Sakit

                                                    </span>

                                                @else

                                                    <span class="px-3 py-1 rounded-full
                                                                 bg-red-100 text-red-700
                                                                 text-xs font-medium">

                                                        Alpha

                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="3"
                                                class="px-4 py-8 text-center
                                                       text-gray-500">

                                                Belum ada data absensi.

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-10 text-gray-500">

                        <i class="fas fa-calendar-times
                                  text-4xl mb-3 text-gray-300"></i>

                        <p>

                            Belum ada riwayat absensi untuk kelas ini.

                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    @else

        {{-- BELUM MEMILIH KELAS --}}
        <div class="bg-white rounded-xl shadow-sm
                    border border-gray-200">

            <div class="text-center py-16">

                <i class="fas fa-calendar-check
                          text-5xl text-gray-300 mb-4"></i>

                <h3 class="text-lg font-semibold text-gray-700">

                    Pilih Kelas

                </h3>

                <p class="text-gray-500 mt-1">

                    Pilih gelombang dan kelas untuk melihat
                    riwayat absensi peserta.

                </p>

            </div>

        </div>

    @endif

@stop