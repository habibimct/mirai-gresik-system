@extends('adminlte::page')

@section('title', 'Laporan Peserta')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="m-0">
                <i class="fas fa-users mr-2"></i>
                Laporan Peserta
            </h1>

            <small class="text-muted">
                Rekapitulasi data peserta LPK Mirai Gresik
            </small>
        </div>

    </div>

@stop


@section('content')

    {{-- =========================================================
         FILTER LAPORAN
    ========================================================== --}}

    <x-adminlte-card title="Filter Laporan" theme="primary" icon="fas fa-filter" collapsible>

        <form method="GET" action="{{ url()->current() }}">

            <div class="row">

                {{-- PROGRAM --}}
                <div class="col-md-2 col-sm-6">

                    <x-adminlte-select name="program_id" label="Program">

                        <option value="">
                            Semua Program
                        </option>

                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}" @selected(request('program_id') == $program->id)>
                                {{ $program->name }}
                            </option>
                        @endforeach

                    </x-adminlte-select>

                </div>


                {{-- GELOMBANG --}}
                <div class="col-md-2 col-sm-6">

                    <x-adminlte-select name="wave_id" label="Gelombang">

                        <option value="">
                            Semua Gelombang
                        </option>

                        @foreach ($waves as $wave)
                            <option value="{{ $wave->id }}" @selected(request('wave_id') == $wave->id)>
                                {{ $wave->name }}
                            </option>
                        @endforeach

                    </x-adminlte-select>

                </div>


                {{-- KELAS --}}
                <div class="col-md-4 col-sm-6">

                    <x-adminlte-select name="classroom_id" label="Kelas">

                        <option value="">
                            Semua Kelas
                        </option>

                        @foreach ($classrooms as $classroom)
                            <option value="{{ $classroom->id }}" @selected(request('classroom_id') == $classroom->id)>
                                {{ $classroom->name }}
                                @if ($classroom->waveProgram?->wave)
                                    — {{ $classroom->waveProgram->wave->name }}
                                @endif
                            </option>
                        @endforeach

                    </x-adminlte-select>

                </div>


                {{-- STATUS --}}
                <div class="col-md-2 col-sm-6">

                    <x-adminlte-select name="status" label="Status">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="Aktif" @selected(request('status') == 'Aktif')>
                            Aktif
                        </option>

                        <option value="Nonaktif" @selected(request('status') == 'Nonaktif')>
                            Nonaktif
                        </option>

                        <option value="Lulus" @selected(request('status') == 'Lulus')>
                            Lulus
                        </option>

                    </x-adminlte-select>

                </div>

                {{-- BUTTON FILTER --}}

                <div class="col-md-2 col-sm-6 d-flex align-items-end mb-3">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search mr-1"></i>
                        Tampilkan
                    </button>


                    <a href="{{ url()->current() }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt mr-1"></i>
                        Reset
                    </a>

                </div>

            </div>


        </form>

    </x-adminlte-card>



    {{-- =========================================================
         STATISTIK
    ========================================================== --}}

    <div class="row">

        {{-- TOTAL --}}

        <div class="col-lg-3 col-md-6 col-sm-6">

            <x-adminlte-small-box title="{{ number_format($totalParticipant) }}" text="Total Peserta" icon="fas fa-users"
                theme="info" />

        </div>


        {{-- AKTIF --}}

        <div class="col-lg-3 col-md-6 col-sm-6">

            <x-adminlte-small-box title="{{ number_format($totalActive) }}" text="Peserta Aktif" icon="fas fa-user-check"
                theme="success" />

        </div>


        {{-- LULUS --}}

        <div class="col-lg-3 col-md-6 col-sm-6">

            <x-adminlte-small-box title="{{ number_format($totalGraduate) }}" text="Peserta Lulus"
                icon="fas fa-graduation-cap" theme="primary" />

        </div>


        {{-- NONAKTIF --}}

        <div class="col-lg-3 col-md-6 col-sm-6">

            <x-adminlte-small-box title="{{ number_format($totalInactive) }}" text="Peserta Nonaktif"
                icon="fas fa-user-times" theme="danger" />

        </div>

    </div>



    {{-- =========================================================
         DATA PESERTA
    ========================================================== --}}

    <x-adminlte-card theme="info" icon="fas fa-table">

        {{-- HEADER --}}

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

            <div>
                <div class="font-weight-bold">
                    <i class="fas fa-users mr-1"></i>
                    Data Peserta
                </div>

                <div class="text-muted small mt-1">
                    Menampilkan
                    <strong>{{ $participants->count() }}</strong>
                    data peserta
                </div>
            </div>


            {{-- EXPORT --}}

            <div class="mt-2 mt-md-0">

                <span class="text-muted mr-2 d-none d-md-inline">
                    Export:
                </span>


                <a href="{{ route('reports.participants.export', request()->query()) }}" class="btn btn-success btn-sm">

                    <i class="fas fa-file-excel mr-1"></i>
                    Excel

                </a>


                <a href="{{ route('reports.participants.export-pdf', request()->query()) }}" class="btn btn-danger btn-sm">

                    <i class="fas fa-file-pdf mr-1"></i>
                    PDF

                </a>

            </div>

        </div>


        {{-- GARIS PEMBATAS --}}

        <hr class="mt-0">


        {{-- =====================================================
             TABLE
        ====================================================== --}}

        <div class="table-responsive">

            <table class="table table-bordered table-hover table-sm mb-0">

                <thead class="thead-light text-center">

                    <tr>

                        <th width="55">
                            No
                        </th>

                        <th>
                            Nama Peserta
                        </th>

                        <th>
                            Program
                        </th>

                        <th>
                            Gelombang
                        </th>

                        <th>
                            Kelas
                        </th>

                        <th width="110">
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($participants as $p)
                        @php

                            $participant = optional($p->participantWaveProgram)->participant;

                            $user = optional($participant)->user;

                            $waveProgram = optional($p->participantWaveProgram)->waveProgram;

                            $program = optional($waveProgram)->program;

                            $classroom = $p->classroom;

                            $wave = optional(optional($classroom)->waveProgram)->wave;

                            $status = optional($p->participantWaveProgram)->status;

                        @endphp


                        <tr>

                            {{-- NO --}}

                            <td class="text-center align-middle">

                                {{ $loop->iteration }}

                            </td>


                            {{-- NAMA --}}

                            <td class="align-middle">

                                <strong>
                                    {{ $user->name ?? '-' }}
                                </strong>

                            </td>


                            {{-- PROGRAM --}}

                            <td class="align-middle">

                                {{ $program->name ?? '-' }}

                            </td>


                            {{-- GELOMBANG --}}

                            <td class="align-middle">

                                {{ $wave->name ?? '-' }}

                            </td>


                            {{-- KELAS --}}

                            <td class="align-middle">

                                {{ $classroom->name ?? '-' }}

                            </td>


                            {{-- STATUS --}}

                            <td class="text-center align-middle">

                                @switch($status)
                                    @case('Aktif')
                                        <span class="badge badge-success px-2 py-1">

                                            <i class="fas fa-check-circle mr-1"></i>
                                            Aktif

                                        </span>
                                    @break

                                    @case('Lulus')
                                        <span class="badge badge-primary px-2 py-1">

                                            <i class="fas fa-graduation-cap mr-1"></i>
                                            Lulus

                                        </span>
                                    @break

                                    @case('Nonaktif')
                                        <span class="badge badge-danger px-2 py-1">

                                            <i class="fas fa-times-circle mr-1"></i>
                                            Nonaktif

                                        </span>
                                    @break

                                    @default
                                        <span class="badge badge-secondary px-2 py-1">

                                            {{ $status ?? '-' }}

                                        </span>
                                @endswitch

                            </td>

                        </tr>


                        @empty

                            <tr>

                                <td colspan="6" class="text-center text-muted py-5">

                                    <i class="fas fa-users fa-2x mb-2"></i>

                                    <br>

                                    <strong>
                                        Tidak ada data peserta
                                    </strong>

                                    <br>

                                    <small>
                                        Silakan ubah filter laporan kemudian coba kembali.
                                    </small>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
             FOOTER TABLE
        ====================================================== --}}

            @if ($participants->count() > 0)
                <div class="d-flex justify-content-between align-items-center mt-3">

                    <small class="text-muted">

                        <i class="fas fa-info-circle mr-1"></i>

                        Total data:
                        <strong>
                            {{ $participants->count() }}
                        </strong>
                        peserta

                    </small>

                </div>
            @endif

        </x-adminlte-card>

    @stop
