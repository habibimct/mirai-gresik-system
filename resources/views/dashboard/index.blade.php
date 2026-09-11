@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

<div class="d-flex justify-content-between align-items-center">

    <div>
        <h1 class="mb-1">Dashboard</h1>

        <p class="text-muted mb-0">
            Ringkasan sistem LPK Mirai Gresik
        </p>
    </div>

</div>

@stop


@section('css')

<style>
    /* =========================================================
       MGS SIDEBAR - TEST
       ========================================================= */

    .nav-sidebar .nav-link {
        border-radius: 6px;
        margin: 3px 8px;
        transition: all .2s ease;
    }

    .nav-sidebar .nav-link:hover {
        background: rgba(255,255,255,.08);
    }

    /* Menu induk */
    .nav-sidebar > .nav-item > .nav-link {
        font-weight: 600;
    }

    /* Submenu */
    .nav-treeview {
        position: relative;
        margin-top: 2px;
        margin-bottom: 4px;
    }

    /* Garis vertikal submenu */
    .nav-treeview::before {
        content: "";
        position: absolute;
        left: 24px;
        top: 6px;
        bottom: 6px;
        width: 1px;
        background: rgba(255,255,255,.18);
    }

    /* Link submenu */
    .nav-treeview .nav-link {
        margin-left: 18px;
        padding-left: 22px !important;
        font-size: 14px;
        color: #cfd4da !important;
    }

    /* Ikon submenu */
    .nav-treeview .nav-icon {
        font-size: 8px !important;
        margin-right: 12px !important;
        color: #adb5bd !important;
    }

    /* Hover submenu */
    .nav-treeview .nav-link:hover {
        background: rgba(255,255,255,.06);
        color: #ffffff !important;
    }

    /* Submenu aktif */
    .nav-treeview .nav-link.active {
        background: #f1f3f5 !important;
        color: #343a40 !important;
        font-weight: 600;
    }

    /* Ikon submenu aktif */
    .nav-treeview .nav-link.active .nav-icon {
        color: #1976d2 !important;
    }
</style>

@stop



@section('content')


{{-- ========================================================= --}}
{{-- STATISTIK UTAMA --}}
{{-- ========================================================= --}}

<div class="row">

    {{-- PESERTA --}}
    <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="small-box bg-primary">

            <div class="inner">

                <h3>{{ $participantCount }}</h3>

                <p>Peserta</p>

            </div>

            <div class="icon">

                <i class="fas fa-users"></i>

            </div>

        </div>

    </div>


    {{-- INSTRUKTUR --}}
    <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="small-box bg-success">

            <div class="inner">

                <h3>{{ $instructorCount }}</h3>

                <p>Instruktur</p>

            </div>

            <div class="icon">

                <i class="fas fa-chalkboard-teacher"></i>

            </div>

        </div>

    </div>


    {{-- PROGRAM --}}
    <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="small-box bg-warning">

            <div class="inner">

                <h3>{{ $programCount }}</h3>

                <p>Program</p>

            </div>

            <div class="icon">

                <i class="fas fa-book"></i>

            </div>

        </div>

    </div>


    {{-- GELOMBANG --}}
    <div class="col-lg-3 col-md-6 col-sm-6">

        <div class="small-box bg-danger">

            <div class="inner">

                <h3>{{ $waveCount }}</h3>

                <p>Gelombang</p>

            </div>

            <div class="icon">

                <i class="fas fa-layer-group"></i>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- STATISTIK TAMBAHAN --}}
{{-- ========================================================= --}}

<div class="row">

    {{-- CLASSROOM --}}
    <div class="col-lg-4 col-md-4">

        <div class="info-box">

            <span class="info-box-icon bg-info">

                <i class="fas fa-school"></i>

            </span>

            <div class="info-box-content">

                <span class="info-box-text">
                    Classroom
                </span>

                <span class="info-box-number">
                    {{ $classroomCount }}
                </span>

            </div>

        </div>

    </div>


    {{-- INVOICE --}}
    <div class="col-lg-4 col-md-4">

        <div class="info-box">

            <span class="info-box-icon bg-secondary">

                <i class="fas fa-file-invoice"></i>

            </span>

            <div class="info-box-content">

                <span class="info-box-text">
                    Invoice
                </span>

                <span class="info-box-number">
                    {{ $invoiceCount }}
                </span>

            </div>

        </div>

    </div>


    {{-- PEMBAYARAN --}}
    <div class="col-lg-4 col-md-4">

        <div class="info-box">

            <span class="info-box-icon bg-success">

                <i class="fas fa-money-bill-wave"></i>

            </span>

            <div class="info-box-content">

                <span class="info-box-text">
                    Pembayaran
                </span>

                <span class="info-box-number">
                    {{ $paymentCount }}
                </span>

            </div>

        </div>

    </div>

</div>



{{-- ========================================================= --}}
{{-- RIWAYAT AKTIVITAS --}}
{{-- ========================================================= --}}

<div class="card card-outline card-primary">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-history mr-1"></i>

            Riwayat Aktivitas Terbaru

        </h3>

        <div class="card-tools">

            <a
                href="{{ route('activity-logs.index') }}"
                class="btn btn-sm btn-primary"
            >

                <i class="fas fa-list mr-1"></i>

                Lihat Semua

            </a>

        </div>

    </div>


    <div class="card-body p-0">

        @if($recentActivities->count())

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>

                            <th style="width: 150px;">
                                Waktu
                            </th>

                            <th style="width: 180px;">
                                User
                            </th>

                            <th style="width: 120px;">
                                Aktivitas
                            </th>

                            <th>
                                Keterangan
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($recentActivities as $activity)

                            <tr>

                                {{-- WAKTU --}}
                                <td>

                                    {{ $activity->created_at->format('d/m/Y') }}

                                    <br>

                                    <small class="text-muted">

                                        {{ $activity->created_at->format('H:i:s') }}

                                    </small>

                                </td>


                                {{-- USER --}}
                                <td>

                                    @if($activity->causer)

                                        <strong>

                                            {{ $activity->causer->name }}

                                        </strong>

                                        @if(method_exists(
                                            $activity->causer,
                                            'getRoleNames'
                                        ))

                                            <br>

                                            <span class="badge badge-secondary">

                                                {{
                                                    $activity->causer
                                                        ->getRoleNames()
                                                        ->first() ?? '-'
                                                }}

                                            </span>

                                        @endif

                                    @else

                                        <span class="text-muted">

                                            System

                                        </span>

                                    @endif

                                </td>


                                {{-- AKTIVITAS --}}
                                <td>

                                    @switch($activity->event)

                                        @case('created')

                                            <span class="badge badge-success">

                                                <i class="fas fa-plus mr-1"></i>

                                                CREATE

                                            </span>

                                            @break


                                        @case('updated')

                                            <span class="badge badge-primary">

                                                <i class="fas fa-edit mr-1"></i>

                                                UPDATE

                                            </span>

                                            @break


                                        @case('deleted')

                                            <span class="badge badge-danger">

                                                <i class="fas fa-trash mr-1"></i>

                                                DELETE

                                            </span>

                                            @break


                                        @default

                                            <span class="badge badge-secondary">

                                                {{
                                                    strtoupper(
                                                        $activity->event ?? 'ACTIVITY'
                                                    )
                                                }}

                                            </span>

                                    @endswitch

                                </td>


                                {{-- KETERANGAN --}}
                                <td>

                                    {{ $activity->description }}

                                    @if($activity->subject)

                                        <br>

                                        <small class="text-muted">

                                            {{ class_basename(
                                                $activity->subject_type
                                            ) }}

                                            #{{ $activity->subject_id }}

                                        </small>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center p-4">

                <i class="fas fa-history fa-2x text-muted mb-2"></i>

                <p class="text-muted mb-0">

                    Belum ada aktivitas yang tercatat.

                </p>

            </div>

        @endif

    </div>

</div>


@stop