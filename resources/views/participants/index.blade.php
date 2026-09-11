@extends('adminlte::page')

@section('title', 'Peserta')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">

        <div>
            <h1 class="mb-1">
                Data Peserta
            </h1>

            <p class="text-muted mb-0">
                Kelola data peserta LPK Mirai Gresik.
            </p>
        </div>

        <a href="{{ route('participants.create') }}" class="btn btn-primary">

            <i class="fas fa-user-plus mr-1"></i>

            Tambah Peserta

        </a>

    </div>

@stop


@section('content')


    {{-- ========================================================= --}}
    {{-- FLASH MESSAGE --}}
    {{-- ========================================================= --}}

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-1"></i>

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- STATISTIK --}}
    {{-- ========================================================= --}}

    <div class="row">


        {{-- Total Peserta --}}

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-primary">

                <div class="inner">

                    <h3>
                        {{ $participants->total() }}
                    </h3>

                    <p>
                        Total Peserta
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-users"></i>

                </div>

            </div>

        </div>


        {{-- Peserta Aktif --}}

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-success">

                <div class="inner">

                    <h3>
                        {{ $totalAktif ?? 0 }}
                    </h3>

                    <p>
                        Peserta Aktif
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-user-check"></i>

                </div>

            </div>

        </div>


        {{-- Peserta Nonaktif --}}

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-warning">

                <div class="inner">

                    <h3>
                        {{ $totalNonaktif ?? 0 }}
                    </h3>

                    <p>
                        Peserta Nonaktif
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-user-clock"></i>

                </div>

            </div>

        </div>


        {{-- Data Ditampilkan --}}

        <div class="col-lg-3 col-md-6">

            <div class="small-box bg-info">

                <div class="inner">

                    <h3>
                        {{ $participants->count() }}
                    </h3>

                    <p>
                        Data Halaman Ini
                    </p>

                </div>

                <div class="icon">

                    <i class="fas fa-list"></i>

                </div>

            </div>

        </div>

    </div>



    {{-- ========================================================= --}}
    {{-- FILTER --}}
    {{-- ========================================================= --}}

    <div class="card">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-filter mr-1"></i>

                Pencarian & Filter

            </h3>

        </div>


        <form method="GET">

            <div class="card-body">

                <div class="row">


                    {{-- Pencarian --}}

                    <div class="col-md-6">

                        <label>
                            Cari Peserta
                        </label>

                        <div class="input-group">

                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Nama, email, atau NIK...">

                            <div class="input-group-append">

                                <button type="submit" class="btn btn-primary">

                                    <i class="fas fa-search"></i>

                                    Cari

                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- Status --}}

                    <div class="col-md-3">

                        <label>
                            Status
                        </label>

                        <select name="status" class="form-control">

                            <option value="">
                                -- Semua Status --
                            </option>

                            <option value="Aktif" @selected(request('status') === 'Aktif')>

                                Aktif

                            </option>

                            <option value="Nonaktif" @selected(request('status') === 'Nonaktif')>

                                Nonaktif

                            </option>

                        </select>

                    </div>


                    {{-- Tombol --}}

                    <div class="col-md-3 d-flex align-items-end">

                        <div class="w-100">

                            <button type="submit" class="btn btn-primary">

                                <i class="fas fa-filter mr-1"></i>

                                Terapkan

                            </button>


                            <a href="{{ route('participants.index') }}" class="btn btn-secondary">

                                <i class="fas fa-sync-alt"></i>

                                Reset

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>



    {{-- ========================================================= --}}
    {{-- DATA PESERTA --}}
    {{-- ========================================================= --}}

    <div class="card">


        {{-- Header --}}

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-users mr-1"></i>

                Daftar Peserta

            </h3>


            <div class="card-tools">

                <span class="badge badge-primary">

                    {{ $participants->total() }}
                    Peserta

                </span>

            </div>

        </div>



        {{-- Body --}}

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    <thead class="thead-light">

                        <tr>

                            <th width="50" class="text-center">

                                No

                            </th>

                            <th width="240" class="text-center">
                                Nama
                            </th>

                            <th>
                                Email
                            </th>

                            <th>
                                NIK
                            </th>

                            <th width="100" class="text-center">

                                Status

                            </th>

                            <th width="240" class="text-center">

                                Aksi

                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @forelse ($participants as $participant)
                            <tr>


                                {{-- No --}}

                                <td class="text-center align-middle">

                                    {{ $participants->firstItem() + $loop->index }}

                                </td>


                                {{-- Nama --}}

                                <td class="align-middle">

                                    <div class="d-flex align-items-center">

                                        <div>

                                            <strong>

                                                {{ $participant->user->name }}

                                            </strong>

                                        </div>

                                    </div>

                                </td>


                                {{-- Email --}}

                                <td class="align-middle">

                                    {{ $participant->user->email }}

                                </td>


                                {{-- NIK --}}

                                <td class="align-middle">

                                    {{ $participant->nik ?? '-' }}

                                </td>


                                {{-- Status --}}

                                <td class="text-center align-middle">

                                    @if ($participant->status === 'Aktif')
                                        <span class="badge badge-success">

                                            <i class="fas fa-check-circle mr-1"></i>

                                            Aktif

                                        </span>
                                    @else
                                        <span class="badge badge-secondary">

                                            {{ $participant->status }}

                                        </span>
                                    @endif

                                </td>


                                {{-- Aksi --}}

                                <td class="text-center align-middle">


                                    <a href="{{ route('participants.show', $participant) }}" class="btn btn-info btn-sm"
                                        title="Detail">

                                        <i class="fas fa-eye"></i>

                                    </a>


                                    <a href="{{ route('participants.programs.index', $participant) }}"
                                        class="btn btn-primary btn-sm" title="Program">

                                        <i class="fas fa-graduation-cap"></i>

                                    </a>


                                    <a href="{{ route('participants.edit', $participant) }}"
                                        class="btn btn-warning btn-sm" title="Edit">

                                        <i class="fas fa-edit"></i>

                                    </a>


                                    @if (!$participant->participant_classrooms_exists)
                                        <form action="{{ route('participants.destroy', $participant) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus peserta ini?')">

                                                <i class="fas fa-trash"></i>
                                               

                                            </button>

                                        </form>
                                    @else
                                        <button type="button" class="btn btn-secondary btn-sm" disabled
                                            title="Peserta sudah masuk kelas">

                                            <i class="fas fa-lock"></i>
                                           

                                        </button>
                                    @endif


                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-5">

                                    <div class="text-muted">

                                        <i class="fas fa-users fa-3x mb-3"></i>

                                        <h5>
                                            Belum ada data peserta
                                        </h5>

                                        <p>
                                            Silakan tambahkan peserta baru.
                                        </p>

                                        <a href="{{ route('participants.create') }}" class="btn btn-primary">

                                            <i class="fas fa-user-plus mr-1"></i>

                                            Tambah Peserta

                                        </a>

                                    </div>

                                </td>

                            </tr>
                        @endforelse


                    </tbody>

                </table>

            </div>

        </div>



        {{-- Footer Pagination --}}

        @if ($participants->hasPages())
            <div class="card-footer">

                <div class="d-flex justify-content-between align-items-center">

                    <small class="text-muted">

                        Menampilkan

                        {{ $participants->firstItem() }}

                        sampai

                        {{ $participants->lastItem() }}

                        dari

                        {{ $participants->total() }}

                        peserta

                    </small>


                    <div>

                        {{ $participants->withQueryString()->links('pagination::bootstrap-4') }}

                    </div>

                </div>

            </div>
        @endif


    </div>


@stop



@section('css')

    <style>
        .avatar-circle {

            width: 36px;

            height: 36px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            border-radius: 50%;

            background-color: #e9ecef;

            color: #6c757d;

        }


        .table td,
        .table th {

            vertical-align: middle;

        }


        .card-tools .badge {

            font-size: 13px;

            padding: 6px 10px;

        }


        @media (max-width: 768px) {

            .content-header h1 {

                font-size: 22px;

            }

            .content-header .btn {

                margin-top: 10px;

            }

        }
    </style>

@stop
