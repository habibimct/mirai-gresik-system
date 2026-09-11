@extends('adminlte::page')

@section('title', 'Laporan Akademik')



@section('content_header')
    <h1>Laporan Akademik</h1>
@stop

@section('content')
    @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-1"></i>

            {{ session('error') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">

        <div class="col-md-2">
            <x-adminlte-small-box title="{{ $totalParticipant }}" text="Total Peserta" theme="primary"
                icon="fas fa-users" />
        </div>

        <div class="col-md-2">
            <x-adminlte-small-box title="{{ $totalMeeting }}" text="Total Pertemuan" theme="success"
                icon="fas fa-calendar-check" />
        </div>

        <div class="col-md-2">
            <x-adminlte-small-box title="{{ $averageAttendance }}%" text="Rata-rata Kehadiran" theme="info"
                icon="fas fa-user-check" />
        </div>

        <div class="col-md-2">
            <x-adminlte-small-box title="{{ number_format($averageScore, 2) }}" text="Rata-rata Nilai" theme="warning"
                icon="fas fa-chart-line" />
        </div>

        <x-adminlte-card title="Filter Kelas" theme="primary" icon="fas fa-filter" class="col-md-4">

            <form method="GET">

                <div class="row">

                    <div class="col-md-6">

                        <x-adminlte-select name="classroom_id">

                            <option value="">-- Semua Kelas --</option>

                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" @selected(request('classroom_id') == $classroom->id)>

                                    {{ $classroom->waveProgram->program->name }}
                                    —
                                    {{ $classroom->waveProgram->wave->name }}
                                    —
                                    {{ $classroom->name }}

                                </option>
                            @endforeach

                        </x-adminlte-select>

                    </div>

                    <div class="col-md-6 d-flex align-items-end">

                        <button type="submit" class="btn btn-primary btn-block mb-3">

                            <i class="fas fa-search"></i>

                            Tampilkan

                        </button>

                    </div>

                </div>

            </form>

        </x-adminlte-card>

    </div>

    {{-- ========================================= --}}
    {{-- TAB LAPORAN AKADEMIK --}}
    {{-- ========================================= --}}

    <div class="card card-info">

        <div class="card-header p-0 pt-1">

            <ul class="nav nav-tabs" id="academicTab" role="tablist">

                <li class="nav-item">

                    <a class="nav-link text-dark active" id="attendance-tab" data-toggle="pill" href="#attendance"
                        role="tab">

                        <i class="fas fa-calendar-check mr-1"></i>
                        Kehadiran

                    </a>

                </li>


                <li class="nav-item">

                    <a class="nav-link text-dark" id="score-tab" data-toggle="pill" href="#score" role="tab">

                        <i class="fas fa-chart-line mr-1"></i>
                        Penilaian

                    </a>

                </li>

            </ul>

        </div>


        <div class="card-body">

            <div class="tab-content" id="academicTabContent">


                {{-- ========================================= --}}
                {{-- TAB KEHADIRAN --}}
                {{-- ========================================= --}}

                <div class="tab-pane fade show active" id="attendance" role="tabpanel">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h5 class="mb-0">
                            <i class="fas fa-calendar-check text-info mr-1"></i>
                            Laporan Kehadiran Harian
                        </h5>


                        <div>

                            <a href="{{ route('reports.academics.attendance.export-excel', request()->query()) }}"
                                class="btn btn-success">

                                <i class="fas fa-file-excel"></i>

                                Excel

                            </a>


                            <a href="{{ route('reports.academics.attendance.export-pdf', request()->query()) }}"
                                class="btn btn-danger">

                                <i class="fas fa-file-pdf"></i>
                                PDF

                            </a>

                        </div>

                    </div>


                    @if (!request()->filled('classroom_id'))

                        <div class="alert alert-info">

                            <i class="fas fa-info-circle mr-1"></i>

                            Silakan pilih <strong>Kelas</strong> terlebih dahulu
                            untuk menampilkan laporan kehadiran harian.

                        </div>
                    @else
                        <div class="attendance-table-wrapper table-responsive">

                            <table class="table table-bordered table-hover table-sm attendance-table mb-0">

                                <thead class="text-center">

                                    <tr>

                                        {{-- TANGGAL --}}
                                        <th rowspan="2" class="sticky-date" style="vertical-align: middle;">

                                            Tanggal

                                        </th>


                                        {{-- MATERI --}}
                                        <th rowspan="2" class="sticky-material" style="vertical-align: middle;">

                                            Materi

                                        </th>


                                        {{-- PESERTA --}}
                                        <th colspan="{{ $participants->count() }}">

                                            Peserta

                                        </th>

                                    </tr>


                                    <tr>

                                        @foreach ($participants as $participant)
                                            <th class="participant-column">

                                                {{ $participant->participantWaveProgram->participant->user->name }}

                                            </th>
                                        @endforeach

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse ($attendanceSessions as $session)
                                        <tr>

                                            {{-- TANGGAL --}}
                                            <td class="text-center sticky-date">

                                                {{ $session->attendance_date->format('d/m/Y') }}

                                            </td>


                                            {{-- MATERI --}}
                                            <td class="sticky-material">

                                                {{ $session->schedule->subject ?? '-' }}

                                            </td>


                                            {{-- KEHADIRAN PESERTA --}}
                                            @foreach ($participants as $participant)
                                                @php

                                                    $attendance = $session->attendances->firstWhere(
                                                        'participant_classroom_id',
                                                        $participant->id,
                                                    );

                                                @endphp


                                                <td class="text-center participant-column">

                                                    @if ($attendance)
                                                        @switch($attendance->status)
                                                            @case('Hadir')
                                                                <span class="badge badge-success">
                                                                    H
                                                                </span>
                                                            @break

                                                            @case('Izin')
                                                                <span class="badge badge-warning">
                                                                    I
                                                                </span>
                                                            @break

                                                            @case('Sakit')
                                                                <span class="badge badge-info">
                                                                    S
                                                                </span>
                                                            @break

                                                            @case('Alpha')
                                                                <span class="badge badge-danger">
                                                                    A
                                                                </span>
                                                            @break

                                                            @default
                                                                -
                                                        @endswitch
                                                    @else
                                                        <span class="text-muted">
                                                            -
                                                        </span>
                                                    @endif

                                                </td>
                                            @endforeach

                                        </tr>

                                        @empty

                                            <tr>

                                                <td colspan="3" class="text-center text-muted py-4">

                                                    Belum ada data kehadiran.

                                                </td>

                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>


                            {{-- KETERANGAN --}}

                            <div class="mt-3">

                                <span class="badge badge-success mr-2">
                                    H = Hadir
                                </span>

                                <span class="badge badge-warning mr-2">
                                    I = Izin
                                </span>

                                <span class="badge badge-info mr-2">
                                    S = Sakit
                                </span>

                                <span class="badge badge-danger">
                                    A = Alpha
                                </span>

                            </div>
                        @endif
                    </div>




                    {{-- ========================================= --}}
                    {{-- TAB PENILAIAN --}}
                    {{-- ========================================= --}}

                    <div class="tab-pane fade" id="score" role="tabpanel">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h5 class="mb-0">

                                <i class="fas fa-chart-line text-warning mr-1"></i>

                                Laporan Penilaian Peserta

                            </h5>


                            <div>

                                <a href="{{ route('reports.academics.score.export-excel', request()->query()) }}"
                                    class="btn btn-success">

                                    <i class="fas fa-file-excel"></i>
                                    Export Excel

                                </a>


                                <a href="{{ route('reports.academics.score.export-pdf', request()->query()) }}"
                                    class="btn btn-danger">

                                    <i class="fas fa-file-pdf"></i>

                                    Export PDF

                                </a>

                            </div>

                        </div>


                        <div class="table-responsive">

                            <table class="table table-bordered table-hover table-sm">

                                <thead class="text-center">

                                    <tr>

                                        <th rowspan="2" style="vertical-align: middle;">
                                            Minggu
                                        </th>

                                        <th rowspan="2" style="vertical-align: middle;">
                                            Tanggal
                                        </th>

                                        <th rowspan="2" style="vertical-align: middle;">
                                            Penilaian
                                        </th>

                                        <th colspan="{{ $participants->count() }}">
                                            Peserta
                                        </th>

                                    </tr>

                                    <tr>

                                        @foreach ($participants as $participant)
                                            <th style="min-width: 120px;">

                                                {{ $participant->participantWaveProgram->participant->user->name }}

                                            </th>
                                        @endforeach

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse ($scoreSessions as $session)

                                        {{-- Setiap jenis penilaian dalam session --}}

                                        @foreach ($session->sessionTypes as $sessionType)
                                            <tr>

                                                {{-- Minggu --}}

                                                <td class="text-center">

                                                    {{ $session->week }}

                                                </td>


                                                {{-- Tanggal --}}

                                                <td class="text-center">

                                                    {{ $session->assessment_date->format('d/m/Y') }}

                                                </td>


                                                {{-- Jenis Penilaian --}}

                                                <td>

                                                    {{ $session->title }}

                                                    <br>

                                                    <small class="text-muted">

                                                        {{ $sessionType->type->name }}

                                                    </small>

                                                </td>


                                                {{-- Nilai masing-masing peserta --}}

                                                @foreach ($participants as $participant)
                                                    @php

                                                        $score = $session->scores
                                                            ->where('participant_classroom_id', $participant->id)
                                                            ->where('score_type_id', $sessionType->score_type_id)
                                                            ->first();

                                                    @endphp


                                                    <td class="text-center">

                                                        @if ($score)
                                                            {{ number_format($score->score, 2) }}
                                                        @else
                                                            <span class="text-muted">
                                                                -
                                                            </span>
                                                        @endif

                                                    </td>
                                                @endforeach

                                            </tr>
                                        @endforeach


                                    @empty

                                        <tr>

                                            <td colspan="{{ $participants->count() + 3 }}"
                                                class="text-center text-muted py-4">

                                                Belum ada data penilaian.

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    @stop


    @section('js')

        <script>
            $(document).ready(function() {

                /*
                |--------------------------------------------------------------------------
                | Kembalikan tab terakhir setelah refresh
                |--------------------------------------------------------------------------
                */

                var activeTab = localStorage.getItem('academicActiveTab');

                if (activeTab) {
                    $('#academicTab a[href="' + activeTab + '"]').tab('show');
                }


                /*
                |--------------------------------------------------------------------------
                | Simpan tab ketika user berpindah tab
                |--------------------------------------------------------------------------
                */

                $('#academicTab a[data-toggle="pill"]').on('shown.bs.tab', function(e) {

                    var target = $(e.target).attr('href');

                    localStorage.setItem(
                        'academicActiveTab',
                        target
                    );

                });

            });
        </script>

    @stop
