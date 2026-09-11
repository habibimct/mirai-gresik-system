<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Program Saya - MGS</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 min-h-screen">

    <div class="max-w-5xl mx-auto px-4 py-6 sm:py-8">

        {{-- Kembali --}}

        <a href="{{ route('participant.dashboard') }}"
            class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 mb-5">

            ← Kembali ke Dashboard

        </a>


        {{-- Header Program --}}

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-5">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <p class="text-sm text-gray-500 mb-1">
                        Program Saya
                    </p>

                    <h1 class="text-2xl font-bold text-gray-800">

                        {{ $participantClassroom->participantWaveProgram->waveProgram->program->name }}

                    </h1>

                    <div class="mt-3 space-y-1 text-sm text-gray-600">

                        <p>
                            <span class="font-medium">
                                Gelombang:
                            </span>

                            {{ $participantClassroom->participantWaveProgram->waveProgram->wave->name }}
                        </p>

                        <p>
                            <span class="font-medium">
                                Kelas:
                            </span>

                            {{ $participantClassroom->classroom->name }}
                        </p>

                    </div>

                </div>


                {{-- Icon --}}

                <div class="hidden sm:flex w-14 h-14 rounded-2xl bg-green-100 items-center justify-center text-2xl">

                    📚

                </div>

            </div>

        </div>

        <div class="mt-3 mb-3">
            <label for="programSelect" class="block text-sm font-medium text-gray-700 mb-2">
                Pilih Program
            </label>

            <select id="programSelect" onchange="window.location.href = this.value"
                class="w-full sm:w-auto min-w-[280px] appearance-none rounded-xl border border-gray-200 bg-white px-4 py-3 pr-10 text-sm font-semibold text-gray-700 shadow-sm transition-all duration-200 hover:border-indigo-300 hover:shadow-md focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100 cursor-pointer"
                style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%236b7280%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Cpath d=%22m6 9 6 6 6-6%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                @foreach ($programs as $program)
                    <option value="{{ route('participant.program.index', ['participant_classroom' => $program->id]) }}"
                        @selected($participantClassroom->id == $program->id)> {{ $program->participantWaveProgram->waveProgram->program->name }}
                        — {{ $program->participantWaveProgram->waveProgram->wave->name }} —
                        {{ $program->classroom->name }} </option>
                @endforeach
            </select>
        </div>

        {{-- Ringkasan Akademik --}}

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-5">

            {{-- Total Pertemuan --}}

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-5">

                <p class="text-sm text-gray-500">
                    Pertemuan
                </p>

                <p class="text-2xl font-bold text-gray-800 mt-1">
                    {{ $totalAttendance }}
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    Total pertemuan
                </p>

            </div>


            {{-- Kehadiran --}}

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-5">

                <p class="text-sm text-gray-500">
                    Kehadiran
                </p>

                <div class="flex items-end gap-2 mt-1">

                    <p class="text-2xl font-bold text-green-600">
                        {{ $hadir }}
                    </p>

                    <p class="text-sm text-gray-500 mb-1">
                        / {{ $totalAttendance }}
                    </p>

                </div>

                <p class="text-sm font-semibold text-gray-700 mt-1">

                    {{ number_format($attendancePercentage, 1) }}%

                </p>

                <p class="text-xs font-semibold mt-1 {{ $attendanceStatusClass }}">

                    {{ $attendanceStatus }}

                </p>

            </div>


            {{-- Tidak Hadir --}}

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-5">

                <p class="text-sm text-gray-500">
                    Tidak Hadir
                </p>

                <p class="text-2xl font-bold text-red-500 mt-1">
                    {{ $izin + $sakit + $alpha }}
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    Izin / Sakit / Alpha
                </p>

            </div>


            {{-- Rata-rata Nilai --}}

            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 sm:p-5">

                <p class="text-sm text-gray-500">
                    Rata-rata Nilai
                </p>

                <p class="text-2xl font-bold text-indigo-600 mt-1">
                    {{ number_format($averageScore, 2) }}
                </p>

                <p class="text-xs text-gray-400 mt-1">
                    Seluruh penilaian
                </p>

            </div>

        </div>

        {{-- Absensi --}}

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

            <div class="p-6 border-b border-gray-200">

                <h2 class="text-lg font-bold text-gray-800">
                    Absensi Harian
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Riwayat kehadiran Anda selama mengikuti pelatihan.
                </p>

            </div>


            @if ($attendances->count())

                <div class="divide-y divide-gray-100">

                    @foreach ($attendances as $attendance)
                        <div class="p-5">

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                                {{-- Tanggal & Jadwal --}}

                                <div>

                                    <p class="font-semibold text-gray-800">

                                        {{ $attendance->session->attendance_date->translatedFormat('l, d F Y') }}

                                    </p>

                                    @if ($attendance->session->schedule)
                                        <p class="text-sm text-gray-500 mt-1">

                                            {{ $attendance->session->schedule->subject }}

                                            •

                                            {{ \Carbon\Carbon::parse($attendance->session->schedule->start_time)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($attendance->session->schedule->end_time)->format('H:i') }}

                                            @if ($attendance->session->schedule->room)
                                                • {{ $attendance->session->schedule->room }}
                                            @endif

                                        </p>
                                    @endif

                                </div>


                                {{-- Status --}}

                                @php

                                    $statusClass = match ($attendance->status) {
                                        'Hadir' => 'bg-green-100 text-green-700',

                                        'Izin' => 'bg-yellow-100 text-yellow-700',

                                        'Sakit' => 'bg-blue-100 text-blue-700',

                                        'Alpha' => 'bg-red-100 text-red-700',

                                        default => 'bg-gray-100 text-gray-700',
                                    };

                                @endphp


                                <span
                                    class="inline-flex items-center self-start sm:self-auto px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusClass }}">

                                    {{ $attendance->status }}

                                </span>

                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                <div class="p-8 text-center">

                    <div class="text-4xl mb-3">
                        📅
                    </div>

                    <p class="font-semibold text-gray-700">
                        Belum ada data absensi.
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Data kehadiran akan muncul setelah absensi dilakukan.
                    </p>

                </div>

            @endif

        </div>

        {{-- Penilaian Mingguan --}}

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mt-5">

            <div class="p-6 border-b border-gray-200">

                <h2 class="text-lg font-bold text-gray-800">
                    Penilaian Mingguan
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Riwayat hasil penilaian selama mengikuti pelatihan.
                </p>

            </div>


            @if ($scores->count())

                <div class="divide-y divide-gray-100">

                    @php
                        $groupedScores = $scores->groupBy(fn($score) => $score->session->week);
                    @endphp


                    @foreach ($groupedScores as $week => $weekScores)
                        <div class="p-6">

                            {{-- Header Minggu --}}

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">

                                <div>

                                    <h3 class="font-bold text-gray-800">
                                        Minggu ke-{{ $week }}
                                    </h3>

                                    @if ($weekScores->first()->session->assessment_date)
                                        <p class="text-sm text-gray-500 mt-1">

                                            {{ $weekScores->first()->session->assessment_date->translatedFormat('l, d F Y') }}

                                        </p>
                                    @endif

                                </div>


                                <div class="text-sm text-gray-500">

                                    {{ $weekScores->first()->session->title }}

                                </div>

                            </div>


                            {{-- Daftar Nilai --}}

                            <div class="space-y-3">

                                @foreach ($weekScores as $score)
                                    <div
                                        class="flex items-center justify-between gap-4 bg-gray-50 rounded-xl px-4 py-3">

                                        <div>

                                            <p class="font-medium text-gray-700">

                                                {{ $score->type->name }}

                                            </p>


                                            @if ($score->notes)
                                                <p class="text-xs text-gray-500 mt-1">

                                                    {{ $score->notes }}

                                                </p>
                                            @endif

                                        </div>


                                        <div class="text-right">

                                            <span class="text-xl font-bold text-indigo-600">

                                                {{ number_format($score->score, 2) }}

                                            </span>

                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        </div>
                    @endforeach

                </div>
            @else
                <div class="p-8 text-center">

                    <div class="text-4xl mb-3">
                        📊
                    </div>

                    <p class="font-semibold text-gray-700">
                        Belum ada penilaian.
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Nilai akan muncul setelah instruktur melakukan penilaian.
                    </p>

                </div>

            @endif

        </div>
    </div>

</body>

</html>
