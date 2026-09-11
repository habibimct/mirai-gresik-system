@extends('adminlte::page')

@section('title', 'Tambah Gelombang')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>

            <h1 class="mb-1">
                <i class="fas fa-layer-group mr-2"></i>
                Tambah Gelombang
            </h1>

            <p class="text-muted mb-0">
                Tambahkan data gelombang pelatihan baru.
            </p>

        </div>

    </div>

@stop


@section('content')

    {{-- =========================================================
        VALIDATION ERROR
    ========================================================== --}}

    @if ($errors->any())

        <div class="alert alert-danger alert-dismissible fade show">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Terjadi Kesalahan
            </h5>

            <ul class="mb-0 pl-3">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

    @endif


    {{-- =========================================================
        FORM
    ========================================================== --}}

    <form action="{{ route('waves.store') }}" method="POST">

        @csrf


        {{-- =====================================================
            INFORMASI GELOMBANG
        ====================================================== --}}

        <x-adminlte-card
            title="Informasi Gelombang"
            theme="primary"
            icon="fas fa-info-circle"
        >

            <div class="row">

                {{-- KODE --}}

                <div class="col-md-4">

                    <div class="form-group">

                        <label for="code">
                            Kode Gelombang
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="code"
                            name="code"
                            class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code') }}"
                            placeholder="Contoh: G01"
                            autocomplete="off"
                        >

                        @error('code')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>


                {{-- NAMA --}}

                <div class="col-md-5">

                    <div class="form-group">

                        <label for="name">
                            Nama Gelombang
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Gelombang I"
                        >

                        @error('name')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>


                {{-- TAHUN --}}

                <div class="col-md-3">

                    <div class="form-group">

                        <label for="year">
                            Tahun
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="number"
                            id="year"
                            name="year"
                            class="form-control @error('year') is-invalid @enderror"
                            value="{{ old('year', date('Y')) }}"
                            min="2000"
                            max="2100"
                        >

                        @error('year')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>

            </div>

        </x-adminlte-card>



        {{-- =====================================================
            PERIODE PENDAFTARAN
        ====================================================== --}}

        <x-adminlte-card
            title="Periode Pendaftaran"
            theme="info"
            icon="fas fa-calendar-alt"
        >

            <div class="row">

                {{-- MULAI PENDAFTARAN --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="registration_start">
                            Tanggal Mulai Pendaftaran
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            id="registration_start"
                            name="registration_start"
                            class="form-control @error('registration_start') is-invalid @enderror"
                            value="{{ old('registration_start') }}"
                        >

                        @error('registration_start')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>


                {{-- SELESAI PENDAFTARAN --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="registration_end">
                            Tanggal Selesai Pendaftaran
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            id="registration_end"
                            name="registration_end"
                            class="form-control @error('registration_end') is-invalid @enderror"
                            value="{{ old('registration_end') }}"
                        >

                        @error('registration_end')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>

            </div>


            <small class="text-muted">

                <i class="fas fa-info-circle mr-1"></i>

                Tentukan periode selama pendaftaran peserta dibuka.

            </small>

        </x-adminlte-card>



        {{-- =====================================================
            PERIODE PELATIHAN
        ====================================================== --}}

        <x-adminlte-card
            title="Periode Pelatihan"
            theme="success"
            icon="fas fa-calendar-check"
        >

            <div class="row">

                {{-- MULAI PELATIHAN --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="training_start">
                            Tanggal Mulai Pelatihan
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            id="training_start"
                            name="training_start"
                            class="form-control @error('training_start') is-invalid @enderror"
                            value="{{ old('training_start') }}"
                        >

                        @error('training_start')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>


                {{-- SELESAI PELATIHAN --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="training_end">
                            Tanggal Selesai Pelatihan
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            id="training_end"
                            name="training_end"
                            class="form-control @error('training_end') is-invalid @enderror"
                            value="{{ old('training_end') }}"
                        >

                        @error('training_end')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>

            </div>


            <small class="text-muted">

                <i class="fas fa-info-circle mr-1"></i>

                Tentukan periode pelaksanaan pelatihan untuk gelombang ini.

            </small>

        </x-adminlte-card>



        {{-- =====================================================
            STATUS & DESKRIPSI
        ====================================================== --}}

        <x-adminlte-card
            title="Status dan Deskripsi"
            theme="warning"
            icon="fas fa-cog"
        >

            <div class="row">

                {{-- STATUS --}}

                <div class="col-md-4">

                    <div class="form-group">

                        <label for="is_active">
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            id="is_active"
                            name="is_active"
                            class="form-control @error('is_active') is-invalid @enderror"
                        >

                            <option value="1"
                                {{ old('is_active', 1) == 1 ? 'selected' : '' }}>

                                Aktif

                            </option>

                            <option value="0"
                                {{ old('is_active') === '0' ? 'selected' : '' }}>

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


                {{-- DESKRIPSI --}}

                <div class="col-md-8">

                    <div class="form-group">

                        <label for="description">
                            Deskripsi
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Masukkan keterangan atau deskripsi gelombang..."
                        >{{ old('description') }}</textarea>

                        @error('description')

                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>

            </div>

        </x-adminlte-card>



        {{-- =====================================================
            ACTION
        ====================================================== --}}

        <div class="card mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div class="text-muted small">

                        <i class="fas fa-info-circle mr-1"></i>

                        Field bertanda
                        <span class="text-danger">*</span>
                        wajib diisi.

                    </div>


                    <div>

                        <a
                            href="{{ route('waves.index') }}"
                            class="btn btn-secondary mr-1"
                        >

                            <i class="fas fa-arrow-left mr-1"></i>

                            Kembali

                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            <i class="fas fa-save mr-1"></i>

                            Simpan Gelombang

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

@stop