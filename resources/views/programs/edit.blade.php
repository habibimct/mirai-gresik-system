@extends('adminlte::page')

@section('title', 'Edit Program')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-0">
                <i class="fas fa-edit mr-2"></i>
                Edit Program
            </h1>

            <small class="text-muted">
                Perbarui informasi program pelatihan
            </small>
        </div>

        <a href="{{ route('programs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>

    </div>

@stop


@section('content')

    {{-- Pesan sukses --}}
    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>

        </div>

    @endif


    {{-- Pesan error --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <h6 class="font-weight-bold">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Terdapat kesalahan pada data
            </h6>

            <ul class="mb-0 pl-3">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="card card-primary card-outline">

        {{-- Card Header --}}

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-graduation-cap mr-1"></i>

                Informasi Program

            </h3>

        </div>


        <form action="{{ route('programs.update', $program) }}" method="POST">

            @csrf

            @method('PUT')


            <div class="card-body">

                <div class="row">

                    {{-- Kode Program --}}

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="code">

                                Kode Program

                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                id="code"
                                name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $program->code) }}"
                                placeholder="Contoh: JP"
                                maxlength="20"
                                required
                            >

                            @error('code')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @else

                                <small class="form-text text-muted">
                                    Kode singkat untuk identifikasi program.
                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- Nama Program --}}

                    <div class="col-md-8">

                        <div class="form-group">

                            <label for="name">

                                Nama Program

                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $program->name) }}"
                                placeholder="Contoh: Bahasa Jepang"
                                required
                            >

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Deskripsi --}}

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="description">
                                Deskripsi
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan deskripsi program..."
                            >{{ old('description', $program->description) }}</textarea>

                            @error('description')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @else

                                <small class="form-text text-muted">
                                    Jelaskan secara singkat mengenai program pelatihan ini.
                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- Status --}}

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="is_active">

                                Status Program

                                <span class="text-danger">*</span>

                            </label>

                            <select
                                id="is_active"
                                name="is_active"
                                class="form-control @error('is_active') is-invalid @enderror"
                                required
                            >

                                <option value="1"
                                    {{ old('is_active', $program->is_active) == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="0"
                                    {{ old('is_active', $program->is_active) == 0 ? 'selected' : '' }}>
                                    Nonaktif
                                </option>

                            </select>

                            @error('is_active')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @else

                                <small class="form-text text-muted">
                                    Program aktif dapat digunakan untuk pendaftaran dan gelombang.
                                </small>

                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- Footer --}}

            <div class="card-footer d-flex justify-content-end">

                <a
                    href="{{ route('programs.index') }}"
                    class="btn btn-secondary mr-2"
                >

                    <i class="fas fa-times mr-1"></i>

                    Batal

                </a>


                <button
                    type="submit"
                    class="btn btn-primary"
                >

                    <i class="fas fa-save mr-1"></i>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

@stop