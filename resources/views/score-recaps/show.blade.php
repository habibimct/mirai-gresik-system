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

                Kembali

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


    @include('score-recaps.partials.recap-tabs')
    {{-- Modal Pengaturan Kelulusan --}}

    @include('score-recaps.partials.graduation-setting-modal')


@stop
