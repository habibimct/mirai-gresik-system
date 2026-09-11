@extends('adminlte::page')

@section('title', 'Tambah Peserta')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-0">Tambah Peserta</h1>
            <small class="text-muted">
                Tambahkan data peserta baru ke dalam sistem
            </small>
        </div>

        <a href="{{ route('participants.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i>
            Kembali
        </a>

    </div>
@stop


@section('content')

    {{-- =====================================================
        PESAN SUKSES
    ====================================================== --}}

    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

    @endif


    {{-- =====================================================
        ERROR VALIDASI
    ====================================================== --}}

    @if ($errors->any())

        <div class="alert alert-danger alert-dismissible fade show">

            <h5>
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Data belum dapat disimpan
            </h5>

            <ul class="mb-0 pl-3">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

    @endif


    {{-- =====================================================
        FORM
    ====================================================== --}}

    <div class="card card-primary">


        {{-- CARD HEADER --}}

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-user-plus mr-1"></i>

                Form Data Peserta

            </h3>

        </div>


        <form action="{{ route('participants.store') }}" method="POST">

            @csrf


            <div class="card-body">


                {{-- =================================================
                    DATA AKUN
                ================================================== --}}

                <h5 class="text-primary mb-3">

                    <i class="fas fa-user-circle mr-1"></i>

                    Data Akun

                </h5>


                <div class="row">


                    {{-- NAMA --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="name">

                                Nama Lengkap
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap"
                                required
                            >

                            @error('name')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- EMAIL --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="email">

                                Email
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="contoh@email.com"
                                required
                            >

                            @error('email')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- NO HP --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="phone">
                                No. HP
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}"
                                placeholder="Contoh: 6281234567890"
                            >

                            @error('phone')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>

                </div>


                <hr>


                {{-- =================================================
                    IDENTITAS PESERTA
                ================================================== --}}

                <h5 class="text-primary mb-3">

                    <i class="fas fa-id-card mr-1"></i>

                    Identitas Peserta

                </h5>


                <div class="row">


                    {{-- NIK --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="nik">
                                NIK
                            </label>

                            <input
                                type="text"
                                id="nik"
                                name="nik"
                                class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik') }}"
                                placeholder="Masukkan NIK"
                                maxlength="16"
                            >

                            @error('nik')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- JENIS KELAMIN --}}

                    <div class="col-md-6">

                        <div class="form-group">

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
                                    {{ old('gender') == 'L' ? 'selected' : '' }}
                                >
                                    Laki-laki
                                </option>

                                <option
                                    value="P"
                                    {{ old('gender') == 'P' ? 'selected' : '' }}
                                >
                                    Perempuan
                                </option>

                            </select>

                            @error('gender')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- TEMPAT LAHIR --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="birth_place">

                                Tempat Lahir
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="text"
                                id="birth_place"
                                name="birth_place"
                                class="form-control @error('birth_place') is-invalid @enderror"
                                value="{{ old('birth_place') }}"
                                placeholder="Contoh: Gresik"
                                required
                            >

                            @error('birth_place')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- TANGGAL LAHIR --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="birth_date">

                                Tanggal Lahir
                                <span class="text-danger">*</span>

                            </label>

                            <input
                                type="date"
                                id="birth_date"
                                name="birth_date"
                                class="form-control @error('birth_date') is-invalid @enderror"
                                value="{{ old('birth_date') }}"
                                required
                            >

                            @error('birth_date')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>

                </div>


                <hr>


                {{-- =================================================
                    ALAMAT & PENDIDIKAN
                ================================================== --}}

                <h5 class="text-primary mb-3">

                    <i class="fas fa-address-card mr-1"></i>

                    Alamat & Pendidikan

                </h5>


                {{-- ALAMAT --}}

                <div class="form-group">

                    <label for="address">
                        Alamat
                    </label>

                    <textarea
                        id="address"
                        name="address"
                        rows="3"
                        class="form-control @error('address') is-invalid @enderror"
                        placeholder="Masukkan alamat lengkap peserta..."
                    >{{ old('address') }}</textarea>

                    @error('address')

                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>

                    @enderror

                </div>


                <div class="row">


                    {{-- PENDIDIKAN --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="education">
                                Pendidikan Terakhir
                            </label>

                            <input
                                type="text"
                                id="education"
                                name="education"
                                class="form-control @error('education') is-invalid @enderror"
                                value="{{ old('education') }}"
                                placeholder="Contoh: SMA / SMK"
                            >

                            @error('education')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- PEKERJAAN --}}

                    <div class="col-md-6">

                        <div class="form-group">

                            <label for="job">
                                Pekerjaan
                            </label>

                            <input
                                type="text"
                                id="job"
                                name="job"
                                class="form-control @error('job') is-invalid @enderror"
                                value="{{ old('job') }}"
                                placeholder="Contoh: Pelajar / Karyawan"
                            >

                            @error('job')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>

                </div>


                <hr>


                {{-- =================================================
                    STATUS PESERTA
                ================================================== --}}

                <h5 class="text-primary mb-3">

                    <i class="fas fa-toggle-on mr-1"></i>

                    Status Peserta

                </h5>


                <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label for="status">
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="form-control @error('status') is-invalid @enderror"
                            >

                                <option
                                    value="Aktif"
                                    {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}
                                >
                                    Aktif
                                </option>

                                <option
                                    value="Lulus"
                                    {{ old('status') == 'Lulus' ? 'selected' : '' }}
                                >
                                    Lulus
                                </option>

                                <option
                                    value="Keluar"
                                    {{ old('status') == 'Keluar' ? 'selected' : '' }}
                                >
                                    Keluar
                                </option>

                            </select>

                            @error('status')

                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>

                </div>


            </div>


            {{-- =====================================================
                CARD FOOTER
            ====================================================== --}}

            <div class="card-footer d-flex justify-content-end">

                <a
                    href="{{ route('participants.index') }}"
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

                    Simpan Peserta

                </button>

            </div>


        </form>

    </div>

@stop