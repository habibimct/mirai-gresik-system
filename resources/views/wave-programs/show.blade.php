@extends('adminlte::page')

@section('title', 'Detail Program Gelombang')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-0">
                Detail Program Gelombang
            </h1>

            <small class="text-muted">
                Informasi program pada {{ $wave->name }}
            </small>

        </div>

        <a href="{{ route('waves.programs.index', $wave) }}" class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>

            Kembali

        </a>

    </div>

@stop


@section('content')


    {{-- =========================================================
         INFORMASI PROGRAM
         ========================================================= --}}

    <div class="card card-outline card-primary">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-graduation-cap mr-2"></i>

                Informasi Program

            </h3>

        </div>


        <div class="card-body">

            <div class="row">

                {{-- GELOMBANG --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label class="text-muted">
                            <i class="fas fa-layer-group mr-1"></i>
                            Gelombang
                        </label>

                        <div class="form-control bg-light">

                            {{ $wave->name }}

                        </div>

                    </div>

                </div>


                {{-- PROGRAM --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label class="text-muted">

                            <i class="fas fa-graduation-cap mr-1"></i>

                            Program

                        </label>

                        <div class="form-control bg-light">

                            {{ $program->program->name }}

                        </div>

                    </div>

                </div>


                {{-- KUOTA --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label class="text-muted">

                            <i class="fas fa-users mr-1"></i>

                            Kuota Peserta

                        </label>

                        <div class="form-control bg-light">

                            {{ $program->quota }}

                            <span class="text-muted">
                                peserta
                            </span>

                        </div>

                    </div>

                </div>


                {{-- STATUS --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label class="text-muted">

                            <i class="fas fa-toggle-on mr-1"></i>

                            Status

                        </label>

                        <div class="form-control bg-light">

                            @if ($program->is_active)
                                <span class="badge badge-success">

                                    <i class="fas fa-check-circle mr-1"></i>

                                    Aktif

                                </span>
                            @else
                                <span class="badge badge-danger">

                                    <i class="fas fa-times-circle mr-1"></i>

                                    Nonaktif

                                </span>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- FOOTER --}}

        <div class="card-footer d-flex align-items-center w-100">

            <a href="{{ route('waves.programs.index', $wave) }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left mr-1"></i>
                Kembali

            </a>

            <a href="{{ route('waves.programs.edit', [$wave, $program]) }}" class="btn btn-warning ml-auto">

                <i class="fas fa-edit mr-1"></i>
                Edit

            </a>

        </div>


    </div>


@stop
