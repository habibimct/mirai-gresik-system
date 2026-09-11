@extends('adminlte::page')

@section('title', 'Detail Peserta')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="mb-1">
                <i class="fas fa-user mr-2"></i>
                Detail Peserta
            </h1>

            <p class="text-muted mb-0">
                Informasi lengkap data peserta
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


    <div class="row">

        {{-- Profil Utama --}}
        <div class="col-lg-4">

            <div class="card card-primary card-outline">

                <div class="card-body box-profile text-center">

                    {{-- Avatar --}}
                    <div class="mb-3">
                        <div
                            class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle"
                            style="width: 90px; height: 90px;">

                            <i class="fas fa-user fa-3x text-white"></i>

                        </div>
                    </div>


                    <h3 class="profile-username text-center mb-1">

                        {{ $participant->user->name }}

                    </h3>


                    <p class="text-muted text-center mb-3">

                        Peserta

                    </p>


                    {{-- Status --}}
                    @if ($participant->status == 'Aktif')

                        <span class="badge badge-success px-3 py-2">
                            <i class="fas fa-check-circle mr-1"></i>
                            Aktif
                        </span>

                    @elseif ($participant->status == 'Lulus')

                        <span class="badge badge-primary px-3 py-2">
                            <i class="fas fa-graduation-cap mr-1"></i>
                            Lulus
                        </span>

                    @else

                        <span class="badge badge-danger px-3 py-2">
                            <i class="fas fa-times-circle mr-1"></i>
                            Keluar
                        </span>

                    @endif


                    <hr>


                    <div class="text-left">

                        <p class="mb-3">
                            <i class="fas fa-envelope text-primary mr-2"></i>

                            {{ $participant->user->email }}
                        </p>


                        <p class="mb-3">
                            <i class="fas fa-phone text-primary mr-2"></i>

                            {{ $participant->user->phone ?? '-' }}
                        </p>


                        <p class="mb-0">
                            <i class="fas fa-id-card text-primary mr-2"></i>

                            {{ $participant->nik ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Tombol Aksi --}}
            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        <i class="fas fa-cog mr-1"></i>
                        Aksi
                    </h3>

                </div>


                <div class="card-body">

                    <div class="d-grid gap-2">

                        <a href="{{ route('participants.edit', $participant) }}"
                            class="btn btn-warning btn-block">

                            <i class="fas fa-edit mr-1"></i>
                            Edit Data Peserta

                        </a>


                        <a href="{{ route('participants.programs.index', $participant) }}"
                            class="btn btn-primary btn-block">

                            <i class="fas fa-graduation-cap mr-1"></i>
                            Program Peserta

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- Detail Data --}}
        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-id-card mr-2"></i>

                        Informasi Peserta

                    </h3>

                </div>


                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover mb-0">

                            <tbody>

                                <tr>

                                    <th width="220" class="bg-light">
                                        Nama Lengkap
                                    </th>

                                    <td>
                                        {{ $participant->user->name }}
                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light">
                                        Email
                                    </th>

                                    <td>
                                        {{ $participant->user->email }}
                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light">
                                        No. HP
                                    </th>

                                    <td>
                                        {{ $participant->user->phone ?? '-' }}
                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light">
                                        NIK
                                    </th>

                                    <td>
                                        {{ $participant->nik ?? '-' }}
                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light">
                                        Jenis Kelamin
                                    </th>

                                    <td>

                                        @if ($participant->gender === 'L')

                                            <span>
                                                <i class="fas fa-mars text-primary mr-1"></i>
                                                Laki-laki
                                            </span>

                                        @elseif ($participant->gender === 'P')

                                            <span>
                                                <i class="fas fa-venus text-danger mr-1"></i>
                                                Perempuan
                                            </span>

                                        @else

                                            -

                                        @endif

                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light">
                                        Tempat, Tanggal Lahir
                                    </th>

                                    <td>

                                        {{ $participant->birth_place ?? '-' }}

                                        @if ($participant->birth_date)

                                            ,

                                            {{ \Carbon\Carbon::parse($participant->birth_date)->translatedFormat('d F Y') }}

                                        @endif

                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light">
                                        Pendidikan
                                    </th>

                                    <td>
                                        {{ $participant->education ?? '-' }}
                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light">
                                        Pekerjaan
                                    </th>

                                    <td>
                                        {{ $participant->job ?? '-' }}
                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light">
                                        Status
                                    </th>

                                    <td>

                                        @if ($participant->status == 'Aktif')

                                            <span class="badge badge-success">
                                                Aktif
                                            </span>

                                        @elseif ($participant->status == 'Lulus')

                                            <span class="badge badge-primary">
                                                Lulus
                                            </span>

                                        @else

                                            <span class="badge badge-danger">
                                                Keluar
                                            </span>

                                        @endif

                                    </td>

                                </tr>


                                <tr>

                                    <th class="bg-light align-top">
                                        Alamat
                                    </th>

                                    <td>

                                        {{ $participant->address ?? '-' }}

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            {{-- Informasi Sistem --}}
            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-info-circle mr-2"></i>

                        Informasi Sistem

                    </h3>

                </div>


                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <strong>
                                <i class="fas fa-calendar-plus text-primary mr-1"></i>
                                Terdaftar
                            </strong>

                            <p class="text-muted mb-0 mt-1">

                                {{ $participant->created_at?->translatedFormat('d F Y H:i') ?? '-' }}

                            </p>

                        </div>


                        <div class="col-md-6">

                            <strong>
                                <i class="fas fa-calendar-check text-success mr-1"></i>
                                Terakhir Diperbarui
                            </strong>

                            <p class="text-muted mb-0 mt-1">

                                {{ $participant->updated_at?->translatedFormat('d F Y H:i') ?? '-' }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@stop