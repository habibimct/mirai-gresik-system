@extends('adminlte::page')

@section('title', 'Tambah Kelas')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-0">
                Tambah Kelas
            </h1>

            <small class="text-muted">
                Tambahkan kelas baru ke dalam program gelombang
            </small>
        </div>

        <a href="{{ route('classrooms.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>

    </div>

@stop


@section('content')

    {{-- Pesan Validasi --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Data belum dapat disimpan
            </h5>

            <ul class="mb-0 pl-3">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card card-primary">

        <form action="{{ route('classrooms.store') }}" method="POST">

            @csrf


            {{-- ============================= --}}
            {{-- PROGRAM GELOMBANG --}}
            {{-- ============================= --}}

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-layer-group mr-1"></i>
                    Program Gelombang
                </h3>

            </div>


            <div class="card-body">

                <div class="form-group">

                    <label for="wave_program_id">
                        Program Gelombang
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        name="wave_program_id"
                        id="wave_program_id"
                        class="form-control @error('wave_program_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            -- Pilih Program Gelombang --
                        </option>

                        @foreach ($wavePrograms as $item)

                            <option
                                value="{{ $item->id }}"
                                {{ old('wave_program_id') == $item->id ? 'selected' : '' }}
                            >

                                {{ $item->wave->code }}
                                -
                                {{ $item->program->name }}

                                (Kuota {{ $item->quota }})

                            </option>

                        @endforeach

                    </select>

                    @error('wave_program_id')

                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>


            {{-- ============================= --}}
            {{-- INFORMASI KELAS --}}
            {{-- ============================= --}}

            <div class="card-header border-top">

                <h3 class="card-title">

                    <i class="fas fa-chalkboard-teacher mr-1"></i>
                    Informasi Kelas

                </h3>

            </div>


            <div class="card-body">

                <div class="row">

                    {{-- Kode --}}
                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="code">
                                Kode Kelas
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="code"
                                id="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code') }}"
                                placeholder="Contoh: KLS-01"
                                required
                            >

                            @error('code')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- Nama --}}
                    <div class="col-md-8">

                        <div class="form-group">

                            <label for="name">
                                Nama Kelas
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Contoh: Kelas Bahasa Jepang A"
                                required
                            >

                            @error('name')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>

                </div>


                <div class="row">

                    {{-- Kapasitas --}}
                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="capacity">
                                Kapasitas
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    name="capacity"
                                    id="capacity"
                                    class="form-control @error('capacity') is-invalid @enderror"
                                    value="{{ old('capacity', 20) }}"
                                    min="1"
                                    required
                                >

                                <div class="input-group-append">

                                    <span class="input-group-text">
                                        Peserta
                                    </span>

                                </div>

                            </div>

                            @error('capacity')

                                <span class="text-danger small">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- Ruangan --}}
                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="room">
                                Ruangan
                            </label>

                            <input
                                type="text"
                                name="room"
                                id="room"
                                class="form-control @error('room') is-invalid @enderror"
                                value="{{ old('room') }}"
                                placeholder="Contoh: Ruang 1"
                            >

                            @error('room')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="is_active">
                                Status
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="is_active"
                                id="is_active"
                                class="form-control @error('is_active') is-invalid @enderror"
                                required
                            >

                                <option
                                    value="1"
                                    {{ old('is_active', '1') == '1' ? 'selected' : '' }}
                                >
                                    Aktif
                                </option>

                                <option
                                    value="0"
                                    {{ old('is_active') == '0' ? 'selected' : '' }}
                                >
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


                {{-- Deskripsi --}}
                <div class="form-group">

                    <label for="description">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        placeholder="Keterangan tambahan mengenai kelas..."
                    >{{ old('description') }}</textarea>

                    @error('description')

                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>

                    @enderror

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="card-footer d-flex justify-content-between">
                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    <i class="fas fa-save mr-1"></i>
                    Simpan Kelas
                </button>
            </div>

        </form>

    </div>

@stop