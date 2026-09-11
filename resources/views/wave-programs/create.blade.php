@extends('adminlte::page')

@section('title', 'Tambah Program Gelombang')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-0">
                Tambah Program Gelombang
            </h1>

            <small class="text-muted">
                Menambahkan program ke {{ $wave->name }}
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
         VALIDASI ERROR
         ========================================================= --}}

    @if ($errors->any())

        <div class="alert alert-danger">

            <h5>

                <i class="fas fa-exclamation-triangle mr-1"></i>

                Terdapat kesalahan

            </h5>

            <ul class="mb-0 pl-4">

                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
         FORM TAMBAH PROGRAM
         ========================================================= --}}

    <div class="card card-outline card-primary">


        {{-- HEADER CARD --}}

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-plus-circle mr-2"></i>

                Informasi Program

            </h3>

        </div>


        <form action="{{ route('waves.programs.store', $wave) }}" method="POST">

            @csrf


            <div class="card-body">


                {{-- =================================================
                     GELOMBANG
                     ================================================= --}}

                <div class="form-group">

                    <label>

                        <i class="fas fa-layer-group mr-1 text-primary"></i>

                        Gelombang

                    </label>


                    <input type="text" class="form-control" value="{{ $wave->name }}" readonly>


                    <small class="form-text text-muted">

                        Program akan ditambahkan ke gelombang ini.

                    </small>

                </div>


                {{-- =================================================
                     PROGRAM & KUOTA
                     ================================================= --}}

                <div class="row">


                    {{-- PROGRAM --}}

                    <div class="col-md-8">

                        <div class="form-group">

                            <label for="program_id">

                                <i class="fas fa-graduation-cap mr-1 text-primary"></i>

                                Program

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <select name="program_id" id="program_id"
                                class="form-control @error('program_id') is-invalid @enderror">

                                <option value="">

                                    -- Pilih Program --

                                </option>


                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}"
                                        {{ old('program_id') == $program->id ? 'selected' : '' }}>

                                        {{ $program->name }}

                                    </option>
                                @endforeach

                            </select>


                            @error('program_id')
                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- KUOTA --}}

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="quota">

                                <i class="fas fa-users mr-1 text-primary"></i>

                                Kuota

                                <span class="text-danger">
                                    *
                                </span>

                            </label>


                            <input type="number" name="quota" id="quota" min="1"
                                class="form-control @error('quota') is-invalid @enderror" value="{{ old('quota', 0) }}">


                            @error('quota')
                                <div class="invalid-feedback">

                                    {{ $message }}

                                </div>
                            @enderror


                            <small class="form-text text-muted">

                                Jumlah maksimal peserta untuk program ini.

                            </small>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     STATUS
                     ================================================= --}}

                <div class="form-group">

                    <label for="is_active">

                        <i class="fas fa-toggle-on mr-1 text-primary"></i>

                        Status Program

                    </label>


                    <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror">

                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>

                            Aktif

                        </option>


                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>

                            Nonaktif

                        </option>

                    </select>


                    @error('is_active')
                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>
                    @enderror


                    <small class="form-text text-muted">

                        Program aktif dapat digunakan dalam proses pelatihan.

                    </small>

                </div>


            </div>


            {{-- =========================================================
                 FOOTER
                 ========================================================= --}}

            <div class="card-footer d-flex justify-content-between align-items-center">

                <a href="{{ route('waves.programs.index', $wave) }}" class="btn btn-secondary">

                    <i class="fas fa-times mr-1"></i>

                    Batal

                </a>

                <button type="submit" class="btn btn-primary ml-auto">

                    <i class="fas fa-save mr-1"></i>

                    Simpan Program

                </button>
            </div>

        </form>

    </div>


@stop
