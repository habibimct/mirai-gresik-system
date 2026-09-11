@extends('adminlte::page')

@section('title', 'Detail Gelombang')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">
                <i class="fas fa-layer-group mr-2"></i>
                Detail Gelombang
            </h1>

            <p class="text-muted mb-0">
                Informasi lengkap gelombang pelatihan.
            </p>

        </div>

        <div>

            <a href="{{ route('waves.index') }}"
                class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>

                Kembali

            </a>

            <a href="{{ route('waves.edit', $wave) }}"
                class="btn btn-warning">

                <i class="fas fa-edit mr-1"></i>

                Edit

            </a>

        </div>

    </div>

@stop


@section('content')

    {{-- =========================================================
        IDENTITAS GELOMBANG
    ========================================================== --}}

    <div class="row">

        {{-- KODE --}}

        <div class="col-md-4">

            <x-adminlte-info-box
                title="{{ $wave->code }}"
                text="Kode Gelombang"
                icon="fas fa-hashtag"
                theme="primary"
            />

        </div>


        {{-- TAHUN --}}

        <div class="col-md-4">

            <x-adminlte-info-box
                title="{{ $wave->year }}"
                text="Tahun Pelaksanaan"
                icon="fas fa-calendar-alt"
                theme="info"
            />

        </div>


        {{-- STATUS --}}

        <div class="col-md-4">

            <x-adminlte-info-box
                title="{{ $wave->is_active ? 'Aktif' : 'Nonaktif' }}"
                text="Status Gelombang"
                icon="fas {{ $wave->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"
                theme="{{ $wave->is_active ? 'success' : 'danger' }}"
            />

        </div>

    </div>



    {{-- =========================================================
        INFORMASI GELOMBANG
    ========================================================== --}}

    <x-adminlte-card
        title="Informasi Gelombang"
        theme="primary"
        icon="fas fa-info-circle"
    >

        <div class="row">

            {{-- NAMA GELOMBANG --}}

            <div class="col-md-6">

                <div class="form-group">

                    <label class="text-muted mb-1">
                        Nama Gelombang
                    </label>

                    <div class="form-control bg-light">

                        <strong>
                            {{ $wave->name }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- KODE --}}

            <div class="col-md-3">

                <div class="form-group">

                    <label class="text-muted mb-1">
                        Kode
                    </label>

                    <div class="form-control bg-light">

                        {{ $wave->code }}

                    </div>

                </div>

            </div>


            {{-- TAHUN --}}

            <div class="col-md-3">

                <div class="form-group">

                    <label class="text-muted mb-1">
                        Tahun
                    </label>

                    <div class="form-control bg-light">

                        {{ $wave->year }}

                    </div>

                </div>

            </div>

        </div>

    </x-adminlte-card>



    {{-- =========================================================
        PERIODE
    ========================================================== --}}

    <div class="row">

        {{-- PENDAFTARAN --}}

        <div class="col-md-6">

            <x-adminlte-card
                title="Periode Pendaftaran"
                theme="info"
                icon="fas fa-calendar-alt"
            >

                <div class="row">

                    <div class="col-6">

                        <div class="text-muted small mb-1">
                            Mulai
                        </div>

                        <div class="font-weight-bold">

                            @if ($wave->registration_start)

                                {{ \Carbon\Carbon::parse($wave->registration_start)->translatedFormat('d F Y') }}

                            @else

                                <span class="text-muted">
                                    -
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="col-6">

                        <div class="text-muted small mb-1">
                            Selesai
                        </div>

                        <div class="font-weight-bold">

                            @if ($wave->registration_end)

                                {{ \Carbon\Carbon::parse($wave->registration_end)->translatedFormat('d F Y') }}

                            @else

                                <span class="text-muted">
                                    -
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </x-adminlte-card>

        </div>


        {{-- PELATIHAN --}}

        <div class="col-md-6">

            <x-adminlte-card
                title="Periode Pelatihan"
                theme="success"
                icon="fas fa-calendar-check"
            >

                <div class="row">

                    <div class="col-6">

                        <div class="text-muted small mb-1">
                            Mulai
                        </div>

                        <div class="font-weight-bold">

                            @if ($wave->training_start)

                                {{ \Carbon\Carbon::parse($wave->training_start)->translatedFormat('d F Y') }}

                            @else

                                <span class="text-muted">
                                    -
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="col-6">

                        <div class="text-muted small mb-1">
                            Selesai
                        </div>

                        <div class="font-weight-bold">

                            @if ($wave->training_end)

                                {{ \Carbon\Carbon::parse($wave->training_end)->translatedFormat('d F Y') }}

                            @else

                                <span class="text-muted">
                                    -
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </x-adminlte-card>

        </div>

    </div>



    {{-- =========================================================
        STATUS & DESKRIPSI
    ========================================================== --}}

    <x-adminlte-card
        title="Status dan Deskripsi"
        theme="warning"
        icon="fas fa-file-alt"
    >

        <div class="row">

            {{-- STATUS --}}

            <div class="col-md-3">

                <label class="text-muted mb-2">
                    Status
                </label>

                <div>

                    @if ($wave->is_active)

                        <span class="badge badge-success px-3 py-2">

                            <i class="fas fa-check-circle mr-1"></i>

                            Aktif

                        </span>

                    @else

                        <span class="badge badge-danger px-3 py-2">

                            <i class="fas fa-times-circle mr-1"></i>

                            Nonaktif

                        </span>

                    @endif

                </div>

            </div>


            {{-- DESKRIPSI --}}

            <div class="col-md-9">

                <label class="text-muted mb-2">
                    Deskripsi
                </label>

                <div class="bg-light border rounded p-3">

                    @if ($wave->description)

                        {!! nl2br(e($wave->description)) !!}

                    @else

                        <span class="text-muted">
                            Tidak ada deskripsi.
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </x-adminlte-card>



    {{-- =========================================================
        INFORMASI SISTEM
    ========================================================== --}}

    <x-adminlte-card
        title="Informasi Sistem"
        theme="secondary"
        icon="fas fa-database"
        collapsible
        collapsed
    >

        <table class="table table-sm table-borderless mb-0">

            <tr>

                <td width="180" class="text-muted">
                    ID Gelombang
                </td>

                <td>
                    {{ $wave->id }}
                </td>

            </tr>

            <tr>

                <td class="text-muted">
                    Dibuat
                </td>

                <td>

                    {{ $wave->created_at?->translatedFormat('d F Y H:i') ?? '-' }}

                </td>

            </tr>

            <tr>

                <td class="text-muted">
                    Terakhir Diperbarui
                </td>

                <td>

                    {{ $wave->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}

                </td>

            </tr>

        </table>

    </x-adminlte-card>



    {{-- =========================================================
        ACTION FOOTER
    ========================================================== --}}

    <div class="card mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div class="text-muted small">

                    <i class="fas fa-info-circle mr-1"></i>

                    Informasi lengkap gelombang
                    <strong>{{ $wave->name }}</strong>.

                </div>


                <div>

                </div>

            </div>

        </div>

    </div>

@stop