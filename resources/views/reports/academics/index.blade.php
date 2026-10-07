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

    </div>

    @include('reports.academics.partials.filters')

    @include('reports.academics.partials.tabs')

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
