@extends('adminlte::page')

@section('title', 'Edit Peserta')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">
                <i class="fas fa-user-edit text-warning mr-2"></i>
                Edit Peserta
            </h1>

            <p class="text-muted mb-0">
                Perbarui informasi data peserta.
            </p>
        </div>

        <a href="{{ route('participants.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>
    </div>
@stop

@section('content')

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif


    {{-- Ringkasan error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5 class="mb-2">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Data belum dapat disimpan
            </h5>

            <p class="mb-2">
                Silakan periksa kembali data berikut:
            </p>

            <ul class="mb-0 pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('participants.update', $participant) }}" method="POST">

        @csrf
        @method('PUT')


        {{-- =========================
             DATA AKUN
        ========================== --}}
        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-circle mr-2"></i>
                    Data Akun
                </h3>
            </div>

            <div class="card-body">

                <div class="row">

                    {{-- Nama --}}
                    <div class="col-md-6 mb-3">

                        <label for="name">
                            Nama Peserta
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $participant->user->name) }}"
                            maxlength="100"
                            required
                        >

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Email --}}
                    <div class="col-md-6 mb-3">

                        <label for="email">
                            Email
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $participant->user->email) }}"
                            maxlength="100"
                            required
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- No HP --}}
                    <div class="col-md-6 mb-3">

                        <label for="phone">
                            No. HP
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $participant->user->phone) }}"
                            maxlength="20"
                        >

                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             DATA PRIBADI
        ========================== --}}
        <div class="card card-info">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-id-card mr-2"></i>
                    Data Pribadi
                </h3>
            </div>

            <div class="card-body">

                <div class="row">

                    {{-- NIK --}}
                    <div class="col-md-6 mb-3">

                        <label for="nik">
                            NIK
                        </label>

                        <input
                            type="text"
                            id="nik"
                            name="nik"
                            class="form-control @error('nik') is-invalid @enderror"
                            value="{{ old('nik', $participant->nik) }}"
                            maxlength="20"
                            inputmode="numeric"
                        >

                        @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Jenis Kelamin --}}
                    <div class="col-md-6 mb-3">

                        <label for="gender">
                            Jenis Kelamin
                        </label>

                        <select
                            id="gender"
                            name="gender"
                            class="form-control @error('gender') is-invalid @enderror"
                        >

                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            <option
                                value="L"
                                @selected(old('gender', $participant->gender) === 'L')
                            >
                                Laki-laki
                            </option>

                            <option
                                value="P"
                                @selected(old('gender', $participant->gender) === 'P')
                            >
                                Perempuan
                            </option>

                        </select>

                        @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Tempat Lahir --}}
                    <div class="col-md-6 mb-3">

                        <label for="birth_place">
                            Tempat Lahir
                        </label>

                        <input
                            type="text"
                            id="birth_place"
                            name="birth_place"
                            class="form-control @error('birth_place') is-invalid @enderror"
                            value="{{ old('birth_place', $participant->birth_place) }}"
                            maxlength="100"
                        >

                        @error('birth_place')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Tanggal Lahir --}}
                    <div class="col-md-6 mb-3">

                        <label for="birth_date">
                            Tanggal Lahir
                        </label>

                        <input
                            type="date"
                            id="birth_date"
                            name="birth_date"
                            class="form-control @error('birth_date') is-invalid @enderror"
                            value="{{ old('birth_date', $participant->birth_date) }}"
                        >

                        @error('birth_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Pendidikan --}}
                    <div class="col-md-6 mb-3">

                        <label for="education">
                            Pendidikan
                        </label>

                        <input
                            type="text"
                            id="education"
                            name="education"
                            class="form-control @error('education') is-invalid @enderror"
                            value="{{ old('education', $participant->education) }}"
                            maxlength="100"
                        >

                        @error('education')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Pekerjaan --}}
                    <div class="col-md-6 mb-3">

                        <label for="job">
                            Pekerjaan
                        </label>

                        <input
                            type="text"
                            id="job"
                            name="job"
                            class="form-control @error('job') is-invalid @enderror"
                            value="{{ old('job', $participant->job) }}"
                            maxlength="100"
                        >

                        @error('job')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="col-md-6 mb-3">

                        <label for="status">
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-control @error('status') is-invalid @enderror"
                            required
                        >

                            <option
                                value="Aktif"
                                @selected(old('status', $participant->status) === 'Aktif')
                            >
                                Aktif
                            </option>

                            <option
                                value="Lulus"
                                @selected(old('status', $participant->status) === 'Lulus')
                            >
                                Lulus
                            </option>

                            <option
                                value="Keluar"
                                @selected(old('status', $participant->status) === 'Keluar')
                            >
                                Keluar
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Alamat --}}
                    <div class="col-md-12 mb-3">

                        <label for="address">
                            Alamat
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="4"
                            class="form-control @error('address') is-invalid @enderror"
                        >{{ old('address', $participant->address) }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             FOOTER ACTION
        ========================== --}}
        <div class="card">

            <div class="card-body d-flex justify-content-between align-items-center w-100">

                <div class="text-muted">
                    <i class="fas fa-info-circle mr-1"></i>
                    Pastikan data peserta sudah benar sebelum disimpan.
                </div>

                <div class="ml-auto">

                    <a href="{{ route('participants.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </div>

        </div>

    </form>

@stop