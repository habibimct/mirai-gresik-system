@extends('adminlte::page')

@section('title', 'Tambah Program')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-0">Tambah Program</h1>
            <small class="text-muted">
                Tambahkan data program pelatihan baru
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
         FORM TAMBAH PROGRAM
    ========================================================== --}}

    <div class="card card-primary">

        <div class="card-header">

            <h3 class="card-title">
                <i class="fas fa-plus-circle mr-1"></i>
                Form Program
            </h3>

        </div>


        <form action="{{ route('programs.store') }}" method="POST">

            @csrf

            <div class="card-body">

                {{-- INFORMASI --}}
                <div class="alert alert-light border mb-4">

                    <div class="d-flex">

                        <div class="mr-3">
                            <i class="fas fa-info-circle text-primary fa-lg"></i>
                        </div>

                        <div>
                            <strong>Informasi Program</strong>

                            <div class="small text-muted mt-1">
                                Lengkapi data program dengan benar.
                                Kode program digunakan sebagai identitas singkat
                                dalam sistem.
                            </div>
                        </div>

                    </div>

                </div>


                <div class="row">

                    {{-- KODE PROGRAM --}}
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
                                value="{{ old('code') }}"
                                placeholder="Contoh: JP"
                                maxlength="20"
                                autocomplete="off"
                            >

                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @else
                                <small class="form-text text-muted">
                                    Kode singkat untuk identitas program.
                                </small>
                            @enderror

                        </div>

                    </div>


                    {{-- NAMA PROGRAM --}}
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
                                value="{{ old('name') }}"
                                placeholder="Contoh: Bahasa Jepang"
                                maxlength="255"
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- DESKRIPSI --}}
                <div class="form-group">

                    <label for="description">
                        Deskripsi
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Masukkan deskripsi program jika diperlukan..."
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- STATUS --}}
                <div class="form-group">

                    <label for="is_active">
                        Status Program
                        <span class="text-danger">*</span>
                    </label>

                    <select
                        id="is_active"
                        name="is_active"
                        class="form-control @error('is_active') is-invalid @enderror"
                    >

                        <option value="1"
                            {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ old('is_active') == '0' ? 'selected' : '' }}>
                            Nonaktif
                        </option>

                    </select>

                    @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="form-text text-muted">
                        Program aktif dapat digunakan untuk pendaftaran dan proses
                        pelatihan.
                    </small>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="card-footer bg-light">

                <div class="d-flex justify-content-end">

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
                        Simpan Program
                    </button>

                </div>

            </div>

        </form>

    </div>

@stop