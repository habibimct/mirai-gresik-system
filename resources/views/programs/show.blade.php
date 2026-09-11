@extends('adminlte::page')

@section('title', 'Detail Program')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-0">
                <i class="fas fa-graduation-cap mr-2"></i>
                Detail Program
            </h1>

            <small class="text-muted">
                Informasi lengkap program pelatihan
            </small>
        </div>

        <a href="{{ route('programs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>

    </div>

@stop


@section('content')


    {{-- =========================================================
         INFORMASI UTAMA
    ========================================================== --}}

    <div class="row">


        {{-- PROFIL PROGRAM --}}

        <div class="col-lg-8">

            <div class="card card-primary card-outline">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-info-circle mr-1"></i>

                        Informasi Program

                    </h3>

                </div>


                <div class="card-body">


                    {{-- KODE PROGRAM --}}

                    <div class="row mb-3">

                        <div class="col-md-4 text-muted">
                            Kode Program
                        </div>

                        <div class="col-md-8">

                            <span class="badge badge-secondary px-3 py-2">

                                {{ $program->code }}

                            </span>

                        </div>

                    </div>


                    <hr>


                    {{-- NAMA PROGRAM --}}

                    <div class="row mb-3">

                        <div class="col-md-4 text-muted">
                            Nama Program
                        </div>

                        <div class="col-md-8">

                            <h5 class="font-weight-bold mb-0">

                                {{ $program->name }}

                            </h5>

                        </div>

                    </div>


                    <hr>


                    {{-- DESKRIPSI --}}

                    <div class="row mb-3">

                        <div class="col-md-4 text-muted">
                            Deskripsi
                        </div>

                        <div class="col-md-8">

                            @if ($program->description)

                                <div class="text-justify">

                                    {{ $program->description }}

                                </div>

                            @else

                                <span class="text-muted font-italic">

                                    Belum ada deskripsi program.

                                </span>

                            @endif

                        </div>

                    </div>


                    <hr>


                    {{-- STATUS --}}

                    <div class="row">

                        <div class="col-md-4 text-muted">
                            Status Program
                        </div>

                        <div class="col-md-8">

                            @if ($program->is_active)

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


                </div>

            </div>

        </div>



        {{-- RINGKASAN --}}

        <div class="col-lg-4">

            <div class="card card-info card-outline">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-clipboard-list mr-1"></i>

                        Ringkasan

                    </h3>

                </div>


                <div class="card-body">


                    {{-- KODE --}}

                    <div class="text-center mb-4">

                        <div class="text-muted small mb-1">
                            Kode Program
                        </div>

                        <h3 class="font-weight-bold mb-0">

                            {{ $program->code }}

                        </h3>

                    </div>


                    <hr>


                    {{-- STATUS --}}

                    <div class="text-center mt-4">

                        <div class="text-muted small mb-2">
                            Status
                        </div>

                        @if ($program->is_active)

                            <span class="badge badge-success px-3 py-2">

                                <i class="fas fa-check-circle mr-1"></i>
                                Program Aktif

                            </span>

                        @else

                            <span class="badge badge-danger px-3 py-2">

                                <i class="fas fa-times-circle mr-1"></i>
                                Program Nonaktif

                            </span>

                        @endif

                    </div>


                </div>

            </div>


            {{-- INFORMASI SISTEM --}}

            <div class="card card-default">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-database mr-1"></i>

                        Informasi Sistem

                    </h3>

                </div>


                <div class="card-body">

                    <div class="small">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                ID Program
                            </span>

                            <strong>
                                #{{ $program->id }}
                            </strong>

                        </div>


                        @if ($program->created_at)

                            <div class="d-flex justify-content-between mb-2">

                                <span class="text-muted">
                                    Dibuat
                                </span>

                                <strong>
                                    {{ $program->created_at->format('d-m-Y H:i') }}
                                </strong>

                            </div>

                        @endif


                        @if ($program->updated_at)

                            <div class="d-flex justify-content-between">

                                <span class="text-muted">
                                    Diperbarui
                                </span>

                                <strong>
                                    {{ $program->updated_at->format('d-m-Y H:i') }}
                                </strong>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =========================================================
         ACTION
    ========================================================== --}}

    <div class="card">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <strong>
                        Kelola Program
                    </strong>

                    <div class="small text-muted">
                        Ubah informasi program jika diperlukan.
                    </div>

                </div>


                <div>
                    <a
                        href="{{ route('programs.edit', $program) }}"
                        class="btn btn-warning"
                    >

                        <i class="fas fa-edit mr-1"></i>

                        Edit Program

                    </a>
                </div>

            </div>

        </div>

    </div>


@stop