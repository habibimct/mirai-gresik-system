@extends('adminlte::page')

@section('title', 'Edit Gelombang')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-0">Edit Gelombang</h1>
            <small class="text-muted">
                Perbarui informasi gelombang pelatihan
            </small>
        </div>

        <a href="{{ route('waves.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>
    </div>
@stop

@section('content')

    {{-- Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Terjadi Kesalahan
            </h5>

            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div class="card card-primary">

        {{-- Card Header --}}
        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-edit mr-1"></i>
                Form Edit Gelombang
            </h3>

        </div>


        <form action="{{ route('waves.update', $wave) }}" method="POST">

            @csrf
            @method('PUT')


            <div class="card-body">

                {{-- =====================================================
                    INFORMASI DASAR
                ====================================================== --}}

                <h5 class="text-primary mb-3">
                    <i class="fas fa-info-circle mr-1"></i>
                    Informasi Dasar
                </h5>


                <div class="row">

                    {{-- Kode --}}
                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="code">
                                Kode Gelombang
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="code" name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $wave->code) }}" placeholder="Contoh: G01">

                            @error('code')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Nama --}}
                    <div class="col-md-5">

                        <div class="form-group">

                            <label for="name">
                                Nama Gelombang
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $wave->name) }}" placeholder="Contoh: Gelombang I">

                            @error('name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Tahun --}}
                    <div class="col-md-3">

                        <div class="form-group">

                            <label for="year">
                                Tahun
                                <span class="text-danger">*</span>
                            </label>

                            <input type="number" id="year" name="year"
                                class="form-control @error('year') is-invalid @enderror"
                                value="{{ old('year', $wave->year) }}" min="2000" max="2100">

                            @error('year')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    PERIODE PENDAFTARAN
                ====================================================== --}}

                <hr>

                <h5 class="text-primary mb-3">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Periode Pendaftaran
                </h5>


                <div class="row">

                    {{-- Mulai Pendaftaran --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="registration_start">
                                Tanggal Mulai Pendaftaran
                            </label>

                            <input type="date" id="registration_start" name="registration_start"
                                class="form-control @error('registration_start') is-invalid @enderror"
                                value="{{ old('registration_start', $wave->registration_start) }}">

                            @error('registration_start')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Selesai Pendaftaran --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="registration_end">
                                Tanggal Selesai Pendaftaran
                            </label>

                            <input type="date" id="registration_end" name="registration_end"
                                class="form-control @error('registration_end') is-invalid @enderror"
                                value="{{ old('registration_end', $wave->registration_end) }}">

                            @error('registration_end')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    PERIODE PELATIHAN
                ====================================================== --}}

                <hr>

                <h5 class="text-primary mb-3">
                    <i class="fas fa-chalkboard-teacher mr-1"></i>
                    Periode Pelatihan
                </h5>


                <div class="row">

                    {{-- Mulai Pelatihan --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="training_start">
                                Tanggal Mulai Pelatihan
                            </label>

                            <input type="date" id="training_start" name="training_start"
                                class="form-control @error('training_start') is-invalid @enderror"
                                value="{{ old('training_start', $wave->training_start) }}">

                            @error('training_start')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Selesai Pelatihan --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="training_end">
                                Tanggal Selesai Pelatihan
                            </label>

                            <input type="date" id="training_end" name="training_end"
                                class="form-control @error('training_end') is-invalid @enderror"
                                value="{{ old('training_end', $wave->training_end) }}">

                            @error('training_end')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    STATUS
                ====================================================== --}}

                <hr>

                <h5 class="text-primary mb-3">
                    <i class="fas fa-toggle-on mr-1"></i>
                    Status Gelombang
                </h5>


                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="is_active">
                                Status
                            </label>

                            <select id="is_active" name="is_active"
                                class="form-control @error('is_active') is-invalid @enderror">

                                <option value="1" {{ old('is_active', $wave->is_active) == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="0" {{ old('is_active', $wave->is_active) == 0 ? 'selected' : '' }}>
                                    Nonaktif
                                </option>

                            </select>

                            @error('is_active')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =====================================================
                    DESKRIPSI
                ====================================================== --}}

                <div class="form-group">

                    <label for="description">
                        Deskripsi
                    </label>

                    <textarea id="description" name="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Masukkan keterangan atau deskripsi gelombang...">{{ old('description', $wave->description) }}</textarea>

                    @error('description')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}

            <div class="card-footer d-flex align-items-center w-100">

                <a href="{{ route('waves.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-1"></i>
                    Batal
                </a>

                <button type="submit" class="btn btn-primary ml-auto">
                    <i class="fas fa-save mr-1"></i>
                    Simpan Perubahan
                </button>

            </div>


        </form>

    </div>

@stop
