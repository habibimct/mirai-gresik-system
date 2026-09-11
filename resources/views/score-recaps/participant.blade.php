@extends('adminlte::page')

@section('title', 'Detail Rekap Nilai')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-1">
                <i class="fas fa-chart-line text-primary mr-2"></i>
                Detail Rekap Nilai
            </h1>

            <small class="text-muted">
                Hasil penilaian peserta selama mengikuti pelatihan
            </small>
        </div>

        <a href="{{ route('score-recaps.show', $classroom) }}" class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
        </a>

    </div>

@stop


@section('content')


    {{-- =========================================================
        IDENTITAS PESERTA
    ========================================================== --}}

    <div class="card card-primary card-outline">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user mr-2"></i>

                Profil Peserta

            </h3>

        </div>


        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-sm table-borderless mb-0">

                        <tr>

                            <th width="150">
                                Nama
                            </th>

                            <td>
                                :
                                {{ $participantClassroom->participantWaveProgram->participant->user->name }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Kelas
                            </th>

                            <td>
                                :
                                {{ $classroom->name }}
                            </td>

                        </tr>

                    </table>

                </div>


                <div class="col-md-6">

                    <table class="table table-sm table-borderless mb-0">

                        <tr>

                            <th width="150">
                                Program
                            </th>

                            <td>
                                :
                                {{ $classroom->waveProgram->program->name }}
                            </td>

                        </tr>

                        <tr>

                            <th>
                                Gelombang
                            </th>

                            <td>
                                :
                                {{ $classroom->waveProgram->wave->name }}
                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>


        <div class="card-footer d-flex justify-content-end">

            <a href="{{ route('score-recaps.printParticipant', [
                'classroom' => $classroom,
                'participantClassroom' => $participantClassroom,
            ]) }}"
                target="_blank" class="btn btn-danger">

                <i class="fas fa-file-pdf mr-1"></i>

                Cetak Hasil Belajar

            </a>

        </div>

    </div>



    {{-- =========================================================
        STATISTIK
    ========================================================== --}}

    <div class="row">


        {{-- NILAI AKHIR --}}

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-primary" style="height: 80%;">

                <div class="inner">

                    <h3>
                        {{ $finalScore }}
                    </h3>

                    <p>
                        Nilai Akhir
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-chart-line"></i>

                </div>

            </div>

        </div>


        {{-- KEHADIRAN --}}

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-success" style="height: 80%;">

                <div class="inner">

                    <h3>
                        {{ $attendancePercent }}%
                    </h3>

                    <p>
                        Kehadiran
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-user-check"></i>

                </div>

            </div>

        </div>


        {{-- TOTAL PENILAIAN --}}

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-info" style="height: 80%;">

                <div class="inner">

                    <h3>
                        {{ $classroom->scoreSessions->count() }}
                    </h3>

                    <p>
                        Total Penilaian
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-list"></i>

                </div>

            </div>

        </div>


        {{-- STATUS --}}

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-{{ $statusColor }}" style="height: 80%;">

                <div class="inner">

                    <h3 class="text-white font-weight-bold mb-0"
                        style="font-size: 23px; line-height: 2.2; min-height: 52px;">
                        {{ $status }}
                    </h3>

                    <p>
                        Status Kelulusan
                    </p>

                </div>

                <div class="icon">
                    <i class="fas fa-award"></i>
                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        DETAIL NILAI
    ========================================================== --}}

    <div class="card card-info card-outline">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-clipboard-list mr-2"></i>

                Nilai Per Minggu

            </h3>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th class="text-center" width="80">
                                Minggu
                            </th>

                            <th class="text-center" width="120">
                                Tanggal
                            </th>

                            <th>
                                Komponen Penilaian
                            </th>

                            <th class="text-center" width="120">
                                Nilai
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @php
                            $hasScoreData = false;
                        @endphp


                        @foreach ($classroom->scoreSessions as $session)
                            @foreach ($session->sessionTypes as $type)
                                @php

                                    $hasScoreData = true;

                                    $score = $participantClassroom->scores
                                        ->where('score_session_id', $session->id)
                                        ->where('score_type_id', $type->score_type_id)
                                        ->first();

                                @endphp


                                <tr>

                                    <td class="text-center">

                                        <span class="badge badge-secondary">

                                            Minggu {{ $session->week }}

                                        </span>

                                    </td>


                                    <td class="text-center">

                                        {{ $session->assessment_date->format('d-m-Y') }}

                                    </td>


                                    <td>

                                        <i class="fas fa-book text-muted mr-1"></i>

                                        {{ $type->type->name }}

                                    </td>


                                    <td class="text-center">

                                        @if ($score)
                                            <strong class="text-primary">

                                                {{ number_format($score->score, 2) }}

                                            </strong>
                                        @else
                                            <span class="text-muted">
                                                -
                                            </span>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach
                        @endforeach


                        @if (!$hasScoreData)
                            <tr>

                                <td colspan="4" class="text-center text-muted py-4">

                                    <i class="fas fa-info-circle mr-1"></i>

                                    Belum ada data penilaian.

                                </td>

                            </tr>
                        @endif

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    {{-- =========================================================
        GRAFIK PERKEMBANGAN
    ========================================================== --}}

    <div class="card card-success card-outline">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-chart-line mr-2"></i>

                Grafik Perkembangan Nilai

            </h3>

        </div>


        <div class="card-body">

            <div style="height: 350px;">

                <canvas id="scoreChart"></canvas>

            </div>

        </div>

    </div>



    {{-- =========================================================
        RINGKASAN
    ========================================================== --}}

    <div class="card card-secondary card-outline">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-info-circle mr-2"></i>

                Ringkasan Hasil

            </h3>

        </div>


        <div class="card-body">
            <div class="table-responsive">
                <div class="row text-center">

                    <div class="col-md-4">

                        <h5 class="text-muted">
                            Nilai Akhir
                        </h5>

                        <h3 class="text-primary">
                            {{ $finalScore }}
                        </h3>

                    </div>


                    <div class="col-md-4">

                        <h5 class="text-muted">
                            Kehadiran
                        </h5>

                        <h3 class="text-success">
                            {{ $attendancePercent }}%
                        </h3>

                    </div>


                    <div class="col-md-4">

                        <h5 class="text-muted">
                            Status Kelulusan
                        </h5>

                        <h3>

                            <span class="badge badge-{{ $statusColor }}">

                                {{ $status }}

                            </span>

                        </h3>

                    </div>
                </div>
            </div>

        </div>

    </div>

@stop



{{-- =============================================================
    CHART.JS
============================================================= --}}

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        const weeks = @json(collect($weeklyAverage)->pluck('week'));

        const averages = @json(collect($weeklyAverage)->pluck('average'));


        const chartElement = document.getElementById('scoreChart');


        if (chartElement && weeks.length > 0) {

            new Chart(chartElement, {

                type: 'line',

                data: {

                    labels: weeks.map(
                        week => 'Minggu ' + week
                    ),

                    datasets: [{

                        label: 'Rata-rata Nilai',

                        data: averages,

                        borderColor: '#007bff',

                        backgroundColor: 'rgba(0,123,255,0.15)',

                        pointRadius: 5,

                        pointHoverRadius: 7,

                        borderWidth: 3,

                        fill: true,

                        tension: 0.35

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {

                            display: true

                        }

                    },

                    scales: {

                        y: {

                            min: 0,

                            max: 100,

                            ticks: {

                                stepSize: 10

                            }

                        }

                    }

                }

            });

        }
    </script>
@endpush
