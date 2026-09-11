@extends('adminlte::page')

@section('title', 'Edit Kelas')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-1">
                <i class="fas fa-edit mr-2"></i>
                Edit Kelas
            </h1>

            <small class="text-muted">
                Perbarui informasi kelas
            </small>
        </div>

        <a href="{{ route('classrooms.show', ['classroom' => $classroom->id]) }}) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>

    </div>

@stop


@section('content')

    {{-- Ringkasan Error --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Data belum dapat diperbarui
            </h5>

            <ul class="mb-0 pl-3">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


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


    <div class="card card-primary">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-chalkboard mr-2"></i>
                Informasi Kelas

            </h3>

        </div>


        <form action="{{ route('classrooms.update', $classroom) }}" method="POST">

            @csrf
            @method('PUT')


            <div class="card-body">

                <div class="row">


                    {{-- Program Gelombang --}}
                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="wave_program_id">

                                <i class="fas fa-layer-group mr-1"></i>
                                Program Gelombang

                                <span class="text-danger">*</span>

                            </label>

                            <select name="wave_program_id" id="wave_program_id"
                                class="form-control @error('wave_program_id') is-invalid @enderror" required>

                                <option value="">
                                    -- Pilih Program Gelombang --
                                </option>

                                @foreach ($wavePrograms as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('wave_program_id', $classroom->wave_program_id) == $item->id ? 'selected' : '' }}>

                                        {{ $item->wave->code }}
                                        -
                                        {{ $item->program->name }}

                                        (Kuota {{ $item->quota }})
                                    </option>
                                @endforeach

                            </select>

                            @error('wave_program_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Kode --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="code">

                                <i class="fas fa-barcode mr-1"></i>
                                Kode Kelas

                                <span class="text-danger">*</span>

                            </label>

                            <input type="text" name="code" id="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $classroom->code) }}" maxlength="50" required>

                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Nama Kelas --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="name">

                                <i class="fas fa-chalkboard-teacher mr-1"></i>
                                Nama Kelas

                                <span class="text-danger">*</span>

                            </label>

                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $classroom->name) }}" maxlength="100" required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- Kapasitas --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="capacity">

                                <i class="fas fa-users mr-1"></i>
                                Kapasitas

                                <span class="text-danger">*</span>

                            </label>

                            <div class="input-group">

                                <input type="number" name="capacity" id="capacity"
                                    class="form-control @error('capacity') is-invalid @enderror"
                                    value="{{ old('capacity', $classroom->capacity) }}" min="1" required>

                                <div class="input-group-append">

                                    <span class="input-group-text">
                                        Peserta
                                    </span>

                                </div>

                                @error('capacity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Ruangan --}}
                    <div class="col-md-3">

                        <div class="form-group">

                            <label for="room">

                                <i class="fas fa-door-open mr-1"></i>
                                Ruangan

                            </label>

                            <input type="text" name="room" id="room"
                                class="form-control @error('room') is-invalid @enderror"
                                value="{{ old('room', $classroom->room) }}" maxlength="100">

                            @error('room')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                    {{-- Ruangan --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>

                            <select name="is_active" class="form-control">

                                <option value="1"
                                    {{ old('is_active', $classroom->is_active) == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="0"
                                    {{ old('is_active', $classroom->is_active) == 0 ? 'selected' : '' }}>
                                    Nonaktif
                                </option>

                            </select>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="description">

                                <i class="fas fa-align-left mr-1"></i>
                                Deskripsi

                            </label>

                            <textarea name="description" id="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan deskripsi kelas jika diperlukan...">{{ old('description', $classroom->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                </div>

            </div>


            {{-- Footer --}}
            <div class="card-footer d-flex justify-content-between">

                <button type="submit" class="btn btn-primary">

                    <i class="fas fa-save mr-1"></i>
                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

@stop
