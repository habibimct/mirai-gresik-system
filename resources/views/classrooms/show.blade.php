@extends('adminlte::page')

@section('title', 'Detail Kelas')


@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-0">
                Detail Kelas
            </h1>

            <small class="text-muted">
                {{ $classroom->name }}
                <span class="mx-1">•</span>
                Kode: {{ $classroom->code }}
            </small>

        </div>


        <div>

            <a href="{{ route('classrooms.edit', $classroom) }}" class="btn btn-warning">

                <i class="fas fa-edit mr-1"></i>
                Edit

            </a>

            <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>
                Kembali

            </a>

        </div>

    </div>

@stop


@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-2"></i>

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>

        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- INFORMASI DASAR KELAS --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3 mb-md-0">

                    <div class="text-muted small">
                        PROGRAM
                    </div>

                    <div class="font-weight-bold">
                        {{ $classroom->waveProgram->program->name ?? '-' }}
                    </div>

                </div>


                <div class="col-md-4 mb-3 mb-md-0">

                    <div class="text-muted small">
                        GELOMBANG
                    </div>

                    <div class="font-weight-bold">
                        {{ $classroom->waveProgram->wave->name ?? '-' }}
                    </div>

                </div>


                <div class="col-md-4">

                    <div class="text-muted small">
                        RUANGAN
                    </div>

                    <div class="font-weight-bold">
                        {{ $classroom->room ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>


    @php

        $jumlahPeserta = $classroom->participantClassrooms->count();

        $kapasitas = $classroom->capacity;

        $sisaKuota = max(0, $kapasitas - $jumlahPeserta);

        $persenKuota = $kapasitas > 0 ? min(100, ($jumlahPeserta / $kapasitas) * 100) : 0;

    @endphp


    {{-- ========================================================= --}}
    {{-- STATISTIK --}}
    {{-- ========================================================= --}}

    <div class="row">


        {{-- PESERTA --}}
        <div class="col-lg-3 col-md-6">

            <x-adminlte-small-box title="{{ $jumlahPeserta }}" text="Peserta" theme="info" icon="fas fa-users" />

        </div>


        {{-- JADWAL --}}
        <div class="col-lg-3 col-md-6">

            <x-adminlte-small-box title="{{ $classroom->schedules->count() }}" text="Jadwal" theme="success"
                icon="fas fa-calendar-alt" />

        </div>


        {{-- PERTEMUAN --}}
        <div class="col-lg-3 col-md-6">

            <x-adminlte-small-box title="{{ $classroom->attendanceSessions->count() }}" text="Pertemuan" theme="warning"
                icon="fas fa-chalkboard-teacher" />

        </div>


        {{-- KAPASITAS --}}
        <div class="col-lg-3 col-md-6">

            <x-adminlte-small-box title="{{ $kapasitas }}" text="Kapasitas" theme="primary" icon="fas fa-door-open" />

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- KUOTA --}}
    {{-- ========================================================= --}}

    <x-adminlte-card title="Kapasitas Kelas" theme="primary" icon="fas fa-users">

        <div class="row align-items-center">

            <div class="col-md-8">

                <div class="progress" style="height: 24px;">

                    <div class="progress-bar
                        @if ($persenKuota >= 100) bg-danger
                        @elseif ($persenKuota >= 80)
                            bg-warning
                        @else
                            bg-success @endif"
                        role="progressbar" style="width: {{ $persenKuota }}%;" aria-valuenow="{{ $persenKuota }}"
                        aria-valuemin="0" aria-valuemax="100">

                        {{ $jumlahPeserta }} / {{ $kapasitas }}

                    </div>

                </div>

            </div>


            <div class="col-md-4 mt-3 mt-md-0 text-md-right">

                @if ($sisaKuota <= 0)
                    <span class="badge badge-danger p-2">

                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Kelas Penuh

                    </span>
                @elseif ($sisaKuota <= 3)
                    <span class="badge badge-warning p-2">

                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Sisa {{ $sisaKuota }} kursi

                    </span>
                @else
                    <span class="badge badge-success p-2">

                        <i class="fas fa-check-circle mr-1"></i>
                        Sisa {{ $sisaKuota }} kursi

                    </span>
                @endif

            </div>

        </div>

    </x-adminlte-card>


    {{-- ========================================================= --}}
    {{-- TAB KELAS --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header p-0">

            <ul class="nav nav-tabs" id="classroomTab" role="tablist">


                {{-- INFORMASI --}}
                <li class="nav-item">

                    <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab"
                        aria-controls="info" aria-selected="true">

                        <i class="fas fa-info-circle mr-1"></i>
                        Informasi

                    </a>

                </li>


                {{-- PESERTA --}}
                <li class="nav-item">

                    <a class="nav-link" id="participants-tab" data-toggle="tab" href="#participants" role="tab"
                        aria-controls="participants" aria-selected="false">

                        <i class="fas fa-users mr-1"></i>
                        Peserta

                    </a>

                </li>


                {{-- JADWAL --}}
                <li class="nav-item">

                    <a class="nav-link" id="schedules-tab" data-toggle="tab" href="#schedules" role="tab"
                        aria-controls="schedules" aria-selected="false">

                        <i class="fas fa-calendar-alt mr-1"></i>
                        Jadwal

                    </a>

                </li>


                {{-- ABSENSI --}}
                <li class="nav-item">

                    <a class="nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab"
                        aria-controls="attendance" aria-selected="false">

                        <i class="fas fa-user-check mr-1"></i>
                        Absensi

                    </a>

                </li>


                {{-- NILAI --}}
                <li class="nav-item">

                    <a class="nav-link" id="scores-tab" data-toggle="tab" href="#scores" role="tab"
                        aria-controls="scores" aria-selected="false">

                        <i class="fas fa-chart-line mr-1"></i>
                        Nilai

                    </a>

                </li>

                {{-- NILAI SIKAP --}}
                <li class="nav-item">
                    <a class="nav-link" id="attitudes-tab" data-toggle="tab" href="#attitudes" role="tab"
                        aria-controls="attitudes" aria-selected="false">

                        <i class="fas fa-user-check mr-1"></i>
                        Nilai Sikap

                    </a>
                </li>

            </ul>

        </div>


        <div class="card-body">

            <div class="tab-content" id="classroomTabContent">


                {{-- INFORMASI --}}
                <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">

                    @include('classrooms.tabs.information')

                </div>


                {{-- PESERTA --}}
                <div class="tab-pane fade" id="participants" role="tabpanel" aria-labelledby="participants-tab">

                    @include('classrooms.tabs.participants')

                </div>


                {{-- JADWAL --}}
                <div class="tab-pane fade" id="schedules" role="tabpanel" aria-labelledby="schedules-tab">

                    @include('classrooms.tabs.schedules')

                </div>


                {{-- ABSENSI --}}
                <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">

                    @include('classrooms.tabs.attendance')

                </div>


                {{-- NILAI --}}
                <div class="tab-pane fade" id="scores" role="tabpanel" aria-labelledby="scores-tab">

                    @include('classrooms.tabs.scores')

                </div>

                {{-- NILAI SIKAP --}}
                <div class="tab-pane fade" id="attitudes" role="tabpanel" aria-labelledby="attitudes-tab">

                    @include('classrooms.tabs.attitudes')

                </div>

            </div>

        </div>

    </div>

@stop


@section('js')

    <script>
        $(document).ready(function() {

            console.log('CLASSROOM TAB SCRIPT BERJALAN');


            const classroomId = '{{ $classroom->id }}';

            const storageKey = 'classroom-active-tab-' + classroomId;


            console.log('Classroom ID:', classroomId);

            console.log('Storage Key:', storageKey);


            const savedTab = localStorage.getItem(storageKey);

            console.log('Saved Tab:', savedTab);


            if (savedTab) {

                const $tab = $('.nav-tabs a[href="' + savedTab + '"]');

                console.log('Tab ditemukan:', $tab.length);


                if ($tab.length) {

                    $tab.tab('show');

                }

            }


            $('.nav-tabs a[data-toggle="tab"]').on(
                'shown.bs.tab',
                function(e) {

                    const activeTab = $(e.target).attr('href');

                    console.log('Tab berubah menjadi:', activeTab);


                    localStorage.setItem(
                        storageKey,
                        activeTab
                    );

                }
            );

        });
    </script>

    <script>
        $(function() {

            $(document).on('change', '#checkAll', function() {

                $('#assignParticipantsForm .participant-checkbox')
                    .prop('checked', this.checked);

            });


            $(document).on('change', '#assignParticipantsForm .participant-checkbox', function() {

                const total =
                    $('#assignParticipantsForm .participant-checkbox').length;

                const checked =
                    $('#assignParticipantsForm .participant-checkbox:checked').length;

                $('#checkAll').prop(
                    'checked',
                    total > 0 && total === checked
                );

            });

        });
    </script>

@stop

{{-- =========================================================
     JAVASCRIPT CHECK ALL
========================================================= --}}

@section('js')



@stop
