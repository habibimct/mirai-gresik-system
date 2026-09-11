@extends('adminlte::page')

@section('title', 'Rekap Nilai - ' . $classroom->name)


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">

                <i class="fas fa-chart-line text-primary mr-2"></i>

                Rekap Nilai

            </h1>

            <p class="text-muted mb-0">

                {{ $classroom->name }}

                @if ($classroom->waveProgram?->program)
                    <span class="mx-1">•</span>

                    {{ $classroom->waveProgram->program->name }}
                @endif

                @if ($classroom->waveProgram?->wave)
                    <span class="mx-1">•</span>

                    {{ $classroom->waveProgram->wave->name }}
                @endif

            </p>

        </div>


        {{-- Tombol Kembali --}}

        <div>

            <a href="{{ route('score-recaps.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>

                

            </a>

        </div>

    </div>

@stop


@section('content')


    {{-- =========================================================
        INFORMASI KELAS
    ========================================================== --}}

    <div class="card card-primary card-outline mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Kelas
                    </small>

                    <strong class="text-dark">

                        <i class="fas fa-school text-primary mr-1"></i>

                        {{ $classroom->name }}

                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Program
                    </small>

                    <strong class="text-dark">

                        <i class="fas fa-book text-primary mr-1"></i>

                        {{ $classroom->waveProgram->program->name ?? '-' }}

                    </strong>

                </div>


                <div class="col-md-4">

                    <small class="text-muted d-block">
                        Gelombang
                    </small>

                    <strong class="text-dark">

                        <i class="fas fa-layer-group text-primary mr-1"></i>

                        {{ $classroom->waveProgram->wave->name ?? '-' }}

                    </strong>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        STATISTIK
    ========================================================== --}}

    <div class="row">


        {{-- Peserta --}}
        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-info">

                <div class="inner">

                    <h3>
                        {{ $classroom->participantClassrooms->count() }}
                    </h3>

                    <p>
                        Peserta
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-users"></i>

                </div>

            </div>

        </div>


        {{-- Minggu Penilaian --}}
        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-success">

                <div class="inner">

                    <h3>
                        {{ $classroom->scoreSessions->count() }}
                    </h3>

                    <p>
                        Minggu Penilaian
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-calendar-check"></i>

                </div>

            </div>

        </div>


        {{-- Komponen Nilai --}}
        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-warning">

                <div class="inner">

                    <h3>
                        {{ $scoreTypes->count() }}
                    </h3>

                    <p>
                        Komponen Nilai
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-tasks"></i>

                </div>

            </div>

        </div>


        {{-- Minimum Kehadiran --}}
        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-primary">

                <div class="inner">

                    <h3>
                        {{ number_format($classroom->minimum_attendance ?? 0, 0) }}%
                    </h3>

                    <p>
                        Minimal Kehadiran
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-user-check"></i>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
        REKAP NILAI
    ========================================================== --}}

    <div class="card card-primary card-outline">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-table mr-1"></i>

                Rekap Nilai Peserta

            </h3>


            <div class="card-tools">

                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#graduationSettingModal"
                    title="Pengaturan Kelulusan">

                    <i class="fas fa-cogs mr-1"></i>

                    Pengaturan Kelulusan

                </button>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-striped mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th width="55" class="text-center align-middle">

                                No

                            </th>


                            <th style="min-width: 220px;" class="align-middle">

                                Peserta

                            </th>


                            {{-- Komponen nilai --}}
                            @foreach ($scoreTypes as $type)
                                <th class="text-center align-middle" style="min-width: 110px;">

                                    {{ $type->name }}

                                </th>
                            @endforeach


                            <th width="110" class="text-center align-middle">

                                Nilai Akhir

                            </th>


                            <th width="120" class="text-center align-middle">

                                Kehadiran

                            </th>


                            <th width="120" class="text-center align-middle">

                                Status

                            </th>


                            <th width="130" class="text-center align-middle">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse ($recaps as $recap)

                            @php

                                $attendancePercent = $recap['attendance']['percent'] ?? 0;

                                $finalScore = $recap['final_score'] ?? null;

                                $minimumAttendance = $classroom->minimum_attendance ?? 0;

                                $minimumScore = $classroom->minimum_score ?? 0;

                            @endphp


                            <tr>


                                {{-- No --}}
                                <td class="text-center align-middle">

                                    {{ $loop->iteration }}

                                </td>



                                {{-- Nama --}}
                                <td class="align-middle">

                                    <strong>

                                        {{ $recap['participant']->participantWaveProgram->participant->user->name }}

                                    </strong>

                                </td>



                                {{-- Nilai setiap komponen --}}
                                @foreach ($scoreTypes as $type)
                                    <td class="text-center align-middle">

                                        @if (isset($recap['scores'][$type->id]))
                                            <span class="font-weight-bold">

                                                {{ number_format($recap['scores'][$type->id], 2) }}

                                            </span>
                                        @else
                                            <span class="text-muted">
                                                -
                                            </span>
                                        @endif

                                    </td>
                                @endforeach



                                {{-- Nilai Akhir --}}
                                <td class="text-center align-middle">

                                    @if ($finalScore !== null)
                                        <span class="badge badge-primary px-3 py-2" style="font-size: 14px;">

                                            {{ number_format($finalScore, 2) }}

                                        </span>
                                    @else
                                        <span class="text-muted">
                                            -
                                        </span>
                                    @endif

                                </td>



                                {{-- Kehadiran --}}
                                <td class="text-center align-middle">

                                    @if ($attendancePercent >= $minimumAttendance)
                                        <span class="badge badge-success px-3 py-2">

                                            <i class="fas fa-check mr-1"></i>

                                            {{ number_format($attendancePercent, 2) }}%

                                        </span>
                                    @else
                                        <span class="badge badge-danger px-3 py-2">

                                            <i class="fas fa-times mr-1"></i>

                                            {{ number_format($attendancePercent, 2) }}%

                                        </span>
                                    @endif

                                </td>



                                {{-- Status --}}
                                <td class="text-center align-middle">

                                    <span class="badge badge-{{ $recap['status_color'] }}"
                                        id="status{{ $recap['participant']->id }}" data-score="{{ $finalScore }}"
                                        data-attendance="{{ $attendancePercent }}">

                                        @if ($recap['status'] === 'Lulus')
                                            <i class="fas fa-check-circle mr-1"></i>
                                        @elseif ($recap['status'] === 'Tidak Lulus')
                                            <i class="fas fa-times-circle mr-1"></i>
                                        @endif

                                        {{ $recap['status'] }}

                                    </span>

                                </td>



                                {{-- Aksi --}}
                                <td class="text-center align-middle">


                                    {{-- Detail --}}
                                    <a href="{{ route('score-recaps.participant', [
                                        'classroom' => $classroom,
                                        'participantClassroom' => $recap['participant'],
                                    ]) }}"
                                        class="btn btn-info btn-sm" title="Lihat Detail Nilai">

                                        <i class="fas fa-eye"></i>

                                    </a>


                                    {{-- PDF --}}
                                    <a href="{{ route('score-recaps.participant.pdf', [
                                        'classroom' => $classroom,
                                        'participantClassroom' => $recap['participant'],
                                    ]) }}"
                                        target="_blank" class="btn btn-danger btn-sm" title="Cetak PDF">

                                        <i class="fas fa-file-pdf"></i>

                                    </a>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="{{ $scoreTypes->count() + 6 }}" class="text-center text-muted py-5">

                                    <i class="fas fa-chart-bar fa-2x mb-3 d-block">
                                    </i>

                                    <strong>
                                        Belum ada data nilai.
                                    </strong>

                                    <br>

                                    <small>
                                        Data nilai peserta akan muncul
                                        setelah penilaian dibuat.
                                    </small>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
            KETERANGAN
        ====================================================== --}}

        <div class="card-footer">

            <div class="row">

                <div class="col-md-6">

                    <small class="text-muted">

                        <i class="fas fa-info-circle mr-1"></i>

                        Nilai akhir digunakan sebagai salah satu
                        indikator kelulusan peserta.

                    </small>

                </div>


                <div class="col-md-6 text-md-right">

                    <small class="text-muted">

                        Minimal Nilai:

                        <strong>

                            {{ number_format($classroom->minimum_score ?? 0, 2) }}

                        </strong>

                        &nbsp; | &nbsp;

                        Minimal Kehadiran:

                        <strong>

                            {{ number_format($classroom->minimum_attendance ?? 0, 2) }}%

                        </strong>

                    </small>

                </div>

            </div>

        </div>

    </div>



    {{-- Modal Pengaturan Kelulusan --}}

    @include('score-recaps.partials.graduation-setting-modal')


@stop
